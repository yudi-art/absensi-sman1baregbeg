
# SISTEM ABSENSI, KAS & TABUNGAN - VERSI ONLINE MULTI-USER
## Laravel 10 + MySQL + Sanctum

### Fitur Online
- Database terpusat MySQL, semua user (Admin, Wali, Pengurus, Siswa) akses data sama
- Auth Sanctum + Role Middleware (admin, wali_kelas, pengurus, siswa)
- Siswa hanya bisa akses data miliknya (policy by siswa_id)
- WhatsApp Center siap integrasi Fonnte / Wablas / WhatsApp Business API
- Backup otomatis via Cron

### Cara Install di Hosting / VPS (5 Menit)
1. Beli Hosting yang support Laravel (Hostinger, Niagahoster, IDCloudHost)
2. Upload semua file ke public_html, atau via git clone
3. Buat database MySQL: absensi_db
4. Copy .env.example ke .env dan isi DB_DATABASE, DB_USERNAME, DB_PASSWORD
5. Jalankan di terminal hosting:
   composer install
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
6. Set domain ke folder public
7. Login default:
   admin / admin123
   wali / wali123
   pengurus / pengurus123
   siswa NIS / 123456

### Akun Default (Seeder)
Lihat database/seeders/DatabaseSeeder.php

### API Endpoints
- POST /api/login
- GET /api/dashboard (role filtered)
- CRUD /api/siswa, /api/absensi, /api/kas-masuk, /api/kas-keluar, /api/tabungan
- POST /api/whatsapp/send (integrasi)

### Frontend
Gunakan frontend React yang sudah kamu punya, tinggal ganti localStorage menjadi fetch ke /api/...

Lihat docs/UPGRADE_FRONTEND.md
