<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id(); // Menggantikan id_pembayaran
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->string('metode_pembayaran'); // Misal: 'Transfer Bank', 'Cash', 'E-Wallet'
            $table->string('bukti_bayar')->nullable(); // Menyimpan path file gambar/pdf struk transfer
            $table->enum('status_validasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
