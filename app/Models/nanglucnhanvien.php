<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nanglucnhanvien extends Model
{
    use HasFactory;
    protected $table = "nanglucnhanvien";
    public $timestamps = false;
    protected $primaryKey = 'idNangLucNhanVien';
    protected $fillable = [
        'idNangLucNhanVien',
        'idDichVu',
        'idNhanVien'
    ];
}
