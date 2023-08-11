<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use App\Models\Modelnhansu;
use App\Models\Modelnhomlamviec;
use DateTime;
use DateTimeZone;
use App\Models\Modelquyenuser;
use Session;
use Carbon\CarbonTimeZone;

class controllersodo extends Controller
{
    public function capnhatsodo()
    {
        $dsnhansu = DB::table('nhansu')->get();
        $dschucdanh = DB::table('chucdanh')->get();
        return view('capnhatsodo', [
            'dsnhansu' => $dsnhansu,
            'dschucdanh' => $dschucdanh,
        ]);
    }
    public function dssodo()
    {
        $gv = new Modelnhansu;
        $dsnhansu = DB::table('sodo_nhansu')
            ->crossJoin('nhansu1')
            ->select('*')
            ->where('sodo_nhansu.manhanvien', '=', DB::raw('nhansu1.manhanvien'))
            ->get();
        //$dsnhansu = DB::table('sodo_nhansu')->get();
        return view('dssodo', [
            'dsnhansu' => $dsnhansu,
            'gv' => $gv,

        ]);
    }
    public function sodo()
    {
        $dsnhansu = DB::table('sodo_nhansu')
            ->crossJoin('nhansu1')
            ->select('*')
            ->where('sodo_nhansu.manhanvien', '=', DB::raw('nhansu1.manhanvien'))
            ->get();
        //$dsnhansu = DB::table('sodo_nhansu')->get();
        return view('sodo', [
            'dsnhansu' => $dsnhansu,

        ]);
    }
    public function xemsodo()
    {
        $dsnhansu = DB::table('sodo_nhansu')
            ->crossJoin('nhansu1')
            ->select('*')
            ->where('sodo_nhansu.manhanvien', '=', DB::raw('nhansu1.manhanvien'))
            ->get();
        //$dsnhansu = DB::table('sodo_nhansu')->get();
        return view('xemsodo', [
            'dsnhansu' => $dsnhansu,

        ]);
    }
    public function xoanode(Request $r)
    {
        $id = $r->id;
        DB::table('sodo_nhansu')->where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }
    public function capnhatsodochucdanh(Request $r)
    {
        $manhanvien = $r->manhanvien;
        $ktnv = DB::table('sodo_nhansu')
            ->select('*')
            ->where('manhanvien', '=', $manhanvien)
            ->get();
        if (count($ktnv) > 0) {
            return response()->json(['success' => false, 'message' => 'Nhân viên này đã được cập nhật vào sơ đồ']);
        }
        $maquanly = $r->maquanly;
        $kt1 = DB::table('sodo_nhansu')
            ->where('manhanvien', $maquanly)
            ->orderByDesc('id')
            ->first();
        $chucdanhql = $kt1->machucdanh;
        $mota = $r->mota;
        if ($r->hasFile('tmpFile')) {
            $uploadedFile = $r->file('tmpFile');
            $destinationPath = public_path('images');
            $newFileName = $destinationPath . '/' . $uploadedFile->getClientOriginalName();
            move_uploaded_file($uploadedFile->getPathname(), $newFileName);
            $pos = 0;
            for ($i = 0; $i < 5; $i++) {
                $pos = strpos($newFileName, '\\', $pos + 1);
            }
            $imagesFolder = substr($newFileName, $pos + 1);
            $imagesFolder1 = str_replace('opt/lampp/htdocs/elasticDemoCopy/public/', '', $imagesFolder);
        } else {
            $imagesFolder1 = "";
        }
        DB::table('chucdanh')->insert([
            'tenchucdanh' => "",
        ]);
        $cd = DB::table('chucdanh')
            ->max('machucdanh');
        DB::table('sodo_nhansu')->insert([
            'manhanvien' => $manhanvien,
            'mota' => $mota,
            'machucdanh' => $cd,
            'chucdanhql' => $chucdanhql,
            'hinhanh' => $imagesFolder1,
            'v' => "",
            'f' => "",
            'f2' => "",
        ]);
        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }
    public function laythongtinchucdanh($manhanvien)
    {
        $dem = 0;
        $kt1 = DB::table('sodo_nhansu')
            ->select('*')
            ->where('id', '=', $manhanvien)
            ->first();
        $kt = DB::table('nhansu1')
            ->select('*')
            ->where('manhanvien', '=', $kt1->manhanvien)
            ->first();
        $chucdanh =  DB::table('chucdanh')
            ->select('*')
            ->where('machucdanh', '>', $kt1->machucdanh)
            ->get();
        $dsnhansu = DB::table('nhansu1')
            ->select('*')
            ->where('manhanvien', '<>', $kt1->manhanvien)
            ->get();
        $ktrcon = DB::table('sodo_nhansu')
            ->select('*')
            ->where('chucdanhql', '=', $kt1->machucdanh)
            ->get();
        $d = count($ktrcon);
        return response()->json([
            'chucdanh' => $chucdanh,
            'ttcn' => $kt,
            'ttcn1' => $kt1,
            'd' => $d,
            'dsnhansu' => $dsnhansu
        ]);
    }
    public function capnhatsodochucdanh1(Request $r)
    {

        $maquanly = $r->maquanly;
        $id = $r->id;
       
       
        $mota = $r->mota;
        if ($r->hasFile('tmpFile')) {
            $uploadedFile = $r->file('tmpFile');
            $destinationPath = public_path('images');
            $newFileName = $destinationPath . '/' . $uploadedFile->getClientOriginalName();
            move_uploaded_file($uploadedFile->getPathname(), $newFileName);
            $pos = 0;
            for ($i = 0; $i < 5; $i++) {
                $pos = strpos($newFileName, '\\', $pos + 1);
            }
            $imagesFolder = substr($newFileName, $pos + 1);
            $imagesFolder1 = str_replace('opt/lampp/htdocs/elasticDemoCopy/public/', '', $imagesFolder);
        } else {
            $imagesFolder1 = "";
        }
        
        if ($imagesFolder1 == "") {
            DB::table('sodo_nhansu')
                ->where('id', '=', $id)
                ->update(['manhanvien' => $maquanly, 'mota'=>$mota]);
        } else {
            DB::table('sodo_nhansu')
                ->where('id', '=', $id)
                ->update(['manhanvien' => $maquanly, 'hinhanh' => $imagesFolder1, 'mota'=>$mota]);
        }
        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }
}
