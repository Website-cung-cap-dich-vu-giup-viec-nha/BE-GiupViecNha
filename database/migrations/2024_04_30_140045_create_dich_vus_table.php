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
            $table->id();
            $table->string('MaDichVu')->nullable()->unique();
            $table->string('ten')->nullable();
            $table->double('SoKPI')->nullable();
            $table->foreignId('idLoaiDichVu')->nullable()->constrained('LoaiDichVu');
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
