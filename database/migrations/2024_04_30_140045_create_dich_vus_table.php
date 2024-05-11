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
            $table->string('ten')->nullable();
            $table->foreignId('idLoaiDichVu')->nullable()->constrained('LoaiDichVu');
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
