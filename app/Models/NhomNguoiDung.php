<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhomNguoiDung extends Model
{
    use HasFactory;
    protected $table = "nhomnguoidung";
    protected $primaryKey = 'idNhomNguoiDung';
    protected $fillable = [
        "idNhomNguoiDung",
        "idNhom",
        "idNhanVien"
    ];
    public $timestamps = false;
}
