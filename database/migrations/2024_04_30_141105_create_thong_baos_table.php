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
        Schema::create('ThongBao', function (Blueprint $table) {
            $table->id();
            $table->string('TieuDe')->nullable();
            $table->string('NoiDung')->nullable();
            $table->foreignId('idDatDichVu')->nullable()->constrained('DatDichVu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ThongBao');
    }
};
