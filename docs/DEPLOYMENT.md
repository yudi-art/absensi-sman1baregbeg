
# DEPLOYMENT ONLINE - LENGKAP

### 1. Beli Domain & Hosting
Domain: absensi-sdn1.sch.id (Rp 150rb/tahun)
Hosting: Hostinger Premium (sudah include SSL gratis)

### 2. Upload
Via hPanel > File Manager > Upload zip laravel, extract.

### 3. Buat Database
hPanel > Databases > Buat absensi_db, user, password.

### 4. .env
Isi DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL=https://domainmu.

### 5. Terminal
Di hPanel buka Terminal:
composer install --no-dev
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

### 6. Point Domain ke folder public
hPanel > Domains > Set root folder ke /public

### 7. SSL
Aktifkan SSL gratis di hPanel > SSL.

### 8. Cron Backup Otomatis
Tambah Cron Job:
0 23 * * * cd /home/u123456789/domains/domainmu/public_html && php artisan backup:run

### 9. Selesai
Buka https://domainmu, login admin/admin123

### Biaya:
- Domain .sch.id: 150rb/tahun
- Hosting Hostinger: 400rb/tahun
- Total tahun pertama < 600rb, bisa dipakai 1 sekolah penuh.
