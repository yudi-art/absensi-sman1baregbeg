<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('kas_masuk', function(Blueprint $t){
   $t->id();
   $t->date('tanggal');
   $t->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
   $t->integer('nominal');
   $t->string('keterangan')->nullable();
   $t->foreignId('created_by')->nullable()->constrained('users');
   $t->timestamps();
  });
  Schema::create('kas_keluar', function(Blueprint $t){
   $t->id();
   $t->date('tanggal');
   $t->string('jenis');
   $t->integer('nominal');
   $t->string('keterangan')->nullable();
   $t->foreignId('created_by')->nullable()->constrained('users');
   $t->timestamps();
  });
 }
 public function down(){
  Schema::dropIfExists('kas_keluar');
  Schema::dropIfExists('kas_masuk');
 }
};