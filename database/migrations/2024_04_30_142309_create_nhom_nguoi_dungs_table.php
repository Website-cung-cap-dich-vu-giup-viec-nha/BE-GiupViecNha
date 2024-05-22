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
        Schema::create('NhomNguoiDung', function (Blueprint $table) {
            $table->id('idNhomNguoiDung');
            $table->foreignId('idNhanVien')->nullable()->references('id')->on('users');
            $table->foreignId('idNhom')->nullable()->references('idNhom')->on('Nhom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('NhomNguoiDung');
    }
};
