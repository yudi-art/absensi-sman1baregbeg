<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('siswa', function(Blueprint $t){
   $t->id();
   $t->string('nama');
   $t->string('nis')->unique();
   $t->enum('jenis_kelamin',['Laki-laki','Perempuan']);
   $t->text('alamat')->nullable();
   $t->string('no_hp')->nullable();
   $t->string('no_hp_ortu')->nullable();
   $t->timestamps();
  });
 }
 public function down(){ Schema::dropIfExists('siswa'); }
};