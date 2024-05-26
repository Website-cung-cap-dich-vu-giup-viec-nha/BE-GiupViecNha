<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietNgayLam extends Model
{
    use HasFactory;
    protected $table = "chitietngaylam";
    protected $fillable = [
        "idChiTietNgayLam",
        "NgayLam",
        "idPhieuDichVu",
        "GhiChu",
        "TinhTrangDichVu"
    ];
    public $timestamps = false;
}
