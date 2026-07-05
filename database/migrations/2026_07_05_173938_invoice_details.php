<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            // Jika invoice dihapus, otomatis baris detailnya ikut terhapus (cascade)
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            // Produk tidak bisa dihapus jika masih tercatat di detail invoice (restrict)
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');
            $table->integer('qty');
            $table->decimal('harga_satuan', 15, 2); // Menyimpan harga historis saat transaksi terjadi
            $table->decimal('subtotal', 15, 2); // qty * harga_satuan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
