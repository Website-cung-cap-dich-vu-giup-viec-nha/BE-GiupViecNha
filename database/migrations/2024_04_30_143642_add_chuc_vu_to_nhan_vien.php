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
        Schema::table('NhanVien', function (Blueprint $table) {
            $table->foreignId('idChucVu')->nullable()->references('idChucVu')->on('ChucVu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('NhanVien', function (Blueprint $table) {
            $table->dropForeign(['idChucVu']);
            $table->dropColumn('idChucVu');
        });
    }
};
