
<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable {
 use HasApiTokens, HasFactory;
 protected $fillable = ['username','password','role','siswa_id','is_active'];
 protected $hidden = ['password'];
 public function siswa(){ return $this->belongsTo(Siswa::class); }
 public function isSiswa(){ return $this->role === 'siswa'; }
}
