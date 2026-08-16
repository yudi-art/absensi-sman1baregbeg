
<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa; use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller {
 public function index(Request $r){
   $q = Siswa::query();
   if($r->search) $q->where('nama','like','%'.$r->search.'%')->orWhere('nis','like','%'.$r->search.'%');
   if($r->jk) $q->where('jenis_kelamin',$r->jk);
   // Siswa hanya bisa lihat dirinya
   if($r->user()->role==='siswa'){
     $q->where('id',$r->user()->siswa_id);
   }
   return $q->with('user')->paginate(20);
 }
 public function store(Request $r){
   $r->validate(['nama'=>'required','nis'=>'required|unique:siswa','jenis_kelamin'=>'required']);
   $siswa = Siswa::create($r->only(['nama','nis','jenis_kelamin','alamat','no_hp','no_hp_ortu']));
   // auto buat akun siswa
   User::create([
     'username'=>$siswa->nis,
     'password'=>Hash::make('123456'),
     'role'=>'siswa',
     'siswa_id'=>$siswa->id
   ]);
   return response()->json($siswa,201);
 }
 public function update(Request $r,$id){ $s=Siswa::findOrFail($id); $s->update($r->all()); return $s; }
 public function destroy($id){ Siswa::findOrFail($id)->delete(); return response()->json(['message'=>'Hapus berhasil']); }
 public function import(Request $r){
   $r->validate(['file'=>'required|mimes:xlsx,xls,csv']);
   // gunakan maatwebsite/excel untuk produksi, ini contoh sederhana
   return response()->json(['message'=>'Gunakan Library Excel Import']);
 }
}
