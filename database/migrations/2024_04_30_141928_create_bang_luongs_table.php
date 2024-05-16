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
            $table->foreignId('idNhanVien')->nullable()->constrained('NhanVien');
            $table->date('Thang')->nullable();
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
