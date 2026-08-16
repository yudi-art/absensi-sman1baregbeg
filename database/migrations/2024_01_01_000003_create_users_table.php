<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('users', function(Blueprint $t){
   $t->id();
   $t->string('username')->unique();
   $t->string('password');
   $t->enum('role',['admin','wali_kelas','pengurus','siswa']);
   $t->foreignId('siswa_id')->nullable()->constrained('siswa')->nullOnDelete();
   $t->boolean('is_active')->default(true);
   $t->timestamps();
  });
 }
 public function down(){ Schema::dropIfExists('users'); }
};