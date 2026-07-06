<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pol', 20)->unique();
            $table->string('jenis_kendaraan', 100)->nullable();
            $table->string('merk', 100)->nullable();
            $table->string('tahun', 4)->nullable();
            $table->string('nama_driver', 100)->nullable();
            $table->string('no_telp_driver', 20)->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
