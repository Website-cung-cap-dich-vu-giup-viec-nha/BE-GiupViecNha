<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('BangGiaDichVu', function (Blueprint $table) {
            $table->id();
            $table->double('GiaTien')->nullable();
            $table->string('Thu')->nullable();
            $table->integer('GioBatDau')->nullable();
            $table->integer('GioKetThuc')->nullable();
            $table->foreignId('idDichVu')->nullable()->constrained('DichVu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('BangGiaDichVu');
    }
};
