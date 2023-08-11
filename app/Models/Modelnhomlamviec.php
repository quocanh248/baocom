<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelnhomlamviec extends Model
{
    use HasFactory;
    protected $primaryKey = 'manhom';
    protected $table = 'nhomlamviec';
    protected $fillable = [
        'manhom',
        'tennhom',        
        
    ];
}
