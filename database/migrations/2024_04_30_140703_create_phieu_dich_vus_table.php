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
        Schema::create('PhieuDichVu', function (Blueprint $table) {
            $table->id('idPhieuDichVu');
            $table->double('Tongtien')->nullable();
            $table->date('NgayBatDau')->nullable();
            $table->integer('SoBuoi')->nullable();
            $table->integer('SoGio')->nullable();
            $table->integer('SoNguoiDuocChamSoc')->nullable();
            $table->time('GioBatDau')->nullable();
            $table->string('GhiChu')->nullable();
            $table->integer('TinhTrang')->nullable(); //Đơn dịch vụ được duyệt chưa
            $table->integer('TinhTrangThanhToan')->nullable();
            $table->foreignId('idDiaChi')->nullable()->references('idDiaChi')->on('DiaChi');
            $table->foreignId('idKhachHang')->nullable()->references('idKhachHang')->on('KhachHang');
            $table->foreignId('idChiTietDichVu')->nullable()->references('idChiTietDichVu')->on('ChiTietDichVu');
            $table->foreignId('idNhanVienQuanLyDichVu')->nullable()->references('idNhanVien')->on('NhanVien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PhieuDichVu');
    }
};
