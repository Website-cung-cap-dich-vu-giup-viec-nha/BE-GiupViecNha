<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDatDichVu extends Model
{
    use HasFactory;
    protected $table = "chitietnhanvienlamdichvu";
    protected $fillable = [
        'idChiTietNhanVienLamDichVu',
        'idChiTietNgayLam',
        'idNhanVien'
    ];
}
