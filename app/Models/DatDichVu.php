<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatDichVu extends Model
{
    use HasFactory;
    protected $table = "phieudichvu";
    protected $primaryKey = 'idPhieuDichVu';
    protected $fillable = [
        "idPhieuDichVu",
        "Tongtien",
        "NgayBatDau",
        "SoBuoi",
        "SoGio",
        "SoNguoiDuocChamSoc",
        "GioBatDau",
        "GhiChu",
        "TinhTrang",
        "TinhTrangThanhToan",
        "NgayDat",
        "idDiaChi",
        "idKhachHang",
        "idChiTietDichVu",
        "idNhanVienQuanLyDichVu"
    ];
    public $timestamps = false;
}
