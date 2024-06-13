<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    use HasFactory;
    protected $table = "phanquyen";
    protected $primaryKey = 'idPhanQuyen';
    protected $fillable = [
        "idPhanQuyen",
        "idNhom",
        "idQuyen",
    ];
    public $timestamps = false;
}
