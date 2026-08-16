
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\WhatsAppController;

Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
 Route::get('/me',[AuthController::class,'me']);
 Route::post('/logout',[AuthController::class,'logout']);

 Route::apiResource('siswa', SiswaController::class);
 Route::post('/whatsapp/send',[WhatsAppController::class,'send']);

 // Tambahkan: absensi, kas-masuk, kas-keluar, tabungan, laporan, pengumuman
 // Route::apiResource('absensi', AbsensiController::class);
 // Route::apiResource('kas-masuk', KasMasukController::class);
});
