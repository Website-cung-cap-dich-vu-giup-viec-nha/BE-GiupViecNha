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
            $table->foreignId('idChiTietDatDichVu')->nullable()->constrained('ChiTietDatDichVu');
            $table->dateTime('Ngay')->nullable();
            $table->double('SoKPI')->nullable();
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
