<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas - {{ $suratTugas->nomor_surat }}</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        .logo {
            width: 80px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 18pt;
            margin: 5px 0;
            font-weight: bold;
        }
        .header h2 {
            font-size: 16pt;
            margin: 5px 0;
        }
        .header p {
            font-size: 10pt;
            margin: 2px 0;
        }
        .title {
            text-align: center;
            margin: 30px 0;
        }
        .title h3 {
            text-decoration: underline;
            font-size: 14pt;
            margin: 0;
        }
        .nomor {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        .data-table {
            width: 100%;
            margin: 20px 0;
        }
        .data-table td {
            padding: 5px;
            vertical-align: top;
        }
        .data-table td:first-child {
            width: 30%;
        }
        .data-table td:nth-child(2) {
            width: 5%;
        }
        .signature {
            margin-top: 50px;
        }
        .signature-box {
            float: right;
            width: 40%;
            text-align: center;
        }
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SEKRETARIAT DPRD PROVINSI DKI JAKARTA</h1>
        <h2>BAGIAN PERLENGKAPAN</h2>
        <p>Jl. Kebon Sirih No. 18, Jakarta Pusat 10340</p>
        <p>Telp: (021) 3840350 | Fax: (021) 3840355</p>
    </div>

    <div class="title">
        <h3>SURAT TUGAS</h3>
    </div>

    <div class="nomor">
        <strong>Nomor: {{ $suratTugas->nomor_surat }}</strong>
    </div>

    <div class="content">
        <p>
            Yang bertanda tangan di bawah ini, Kepala Bagian Perlengkapan Sekretariat DPRD Provinsi DKI Jakarta, 
            dengan ini memberikan tugas kepada:
        </p>

        <table class="data-table">
            <tr>
                <td>Nama Supir</td>
                <td>:</td>
                <td><strong>{{ $suratTugas->peminjaman->supir->nama }}</strong></td>
            </tr>
            <tr>
                <td>Nomor HP</td>
                <td>:</td>
                <td>{{ $suratTugas->peminjaman->supir->nomor_hp }}</td>
            </tr>
        </table>

        <p>
            Untuk melaksanakan tugas mengemudikan kendaraan dinas operasional dengan rincian sebagai berikut:
        </p>

        <table class="data-table">
            <tr>
                <td>Kendaraan</td>
                <td>:</td>
                <td>{{ $suratTugas->peminjaman->kendaraan->merk }} {{ $suratTugas->peminjaman->kendaraan->tipe }}</td>
            </tr>
            <tr>
                <td>Nomor Polisi</td>
                <td>:</td>
                <td><strong>{{ $suratTugas->peminjaman->kendaraan->nomor_polisi }}</strong></td>
            </tr>
            <tr>
                <td>Penanggung Jawab</td>
                <td>:</td>
                <td>{{ $suratTugas->peminjaman->user->name }}</td>
            </tr>
            <tr>
                <td>Tujuan</td>
                <td>:</td>
                <td>{{ $suratTugas->peminjaman->tujuan }}</td>
            </tr>
            <tr>
                <td>Keperluan</td>
                <td>:</td>
                <td>{{ $suratTugas->peminjaman->kebutuhan }}</td>
            </tr>
            <tr>
                <td>Periode Penugasan</td>
                <td>:</td>
                <td>
                    {{ $suratTugas->peminjaman->tanggal_mulai->format('d F Y') }} s/d 
                    {{ $suratTugas->peminjaman->tanggal_selesai->format('d F Y') }}
                </td>
            </tr>
            <tr>
                <td>Nomor HP PIC</td>
                <td>:</td>
                <td>{{ $suratTugas->peminjaman->nomor_hp_pic }}</td>
            </tr>
        </table>

        <p>
            Demikian Surat Tugas ini dibuat untuk dilaksanakan dengan sebaik-baiknya dan penuh tanggung jawab.
        </p>
    </div>

    <div class="signature">
        <div class="signature-box">
            <p>Jakarta, {{ $suratTugas->tanggal_surat->format('d F Y') }}</p>
            <p><strong>Kepala Bagian Perlengkapan</strong></p>
            <div class="signature-line">
                <strong>{{ $suratTugas->createdBy->name }}</strong><br>
                NIP. __________________
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div style="margin-top: 30px; font-size: 10pt; color: #666;">
        <p><em>Catatan:</em></p>
        <ol style="margin-left: 20px;">
            <li>Supir wajib menjaga kendaraan dengan baik dan melaporkan jika terjadi kerusakan</li>
            <li>Kendaraan harus dikembalikan dalam kondisi bersih dan terisi bahan bakar</li>
            <li>Segala kerusakan atau kehilangan menjadi tanggung jawab pengemudi dan penanggung jawab</li>
        </ol>
    </div>
</body>
</html>
