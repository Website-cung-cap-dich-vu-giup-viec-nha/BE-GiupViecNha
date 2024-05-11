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
        Schema::create('ChiTietDatDichVu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idDatDichVu')->nullable()->constrained('DatDichVu');
            $table->foreignId('idNhanVien')->nullable()->constrained('NhanVien');
            $table->boolean('isTruongNhom')->nullable();
            $table->date('NgayLam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ChiTietDatDichVu');
    }
};
