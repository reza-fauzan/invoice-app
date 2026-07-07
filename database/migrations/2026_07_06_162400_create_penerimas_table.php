<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerimas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150)->unique();
            $table->string('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimas');
    }
};
