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
        Schema::create('ChiTietDichVu', function (Blueprint $table) {
            $table->id('idChiTietDichVu');
            $table->double('GiaTien')->nullable();
            $table->string('BuoiDangKyDichVu')->nullable();
            $table->string('tenChiTietDichVu')->nullable();
            $table->foreignId('idDichVu')->nullable()->references('idDichVu')->on('DichVu');
            $table->foreignId('idKieuDichVu')->nullable()->references('idKieuDichVu')->on('KieuDichVu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ChiTietDichVu');
    }
};
