
<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
 public function login(Request $r){
   $r->validate(['username'=>'required','password'=>'required']);
   $user = User::where('username',$r->username)->first();
   if(!$user || !Hash::check($r->password, $user->password)){
     return response()->json(['message'=>'Username atau password salah'],401);
   }
   if(!$user->is_active) return response()->json(['message'=>'Akun nonaktif'],403);
   $token = $user->createToken('web')->plainTextToken;
   return response()->json(['token'=>$token,'user'=>$user->load('siswa')]);
 }
 public function me(Request $r){ return $r->user()->load('siswa'); }
 public function logout(Request $r){ $r->user()->currentAccessToken()->delete(); return response()->json(['message'=>'Logout berhasil']); }
}
