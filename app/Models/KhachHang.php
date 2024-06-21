<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;
    protected $table = "khachhang";

    protected $fillable = [
        "idKhachHang",
        "idNguoiDung"
    ];
    public $timestamps = false;
}
