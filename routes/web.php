<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JenisKendaraanController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\MerkKendaraanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Pelanggan
Route::resource('pelanggan', PelangganController::class)->except(['show']);

// Produk
Route::resource('produk', ProdukController::class)->except(['show']);

// Kendaraan
Route::resource('kendaraan', KendaraanController::class)->except(['show']);

// Master Jenis & Merk Kendaraan
Route::resource('jenis-kendaraan', JenisKendaraanController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('merk-kendaraan', MerkKendaraanController::class)->only(['index', 'store', 'update', 'destroy']);

// Master Penerima
Route::resource('penerima-master', PenerimaController::class)->only(['index', 'store', 'update', 'destroy']);

// Invoice
Route::get('invoice/{invoice}/print', [InvoiceController::class, 'print'])->name('invoice.print');
Route::resource('invoice', InvoiceController::class);

// Pembayaran
Route::resource('pembayaran', PembayaranController::class)->except(['show']);
