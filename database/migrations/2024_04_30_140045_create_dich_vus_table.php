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
        Schema::create('DichVu', function (Blueprint $table) {
            $table->id('idDichVu');
            $table->string('tenDichVu')->nullable();
            $table->foreignId('idLoaiDichVu')->nullable()->references('idLoaiDichVu')->on('LoaiDichVu');
            $table->string('Anh')->nullable();
            $table->string('MoTa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DichVu');
    }
};
