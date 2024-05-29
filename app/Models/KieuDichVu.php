<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KieuDichVu extends Model
{
    use HasFactory;
    protected $table = 'kieudichvu';
    protected $fillable = [
        'idKieuDichVu',
        'tenKieuDichVu',
    ];
}
