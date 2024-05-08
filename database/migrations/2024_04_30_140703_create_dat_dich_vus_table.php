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
        Schema::create('DatDichVu', function (Blueprint $table) {
            $table->id();
            $table->double('Tongtien')->nullable();
            $table->date('NgayBatDau')->nullable();
            $table->date('NgayKetThuc')->nullable();
            $table->time('ThoiGianBatDau')->nullable();
            $table->time('ThoiGianKetThuc')->nullable();
            $table->string('GhiChu')->nullable();
            $table->foreignId('idDiaChi')->nullable()->constrained('DiaChi');
            $table->foreignId('idKhachHang')->nullable()->constrained('KhachHang');
            $table->time('ThoiGianBatDauCongViec')->nullable();
            $table->time('ThoiGianKetThucCongViec')->nullable();
            $table->integer('TrangThai')->nullable();
            $table->foreignId('idDichVu')->nullable()->constrained('DichVu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DatDichVu');
    }
};
