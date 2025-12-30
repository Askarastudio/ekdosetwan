# Fitur Export Surat Tugas - Pengurus Barang

## Deskripsi
Fitur baru yang memungkinkan Pengurus Barang untuk:
1. **Cetak ulang** Surat Tugas yang sudah disetujui
2. **Export ke PDF** - Format final untuk distribusi
3. **Export ke Word (.docx)** - Format editable untuk modifikasi

## Lokasi Fitur

### 1. Menu Peminjaman (Daftar Semua Peminjaman)
**Path**: `/peminjaman`

**Akses**: Role Pengurus Barang

**Tombol yang tersedia**:
- 👁️ **Detail** - Lihat detail peminjaman
- 📄 **Export PDF** - Download Surat Tugas dalam format PDF (hanya muncul jika status "Disetujui" dan Surat Tugas sudah diterbitkan)
- 📥 **Export Word** - Download Surat Tugas dalam format Word yang dapat diedit (hanya muncul jika status "Disetujui" dan Surat Tugas sudah diterbitkan)

### 2. Menu Kelola Surat Tugas
**Path**: `/pengurus-barang/surat-tugas`

**Akses**: Role Pengurus Barang

**Tombol yang tersedia**:
- 📄 **Download PDF** - Download Surat Tugas dalam format PDF
- 📥 **Export Word** - Download Surat Tugas dalam format Word yang dapat diedit

## Cara Penggunaan

### Export ke PDF
1. Login sebagai Pengurus Barang
2. Buka menu **Peminjaman** atau **Kelola Surat Tugas**
3. Pada peminjaman yang berstatus "Disetujui" dan sudah memiliki Surat Tugas, klik icon 📄 (warna merah)
4. File PDF akan otomatis terdownload dengan nama: `surat-tugas-[nomor-surat].pdf`

### Export ke Word
1. Login sebagai Pengurus Barang
2. Buka menu **Peminjaman** atau **Kelola Surat Tugas**
3. Pada peminjaman yang berstatus "Disetujui" dan sudah memiliki Surat Tugas, klik icon 📥 (warna biru)
4. File Word akan otomatis terdownload dengan nama: `surat-tugas-[nomor-surat].docx`
5. Buka file dengan Microsoft Word atau aplikasi pengolah kata lainnya
6. Edit sesuai kebutuhan
7. Simpan perubahan

## Format Surat Tugas

Dokumen yang dihasilkan (baik PDF maupun Word) berisi:

### Header
- Nama instansi: SEKRETARIAT DPRD PROVINSI DKI JAKARTA
- Bagian: BAGIAN PERLENGKAPAN
- Alamat dan kontak

### Isi Surat
- **Nomor Surat**: Format `XXX/ST-KDO/MM/YYYY`
- **Data Supir**: Nama dan nomor HP
- **Data Kendaraan**: Merk, tipe, dan nomor polisi
- **Penanggung Jawab**: Nama peminjam
- **Tujuan**: Lokasi tujuan peminjaman
- **Keperluan**: Alasan peminjaman
- **Periode Penugasan**: Tanggal mulai s/d selesai
- **Nomor HP PIC**: Kontak person

### Footer
- Tanda tangan Kepala Bagian Perlengkapan
- Catatan untuk supir dan penanggung jawab

## Perbedaan Format PDF dan Word

| Aspek | PDF | Word |
|-------|-----|------|
| **Dapat diedit** | ❌ Tidak | ✅ Ya |
| **Format tetap** | ✅ Ya | ⚠️ Tergantung aplikasi |
| **Ukuran file** | Lebih kecil | Lebih besar |
| **Cocok untuk** | Distribusi final, cetak | Modifikasi, custom editing |
| **Kompatibilitas** | Universal | Perlu aplikasi Word processor |

## Technical Implementation

### Dependencies
```json
{
  "barryvdh/laravel-dompdf": "^3.1",
  "phpoffice/phpword": "^1.4"
}
```

### Routes
```php
Route::get('peminjaman/{peminjaman}/export-pdf', [SuratTugasController::class, 'exportPdf'])
    ->name('peminjaman.export-pdf');
    
Route::get('peminjaman/{peminjaman}/export-word', [SuratTugasController::class, 'exportWord'])
    ->name('peminjaman.export-word');
```

### Controller Methods
- `exportPdf(Peminjaman $peminjaman)` - Generate dan download PDF
- `exportWord(Peminjaman $peminjaman)` - Generate dan download Word document

### File Storage
- PDF: Disimpan di `storage/app/public/surat-tugas/`
- Word: Generated on-demand, temporary file di `storage/app/temp/`

## Validasi & Error Handling

### Kondisi yang harus dipenuhi:
1. ✅ User harus memiliki role "Pengurus Barang" atau "Admin"
2. ✅ Peminjaman harus berstatus "Disetujui"
3. ✅ Surat Tugas harus sudah diterbitkan

### Error Messages:
- **"Surat Tugas belum diterbitkan untuk peminjaman ini."**
  - Solusi: Terbitkan Surat Tugas terlebih dahulu dari menu "Kelola Surat Tugas"

## Testing Checklist

- [ ] Login sebagai Pengurus Barang
- [ ] Pastikan ada peminjaman dengan status "Disetujui"
- [ ] Pastikan Surat Tugas sudah diterbitkan
- [ ] Test export PDF - file terdownload dan dapat dibuka
- [ ] Test export Word - file terdownload dan dapat dibuka di Word
- [ ] Test edit file Word dan simpan perubahan
- [ ] Verify format dan konten dokumen sesuai
- [ ] Test dengan peminjaman tanpa Surat Tugas (harus muncul error)
- [ ] Test dengan user selain Pengurus Barang (tidak ada tombol export)

## Keamanan

### Access Control
- Hanya role "Pengurus Barang" dan "Admin" yang dapat mengakses fitur ini
- Middleware Laravel memastikan authorization yang tepat
- Route group dengan middleware `role:Pengurus Barang|Admin`

### Data Validation
- Pemeriksaan keberadaan Surat Tugas sebelum export
- Validasi status peminjaman harus "Disetujui"

## Maintenance

### Temp Directory Cleanup
File Word temporary disimpan di `storage/app/temp/` dan otomatis dihapus setelah download menggunakan `deleteFileAfterSend(true)`.

### PDF Storage
File PDF disimpan permanen di `storage/app/public/surat-tugas/` untuk memungkinkan re-download tanpa regenerate.

## Future Improvements

- [ ] Batch export multiple Surat Tugas
- [ ] Template customization dari admin panel
- [ ] Email Surat Tugas langsung ke supir
- [ ] Digital signature integration
- [ ] Export to other formats (Excel, etc)
- [ ] Preview before download

## Support & Documentation

Untuk pertanyaan atau bantuan terkait fitur ini:
- Email: admin@ekdosetwan.com
- Role default setelah seeding: `pengurus@ekdosetwan.com` (password: `password`)

---
**Versi**: 1.0  
**Tanggal**: 30 Desember 2025  
**Developer**: E-KDO Development Team
