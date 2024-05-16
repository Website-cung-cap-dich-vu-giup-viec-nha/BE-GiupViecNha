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
            $table->integer('SoBuoi')->nullable();
            $table->integer('SoGio')->nullable();
            $table->integer('SoNguoiDuocChamSoc')->nullable();
            $table->time('GioBatDau')->nullable();
            $table->string('GhiChu')->nullable();
            $table->integer('TinhTrang')->nullable();
            $table->foreignId('idDiaChi')->nullable()->constrained('DiaChi');
            $table->foreignId('idKhachHang')->nullable()->constrained('KhachHang');
            $table->foreignId('idChiTietDichVu')->nullable()->constrained('ChiTietDichVu');
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
