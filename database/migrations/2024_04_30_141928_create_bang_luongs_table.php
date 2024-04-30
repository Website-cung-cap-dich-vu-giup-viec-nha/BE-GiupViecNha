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
        Schema::create('BangLuong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idNhanVien')->nullable()->constrained('users');
            $table->date('Thang');
            $table->double('SoSao');
            $table->double('LuongCoBan');
            $table->double('PhuCap');
            $table->double('SoKPICoBan');
            $table->double('SoKPIThucTe');
            $table->double('TongLuong');
            $table->double('BaoHiemXaHoi');
            $table->double('LuongThucNhan');
            $table->double('LuongDaTra');
            $table->double('LuongConNo');
            $table->double('TinhTrang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('BangLuong');
    }
};
