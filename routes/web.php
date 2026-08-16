<?php
use Illuminate\Support\Facades\Route;
Route::get('/', fn()=>response()->json(['status'=>'Absensi SMAN1 Baregbeg API Online','version'=>'1.0']));
Route::get('/up', fn()=>response()->json(['ok'=>true]));
