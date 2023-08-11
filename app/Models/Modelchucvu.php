<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelchucvu extends Model
{
    use HasFactory;
    protected $primaryKey = 'manhanvien';
    protected $table = 'nhansu';
    protected $fillable = [
        'manhanvien',
        'tennhanvien',
        'tag',    
        'manhom',       
        
    ];
}
