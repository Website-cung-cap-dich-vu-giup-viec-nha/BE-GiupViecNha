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
        Schema::create('DanhGia', function (Blueprint $table) {
            $table->id();
            $table->integer('SoSao')->nullable();
            $table->string('YKien')->nullable();
            $table->foreignId('idDatDichVu')->nullable()->constrained('DatDichVu');
            $table->foreignId('idNhanVien')->nullable()->constrained('NhanVien');
            $table->foreignId('idKhachHang')->nullable()->constrained('KhachHang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DanhGia');
    }
};
