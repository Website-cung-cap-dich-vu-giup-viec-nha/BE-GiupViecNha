<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaChi extends Model
{
    use HasFactory;
    protected $table = "diachi";
    protected $primaryKey = 'idDiaChi';
    protected $fillable = [
        "idDiaChi",
        "Duong",
        "Phuong",
        "MacDinh",
        "HienThi",
        "idNguoiDung"
    ];
    public $timestamps = false;
}
