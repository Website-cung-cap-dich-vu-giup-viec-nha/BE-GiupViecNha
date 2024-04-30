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
        Schema::create('PhanQuyen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idQuyen')->nullable()->constrained('Quyen');
            $table->foreignId('idNhom')->nullable()->constrained('Nhom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PhanQuyen');
    }
};
