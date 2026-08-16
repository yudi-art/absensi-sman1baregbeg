
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Siswa extends Model {
 protected $fillable = ['nama','nis','jenis_kelamin','alamat','no_hp','no_hp_ortu'];
 public function absensi(){ return $this->hasMany(Absensi::class); }
 public function kasMasuk(){ return $this->hasMany(KasMasuk::class); }
 public function tabungan(){ return $this->hasMany(Tabungan::class); }
 public function user(){ return $this->hasOne(User::class); }
 public function getSaldoTabunganAttribute(){
   $setor = $this->tabungan()->where('jenis','setoran')->sum('nominal');
   $tarik = $this->tabungan()->where('jenis','penarikan')->sum('nominal');
   return $setor - $tarik;
 }
}
