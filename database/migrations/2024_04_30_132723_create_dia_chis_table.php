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
        Schema::create('DiaChi', function (Blueprint $table) {
            $table->id('idDiaChi');
            $table->string('Duong')->nullable();
            $table->foreignId('Phuong')->nullable()->constrained()->references('ward_id')->on('ward');
            $table->foreignId('idNguoiDung')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DiaChi');
    }
};
