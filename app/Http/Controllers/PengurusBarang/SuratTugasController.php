<?php

namespace App\Http\Controllers\PengurusBarang;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

class SuratTugasController extends Controller
{
    public function index()
    {
        $peminjamanDisetujui = Peminjaman::where('status', 'Disetujui')
            ->whereDoesntHave('suratTugas')
            ->with(['user', 'kendaraan', 'supir'])
            ->latest()
            ->get();

        $suratTugasTerbaru = SuratTugas::with(['peminjaman.user', 'peminjaman.kendaraan'])
            ->latest()
            ->take(10)
            ->get();

        return view('pengurus-barang.surat-tugas.index', compact('peminjamanDisetujui', 'suratTugasTerbaru'));
    }

    public function generate(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Disetujui') {
            return back()->with('error', 'Peminjaman belum disetujui.');
        }

        if ($peminjaman->suratTugas) {
            return back()->with('error', 'Surat Tugas sudah pernah diterbitkan.');
        }

        // Generate nomor surat
        $year = date('Y');
        $month = date('m');
        $lastSurat = SuratTugas::whereYear('tanggal_surat', $year)
            ->whereMonth('tanggal_surat', $month)
            ->latest('id')
            ->first();

        $sequence = $lastSurat ? (int)substr($lastSurat->nomor_surat, 0, 3) + 1 : 1;
        $nomorSurat = sprintf('%03d/ST-KDO/%s/%s', $sequence, $month, $year);

        // Create Surat Tugas
        $suratTugas = SuratTugas::create([
            'peminjaman_id' => $peminjaman->id,
            'nomor_surat' => $nomorSurat,
            'tanggal_surat' => now(),
            'created_by' => auth()->id(),
        ]);

        // Generate PDF
        $pdf = Pdf::loadView('pengurus-barang.surat-tugas.pdf', [
            'suratTugas' => $suratTugas->load(['peminjaman.user', 'peminjaman.kendaraan', 'peminjaman.supir']),
        ]);

        $filename = 'surat-tugas-' . $suratTugas->id . '.pdf';
        $path = 'surat-tugas/' . $filename;
        
        \Storage::disk('public')->put($path, $pdf->output());

        $suratTugas->update(['file_path' => $path]);

        return redirect()->route('pengurus-barang.surat-tugas.index')
            ->with('success', 'Surat Tugas berhasil diterbitkan.');
    }

    public function download(SuratTugas $suratTugas)
    {
        if (!$suratTugas->file_path || !\Storage::disk('public')->exists($suratTugas->file_path)) {
            // Regenerate PDF
            $pdf = Pdf::loadView('pengurus-barang.surat-tugas.pdf', [
                'suratTugas' => $suratTugas->load(['peminjaman.user', 'peminjaman.kendaraan', 'peminjaman.supir']),
            ]);

            return $pdf->download('surat-tugas-' . $suratTugas->nomor_surat . '.pdf');
        }

        $filePath = storage_path('app/public/' . $suratTugas->file_path);
        return response()->download($filePath);
    }

    public function exportPdf(Peminjaman $peminjaman)
    {
        // Check if peminjaman has surat tugas
        if (!$peminjaman->suratTugas) {
            return back()->with('error', 'Surat Tugas belum diterbitkan untuk peminjaman ini.');
        }

        $suratTugas = $peminjaman->suratTugas->load(['peminjaman.user', 'peminjaman.kendaraan', 'peminjaman.supir']);

        $pdf = Pdf::loadView('pengurus-barang.surat-tugas.pdf', [
            'suratTugas' => $suratTugas,
        ]);

        return $pdf->download('surat-tugas-' . $suratTugas->nomor_surat . '.pdf');
    }

    public function exportWord(Peminjaman $peminjaman)
    {
        // Check if peminjaman has surat tugas
        if (!$peminjaman->suratTugas) {
            return back()->with('error', 'Surat Tugas belum diterbitkan untuk peminjaman ini.');
        }

        $suratTugas = $peminjaman->suratTugas->load(['peminjaman.user', 'peminjaman.kendaraan', 'peminjaman.supir']);

        // Create new PHPWord object
        $phpWord = new PhpWord();
        
        // Set document properties
        $properties = $phpWord->getDocInfo();
        $properties->setCreator('E-KDO SETWAN');
        $properties->setTitle('Surat Tugas - ' . $suratTugas->nomor_surat);

        // Add section
        $section = $phpWord->addSection([
            'marginTop' => 1134,    // 2cm in twips
            'marginBottom' => 1134,
            'marginLeft' => 1134,
            'marginRight' => 1134,
        ]);

        // Header
        $headerStyle = ['align' => 'center', 'spaceAfter' => 0];
        $section->addText('SEKRETARIAT DPRD PROVINSI DKI JAKARTA', ['bold' => true, 'size' => 14], $headerStyle);
        $section->addText('BAGIAN PERLENGKAPAN', ['bold' => true, 'size' => 13], $headerStyle);
        $section->addText('Jl. Kebon Sirih No. 18, Jakarta Pusat 10340', ['size' => 9], $headerStyle);
        $section->addText('Telp: (021) 3840350 | Fax: (021) 3840355', ['size' => 9], $headerStyle);
        
        // Line separator
        $section->addLine([
            'weight' => 2,
            'width' => 450,
            'height' => 0,
            'color' => '000000',
        ]);

        $section->addTextBreak(2);

        // Title
        $section->addText('SURAT TUGAS', ['bold' => true, 'size' => 12, 'underline' => 'single'], ['align' => 'center']);
        $section->addTextBreak(1);
        
        // Nomor Surat
        $section->addText('Nomor: ' . $suratTugas->nomor_surat, ['bold' => true], ['align' => 'center']);
        $section->addTextBreak(2);

        // Content
        $section->addText(
            'Yang bertanda tangan di bawah ini, Kepala Bagian Perlengkapan Sekretariat DPRD Provinsi DKI Jakarta, dengan ini memberikan tugas kepada:',
            ['size' => 11],
            ['align' => 'both', 'spaceAfter' => 200]
        );

        // Driver info table
        $table = $section->addTable(['borderSize' => 0, 'borderColor' => 'FFFFFF']);
        $table->addRow();
        $table->addCell(3000)->addText('Nama Supir', ['size' => 11]);
        $table->addCell(200)->addText(':', ['size' => 11]);
        $table->addCell(6000)->addText($suratTugas->peminjaman->supir->nama, ['bold' => true, 'size' => 11]);
        
        $table->addRow();
        $table->addCell(3000)->addText('Nomor HP', ['size' => 11]);
        $table->addCell(200)->addText(':', ['size' => 11]);
        $table->addCell(6000)->addText($suratTugas->peminjaman->supir->nomor_hp, ['size' => 11]);

        $section->addTextBreak(1);

        $section->addText(
            'Untuk melaksanakan tugas mengemudikan kendaraan dinas operasional dengan rincian sebagai berikut:',
            ['size' => 11],
            ['align' => 'both', 'spaceAfter' => 200]
        );

        // Details table
        $table2 = $section->addTable(['borderSize' => 0, 'borderColor' => 'FFFFFF']);
        
        $table2->addRow();
        $table2->addCell(3000)->addText('Kendaraan', ['size' => 11]);
        $table2->addCell(200)->addText(':', ['size' => 11]);
        $table2->addCell(6000)->addText($suratTugas->peminjaman->kendaraan->merk . ' ' . $suratTugas->peminjaman->kendaraan->tipe, ['size' => 11]);
        
        $table2->addRow();
        $table2->addCell(3000)->addText('Nomor Polisi', ['size' => 11]);
        $table2->addCell(200)->addText(':', ['size' => 11]);
        $table2->addCell(6000)->addText($suratTugas->peminjaman->kendaraan->nomor_polisi, ['bold' => true, 'size' => 11]);
        
        $table2->addRow();
        $table2->addCell(3000)->addText('Penanggung Jawab', ['size' => 11]);
        $table2->addCell(200)->addText(':', ['size' => 11]);
        $table2->addCell(6000)->addText($suratTugas->peminjaman->user->name, ['size' => 11]);
        
        $table2->addRow();
        $table2->addCell(3000)->addText('Tujuan', ['size' => 11]);
        $table2->addCell(200)->addText(':', ['size' => 11]);
        $table2->addCell(6000)->addText($suratTugas->peminjaman->tujuan, ['size' => 11]);
        
        $table2->addRow();
        $table2->addCell(3000)->addText('Keperluan', ['size' => 11]);
        $table2->addCell(200)->addText(':', ['size' => 11]);
        $table2->addCell(6000)->addText($suratTugas->peminjaman->kebutuhan, ['size' => 11]);
        
        $table2->addRow();
        $table2->addCell(3000)->addText('Periode Penugasan', ['size' => 11]);
        $table2->addCell(200)->addText(':', ['size' => 11]);
        $table2->addCell(6000)->addText(
            $suratTugas->peminjaman->tanggal_mulai->format('d F Y') . ' s/d ' . $suratTugas->peminjaman->tanggal_selesai->format('d F Y'),
            ['size' => 11]
        );
        
        $table2->addRow();
        $table2->addCell(3000)->addText('Nomor HP PIC', ['size' => 11]);
        $table2->addCell(200)->addText(':', ['size' => 11]);
        $table2->addCell(6000)->addText($suratTugas->peminjaman->nomor_hp_pic, ['size' => 11]);

        $section->addTextBreak(1);

        $section->addText(
            'Demikian Surat Tugas ini dibuat untuk dilaksanakan dengan sebaik-baiknya dan penuh tanggung jawab.',
            ['size' => 11],
            ['align' => 'both']
        );

        $section->addTextBreak(2);

        // Signature
        $signatureTable = $section->addTable(['borderSize' => 0, 'borderColor' => 'FFFFFF']);
        $signatureTable->addRow();
        $signatureTable->addCell(5000)->addText('');
        $signatureTable->addCell(4500)->addText(
            'Jakarta, ' . $suratTugas->tanggal_surat->format('d F Y'),
            ['size' => 11],
            ['align' => 'center']
        );
        
        $signatureTable->addRow();
        $signatureTable->addCell(5000)->addText('');
        $signatureTable->addCell(4500)->addText(
            'Kepala Bagian Perlengkapan',
            ['bold' => true, 'size' => 11],
            ['align' => 'center']
        );

        $signatureTable->addRow(1500);
        $signatureTable->addCell(5000)->addText('');
        $signatureTable->addCell(4500)->addText('');

        $signatureTable->addRow();
        $signatureTable->addCell(5000)->addText('');
        $signatureTable->addCell(4500)->addText(
            $suratTugas->createdBy->name,
            ['bold' => true, 'size' => 11],
            ['align' => 'center']
        );
        
        $signatureTable->addRow();
        $signatureTable->addCell(5000)->addText('');
        $signatureTable->addCell(4500)->addText(
            'NIP. __________________',
            ['size' => 11],
            ['align' => 'center']
        );

        $section->addTextBreak(1);

        // Notes
        $section->addText('Catatan:', ['italic' => true, 'size' => 9, 'color' => '666666']);
        $section->addListItem(
            'Supir wajib menjaga kendaraan dengan baik dan melaporkan jika terjadi kerusakan',
            0,
            ['size' => 9, 'color' => '666666'],
            ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER]
        );
        $section->addListItem(
            'Kendaraan harus dikembalikan dalam kondisi bersih dan terisi bahan bakar',
            0,
            ['size' => 9, 'color' => '666666'],
            ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER]
        );
        $section->addListItem(
            'Segala kerusakan atau kehilangan menjadi tanggung jawab pengemudi dan penanggung jawab',
            0,
            ['size' => 9, 'color' => '666666'],
            ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER]
        );

        // Save file
        $filename = 'surat-tugas-' . str_replace('/', '-', $suratTugas->nomor_surat) . '.docx';
        $tempFile = storage_path('app/temp/' . $filename);
        
        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }
}
