<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDatDichVu extends Model
{
    use HasFactory;
    protected $table = "chitietnhanvienlamdichvu";
    public $timestamps = false;
    protected $primaryKey = 'idChiTietNhanVienLamDichVu';
    protected $fillable = [
        'idChiTietNhanVienLamDichVu',
        'idChiTietNgayLam',
        'idNhanVien'
    ];
}
