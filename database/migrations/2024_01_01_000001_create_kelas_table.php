<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('kelas', function(Blueprint $t){
   $t->id();
   $t->string('nama_sekolah');
   $t->string('npsn')->nullable();
   $t->string('tahun_pelajaran');
   $t->string('semester');
   $t->string('nama_kelas');
   $t->string('tingkat')->nullable();
   $t->string('wali_kelas');
   $t->string('nip_wali_kelas')->nullable();
   $t->string('ketua')->nullable();
   $t->string('wakil')->nullable();
   $t->string('sekretaris')->nullable();
   $t->string('bendahara')->nullable();
   $t->timestamps();
  });
 }
 public function down(){ Schema::dropIfExists('kelas'); }
};