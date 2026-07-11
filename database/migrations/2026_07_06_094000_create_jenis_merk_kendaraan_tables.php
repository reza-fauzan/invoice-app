<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->unique();
            $table->timestamps();
        });

        Schema::create('merk_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->unique();
            $table->timestamps();
        });

        // Seed default data
        $jenisDefaults = ['Truk Engkel', 'Truk CDD', 'Truk CDE', 'Truk Fuso', 'Truk Tronton', 'Truk Wingbox', 'Truk Trailer', 'Pickup', 'L300'];
        foreach ($jenisDefaults as $j) {
            DB::table('jenis_kendaraans')->insert(['nama' => $j, 'created_at' => now(), 'updated_at' => now()]);
        }

        $merkDefaults = ['Mitsubishi', 'Hino', 'Isuzu', 'Toyota', 'Daihatsu', 'Suzuki', 'Nissan', 'Mercedes-Benz', 'Volvo', 'Scania'];
        foreach ($merkDefaults as $m) {
            DB::table('merk_kendaraans')->insert(['nama' => $m, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('merk_kendaraans');
        Schema::dropIfExists('jenis_kendaraans');
    }
};
