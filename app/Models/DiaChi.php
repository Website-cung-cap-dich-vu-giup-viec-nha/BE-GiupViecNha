<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaChi extends Model
{
    use HasFactory;
    protected $table = "DiaChi";
    protected $primaryKey = 'idDiaChi';
    protected $fillable = [
        "idDiaChi",
        "Duong",
        "Phuong",
        "idNguoiDung",
        "MacDinh"
    ];
    public $timestamps = false;
}
