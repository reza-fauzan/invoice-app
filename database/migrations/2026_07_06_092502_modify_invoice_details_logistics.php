<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            // Drop old columns
            $table->dropForeign(['produk_id']);
            $table->dropColumn(['produk_id', 'qty', 'harga_satuan', 'subtotal']);

            // Add new logistics columns
            $table->date('tanggal_kirim')->nullable()->after('invoice_id');
            $table->string('no_pol')->nullable()->after('tanggal_kirim');
            $table->string('penerima')->nullable()->after('no_pol');
            $table->string('sa_no')->nullable()->after('penerima');
            $table->text('surat_jalan')->nullable()->after('sa_no');
            $table->string('tujuan')->nullable()->after('surat_jalan');
            $table->string('keterangan')->nullable()->after('tujuan');
            $table->integer('colly')->nullable()->after('keterangan');
            $table->decimal('tonase', 12, 2)->default(0)->after('colly');
            $table->string('satuan', 20)->default('Kg')->after('tonase');
            $table->decimal('tarif', 15, 2)->default(0)->after('satuan');
            $table->decimal('jumlah', 15, 2)->default(0)->after('tarif');
        });
    }

    public function down(): void
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_kirim', 'no_pol', 'penerima', 'sa_no',
                'surat_jalan', 'tujuan', 'keterangan', 'colly',
                'tonase', 'satuan', 'tarif', 'jumlah',
            ]);

            $table->foreignId('produk_id')->constrained('produks')->cascadeOnDelete();
            $table->integer('qty');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
        });
    }
};
