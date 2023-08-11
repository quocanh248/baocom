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

class controllercongviec extends Controller
{
    public function viewpccv()
    {
        $this->newcongviec();
        //data
        $userid = Session::get('userid');
        $q = DB::table('quyenuser')
            ->crossJoin('quyen')
            ->select('quyen.*')
            ->where('quyenuser.maquyen', '=', DB::raw('quyen.maquyen'))
            ->where('id', $userid)
            ->where('tenquyen', '<>', "Hành chánh")
            ->get();
        $c = 0;
        $itemsArray = $q->toArray();
        usort($itemsArray, function ($a, $b) {
            return $a->maquyen - $b->maquyen;
        });

        // Lấy phần tử đầu tiên trong mảng (có maquyen nhỏ nhất)
        $minItem = $itemsArray[0];
        // dd($minItem->tenquyen, $itemsArray);
        $d = "";
        if ($minItem->tenquyen == "Admin") {
            $c++;
            $d = "Admin";
            $nhom = DB::table('bophan')->get();
            // $nhom = DB::table('nhomlamviec')->get();               
        } elseif ($minItem->tenquyen == "Quản lý pro") {
            $nhom = DB::table('bophan')
                ->crossJoin('nhansu_bophan')
                ->crossJoin('nhansu')
                ->crossJoin('users')
                ->select('bophan.*')
                ->where('bophan.mabophan', '=', DB::raw('nhansu_bophan.mabophan'))
                ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
                ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
                ->where('id', $userid)
                ->get();
        } elseif ($minItem->tenquyen == "Quản lý") {
            $nhom = DB::table('bophan')
                ->crossJoin('nhansu_bophan')
                ->crossJoin('nhansu')
                ->crossJoin('users')
                ->select('bophan.*')
                ->where('bophan.mabophan', '=', DB::raw('nhansu_bophan.mabophan'))
                ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
                ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
                ->where('id', $userid)
                ->where('tt', "bophanchinh")
                ->get();
        }

        // if ($c == 0) {
        //     // $nhom = DB::table('nhomlamviec')
        //     //     ->crossJoin('nhansu')
        //     //     ->crossJoin('users')
        //     //     ->select('nhomlamviec.*')
        //     //     ->where('nhomlamviec.manhom', '=', DB::raw('nhansu.manhom'))
        //     //     ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
        //     //     ->where('id', $userid)
        //     //     ->get();

        // }
        $loaicongviec = DB::table('loaicongviec')->orderBy('maloai', 'desc')->get();
        $link = DB::table('link')->get();
        return view('viewpccv', [
            'nhom' => $nhom,
            'link' => $link,
            'loaicongviec' => $loaicongviec
        ]);
    }
    public function laybophanql($manhom)
    {
        $nhom = DB::table('bophan')
            ->select('bophan.*')
            ->where('tengoinho', '<>', $manhom)
            ->get();
        return response()->json($nhom);
    }
    public function laytieudenhom($manhom)
    {
        $nhom = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->crossJoin('congviec')
            ->select('tieude')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('congviec.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->distinct('tieude')
            ->get();
        return response()->json($nhom);
    }
    public function laynhansunhom($manhom)
    {
        $nhom = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->select('nhansu.*')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->get();
        return response()->json($nhom);
    }
    public function laydscongviec($manhanvien)
    {
        $nhom = DB::table('congviec')
            ->crossJoin('loaicongviec')
            ->select('*')
            ->where('congviec.maloai', '=', DB::raw('loaicongviec.maloai'))
            ->where('congviec.manhanvien', $manhanvien)
            ->orderBy('congviec.macongviec', 'desc')
            ->take(4)
            ->get();
        return response()->json($nhom);
    }
    public function themcongviec(Request $r)
    {
        $userid = Session::get('userid');
        $ttcn = DB::table('users')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->get();
        $nguoitao =  $ttcn[0]->manhanvien;
        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');
        $manhanvien = $r->manhanvien;
        $loaicongviec = $r->loaicongviec;
        $noidung = $r->noidung;
        $tieude = $r->tieude;
        $duongdan = $r->duongdan;
        $ngayhethan = $r->ngayhethan;
        DB::table('congviec')->insert([
            'manhanvien' => $manhanvien,
            'nguoitao' => $nguoitao,
            'maloai' => $loaicongviec,
            'noidung' => $noidung,
            'tieude' => $tieude,
            'nguoithuchien' => "",
            'duongdan' => $duongdan,
            'trangthai' => "Chưa thực hiện",
            'ngayhethan' => $ngayhethan,
            'created_at' => $t,
        ]);
        $nhom = DB::table('congviec')
            ->crossJoin('loaicongviec')
            ->select('*')
            ->where('congviec.maloai', '=', DB::raw('loaicongviec.maloai'))
            ->where('congviec.manhanvien', $manhanvien)
            ->orderBy('macongviec', 'desc')
            ->take(4)
            ->get();


        return response()->json($nhom);
    }
    public function timkiemcvnhom(Request $r)
    {
        $manhom = $r->manhom;
        $manhanvien = $r->manhanvien;

        $gv = new Modelnhansu;


        $nhom = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->crossJoin('bophan')
            ->select('nhansu.manhanvien', 'tennhanvien', 'tengoinho')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', '=', DB::raw('bophan.mabophan'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->where('nhansu.manhanvien', $manhanvien)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->groupBy('nhansu.manhanvien', 'tennhanvien', 'tengoinho')
            ->get();
        $nhom1 = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->groupBy('nhansu.manhanvien', 'tennhanvien')
            ->get();
        return view('xemcvnhom', [
            'nhom1' => $nhom1,
            'nhom' => $nhom,
            'gv' => $gv,
            'manhom' => $manhom,

        ]);
    }
    public function xemcongviecnhom($manhom)
    {
        $gv = new Modelnhansu;
        // $nhom = DB::table('nhomlamviec')
        //     ->crossJoin('nhansu')
        //     ->crossJoin('congviec')
        //     ->crossJoin('loaicongviec')
        //     ->select('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude', 'tenloai')
        //     ->where('nhomlamviec.manhom', '=', DB::raw('nhansu.manhom'))
        //     ->where('nhansu.manhanvien', '=', DB::raw('congviec.manhanvien'))
        //     ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
        //     ->where('nhomlamviec.manhom', $manhom)
        //     ->groupBy('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'tenloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude')
        //     ->orderBy('maloai', 'asc')
        //     ->orderBy('trangthai', 'asc')
        //     ->get();
        $nhom = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->crossJoin('bophan')
            ->select('nhansu.manhanvien', 'tennhanvien', 'tengoinho')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', '=', DB::raw('bophan.mabophan'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->groupBy('nhansu.manhanvien', 'tennhanvien', 'tengoinho')
            ->get();
        $nhom1 = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->groupBy('nhansu.manhanvien', 'tennhanvien')
            ->get();

        return view('xemcvnhom', [
            'nhom1' => $nhom1,
            'nhom' => $nhom,
            'gv' => $gv,
            'manhom' => $manhom,

        ]);
    }
    public function laythongtincongviec($macongviec)
    {

        $nhom = DB::table('loaicongviec')
            ->crossJoin('congviec')
            ->crossJoin('nhansu')
            ->select('*')
            ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
            ->where('congviec.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('congviec.macongviec', $macongviec)
            ->get();

        return response()->json($nhom);
    }
    public function laythongtinlscongviec($macongviec)
    {

        $nhom = DB::table('loaicongviec')
            ->crossJoin('lscongviec')
            ->crossJoin('nhansu')
            ->select('lscongviec.malscongviec', 'noidung', 'lscongviec.created_at', 'tieude', 'ngayhethan', 'tenloai', 'lscongviec.maloai', 'lscongviec.manhanvien', 'tennhanvien', 'duongdan', 'hinhanh')
            ->where('loaicongviec.maloai', '=', DB::raw('lscongviec.maloai'))
            ->where('lscongviec.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('lscongviec.malscongviec', $macongviec)
            ->get();

        return response()->json($nhom);
    }
    public function capnhattrangthaicv(Request $r)
    {
        $macongviec = $r->macongviec;
        $noidung = $r->noidung;
        $userid = Session::get('userid');
        $ttcn = DB::table('users')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->get();
        $ktrnt = DB::table('congviec')
            ->select('*')
            ->where('macongviec', '=', $macongviec)
            ->get();
        $ktrls = DB::table('lscongviec')
            ->select('*')
            ->where('malscongviec', '=', $macongviec)
            ->get();

        $nguoithuchien =  $ttcn[0]->tennhanvien;
        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');
        if ($r->hasFile('tmpFile')) {
            $uploadedFile = $r->file('tmpFile');
            $destinationPath = public_path('images');
            $newFileName = $destinationPath . '/' . $uploadedFile->getClientOriginalName();

            move_uploaded_file($uploadedFile->getPathname(), $newFileName);
            DB::table('congviec')
                ->where('macongviec', '=', $macongviec)
                ->update(['trangthai' => 'Hoàn thành', 'updated_at' => $t, 'hinhanh' => $newFileName, 'tenhinhanh' => $newFileName, 'noidung' => $noidung, 'nguoithuchien' => $nguoithuchien]);

            if (count($ktrls) == 0) {
                $kt = DB::table('congviec')
                    ->select('*')
                    ->where('macongviec', '=', $macongviec)
                    ->first();
                $noidung = "";
                if ($kt->noidung != null) {
                    $noidung = $kt->noidung;
                }
                DB::table('lscongviec')->insert([
                    'malscongviec' => $macongviec,
                    'manhanvien' => $kt->manhanvien,
                    'nguoitao' => $ktrnt[0]->nguoitao,
                    'maloai' =>  $kt->maloai,
                    'noidung' =>  $noidung,
                    'tieude' =>  $kt->tieude,
                    'nguoithuchien' =>  $nguoithuchien,
                    'duongdan' => $kt->duongdan,
                    'trangthai' => "Hoàn thành",
                    'ngayhethan' => $kt->ngayhethan,
                    'hinhanh' => $kt->hinhanh,
                    'tenhinhanh' => $kt->tenhinhanh,
                    'updated_at' => $t,
                    'created_at' => $kt->created_at,
                ]);
            }
        } else {
            $newFileName = "";
            DB::table('congviec')
                ->where('macongviec', '=', $macongviec)
                ->update(['trangthai' => 'Hoàn thành', 'updated_at' => $t, 'nguoithuchien' => $nguoithuchien, 'noidung' => $noidung,]);
            if (count($ktrls) == 0) {
                $kt = DB::table('congviec')
                    ->select('*')
                    ->where('macongviec', '=', $macongviec)
                    ->first();
                $noidung = "";
                if ($kt->noidung != null) {
                    $noidung = $kt->noidung;
                }
                DB::table('lscongviec')->insert([
                    'malscongviec' => $macongviec,
                    'manhanvien' => $kt->manhanvien,
                    'nguoitao' => $ktrnt[0]->nguoitao,
                    'maloai' =>  $kt->maloai,
                    'noidung' =>  $noidung,
                    'tieude' =>  $kt->tieude,
                    'nguoithuchien' =>  $nguoithuchien,
                    'duongdan' => $kt->duongdan,
                    'trangthai' => "Hoàn thành",
                    'ngayhethan' => $kt->ngayhethan,
                    'hinhanh' => $kt->hinhanh,
                    'tenhinhanh' => $kt->tenhinhanh,
                    'updated_at' => $t,
                    'created_at' => $kt->created_at,
                ]);
            }
        }
        return response()->json(['path' => $newFileName]);
    }
    public function themcongviecht(Request $r)
    {
        if ($r->hasFile('tmpFile')) {
            $uploadedFile = $r->file('tmpFile');
            $destinationPath = public_path('images');
            $newFileName = $destinationPath . '/' . $uploadedFile->getClientOriginalName();

            move_uploaded_file($uploadedFile->getPathname(), $newFileName);
        } else {
            $newFileName = "";
        }
        $userid = Session::get('userid');
        $ttcn = DB::table('users')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->get();
        $nguoitao =  $ttcn[0]->manhanvien;
        $nguoithuchien =  $ttcn[0]->tennhanvien;
        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');
        $manhanvien = $r->manhanvien;
        $loaicongviec = $r->loaicongviec;
        $noidung = $r->noidung;
        $tieude = $r->tieude;
        $duongdan = $r->duongdan;
        $ngayhethan = $r->ngayhethan;
        DB::table('congviec')->insert([
            'manhanvien' => $manhanvien,
            'nguoitao' => $nguoitao,
            'maloai' => $loaicongviec,
            'noidung' => $noidung,
            'tieude' => $tieude,
            'nguoithuchien' => $nguoithuchien,
            'duongdan' => $duongdan,
            'trangthai' => "Hoàn thành",
            'ngayhethan' => $ngayhethan,
            'hinhanh' => $newFileName,
            'tenhinhanh' => $newFileName,
            'created_at' => $t,
        ]);
        $laycvmoi = DB::table('congviec')
            ->where('congviec.manhanvien', $manhanvien)
            ->orderBy('macongviec', 'desc')
            ->first();
        DB::table('lscongviec')->insert([
            'malscongviec' => $laycvmoi->macongviec,
            'manhanvien' => $manhanvien,
            'nguoitao' => $nguoitao,
            'maloai' =>  $loaicongviec,
            'noidung' =>  $noidung,
            'tieude' =>  $tieude,
            'nguoithuchien' =>  $nguoithuchien,
            'duongdan' => $duongdan,
            'trangthai' => "Hoàn thành",
            'ngayhethan' => $ngayhethan,
            'hinhanh' => $newFileName,
            'tenhinhanh' => $laycvmoi->tenhinhanh,
            'updated_at' => $t,
            'created_at' => $laycvmoi->created_at,
        ]);
        $nhom = DB::table('congviec')
            ->crossJoin('loaicongviec')
            ->select('*')
            ->where('congviec.maloai', '=', DB::raw('loaicongviec.maloai'))
            ->where('congviec.manhanvien', $manhanvien)
            ->orderBy('macongviec', 'desc')
            ->take(4)
            ->get();


        return response()->json($nhom);
    }
    public function viewpccvcc()
    {
        $this->newcongviec();
        $userid = Session::get('userid');
        $q = DB::table('quyenuser')
            ->crossJoin('quyen')
            ->select('quyen.*')
            ->where('quyenuser.maquyen', '=', DB::raw('quyen.maquyen'))
            ->where('id', $userid)
            ->get();

        $nhom = DB::table('congviec')
            ->crossJoin('loaicongviec')
            ->crossJoin('nhansu')
            ->crossJoin('users')
            ->select('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude', 'tenloai')
            ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
            ->where('nhansu.manhanvien', '=', DB::raw('congviec.manhanvien'))
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->groupBy('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'tenloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude')
            ->orderBy('maloai', 'asc')
            ->orderBy('trangthai', 'asc')
            ->get();
        $ttcn = DB::table('users')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->get();
        $loaicongviec = DB::table('loaicongviec')->orderBy('maloai', 'desc')->get();
        $link = DB::table('link')->get();
        $laynhom =  $ttcn = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->select('mabophan')
            ->where('nhansu.manhanvien', '=', DB::raw('nhansu_bophan.manhanvien'))
            ->where('nhansu.manhanvien', $ttcn[0]->manhanvien)
            ->get();
        $laytieude =  DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->crossJoin('congviec')
            ->select('tieude')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('congviec.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', $laynhom[0]->mabophan)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->distinct('tieude')
            ->get();
        $ttcn = DB::table('users')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->get();
        return view('viewpccvcc', [
            'ttcn' => $ttcn,
            'nhom' => $nhom,
            'link' => $link,
            'laytieude' => $laytieude,
            'loaicongviec' => $loaicongviec
        ]);
    }
    public function xemlscvnhom($manhom)
    {
        $gv = new Modelnhansu;

        // $nhom = DB::table('nhansu_bophan')
        //     ->crossJoin('nhansu')
        //     ->select('nhansu.manhanvien', 'tennhanvien')
        //     ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
        //     ->where('nhansu_bophan.mabophan', $manhom)
        //     ->groupBy('nhansu.manhanvien', 'tennhanvien')
        //     ->get();
        // $nhom1 = DB::table('nhansu_bophan')
        //     ->crossJoin('nhansu')
        //     ->select('nhansu.manhanvien', 'tennhanvien')
        //     ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
        //     ->where('nhansu_bophan.mabophan', $manhom)
        //     ->groupBy('nhansu.manhanvien', 'tennhanvien')
        //     ->get();
        $nhom = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->crossJoin('bophan')
            ->select('nhansu.manhanvien', 'tennhanvien', 'tengoinho')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', '=', DB::raw('bophan.mabophan'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->groupBy('nhansu.manhanvien', 'tennhanvien', 'tengoinho')
            ->get();
        $nhom1 = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->groupBy('nhansu.manhanvien', 'tennhanvien')
            ->get();

        return view('lscongviecnhom', [
            'nhom1' => $nhom1,
            'nhom' => $nhom,
            'gv' => $gv,
            'manhom' => $manhom,

        ]);
    }
    public function timkiemlscvnhom(Request $r)
    {
        // $ngay = $r->ngayhoanthanh;
        // $ngayCarbon = Carbon::parse($ngay); // Convert the string to a Carbon instance
        // $today = $ngayCarbon->setTimezone('Asia/Ho_Chi_Minh');
        // $startOfDay = $ngayCarbon->copy()->startOfDay()->hour(1);
        // $endOfDay = $ngayCarbon->copy()->startOfDay()->hour(23);      
        $manhom = $r->manhom;
        $manhanvien = $r->manhanvien;
        $nhom = DB::table('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', $manhanvien)
            ->get();
        $gv = new Modelnhansu;
        $nhom1 = DB::table('nhansu_bophan')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu_bophan.mabophan', $manhom)
            ->groupBy('nhansu.manhanvien', 'tennhanvien')
            ->get();

        return view('lscongviecnhom', [
            'nhom1' => $nhom1,
            'nhom' => $nhom,
            'gv' => $gv,
            'manhom' => $manhom,

        ]);
    }
    public function xemlscvcc()
    {
        $userid = Session::get('userid');
        $q = DB::table('quyenuser')
            ->crossJoin('quyen')
            ->select('quyen.*')
            ->where('quyenuser.maquyen', '=', DB::raw('quyen.maquyen'))
            ->where('id', $userid)
            ->get();
        $nhom = DB::table('lscongviec')
            ->crossJoin('loaicongviec')
            ->crossJoin('nhansu')
            ->crossJoin('users')
            ->select('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'trangthai', 'ngayhethan', 'malscongviec', 'tieude', 'tenloai', 'nguoithuchien')
            ->where('loaicongviec.maloai', '=', DB::raw('lscongviec.maloai'))
            ->where('nhansu.manhanvien', '=', DB::raw('lscongviec.manhanvien'))
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->groupBy('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'tenloai', 'trangthai', 'ngayhethan', 'malscongviec', 'tieude', 'nguoithuchien')
            ->orderBy('maloai', 'asc')
            ->orderBy('trangthai', 'asc')
            ->get();
        $ttcn = DB::table('users')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->get();
        $loaicongviec = DB::table('loaicongviec')->get();
        $link = DB::table('link')->get();
        return view('xemlscvcc', [
            'nhom' => $nhom,
            'ttcn' => $ttcn,
            'link' => $link,
            'loaicongviec' => $loaicongviec
        ]);
    }
    public function cvsaphethan()
    {
        $userid = Session::get('userid');
        $ttcc = DB::table('nhansu')
            ->crossJoin('users')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->get();
        $today = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');
        $t = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');
        $cvtuan = [];
        $cvthang = [];
        $cvnam = [];
        $dayOfWeek = $today->dayOfWeek;
        $dayOfMonth = $today->day;
        $month = $today->month;
        $cvkxd = DB::table('congviec')
            ->crossJoin('loaicongviec')
            ->crossJoin('nhansu')
            ->crossJoin('users')
            ->select('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude', 'tenloai')
            ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
            ->where('nhansu.manhanvien', '=', DB::raw('congviec.manhanvien'))
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->where('tenloai', 'Không xác định')
            ->where('trangthai', "Chưa thực hiện")
            ->groupBy('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'tenloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude')
            ->orderBy('maloai', 'asc')
            ->orderBy('trangthai', 'asc')
            ->get();
        $combinedDatas = [];
        $ngayThangNam = $t->format('Y-m-d');
        foreach ($cvkxd as $data) {
            $ngayHetHanCongViec = Carbon::parse($data->ngayhethan); // Giả sử $cvkxd[0]->ngayhethan chứa ngày hết hạn công việc
            $soNgay = $ngayHetHanCongViec->diffInDays($ngayThangNam);
            if ($soNgay < 2 && $soNgay > -1) {
                $combinedData[] = [
                    'manhanvien' => $data->manhanvien,
                    'tennhanvien' => $data->tennhanvien,
                    'maloai' => $data->maloai,
                    'trangthai' => $data->trangthai,
                    'ngayhethan' => $data->ngayhethan,
                    'macongviec' => $data->macongviec,
                    'tieude' => $data->tieude,
                    'tenloai' => $data->tenloai,
                ];
                $combinedDatas = $combinedData;
            }
        }

        $cvngay = DB::table('congviec')
            ->crossJoin('loaicongviec')
            ->crossJoin('nhansu')
            ->crossJoin('users')
            ->select('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude', 'tenloai')
            ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
            ->where('nhansu.manhanvien', '=', DB::raw('congviec.manhanvien'))
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->where('tenloai', 'Công việc ngày')
            ->where('trangthai', "Chưa thực hiện")
            ->groupBy('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'tenloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude')
            ->orderBy('maloai', 'asc')
            ->orderBy('trangthai', 'asc')
            ->get();
        if ($dayOfWeek === Carbon::THURSDAY) {
            $cvtuan = DB::table('congviec')
                ->crossJoin('loaicongviec')
                ->crossJoin('nhansu')
                ->crossJoin('users')
                ->select('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude', 'tenloai')
                ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                ->where('nhansu.manhanvien', '=', DB::raw('congviec.manhanvien'))
                ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
                ->where('users.id', $userid)
                ->where('tenloai', 'Công việc Tuần')
                ->where('trangthai', "Chưa thực hiện")
                ->groupBy('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'tenloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude')
                ->orderBy('maloai', 'asc')
                ->orderBy('trangthai', 'asc')
                ->get();
        }
        if ($dayOfMonth == 25) {
            $cvthang = DB::table('congviec')
                ->crossJoin('loaicongviec')
                ->crossJoin('nhansu')
                ->crossJoin('users')
                ->select('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude', 'tenloai')
                ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                ->where('nhansu.manhanvien', '=', DB::raw('congviec.manhanvien'))
                ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
                ->where('users.id', $userid)
                ->where('tenloai', 'Công việc Tháng')
                ->where('trangthai', "Chưa thực hiện")
                ->groupBy('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'tenloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude')
                ->orderBy('maloai', 'asc')
                ->orderBy('trangthai', 'asc')
                ->get();
        }
        if ($month == 12) {
            $cvnam = DB::table('congviec')
                ->crossJoin('loaicongviec')
                ->crossJoin('nhansu')
                ->crossJoin('users')
                ->select('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude', 'tenloai')
                ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                ->where('nhansu.manhanvien', '=', DB::raw('congviec.manhanvien'))
                ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
                ->where('users.id', $userid)
                ->where('tenloai', 'Công việc Năm')
                ->where('trangthai', "Chưa thực hiện")
                ->groupBy('nhansu.manhanvien', 'tennhanvien',  'loaicongviec.maloai', 'tenloai', 'trangthai', 'ngayhethan', 'macongviec', 'tieude')
                ->orderBy('maloai', 'asc')
                ->orderBy('trangthai', 'asc')
                ->get();
        }

        $loaicongviec = DB::table('loaicongviec')->get();
        $link = DB::table('link')->get();
        return view('cvsaphethan', [
            'cvnam' => $cvnam,
            'cvthang' => $cvthang,
            'cvtuan' => $cvtuan,
            'cvngay' => $cvngay,
            'cvkxd' => $combinedDatas,
            'ttcc' => $ttcc,
            'loaicongviec' => $loaicongviec
        ]);
    }
    public function huycongviec($macongviec)
    {
        $userid = Session::get('userid');
        $ttcn = DB::table('users')
            ->crossJoin('nhansu')
            ->select('nhansu.manhanvien', 'tennhanvien')
            ->where('nhansu.manhanvien', '=', DB::raw('users.manhanvien'))
            ->where('users.id', $userid)
            ->get();
        $q = DB::table('quyenuser')
            ->crossJoin('quyen')
            ->select('quyen.*')
            ->where('quyenuser.maquyen', '=', DB::raw('quyen.maquyen'))
            ->where('id', $userid)
            ->get();

        $ktr = DB::table('congviec')
            ->select('*')
            ->where('macongviec', $macongviec)
            ->get();
        $c = "";
        if (count($q) > 0) {

            $itemsArray = $q->toArray();
            usort($itemsArray, function ($a, $b) {
                return $a->maquyen - $b->maquyen;
            });
            $minItem = $itemsArray[0];
            if ($minItem->tenquyen == "Admin") {
                $c = "Admin";
            } elseif ($minItem->tenquyen == "Quản lý pro") {
                $c = "Quản lý pro";
            } elseif ($minItem->tenquyen == "Quản lý") {
                $c = "Quản lý";
            }
        }
        // Lấy phần tử đầu tiên trong mảng (có maquyen nhỏ nhất)

        if ($c == "") {
            if ($ttcn[0]->manhanvien == $ktr[0]->nguoitao) {
                DB::table('congviec')->where('macongviec', $macongviec)->delete();
                return response()->json(['success' => true, 'message' => 'Xóa công việc hoàn tất']);
            } else {
                return response()->json(['success' => false, 'message' => 'không được quyền xóa công việc này']);
            }
        } elseif ($c == "Admin") {
            DB::table('congviec')->where('macongviec', $macongviec)->delete();
            return response()->json(['success' => true, 'message' => 'Xóa công việc hoàn tất']);
        } elseif ($c == "Quản lý pro") {
            if ($ttcn[0]->manhanvien == $ktr[0]->nguoitao) {
                DB::table('congviec')->where('macongviec', $macongviec)->delete();
                return response()->json(['success' => true, 'message' => 'Xóa công việc hoàn tất']);
            } else {
                return response()->json(['success' => false, 'message' => 'không được quyền xóa công việc này']);
            }
        } elseif ($c == "Quản lý") {
            $ttnt = DB::table('users')
                ->crossJoin('quyenuser')
                ->crossJoin('quyen')
                ->select('*')
                ->where('users.id', '=', DB::raw('quyenuser.id'))
                ->where('quyenuser.maquyen', '=', DB::raw('quyen.maquyen'))
                ->where('users.manhanvien', $ktr[0]->nguoitao)
                ->where(function ($query) {
                    $query->where('tenquyen', '=', 'Admin')
                        ->orWhere('tenquyen', '=', 'Quản lý pro');
                })
                ->get();

            if (count($ttnt) > 0) {
                return response()->json(['success' => false, 'message' => 'không được quyền xóa công việc này']);
            } else {
                DB::table('congviec')->where('macongviec', $macongviec)->delete();
                return response()->json(['success' => true, 'message' => 'Xóa công việc hoàn tất']);
            }
        }
    }

    public function chuyenbophan($manhom)
    {
        $ktrcv = new Modelnhansu;
        $nhom = DB::table('nhansu')
            ->crossJoin('nhansu_bophan')
            ->select('nhansu_bophan.manhanvien', 'tennhanvien', 'mabophan')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('mabophan', $manhom)
            ->where('tt', "bophanchinh")
            ->get();
        $dsnhom = DB::table('bophan')
            ->select('mabophan', 'tenbophan')
            ->where('bophan.mabophan', '<>', $manhom)
            ->get();
        return view('chuyenbophan', [
            'nhom' => $nhom,
            'ktrcv' => $ktrcv,
            'ds' => $dsnhom,
        ]);
    }
    public function chuyenbophanmoi(Request $r)
    {
        $bangiao = $r->bangiao;
        $manhanvien = $r->manhanvien;
        $manhom = $r->manhom;
        $tiepnhan = $r->tiepnhan;
        if ($bangiao == "true") {
            DB::table('nhansu_bophan')
                ->where('manhanvien', '=', $manhanvien)
                ->update([
                    'mabophan' => $manhom,
                    'tt' => "bophanchinh",
                ]);
            DB::table('congviec')
                ->where('manhanvien', '=', $manhanvien)
                ->update(['manhanvien' => $tiepnhan]);
            DB::table('lscongviec')
                ->where('manhanvien', '=', $manhanvien)
                ->update(['manhanvien' => $tiepnhan]);
            return response()->json(['success' => true, 'message' => 'Chuyển bộ phận thành công!']);
        } else {
            DB::table('congviec')->where('manhanvien', $manhanvien)->delete();
            return response()->json(['success' => true, 'message' => 'Chuyển bộ phận thành công!']);
        }
    }
    public function bangiaocv(Request $r)
    {
        $manhanvien = $r->manhanvien;
        $tiepnhan = $r->tiepnhan;
        DB::table('congviec')
            ->where('manhanvien', '=', $manhanvien)
            ->update(['manhanvien' => $tiepnhan]);
        return response()->json(['success' => true, 'message' => 'Bàn giao công việc thành công!']);
    }
    public function laynhanvientiepnhan($manhanvien, $manhom)
    {

        $dsnhom = DB::table('nhansu')
            ->crossJoin('nhansu_bophan')
            ->select('tennhanvien', 'nhansu.manhanvien')
            ->where('nhansu_bophan.manhanvien', '=', DB::raw('nhansu.manhanvien'))
            ->where('nhansu.manhanvien', '<>', $manhanvien)
            ->where('mabophan', $manhom)
            ->where('nhansu_bophan.tt', "bophanchinh")
            ->get();
        return response()->json($dsnhom);
    }
    public function newcongviec()
    {
        // Lấy ngày hiện tại
        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');
        $startOfDay = $t->copy()->startOfDay()->hour(01);
        $endOfDay = $t->copy()->startOfDay()->hour(23);               //renewcv ngày
        $ktrcongviecngay = DB::table('congviec')
            ->crossJoin('loaicongviec')
            ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
            ->where('tenloai', 'Công việc ngày')
            ->whereBetween('congviec.created_at', [$startOfDay, $endOfDay])
            ->get();
        if (count($ktrcongviecngay) == 0) {
            $currentDate1 = Carbon::now();
            $t1 = $currentDate1->setTimezone('Asia/Ho_Chi_Minh');
            $subday1 =    $t1->subDay();
            $startOfDay1 = $subday1->copy()->startOfDay()->hour(01);
            $endOfDay1 = $subday1->copy()->startOfDay()->hour(23);
            $noidung = "";
            $duongdan = "";
            $cvngaytruoc = DB::table('congviec')
                ->crossJoin('loaicongviec')
                ->select('congviec.created_at', 'manhanvien', 'congviec.maloai', 'noidung', 'tieude', 'duongdan', 'ngayhethan', 'macongviec', 'trangthai', 'nguoitao', 'nguoithuchien')
                ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                ->where('tenloai', 'Công việc ngày')
                ->whereBetween('congviec.created_at', [$startOfDay1, $endOfDay1])
                ->get();
            foreach ($cvngaytruoc as $data) {
                if ($data->noidung != null) {
                    $noidung = $data->noidung;
                }
                if ($data->duongdan != null) {
                    $duongdan = $data->duongdan;
                }
                DB::table('congviec')->insert([
                    'manhanvien' => $data->manhanvien,
                    'maloai' => $data->maloai,
                    'noidung' => $noidung,
                    'tieude' => $data->tieude,
                    'duongdan' => $duongdan,
                    'nguoithuchien' => "",
                    'nguoitao' => $data->nguoitao,
                    'trangthai' => "Chưa thực hiện",
                    'ngayhethan' => null,
                    'created_at' => $t,
                ]);
                if ($data->trangthai == "Chưa thực hiện") {
                    DB::table('lscongviec')->insert([
                        'malscongviec' => $data->macongviec,
                        'manhanvien' => $data->manhanvien,
                        'maloai' => $data->maloai,
                        'noidung' => $noidung,
                        'tieude' => $data->tieude,
                        'duongdan' => $duongdan,
                        'nguoitao' => $data->nguoitao,
                        'nguoithuchien' => $data->nguoithuchien,
                        'trangthai' => $data->trangthai,
                        'ngayhethan' => $data->ngayhethan,
                        'created_at' => $data->created_at,
                    ]);
                }
                DB::table('congviec')->where('macongviec', $data->macongviec)->delete();
            }
        }
        //renew công việc tuần
        $isMonday = $currentDate->isDayOfWeek(Carbon::MONDAY);
        if ($isMonday) {
            $mondayLastWeek = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->subWeek()->startOfWeek();
            // Lấy ngày chủ nhật tuần trước
            $sundayLastWeek = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->subWeek()->endOfWeek();
            $mondayWeek = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->startOfWeek();
            $sundayWeek = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->endOfWeek();
            $ktrcongviectuan = DB::table('congviec')
                ->crossJoin('loaicongviec')
                ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                ->where('tenloai', 'Công việc Tuần')
                // ->where('trangthai', 'Chưa thực hiện')
                ->whereBetween('congviec.created_at', [$mondayWeek, $sundayWeek])
                ->get();
            if (count($ktrcongviectuan) == 0) {
                $cvtuantruoc = DB::table('congviec')
                    ->crossJoin('loaicongviec')
                    ->select('congviec.created_at', 'manhanvien', 'congviec.maloai', 'noidung', 'tieude', 'duongdan', 'ngayhethan', 'macongviec', 'trangthai', 'nguoitao', 'nguoithuchien')
                    ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                    ->where('tenloai', 'Công việc Tuần')
                    ->whereBetween('congviec.created_at', [$mondayLastWeek, $sundayLastWeek])
                    ->get();
                $noidung = "";
                $duongdan = "";
                foreach ($cvtuantruoc as $data) {
                    if ($data->noidung != null) {
                        $noidung = $data->noidung;
                    }
                    if ($data->duongdan != null) {
                        $duongdan = $data->duongdan;
                    }
                    DB::table('congviec')->insert([
                        'manhanvien' => $data->manhanvien,
                        'maloai' => $data->maloai,
                        'noidung' => $noidung,
                        'tieude' => $data->tieude,
                        'nguoitao' => $data->nguoitao,
                        'nguoithuchien' => "",
                        'duongdan' => $duongdan,
                        'trangthai' => "Chưa thực hiện",
                        'ngayhethan' => null,
                        'created_at' => $t,
                    ]);
                    if ($data->trangthai == "Chưa thực hiện") {
                        DB::table('lscongviec')->insert([
                            'malscongviec' => $data->macongviec,
                            'manhanvien' => $data->manhanvien,
                            'maloai' => $data->maloai,
                            'noidung' => $noidung,
                            'tieude' => $data->tieude,
                            'duongdan' => $duongdan,
                            'nguoitao' => $data->nguoitao,
                            'nguoithuchien' => $data->nguoithuchien,
                            'trangthai' => $data->trangthai,
                            'ngayhethan' => $data->ngayhethan,
                            'created_at' => $data->created_at,
                        ]);
                    }
                    DB::table('congviec')->where('macongviec', $data->macongviec)->delete();
                }
            }
        }
        //renewcoong viec thang
        //fotmat lấy tháng hiện tại
        $currentMonth = $currentDate->month;
        $isFirstDayOfMonth = $currentDate->day === 1; // Kiểm tra nếu là đầu tháng   
        if ($isFirstDayOfMonth) {
            $previousMonthJobs1 = DB::table('congviec')
                ->crossJoin('loaicongviec')
                ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                ->where('tenloai', 'Công việc Tháng')
                // ->where('trangthai', 'Chưa thực hiện')
                ->whereMonth('congviec.created_at', $currentMonth)
                ->get();
            if (count($previousMonthJobs1) == 0) {
                $previousMonthJobs = DB::table('congviec')
                    ->crossJoin('loaicongviec')
                    ->select('congviec.created_at', 'manhanvien', 'congviec.maloai', 'noidung', 'tieude', 'duongdan', 'ngayhethan', 'macongviec', 'trangthai', 'nguoitao', 'nguoithuchien')
                    ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                    ->where('tenloai', 'Công việc Tháng')
                    ->whereMonth('congviec.created_at', $currentMonth - 1)
                    ->get();
                $noidung = "";
                $duongdan = "";
                foreach ($previousMonthJobs as $data) {
                    if ($data->noidung != null) {
                        $noidung = $data->noidung;
                    }
                    if ($data->duongdan != null) {
                        $duongdan = $data->duongdan;
                    }
                    DB::table('congviec')->insert([
                        'manhanvien' => $data->manhanvien,
                        'maloai' => $data->maloai,
                        'noidung' => $noidung,
                        'tieude' => $data->tieude,
                        'duongdan' => $duongdan,
                        'nguoitao' => $data->nguoitao,
                        'nguoithuchien' => "",
                        'trangthai' => "Chưa thực hiện",
                        'ngayhethan' => null,
                        'created_at' => $t,
                    ]);
                    if ($data->trangthai == "Chưa thực hiện") {
                        DB::table('lscongviec')->insert([
                            'malscongviec' => $data->macongviec,
                            'manhanvien' => $data->manhanvien,
                            'maloai' => $data->maloai,
                            'noidung' => $noidung,
                            'tieude' => $data->tieude,
                            'nguoitao' => $data->nguoitao,
                            'nguoithuchien' => $data->nguoithuchien,
                            'duongdan' => $duongdan,
                            'trangthai' => $data->trangthai,
                            'ngayhethan' => $data->ngayhethan,
                            'created_at' => $data->created_at,
                        ]);
                    }
                    DB::table('congviec')->where('macongviec', $data->macongviec)->delete();
                }
            }
        }              //renew công việc năm
        $today = Carbon::today()->setTimezone('Asia/Ho_Chi_Minh');
        // Kiểm tra xem ngày hôm nay có phải là ngày đầu tiên của năm mới hay không
        if ($today->dayOfYear == 1) {
            $currentDate2 = Carbon::now();
            $t2 = $currentDate2->setTimezone('Asia/Ho_Chi_Minh');
            $startOfDay2 = $t2->copy()->startOfDay()->hour(01);
            $endOfDay2 = $t2->copy()->startOfDay()->hour(23);
            $ktrcongviecnam = DB::table('congviec')
                ->crossJoin('loaicongviec')
                ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                ->where('tenloai', 'Công việc Năm')
                // ->where('trangthai', 'Chưa thực hiện')
                ->whereBetween('congviec.created_at', [$startOfDay2, $endOfDay2])
                ->get();
            if (count($ktrcongviecnam) == 0) {
                $startOfYear = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->startOfYear()->subYear();

                // Lấy ngày kết thúc của năm trước
                $endOfYear = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->startOfYear()->subDay();
                $laycongviecnam = DB::table('congviec')
                    ->crossJoin('loaicongviec')
                    ->select('congviec.created_at', 'manhanvien', 'congviec.maloai', 'noidung', 'tieude', 'duongdan', 'ngayhethan', 'macongviec', 'trangthai', 'nguoitao', 'nguoithuchien')
                    ->where('loaicongviec.maloai', '=', DB::raw('congviec.maloai'))
                    ->where('tenloai', 'Công việc Năm')
                    ->whereBetween('congviec.created_at', [$startOfYear, $endOfYear])
                    ->get();
                $noidung = "";
                $duongdan = "";
                foreach ($laycongviecnam as $data) {
                    if ($data->noidung != null) {
                        $noidung = $data->noidung;
                    }
                    if ($data->duongdan != null) {
                        $duongdan = $data->duongdan;
                    }
                    DB::table('congviec')->insert([
                        'manhanvien' => $data->manhanvien,
                        'maloai' => $data->maloai,
                        'noidung' => $noidung,
                        'tieude' => $data->tieude,
                        'nguoitao' => $data->nguoitao,
                        'nguoithuchien' => "",
                        'duongdan' => $duongdan,
                        'trangthai' => "Chưa thực hiện",
                        'ngayhethan' => null,
                        'created_at' => $t,
                    ]);
                    if ($data->trangthai == "Chưa thực hiện") {
                        DB::table('lscongviec')->insert([
                            'malscongviec' => $data->macongviec,
                            'manhanvien' => $data->manhanvien,
                            'maloai' => $data->maloai,
                            'noidung' => $noidung,
                            'tieude' => $data->tieude,
                            'duongdan' => $duongdan,
                            'nguoitao' => $data->nguoitao,
                            'nguoithuchien' => $data->nguoithuchien,
                            'trangthai' => $data->trangthai,
                            'ngayhethan' => $data->ngayhethan,
                            'created_at' => $data->created_at,
                        ]);
                    }
                    DB::table('congviec')->where('macongviec', $data->macongviec)->delete();
                }
            }
        }
    }
    public function ktrcv($manhanvien)
    {
        $nhom = DB::table('congviec')
            ->where('manhanvien', $manhanvien)
            ->get();
        $c = count($nhom);
        return response()->json($c);
    }
}
