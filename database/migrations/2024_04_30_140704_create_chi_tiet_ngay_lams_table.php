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
            $table->id('idChiTietNgayLam');
            $table->date('NgayLam')->nullable();
            $table->foreignId('idPhieuDichVu')->nullable()->references('idPhieuDichVu')->on('PhieuDichVu');
            $table->string('GhiChu')->nullable();
            $table->integer('TinhTrangDichVu')->nullable(); // 1: Chưa phân nhân viên, 2: Đã đủ NV, 3: Đang làm DV, 4: Đã hoàn thành
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
