# E-Peminjaman KDO (Kendaraan Dinas Operasional)

Aplikasi E-Peminjaman KDO Sekretariat DPRD Provinsi DKI Jakarta - Sistem manajemen peminjaman kendaraan dinas yang lengkap dan terintegrasi.

## Fitur Utama

### 1. Manajemen Kendaraan
- Database lengkap kendaraan dinas (merk, tipe, nomor polisi, galeri foto)
- Status kondisi kendaraan (Sangat Baik, Perbaikan, Rusak)
- CRUD kendaraan oleh Admin

### 2. Manajemen Supir
- Database supir dengan foto profil dan kontak WhatsApp
- Status ketersediaan (Standby, On Duty)
- CRUD supir oleh Admin

### 3. Sistem Peminjaman Multi-Level
- **User (Anggota Dewan)**: Mengajukan peminjaman
- **P3B (Kassubag Perlengkapan)**: Verifikasi dan penugasan kendaraan/supir
- **Pengurus Barang**: Approval akhir dan penerbitan Surat Tugas

### 4. Kalender Interaktif
- Visualisasi ketersediaan kendaraan (Flight Booking Style)
- FullCalendar API integration (to be completed)
- Detail peminjaman yang sudah ada (klik untuk lihat detail)

### 5. Aturan & Validasi Dinamis
- Batas maksimal hari peminjaman (konfigurable)
- Filter hari: Semua hari atau Hanya hari libur
- Cooldown period 14 hari setelah peminjaman selesai

### 6. Fitur Tambahan
- Audit log lengkap untuk semua aktivitas
- Integrasi WhatsApp untuk komunikasi dengan supir (to be completed)
- Generate Surat Tugas otomatis (PDF) (to be completed)
- Dashboard berbeda untuk setiap role
- Mobile-responsive design

## Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL/SQLite
- **Frontend**: Tailwind CSS + Blade
- **Authentication**: Laravel Breeze
- **Permissions**: Spatie Laravel Permission
- **PDF Generator**: DomPDF
- **Calendar**: FullCalendar (to be integrated)

## Instalasi

### Requirements
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL (atau SQLite untuk development)

### Langkah Instalasi

1. Clone repository
2. Install dependencies:
```bash
composer install
npm install
```

3. Copy file environment:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Konfigurasi database di file `.env` (atau gunakan SQLite default)

6. Jalankan migrasi dan seeder:
```bash
php artisan migrate --seed
```

7. Buat storage symlink:
```bash
php artisan storage:link
```

8. Build assets:
```bash
npm run build
```

9. Jalankan aplikasi:
```bash
php artisan serve
```

## Default Users

Setelah seeding, Anda dapat login dengan akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ekdosetwan.com | password |
| P3B | p3b@ekdosetwan.com | password |
| Pengurus Barang | pengurus@ekdosetwan.com | password |
| User | user@ekdosetwan.com | password |

## Struktur Database

### Tabel Utama
- **users**: Data pengguna dengan role
- **kendaraans**: Master data kendaraan
- **supirs**: Master data supir
- **peminjamans**: Data peminjaman
- **settings**: Konfigurasi dinamis
- **audit_logs**: Log aktivitas
- **surat_tugas**: Data surat tugas

### Roles & Permissions
- **Admin**: Full access
- **P3B**: Verifikasi peminjaman, assign kendaraan & supir
- **Pengurus Barang**: Approval, cetak surat tugas
- **User**: Ajukan peminjaman

## Workflow Peminjaman

1. **Pengajuan**: User mengisi form peminjaman
2. **Validasi**: Sistem cek limit hari dan cooldown period
3. **Verifikasi P3B**: Kassubag Perlengkapan verifikasi dan assign kendaraan/supir
4. **Approval**: Pengurus Barang approve dan terbitkan Surat Tugas
5. **Eksekusi**: Supir menerima penugasan
6. **Selesai**: Admin close order, trigger cooldown 14 hari

## Development Status

### Completed ✅
- Laravel 11 setup with authentication
- Database schema and migrations
- Models with relationships
- Role-based access control
- Admin, P3B, Pengurus Barang, and User dashboards
- Kendaraan management (CRUD - partial)
- Audit logging system
- Cooldown period logic

### In Progress 🚧
- FullCalendar integration
- Complete CRUD for all master data
- Peminjaman workflow implementation
- PDF generation for Surat Tugas
- WhatsApp integration

### To Do 📋
- Gantt Chart visualization
- Notification system
- Advanced reporting
- Mobile app (future consideration)

## License

This project is proprietary software developed for Sekretariat DPRD Provinsi DKI Jakarta.
