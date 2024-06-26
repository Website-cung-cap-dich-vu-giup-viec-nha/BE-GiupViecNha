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
        Schema::create('nanglucnhanvien', function (Blueprint $table) {
            $table->id('idNangLucNhanVien');
            $table->foreignId('idNhanVien')->nullable()->references('idNhanVien')->on('NhanVien');
            $table->foreignId('idDichVu')->nullable()->references('idDichVu')->on('dichvu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nanglucnhanvien');
    }
};
