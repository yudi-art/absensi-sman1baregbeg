
# Cara Ubah Frontend React (Versi localStorage) jadi Online

Frontend yang sudah jadi (artifact HTML) perlu diubah fetch ke Laravel API.

## Langkah:

1. Ganti fungsi loadData():
   SEBELUM:
   const siswa = JSON.parse(localStorage.getItem('app_siswa'))

   SESUDAH:
   const token = localStorage.getItem('token');
   const res = await fetch('https://absensi.sekolahmu.sch.id/api/siswa', {
     headers: { Authorization: 'Bearer '+token }
   });
   const siswa = await res.json();

2. Semua simpan data ganti POST ke /api/...
   Contoh simpan absensi:
   await fetch('/api/absensi', { method:'POST', body: JSON.stringify({siswa_id, tanggal, status}) })

3. Untuk Siswa: Backend sudah filter otomatis where siswa_id = auth()->user()->siswa_id
   Jadi aman, siswa tidak bisa lihat data orang lain walaupun ganti URL.

4. WhatsApp: 
   const {url} = await fetch('/api/whatsapp/send', {method:'POST', body:{phone, message}}).then(r=>r.json())
   window.open(url,'_blank') // jika mode link

5. Deploy frontend ke Vercel, set env VITE_API_URL=https://absensi.sekolahmu.sch.id

## Keamanan Role (Middleware Laravel)
Buat middleware RoleMiddleware:
public function handle($request, Closure $next, ...$roles){
  if(!in_array($request->user()->role, $roles)) abort(403,'Tidak ada izin');
  return $next($request);
}

Terapkan di route:
Route::middleware(['auth:sanctum','role:admin,wali_kelas'])->group(...)

## Hosting Rekomendasi:
- Shared: Hostinger (Rp 30rb/bln, support Laravel)
- VPS: IDCloudHost / DigitalOcean (untuk WA API + Cron backup)
- Gratis: Vercel (frontend) + Railway (backend MySQL)
