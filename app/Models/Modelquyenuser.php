<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Modelquyenuser extends Model
{
    use HasFactory;

    protected $table = 'quyenuser';
    protected $fillable = [
        'maquyen',
        'id',

    ];
    public function getquyenuser($manhanvien)
    {
        $gv = DB::table('nhansu')
            ->crossJoin('users')
            ->crossJoin('quyenuser')
            ->crossJoin('quyen')
            ->select('quyen.maquyen', 'tenquyen')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', '=', DB::raw('quyenuser.id'))
            ->where('quyenuser.maquyen', '=', DB::raw('quyen.maquyen'))
            ->where('nhansu.manhanvien', '=', $manhanvien)
            ->get();



        return $gv;
    }
}
