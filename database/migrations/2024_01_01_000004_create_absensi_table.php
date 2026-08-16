<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('absensi', function(Blueprint $t){
   $t->id();
   $t->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
   $t->date('tanggal');
   $t->enum('status',['H','S','I','A']);
   $t->string('keterangan')->nullable();
   $t->timestamps();
   $t->unique(['siswa_id','tanggal']);
  });
 }
 public function down(){ Schema::dropIfExists('absensi'); }
};