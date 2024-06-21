<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongBan extends Model
{
    use HasFactory;
    protected $table = 'phongban';
    protected $primaryKey = 'idPhongBan';
    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'idPhongBan',
        'tenPhongBan',
    ];
}
