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
        Schema::create('KPI', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idDichVu')->nullable()->constrained('DichVu');
            $table->dateTime('Ngay');
            $table->foreignId('idNhanVien')->nullable()->constrained('users');
            $table->double('SoKPI');
            $table->foreignId('idDatDichVu')->nullable()->constrained('DatDichVu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('KPI');
    }
};
