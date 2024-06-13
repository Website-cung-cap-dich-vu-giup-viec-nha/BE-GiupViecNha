<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nhom extends Model
{
    use HasFactory;
    protected $table = "nhom";
    protected $primaryKey = 'idNhom';
    protected $fillable = [
        "idNhom",
        "tenNhom",
    ];
    public $timestamps = false;
}
