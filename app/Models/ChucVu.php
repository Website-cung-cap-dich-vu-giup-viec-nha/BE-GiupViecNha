<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChucVu extends Model
{
    use HasFactory;
    protected $table = 'chucvu';
    protected $primaryKey = 'idChucVu';
    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['idChucVu', 'tenChucVu', 'idPhongBan'];
}
