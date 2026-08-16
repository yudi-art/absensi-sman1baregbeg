<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('tabungan', function(Blueprint $t){
   $t->id();
   $t->date('tanggal');
   $t->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
   $t->enum('jenis',['setoran','penarikan']);
   $t->integer('nominal');
   $t->string('keterangan')->nullable();
   $t->foreignId('created_by')->nullable()->constrained('users');
   $t->timestamps();
  });
  Schema::create('audit_logs', function(Blueprint $t){
   $t->id();
   $t->foreignId('user_id')->nullable()->constrained('users');
   $t->string('aktivitas');
   $t->string('modul');
   $t->string('record_id')->nullable();
   $t->string('ip_address')->nullable();
   $t->timestamps();
  });
  Schema::create('pengumuman', function(Blueprint $t){
   $t->id();
   $t->string('judul');
   $t->text('isi');
   $t->date('tanggal');
   $t->string('target')->default('semua');
   $t->timestamps();
  });
 }
 public function down(){
  Schema::dropIfExists('pengumuman');
  Schema::dropIfExists('audit_logs');
  Schema::dropIfExists('tabungan');
 }
};