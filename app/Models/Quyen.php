<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    use HasFactory;
    protected $table = "quyen";
    protected $primaryKey = 'idQuyen';
    protected $fillable = [
        "idQuyen",
        "tenQuyen",
    ];
    public $timestamps = false;
}
