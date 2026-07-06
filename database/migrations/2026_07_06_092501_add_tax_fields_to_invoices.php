<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->date('tanggal_jatuh_tempo')->nullable()->after('tanggal_invoice');
            $table->decimal('sub_total', 15, 2)->default(0)->after('total_tagihan');
            $table->decimal('dpp', 15, 2)->default(0)->after('sub_total');
            $table->decimal('ppn', 15, 2)->default(0)->after('dpp');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['tanggal_jatuh_tempo', 'sub_total', 'dpp', 'ppn']);
        });
    }
};
