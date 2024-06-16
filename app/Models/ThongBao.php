<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    use HasFactory;
    protected $table = "thongbao";
    protected $primaryKey = 'idThongBao';
    protected $fillable = [
        "idThongBao",
        "TieuDe",
        "NoiDung",
        "NgayTao",
        "idPhieuDichVu"
    ];
    public $timestamps = false;
}
