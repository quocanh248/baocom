<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Modelnhansu extends Model
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
    public function getcv($manhanvien)
    {
        $gv = DB::table('congviec')
            ->crossJoin('loaicongviec')
            ->select('*')
            ->where('congviec.maloai', '=', DB::raw('loaicongviec.maloai'))
            ->where('manhanvien', '=', $manhanvien)
            ->orderBy('congviec.maloai', 'asc')
            ->orderBy('trangthai', 'asc')
            ->orderBy('congviec.updated_at', 'desc')
            ->get();
        return $gv;
    }
    public function getlscv($manhanvien)
    {
        $gv = DB::table('lscongviec')
            ->crossJoin('loaicongviec')
            ->select('malscongviec', 'ngayhethan', 'lscongviec.created_at', 'lscongviec.updated_at', 'tenloai', 'lscongviec.maloai', 'trangthai', 'duongdan', 'tieude', 'noidung', 'nguoithuchien')
            ->where('lscongviec.maloai', '=', DB::raw('loaicongviec.maloai'))
            ->where('manhanvien', '=', $manhanvien)
            ->orderBy('lscongviec.maloai', 'asc')
            ->orderBy('trangthai', 'asc')
            ->orderBy('lscongviec.updated_at', 'desc')
            ->take(200)
            ->get();
        return $gv;
    }
    public function getcv1($manhanvien)
    {
        $nhom = DB::table('congviec')
            ->where('manhanvien', $manhanvien)
            ->get();
        return $nhom;
    }
    public function getchucdanhql($id)
    {
        $idql = DB::table('sodo_nhansu')            
            ->where('id', $id)
            ->get();
        $nhom = DB::table('sodo_nhansu')
            ->crossJoin('chucdanh')
            ->crossJoin('nhansu1')
            ->where('chucdanh.machucdanh', '=', DB::raw('sodo_nhansu.machucdanh'))
            ->where('nhansu1.manhanvien', '=', DB::raw('sodo_nhansu.manhanvien'))
            ->where('chucdanh.machucdanh', $idql[0]->chucdanhql)
            ->get();
        return $nhom;
    }
}
