<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
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

// Invoice
Route::resource('invoice', InvoiceController::class);

// Pembayaran
Route::resource('pembayaran', PembayaranController::class)->except(['show']);
