<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modeldiemdanh extends Model
{
    use HasFactory;    
    protected $primaryKey = 'id';
    protected $table = 'diemdanh';
    protected $fillable = [
        'id',
        'gio',
        'xuong',
        'manhanvien'
    ];
}
