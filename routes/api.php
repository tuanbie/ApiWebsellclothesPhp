<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KhachhangController;
use App\Http\Controllers\SanphamController;
use App\Http\Controllers\HoadonController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('SanPham', [SanphamController::class, 'index']); 
// Route::get('LaySanPhamTheoId/{id}', [SanphamController::class, 'show']); 
// Route::post('ThemSanPham', [SanphamController::class, 'store']); 
// Route::put('CapNhatSanPham/{id}', [SanphamController::class, 'update']);
// Route::delete('XoaSanPham/{id}', [SanphamController::class, 'destroy']);

Route::resource('khachhang', KhachhangController::class);
Route::resource('sanpham', SanphamController::class);
Route::resource('hoadon', HoadonController::class);
Route::post('login', [KhachhangController::class, 'login']); 
// Route::post('/login', 'KhachhangController@login');
