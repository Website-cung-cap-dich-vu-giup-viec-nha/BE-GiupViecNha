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
        Schema::create('ChiTietNgayLam', function (Blueprint $table) {
            $table->id();
            $table->integer('Thu')->nullable();
            $table->foreignId('idDatDichVu')->nullable()->constrained('DatDichVu');
            $table->integer('TinhTrang')->nullable();
            $table->string('GhiChu')->nullable();
            $table->integer('TinhTrangDichVu')->nullable();
            $table->integer('TinhTrangThanhToan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ChiTietNgayLam');
    }
};
