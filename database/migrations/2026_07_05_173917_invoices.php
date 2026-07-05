<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Menggantikan id_invoice
            // Menghubungkan ke tabel pelanggans (Foreign Key)
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('restrict');
            $table->string('nomor_invoice')->unique(); // Format string unik untuk kode invoice
            $table->date('tanggal_invoice');
            $table->enum('status_pembayaran', ['Draft', 'Unpaid', 'Paid', 'Canceled'])->default('Unpaid');
            $table->decimal('total_tagihan', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
