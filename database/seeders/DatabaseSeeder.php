
<?php
// Taruh di database/seeders/DatabaseSeeder.php
use Illuminate\Database\Seeder;
use App\Models\User; use App\Models\Siswa; use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
 public function run(){
  Kelas::create([
   'nama_sekolah'=>'SD Negeri 1 Tanjunglaya',
   'npsn'=>'12345678',
   'tahun_pelajaran'=>'2025/2026',
   'semester'=>'Ganjil',
   'nama_kelas'=>'Kelas 6A',
   'wali_kelas'=>'Ibu Siti Rahayu, S.Pd',
   'nip_wali_kelas'=>'198001012005012001',
   'ketua'=>'Budi','wakil'=>'Siti','sekretaris'=>'Ahmad','bendahara'=>'Dewi'
  ]);

  $siswaList = [
   ['nama'=>'Budi Santoso','nis'=>'001','jenis_kelamin'=>'Laki-laki','alamat'=>'Tanjunglaya','no_hp'=>'081234567001','no_hp_ortu'=>'081234567101'],
   ['nama'=>'Siti Aminah','nis'=>'002','jenis_kelamin'=>'Perempuan','alamat'=>'Tanjunglaya','no_hp'=>'081234567002','no_hp_ortu'=>'081234567102'],
   ['nama'=>'Ahmad Rizki','nis'=>'003','jenis_kelamin'=>'Laki-laki','alamat'=>'Tanjunglaya','no_hp'=>'081234567003','no_hp_ortu'=>'081234567103'],
   ['nama'=>'Dewi Lestari','nis'=>'004','jenis_kelamin'=>'Perempuan','alamat'=>'Tanjunglaya','no_hp'=>'081234567004','no_hp_ortu'=>'081234567104'],
   ['nama'=>'Joko Widodo','nis'=>'005','jenis_kelamin'=>'Laki-laki','alamat'=>'Tanjunglaya','no_hp'=>'081234567005','no_hp_ortu'=>'081234567105'],
  ];
  foreach($siswaList as $s){ $sis=Siswa::create($s); User::create(['username'=>$sis->nis,'password'=>Hash::make('123456'),'role'=>'siswa','siswa_id'=>$sis->id]); }

  User::create(['username'=>'admin','password'=>Hash::make('admin123'),'role'=>'admin']);
  User::create(['username'=>'wali','password'=>Hash::make('wali123'),'role'=>'wali_kelas']);
  User::create(['username'=>'pengurus','password'=>Hash::make('pengurus123'),'role'=>'pengurus']);
 }
}
