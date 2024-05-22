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
            $table->id('idBangLuong');
            $table->foreignId('idNhanVien')->nullable()->references('idNhanVien')->on('NhanVien');
            $table->date('NgayXuatBangLuong')->nullable();
            $table->double('SoSao')->nullable();
            $table->double('Luong')->nullable();
            $table->double('TinhTrang')->nullable();
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
