<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Session;

class logincontroller extends Controller
{
    public function viewlogin()
    {
        return view('dangnhap');
    }
    public function index1()
    {
        return view('index');
    }
    public function themtaikhoan(Request $r)
    {

        $kt = DB::table('users')
            ->select('id')
            ->where('manhanvien', '=', $r->manhanvien)
            ->where('name', '=', $r->username)
            ->get();
        if (count($kt) == 0) {
            DB::table('users')->insert([
                'name' => $r->username,
                'email' => $r->username,
                'password' => bcrypt($r->password),
                'manhanvien' => $r->manhanvien,
            ]);
            return response()->json(['success' => true, 'message' => 'Tạo tài khoản thành công']);
        } else {
            return response()->json(['success' => false, 'message' => 'Tài khoản đã tồn tại']);
        }
    }
    public function layvaitro($manhanvien)
    {
        $kt = DB::table('quyen')
            ->join('quyenuser', 'quyenuser.maquyen', '=', 'quyen.maquyen')
            ->join('users', 'users.id', '=', 'quyenuser.id')
            ->select('quyenuser.maquyen', 'tenquyen')
            ->where('manhanvien', '=', $manhanvien)
            ->get();
        $vaitro = DB::table('quyen')->get();
        $filteredQuyen = $vaitro->reject(function ($quyen) use ($kt) {
            return $kt->contains('maquyen', $quyen->maquyen) && $kt->contains('tenquyen', $quyen->tenquyen);
        });
        return response()->json($filteredQuyen);
    }
    public function capnhatnhomql(Request $r)
    {
        $nhom = $r->nhom;
        $manhanvien = $r->manhanvien;
        $kt = DB::table('nhansu_bophan')
            ->select('mabophan')
            ->where('manhanvien', '=', $manhanvien)
            ->where('tt', '=', "bophanchinh")
            ->first();
            DB::table('nhansu_bophan')->where('manhanvien', $manhanvien)->where('tt', "bophanquanly")->delete();
        for ($i = 0; $i < count($nhom); $i++) {
            if ($kt->mabophan != $nhom[$i]) {
                DB::table('nhansu_bophan')->insert([
                    'manhanvien' => $manhanvien,
                    'mabophan' => $nhom[$i],
                    'tt' => "bophanquanly"
                ]);
            }
        }
       
        return response()->json([
            'success' => true,            
        ]);
    }
    public function layvaitrouser($manhanvien)
    {
        $kt = DB::table('quyen')
            ->join('quyenuser', 'quyenuser.maquyen', '=', 'quyen.maquyen')
            ->join('users', 'users.id', '=', 'quyenuser.id')
            ->select('quyenuser.maquyen', 'tenquyen')
            ->where('manhanvien', '=', $manhanvien)
            ->get();
        return response()->json($kt);
    }
    // public function themvaitro(Request $r)
    // {

    //     $kt = DB::table('users')
    //         ->select('id')
    //         ->where('manhanvien', '=', $r->manhanvien)
    //         ->first();


    //     if ($r->vaitro == null && $r->nhomql != null) {
    //         $kt12 = DB::table('bophan')
    //             ->select('mabophan')
    //             ->where('tengoinho', '=', $r->nhomql)
    //             ->first();
    //         DB::table('nhansu_bophan')->insert([
    //             'manhanvien' => $r->manhanvien,
    //             'mabophan' => $kt12->mabophan,
    //             'tt' => "bophanquanly"

    //         ]);
    //         return response()->json(['success' => true, 'message' => 'Thêm quản lý bộ phận thành công!']);
    //     } else {
    //         if ($r->nhomql != null) {
    //             $kt12 = DB::table('bophan')
    //                 ->select('mabophan')
    //                 ->where('tengoinho', '=', $r->nhomql)
    //                 ->first();
    //             DB::table('nhansu_bophan')->insert([
    //                 'manhanvien' => $r->manhanvien,
    //                 'mabophan' => $kt12->mabophan,
    //                 'tt' => "bophanquanly"

    //             ]);
    //         }           
    //         DB::table('quyenuser')->insert([
    //             'id' => $kt->id,
    //             'maquyen' => $r->vaitro,

    //         ]);
    //         return response()->json(['success' => true, 'message' => 'Thêm vai trò thành công']);
    //     }
    // }
    public function huyvaitro($maquyen, $manhanvien)
    {
        $kt = DB::table('users')
            ->select('id')
            ->where('manhanvien', '=', $manhanvien)
            ->first();
        DB::table('quyenuser')->where('id', $kt->id)->where('maquyen', $maquyen)->delete();
        return response()->json(['success' => true, 'message' => 'Hủy vai trò thành công']);
    }
    public function themvaitro(Request $r)
    {

        $kt = DB::table('users')
            ->select('id')
            ->where('manhanvien', '=', $r->manhanvien)
            ->first();

        if ($r->vaitro == 1) {
            DB::table('quyenuser')->where('id', $kt->id)->delete();
        }

        DB::table('quyenuser')->insert([
            'id' => $kt->id,
            'maquyen' => $r->vaitro,

        ]);
        $kt1 = DB::table('quyen')
            ->join('quyenuser', 'quyenuser.maquyen', '=', 'quyen.maquyen')
            ->join('users', 'users.id', '=', 'quyenuser.id')
            ->select('quyenuser.maquyen', 'tenquyen')
            ->where('manhanvien', '=', $r->manhanvien)
            ->get();
        //dd($kt1);
        $vaitro = DB::table('quyen')->get();
        $filteredQuyen = $vaitro->reject(function ($quyen) use ($kt1) {
            return $kt1->contains('maquyen', $quyen->maquyen) && $kt1->contains('tenquyen', $quyen->tenquyen);
        });
        return response()->json([
            'filteredQuyen' => $filteredQuyen,
            'kt' => $kt1
        ]);
        // return response()->json(['success' => true, 'message' => 'Thêm vai trò thành công']);
    }
    public function laybophanuser($manhanvien)
    {

        $kt1 = DB::table('nhansu_bophan')
            ->select('mabophan')
            ->where('manhanvien', '=', $manhanvien)
            ->get();
        //dd($kt1);
        $vaitro = DB::table('bophan')->get();
        return response()->json([
            'vaitro' => $vaitro,
            'kt' => $kt1
        ]);
        // return response()->json(['success' => true, 'message' => 'Thêm vai trò thành công']);
    }
    public function login(Request $r)
    {
        if (Auth::attempt(['name' => $r->input('username'), 'password' => $r->input('password')])) {
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $q = DB::table('quyenuser')
                ->select('maquyen')
                ->where('id', $userid)
                ->get();                //dd($q);

            Session::put('q', $q);
            Session::put('userid', $userid);
            Session::put('username', $username);

            return redirect('index1');
        } else {

            return redirect('viewlogin');
        }

        return redirect('viewlogin');
    }

    public function dangxuat()
    {
        Auth::logout();
        Session::forget('datanew');
        Session::forget('datanhombannew');
        Session::forget('datanewban');
        Session::forget('dataoldb');
        Session::forget('tbb');
        Session::forget('tcb');
        Session::forget('tbr');
        Session::forget('tcr');
        Session::forget('dataassynew');
        Session::forget('quyen');
        Session::forget('userid');
        Session::forget('quyen1');
        Session::forget('quyen2');
        Session::forget('quyen3');
        Session::forget('quyen4');
        Session::forget('username');
        Session::forget('dataold1');
        Session::forget('dataoldr');
        Session::forget('dataold');
        Session::forget('tb');
        Session::forget('tc');
        Session::forget('tba');
        Session::forget('tca');
        return redirect('/');
    }
    public function convert()
    {
        return view('baocom');
    }
    public function getIPAddress()
    {
        $currentDate = Carbon::now();
        $nextMonday = $currentDate->next(Carbon::MONDAY)->format('Y-m-d');
        return $nextMonday;
    }
    public function laythongtin(Request $request)
    {
        $ipAddress = $request->ip();
        $currentDate1 = Carbon::now();
        $t1 = $currentDate1->setTimezone('Asia/Ho_Chi_Minh');
        $id = $request->result;

        $soKyTu = strlen($id);

        if ($soKyTu > 12) {
            $viTriDauPhay = strpos($id, ',', strpos($id, ',') + 1);

            // Lấy 7 ký tự từ vị trí dấu phẩy thứ hai trở đi
            $kyTu = substr($id, $viTriDauPhay + 1, 7);
            $kt = DB::table('nhansu')
                ->select('*')
                ->where('manhanvien', $kyTu)
                ->get();
        } else {
            $id_dec = floatval($request->result);
            $hex = sprintf("%08X", $id_dec);
            $hexPairs = str_split($hex, 2);
            $reversedPairs = array_reverse($hexPairs);
            $id_hex = implode("", $reversedPairs);
            $kt = DB::table('nhansu')
                ->select('*')
                ->where('tag', $id_hex)
                ->get();
        }
        $startOfDay = $t1->copy()->startOfDay()->hour(6);
        $endOfDay = $t1->copy()->startOfDay()->hour(10);
        $startOfDay1 = $t1->copy()->startOfDay()->hour(12);
        $targetTime = Carbon::createFromTime(15, 30, 0);
        if ($t1->between($startOfDay, $endOfDay)) {
            $khunggio = "S";
        } elseif ($t1->between($startOfDay1, $targetTime)) {
            $khunggio = "C";
        } else {
            $k = substr($t1, 14, 2);
            $thoiGian = Carbon::parse(substr($t1, 10, 6));

            if ($k < 30) {
                $kg = $thoiGian->minute(0);
            } else {
                $kg = $thoiGian->minute(30);
            }
            $khunggio = substr($kg, 11, 5);
        }
        if (count($kt) > 0) {
            $currentDate = Carbon::now();
            $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');

            // Lấy chỉ ngày, tháng và năm từ Carbon date
            $ngayThangNam = $t->format('d-m-Y');
            $ktc = DB::table('commands')
                ->select('*')
                ->where('manhanvien', '=', $kt[0]->manhanvien)
                ->where('created_at', '=', $ngayThangNam)
                ->get();

            if (count($ktc) == 0) {
                DB::table('commands')->insert([
                    'manhanvien' => $kt[0]->manhanvien,
                    'created_at' => $ngayThangNam,
                    'updated_at' => $t,
                    'khunggio' => $khunggio,
                    'ip' => $ipAddress
                ]);
            }
        }
        return response()->json($kt);
    }
    public function dkcomchay()
    {
        return view('dkcomchay');
    }
    public function ktrcomchay()
    {
        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');

        // Lấy chỉ ngày, tháng và năm từ Carbon date
        $ngayThangNam = $t->format('d-m-Y');
        $ktc = DB::table('comchayds')
            ->select('*')
            ->where('ngaydk', '=', $ngayThangNam)
            ->where('tt', '=', 'dk')
            ->get();

        return view('checkcomchay', [
            'ktc' => $ktc
        ]);
    }
    public function laythongtincomchay(Request $request)
    {
        $currentDate1 = Carbon::now();
        $t1 = $currentDate1->setTimezone('Asia/Ho_Chi_Minh');
        $ipAddress = $request->ip();
        $id = $request->result;

        $soKyTu = strlen($id);

        if ($soKyTu > 12) {
            $viTriDauPhay = strpos($id, ',', strpos($id, ',') + 1);

            // Lấy 7 ký tự từ vị trí dấu phẩy thứ hai trở đi
            $kyTu = substr($id, $viTriDauPhay + 1, 7);
            $kt = DB::table('nhansu')
                ->select('*')
                ->where('manhanvien', $kyTu)
                ->get();
        } else {
            $id_dec = floatval($request->result);
            $hex = sprintf("%08X", $id_dec);
            $hexPairs = str_split($hex, 2);
            $reversedPairs = array_reverse($hexPairs);
            $id_hex = implode("", $reversedPairs);
            $kt = DB::table('nhansu')
                ->select('*')
                ->where('tag', $id_hex)
                ->get();
        }
        if (count($kt) > 0) {
            $currentDate = Carbon::tomorrow();
            $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');
            if ($t->isSunday()) {
                $ngayThangNam = $t->next(Carbon::MONDAY)->format('d-m-Y');
                $t = $t->next(Carbon::MONDAY);
            } else {
                // Lấy chỉ ngày, tháng và năm từ Carbon date
                $ngayThangNam = $t->format('d-m-Y');
            }
            $ktc = DB::table('comchayds')
                ->select('*')
                ->where('manhanvien', '=', $kt[0]->manhanvien)
                ->where('ngaydk', '=', $ngayThangNam)
                ->get();
            $startOfDay = $t1->copy()->startOfDay()->hour(6);
            $endOfDay = $t1->copy()->startOfDay()->hour(10);
            $startOfDay1 = $t1->copy()->startOfDay()->hour(12);
            $targetTime = Carbon::createFromTime(15, 30, 0);
            if ($t1->between($startOfDay, $endOfDay)) {
                $khunggio = "S";
            } elseif ($t1->between($startOfDay1, $targetTime)) {
                $khunggio = "C";
            } else {
                $k = substr($t1, 14, 2);
                $thoiGian = Carbon::parse(substr($t1, 10, 6));

                if ($k < 30) {
                    $kg = $thoiGian->minute(0);
                } else {
                    $kg = $thoiGian->minute(30);
                }
                $khunggio = substr($kg, 10, 6);
            }
            if (count($ktc) == 0) {
                DB::table('comchayds')->insert([
                    'manhanvien' => $kt[0]->manhanvien,
                    'ngaydk' => $ngayThangNam,
                    'created_at' => $t1,
                    'updated_at' => $t,
                    'tt' => 'dk',
                    'khunggio' => $khunggio,
                    'ip' => $ipAddress
                ]);
            }
        }
        return response()->json($kt);
    }
    public function checkthongtincomchay(Request $request)
    {
        $ipAddress = $request->ip();
        $id = $request->result;

        $soKyTu = strlen($id);

        if ($soKyTu > 12) {
            $viTriDauPhay = strpos($id, ',', strpos($id, ',') + 1);

            // Lấy 7 ký tự từ vị trí dấu phẩy thứ hai trở đi
            $kyTu = substr($id, $viTriDauPhay + 1, 7);
            $kt = DB::table('nhansu')
                ->select('*')
                ->where('manhanvien', $kyTu)
                ->get();
        } else {
            $id_dec = floatval($request->result);
            $hex = sprintf("%08X", $id_dec);
            $hexPairs = str_split($hex, 2);
            $reversedPairs = array_reverse($hexPairs);
            $id_hex = implode("", $reversedPairs);
            $kt = DB::table('nhansu')
                ->select('*')
                ->where('tag', $id_hex)
                ->get();
        }

        if (count($kt) > 0) {
            $currentDate = Carbon::now();
            $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');

            // Lấy chỉ ngày, tháng và năm từ Carbon date
            $ngayThangNam = $t->format('d-m-Y');
            $ktc = DB::table('comchayds')
                ->select('*')
                ->where('manhanvien', '=', $kt[0]->manhanvien)
                ->where('ngaydk', '=', $ngayThangNam)
                ->get();

            if (count($ktc) > 0) {
                DB::table('comchayds')
                    ->where('manhanvien', '=', $kt[0]->manhanvien)
                    ->where('ngaydk', '=', $ngayThangNam)
                    ->update(['tt' => 'dn', 'updated_at' => $t]);
            } else {
                return response()->json(999);
            }
        }
        return response()->json($kt);
    }
    public function dscomchay()
    {

        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');
        $ngayThangNam = $t->format('d-m-Y');
        $startOfDay = $t->copy()->startOfDay()->hour(1);
        $endOfDay = $t->copy()->startOfDay()->hour(23);
        $lichlamviec1 =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('comchayds', 'comchayds.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip', 'comchayds.ngaydk', 'comchayds.created_at', 'tt', 'comchayds.updated_at', 'khunggio')
            ->where('ngaydk', $ngayThangNam)
            ->groupBy('tt', 'nhomlamviec.manhom', 'comchayds.ngaydk', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip',  'comchayds.created_at', 'comchayds.updated_at', 'khunggio')
            ->get();
        $diemdanh = DB::table('diemdanh')
            ->select('*')
            ->whereBetween('gio', [$startOfDay, $endOfDay])
            ->get();
        $mangMaNhanVien = [];
        foreach ($diemdanh as $hang) {
            $manhanvien = $hang->manhanvien;
            if (!Str::startsWith($manhanvien, range('a', 'z')) && !Str::startsWith($manhanvien, range('A', 'Z'))) {
                $mangMaNhanVien[] = $manhanvien;
            }
        }
        $mangMaNhanViennghi = [];
        foreach ($lichlamviec1 as $manhanvien) {
            if (!in_array($manhanvien->manhanvien, $mangMaNhanVien)) {
                $mangMaNhanViennghi[] = $manhanvien->manhanvien;
            }
        }
        $lichlamviec =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('comchayds', 'comchayds.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip', 'comchayds.ngaydk', 'comchayds.created_at', 'tt', 'comchayds.updated_at', 'khunggio')
            ->groupBy('tt', 'nhomlamviec.manhom', 'comchayds.ngaydk',  'khunggio',  'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip',  'comchayds.created_at', 'comchayds.updated_at')
            ->orderBy('comchayds.ngaydk', 'desc')
            ->get();
        return view('dscomchay', ['results' => $lichlamviec, 'nvn' => $mangMaNhanViennghi, 'ngaydk' => $ngayThangNam]);
    }
    public function dscomman()
    {
        $lichlamviec =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('commands', 'commands.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip', 'commands.created_at',  'commands.updated_at')
            ->groupBy('commands.created_at', 'nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip',  'commands.updated_at')
            ->get();
        return view('dscomman', ['results' => $lichlamviec]);
    }
    public function thongkeslcom()
    {
        $nam = Carbon::now()->year;
        $results = DB::table('commands')
            ->select(DB::raw('MONTH(updated_at) as month'), DB::raw('count(id) as com_man_total'))
            ->whereYear('updated_at', $nam)
            ->groupBy(DB::raw('MONTH(updated_at)'))
            ->get();
        $results1 = DB::table('comchayds')
            ->select(DB::raw('MONTH(updated_at) as month'), DB::raw('count(id) as com_chay_total'))
            ->whereYear('updated_at', $nam)
            ->groupBy(DB::raw('MONTH(updated_at)'))
            ->get();

        dd($results);
        $userInputMonth = 5; // Tháng 5
        $userInputYear = 2023; // Năm 2023

        $date = Carbon::create($userInputYear, $userInputMonth, 1);
        $startOfMonth = $date->startOfMonth()->toDateTimeString();
        $endOfMonth = $date->endOfMonth()->toDateTimeString();
    }
    public function tkcomtheongay()
    {
        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');
        $ngayThangNam = $t->format('d-m-Y');

        $lichlamviec =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('comchayds', 'comchayds.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip', 'comchayds.ngaydk', 'comchayds.created_at', 'tt', 'comchayds.updated_at', 'khunggio')
            ->where('ngaydk', $ngayThangNam)
            ->groupBy('tt', 'nhomlamviec.manhom', 'comchayds.ngaydk', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip',  'comchayds.created_at', 'comchayds.updated_at', 'khunggio')
            ->get();
        $startOfDay1 = $t->copy()->startOfDay()->hour(1);
        $endOfDay1 = $t->copy()->startOfDay()->hour(23);

        $soluongcom = DB::table('soluongcom')
            ->select('*')
            ->whereBetween('created_at', [$startOfDay1, $endOfDay1])
            ->get();
        if ($t->isMonday()) {
            $previousSaturday = $currentDate->previous(Carbon::SATURDAY);
            $t1 = $previousSaturday->setTimezone('Asia/Ho_Chi_Minh');
        } else {
            $date = Carbon::yesterday();
            $t1 = $date->setTimezone('Asia/Ho_Chi_Minh');
        }
        $ngayThangNam1 = $t1->format('d-m-Y');
        $comman =  DB::table('nhansu')
            ->join('nhomlamviec', 'nhomlamviec.manhom', '=', 'nhansu.manhom')
            ->join('commands', 'commands.manhanvien', '=', 'nhansu.manhanvien')
            ->select('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip',  'commands.created_at',  'commands.updated_at', 'khunggio')
            ->where('commands.created_at', $ngayThangNam1)
            ->groupBy('nhomlamviec.manhom', 'nhansu.manhanvien', 'tennhom', 'tennhanvien', 'ip',  'commands.created_at', 'commands.updated_at', 'khunggio')
            ->get();
        //dd($comman);
        $currentDate1 = Carbon::now();
        $t2 = $currentDate1->setTimezone('Asia/Ho_Chi_Minh');
        $startOfDay = $t2->copy()->startOfDay()->hour(1);
        $endOfDay = $t2->copy()->startOfDay()->hour(23);

        $diemdanh = DB::table('diemdanh')
            ->select('*')
            ->whereBetween('gio', [$startOfDay, $endOfDay])
            ->get();
        $mangMaNhanVien = [];
        foreach ($diemdanh as $hang) {
            $manhanvien = $hang->manhanvien;
            if (!Str::startsWith($manhanvien, range('a', 'z')) && !Str::startsWith($manhanvien, range('A', 'Z'))) {
                $mangMaNhanVien[] = $manhanvien;
            }
        }

        $soLuong1 = 0;
        $soLuong2 = 0;
        foreach ($lichlamviec as $manhanvien) {
            if ($manhanvien->ip == "30.30.30.32" || $manhanvien->ip == "30.30.30.36") {
                if (!in_array($manhanvien->manhanvien, $mangMaNhanVien)) {
                    $soLuong1++;
                }
            } else {
                if (!in_array($manhanvien->manhanvien, $mangMaNhanVien)) {
                    $soLuong2++;
                }
            }
        }

        return view('tkcomtheongay', [
            'results' => $lichlamviec,
            'comman' => $comman,
            'diemdanh' => $mangMaNhanVien,
            'soluong1' => $soLuong1,
            'soluong2' => $soLuong2,
            'slcom' => $soluongcom,

        ]);
    }
    public function nhapsoluongcom(Request $r)
    {
        $mansang1     = $r->man1s;
        $manchieu1    =    $r->man1c;
        $mansang2    = $r->man2s;
        $manchieu2    = $r->man2c;
        $chaysang1    = $r->chay1s;
        $chaysang2    = $r->chay2s;
        $chaychieu1    = $r->chay1c;
        $chaychieu2   = $r->chay2c;
        $currentDate = Carbon::now();
        $t = $currentDate->setTimezone('Asia/Ho_Chi_Minh');
        $currentDate1 = Carbon::now();
        $t2 = $currentDate1->setTimezone('Asia/Ho_Chi_Minh');
        $startOfDay = $t2->copy()->startOfDay()->hour(1);
        $endOfDay = $t2->copy()->startOfDay()->hour(23);

        $diemdanh = DB::table('diemdanh')
            ->select('*')
            ->whereBetween('gio', [$startOfDay, $endOfDay])
            ->get();
        $mangMaNhanVien = [];
        foreach ($diemdanh as $hang) {
            $manhanvien = $hang->manhanvien;
            if (!Str::startsWith($manhanvien, range('a', 'z')) && !Str::startsWith($manhanvien, range('A', 'Z'))) {
                $mangMaNhanVien[] = $manhanvien;
            }
        }
        $ktr = DB::table('soluongcom')
            ->select('*')
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->get();
        if (count($ktr) > 0) {
            DB::table('soluongcom')
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                ->update([
                    'mansang1' =>   $mansang1,
                    'manchieu1' =>   $manchieu1,
                    'mansang2' =>    $mansang2,
                    'manchieu2' =>   $manchieu2,
                    'chaysang1' =>   $chaysang1,
                    'chaysang2' =>  $chaysang2,
                    'chaychieu1' => $chaychieu1,
                    'chaychieu2' =>  $chaychieu2,
                    'chaychieu2' =>  $chaychieu2,
                    'created_at' => $t,
                    'diemdanh' => count($mangMaNhanVien) - 1,
                ]);
        } else {
            DB::table('soluongcom')->insert([
                'mansang1' =>   $mansang1,
                'manchieu1' =>   $manchieu1,
                'mansang2' =>    $mansang2,
                'manchieu2' =>   $manchieu2,
                'chaysang1' =>   $chaysang1,
                'chaysang2' =>  $chaysang2,
                'chaychieu1' => $chaychieu1,
                'chaychieu2' =>  $chaychieu2,
                'chaychieu2' =>  $chaychieu2,
                'created_at' => $t,
                'diemdanh' => count($mangMaNhanVien) - 1,
            ]);
        }
        return redirect()->back();
    }
    public function thongkecomthang()
    {
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->format('m');
        $currentYear = $currentDate->format('Y');

        $month = $currentYear . "-" . $currentMonth;
        $results = DB::table('comchayds')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_comchay, COUNT(CASE WHEN tt = "dn" THEN 1 END) AS total_dn'))
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');

        $commands = DB::table('commands')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_commands'))
            ->where('ip', '30.30.30.42')
            ->orwhere('ip', '30.30.30.43')
            ->orwhere('ip', '30.30.30.44')
            ->orwhere('ip', '30.30.30.45')
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');
        $commandst = DB::table('commands')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_commands'))
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');

        $comchayds1 = DB::table('comchayds')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('tt', 'dn')
            ->where('ip', '30.30.30.31')
            ->orwhere('ip', '30.30.30.36')
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');
        $comchayds2 = DB::table('comchayds')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('tt', 'dn')
            ->where('ip', '30.30.30.32')
            ->orwhere('ip', '30.30.30.41')
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');
        $dkchay1 = DB::table('comchayds')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('ip', '30.30.30.31')
            ->orwhere('ip', '30.30.30.36')
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');
        $dkchay2 = DB::table('comchayds')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('ip', '30.30.30.32')
            ->orwhere('ip', '30.30.30.41')
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');
        // $dkchay2 = DB::table('comchayds')
        //     ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_comchayds'))
        //     ->where('ip', '30.30.30.32')
        //     ->orwhere('ip', '30.30.30.41')
        //     ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
        //     ->groupBy(DB::raw('DATE(updated_at)'))
        //     ->get()
        //     ->keyBy('date');
        // $soluongcom = DB::table('soluongcom')
        //     ->select(DB::raw('DATE(created_at) AS date, COUNT(*) AS total_soluongcom'))
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->get()
        //     ->keyBy('date');
        $soluongcom = DB::table('soluongcom')
            ->select(DB::raw('DATE(created_at) AS date, mansang1 + manchieu1 AS man1, chaysang1 + chaychieu1 AS chay1, chaysang2 + chaychieu2 AS chay2, mansang2 + manchieu2 AS man2, diemdanh'))
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->get()
            ->keyBy('date');
        $combinedData = [];

        foreach ($results as $date => $result) {


            if (isset($commands[$date])) {
                $combinedData[$date] = [
                    'date' => $date,
                    'total_commands' => $commands[$date]->total_commands ?? 0,
                    'total_comchayds' => $result->total_comchay ?? 0,
                    'total_comchayds1' => $comchayds1[$date]->total_comchayds ?? 0,
                    'total_comchayds2' => $comchayds2[$date]->total_comchayds ?? 0,
                    'dkchay1' => $dkchay1[$date]->total_comchayds ?? 0,
                    'dkchay2' => $dkchay2[$date]->total_comchayds ?? 0,
                    'total_comchaydn' => $result->total_dn ?? 0,
                    'commandst' => $commandst[$date]->total_commands ?? 0,
                    'man1' => $soluongcom[$date]->man1 ?? 0,
                    'man2' => $soluongcom[$date]->man2 ?? 0,
                    'chay1' => $soluongcom[$date]->chay1 ?? 0,
                    'chay2' => $soluongcom[$date]->chay2 ?? 0,
                    'diemdanh' => $soluongcom[$date]->diemdanh ?? 0,
                    // 'total_soluongcom' => $soluongcom[$date]->total_soluongcom ?? 0,
                ];
            } else {

                $combinedData[$date] = [
                    'date' => $date,
                    'total_commands' => $commands[$date]->total_commands ?? 0,
                    'total_comchayds' => $result->total_comchay ?? 0,
                    'total_comchayds1' => $comchayds1[$date]->total_comchayds ?? 0,
                    'total_comchayds2' => $comchayds2[$date]->total_comchayds ?? 0,
                    'total_comchaydn' => $result->total_dn ?? 0,
                    'commandst' => $commandst[$date]->total_commands ?? 0,
                    'man1' => $soluongcom[$date]->man1 ?? 0,
                    'man2' => $soluongcom[$date]->man2 ?? 0,
                    'chay1' => $soluongcom[$date]->chay1 ?? 0,
                    'chay2' => $soluongcom[$date]->chay2 ?? 0,
                    'dkchay1' => $dkchay1[$date]->total_comchayds ?? 0,
                    'dkchay2' => $dkchay2[$date]->total_comchayds ?? 0,
                    'diemdanh' => $soluongcom[$date]->diemdanh ?? 0,
                    // 'total_soluongcom' => $soluongcom[$date]->total_soluongcom ?? 0,
                ];
            }
        }
        //dd($combinedData);
        return view('thongkecomthang', ['data' => $combinedData, 'thang' => $month]);
    }
    public function tkthang(Request $r)
    {
        $month = $r->ngay;

        $results = DB::table('comchayds')
            ->select(DB::raw('DATE(created_at) AS date, COUNT(*) AS total_comchay, COUNT(CASE WHEN tt = "dn" THEN 1 END) AS total_dn'))
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');

        $commands = DB::table('commands')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_commands'))
            ->where('ip', '30.30.30.42')
            ->orwhere('ip', '30.30.30.43')
            ->orwhere('ip', '30.30.30.44')
            ->orwhere('ip', '30.30.30.45')
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');
        $commandst = DB::table('commands')
            ->select(DB::raw('DATE(updated_at) AS date, COUNT(*) AS total_commands'))
            ->whereRaw("DATE_FORMAT(updated_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get()
            ->keyBy('date');

        $comchayds1 = DB::table('comchayds')
            ->select(DB::raw('DATE(created_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('tt', 'dn')
            ->where('ip', '30.30.30.31')
            ->orwhere('ip', '30.30.30.36')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');
        $comchayds2 = DB::table('comchayds')
            ->select(DB::raw('DATE(created_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('tt', 'dn')
            ->where('ip', '30.30.30.32')
            ->orwhere('ip', '30.30.30.41')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');
        $dkchay1 = DB::table('comchayds')
            ->select(DB::raw('DATE(created_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('ip', '30.30.30.31')
            ->orwhere('ip', '30.30.30.36')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');
        $dkchay2 = DB::table('comchayds')
            ->select(DB::raw('DATE(created_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('ip', '30.30.30.32')
            ->orwhere('ip', '30.30.30.41')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');
        $dkchay2 = DB::table('comchayds')
            ->select(DB::raw('DATE(created_at) AS date, COUNT(*) AS total_comchayds'))
            ->where('ip', '30.30.30.32')
            ->orwhere('ip', '30.30.30.41')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');
        // $soluongcom = DB::table('soluongcom')
        //     ->select(DB::raw('DATE(created_at) AS date, COUNT(*) AS total_soluongcom'))
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->get()
        //     ->keyBy('date');
        $soluongcom = DB::table('soluongcom')
            ->select(DB::raw('DATE(created_at) AS date, mansang1 + manchieu1 AS man1, chaysang1 + chaychieu1 AS chay1, chaysang2 + chaychieu2 AS chay2, mansang2 + manchieu2 AS man2, diemdanh'))
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->get()
            ->keyBy('date');
        $combinedData = [];

        foreach ($results as $date => $result) {


            if (isset($commands[$date])) {
                $combinedData[$date] = [
                    'date' => $date,
                    'total_commands' => $commands[$date]->total_commands ?? 0,
                    'total_comchayds' => $result->total_comchay ?? 0,
                    'total_comchayds1' => $comchayds1[$date]->total_comchayds ?? 0,
                    'total_comchayds2' => $comchayds2[$date]->total_comchayds ?? 0,
                    'dkchay1' => $dkchay1[$date]->total_comchayds ?? 0,
                    'dkchay2' => $dkchay2[$date]->total_comchayds ?? 0,
                    'total_comchaydn' => $result->total_dn ?? 0,
                    'commandst' => $commandst[$date]->total_commands ?? 0,
                    'man1' => $soluongcom[$date]->man1 ?? 0,
                    'man2' => $soluongcom[$date]->man2 ?? 0,
                    'chay1' => $soluongcom[$date]->chay1 ?? 0,
                    'chay2' => $soluongcom[$date]->chay2 ?? 0,
                    'diemdanh' => $soluongcom[$date]->diemdanh ?? 0,
                    // 'total_soluongcom' => $soluongcom[$date]->total_soluongcom ?? 0,
                ];
            } else {

                $combinedData[$date] = [
                    'date' => $date,
                    'total_commands' => $commands[$date]->total_commands ?? 0,
                    'total_comchayds' => $result->total_comchay ?? 0,
                    'total_comchayds1' => $comchayds1[$date]->total_comchayds ?? 0,
                    'total_comchayds2' => $comchayds2[$date]->total_comchayds ?? 0,
                    'total_comchaydn' => $result->total_dn ?? 0,
                    'commandst' => $commandst[$date]->total_commands ?? 0,
                    'man1' => $soluongcom[$date]->man1 ?? 0,
                    'man2' => $soluongcom[$date]->man2 ?? 0,
                    'chay1' => $soluongcom[$date]->chay1 ?? 0,
                    'chay2' => $soluongcom[$date]->chay2 ?? 0,
                    'dkchay1' => $dkchay1[$date]->total_comchayds ?? 0,
                    'dkchay2' => $dkchay2[$date]->total_comchayds ?? 0,
                    'diemdanh' => $soluongcom[$date]->diemdanh ?? 0,
                    // 'total_soluongcom' => $soluongcom[$date]->total_soluongcom ?? 0,
                ];
            }
        }
        //dd($combinedData);
        return view('thongkecomthang', ['data' => $combinedData, 'thang' => $month]);
    }
}
