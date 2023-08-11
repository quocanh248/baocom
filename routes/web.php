<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Nhansucontroller;
use App\Http\Controllers\controllercongviec;
use App\Http\Controllers\controllersodo;
use App\Http\Controllers\logincontroller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dangnhap');
});
Route::get('/viewlogin', [logincontroller::class, 'viewlogin'])->name('login');

Route::post('/login', [logincontroller::class, 'login']);
Route::post('/themtaikhoan', [logincontroller::class, 'themtaikhoan']);
Route::post('/themvaitro', [logincontroller::class, 'themvaitro']);

Route::get('/layvaitro/{manhanvien}', [logincontroller::class, 'layvaitro']);
Route::get('/layvaitrouser/{manhanvien}', [logincontroller::class, 'layvaitrouser']);
Route::get('/huyvaitro/{maquyen}/{manhanvien}', [logincontroller::class, 'huyvaitro']);
Route::middleware('auth')->group(function () {
    Route::get('/laythongtinnhansu', [Nhansucontroller::class, 'laythongtinnhansu']);
    Route::get('/lichlamviec0', [Nhansucontroller::class, 'lichlamviec0']);
    Route::get('/dslichlamviec0', [Nhansucontroller::class, 'dslichlamviec0']);
    Route::get('/lichlamviec', [Nhansucontroller::class, 'lichlamviec']);
   
    Route::get('/dsdiemdanh', [Nhansucontroller::class, 'dsdiemdanh']);
    Route::get('/dslichlamviec', [Nhansucontroller::class, 'dslichlamviec']);
    Route::post('/search', [Nhansucontroller::class, 'search'])->name('search.search');

    Route::get('/restore', [Nhansucontroller::class, 'restore']);
    Route::get('/dsnhansu', [Nhansucontroller::class, 'dsnhansu']);
    Route::post('/themnhansu', [Nhansucontroller::class, 'themnhansu']);
    Route::get('/viewcaptaikhoan', [Nhansucontroller::class, 'viewcaptaikhoan']);
    Route::get('/index1', [logincontroller::class, 'index1']);
    Route::get('/dangxuat', [logincontroller::class, 'dangxuat']);
    Route::get('/dscomchay', [logincontroller::class, 'dscomchay']);
    Route::get('/dscomman', [logincontroller::class, 'dscomman']);
    Route::get('/thongkeslcom', [logincontroller::class, 'thongkeslcom']);
    Route::get('/thongkecomthang', [logincontroller::class, 'thongkecomthang']);
    Route::post('/capnhatnhomql', [logincontroller::class, 'capnhatnhomql']);

    //Công việc
    Route::get('/laybophanuser/{manhanvien}', [logincontroller::class, 'laybophanuser']);
    Route::get('/viewpccv', [controllercongviec::class, 'viewpccv']);
    Route::get('/xemcongviecnhom/{manhanvien}', [controllercongviec::class, 'xemcongviecnhom']);
    Route::get('/ktrcv/{manhanvien}', [controllercongviec::class, 'ktrcv']);
    Route::get('/laybophanql/{manhanvien}', [controllercongviec::class, 'laybophanql']);
    Route::get('/laytieudenhom/{manhanvien}', [controllercongviec::class, 'laytieudenhom']);
    Route::get('/laynhansunhom/{manhanvien}', [controllercongviec::class, 'laynhansunhom']);
    Route::get('/laydscongviec/{manhanvien}', [controllercongviec::class, 'laydscongviec']);
    Route::post('/themcongviec', [controllercongviec::class, 'themcongviec']);
    Route::post('/themcongviecht', [controllercongviec::class, 'themcongviecht']);

    Route::get('/laythongtincongviec/{macongviec}', [controllercongviec::class, 'laythongtincongviec']);
    Route::post('/capnhattrangthaicv', [controllercongviec::class, 'capnhattrangthaicv']);
    Route::get('/viewpccvcc', [controllercongviec::class, 'viewpccvcc']);
    Route::post('/timkiemcvnhom', [controllercongviec::class, 'timkiemcvnhom']);
    Route::get('/xemlscvnhom/{manhanvien}', [controllercongviec::class, 'xemlscvnhom']);
    Route::get('/laythongtinlscongviec/{macongviec}', [controllercongviec::class, 'laythongtinlscongviec']);
    Route::get('/huycongviec/{macongviec}', [controllercongviec::class, 'huycongviec']);
    Route::get('/laynhanvientiepnhan/{manhanvien}/{manhom}', [controllercongviec::class, 'laynhanvientiepnhan']);
    Route::get('/chuyenbophan/{manhom}', [controllercongviec::class, 'chuyenbophan']);
    Route::post('/timkiemlscvnhom', [controllercongviec::class, 'timkiemlscvnhom']);
    Route::post('/chuyenbophanmoi', [controllercongviec::class, 'chuyenbophanmoi']);
    Route::post('/bangiaocv', [controllercongviec::class, 'bangiaocv']);
    Route::get('/xemlscvcc', [controllercongviec::class, 'xemlscvcc']);
    Route::get('/cvsaphethan', [controllercongviec::class, 'cvsaphethan']);

    Route::get('/capnhatsodo', [controllersodo::class, 'capnhatsodo']);
    Route::post('/xoanode', [controllersodo::class, 'xoanode']);
    Route::get('/sodo', [controllersodo::class, 'sodo']);
    Route::get('/xemsodo', [controllersodo::class, 'xemsodo']);
    Route::post('/capnhatsodochucdanh', [controllersodo::class, 'capnhatsodochucdanh']);
    Route::get('/laythongtinchucdanh/{manhanvien}', [controllersodo::class, 'laythongtinchucdanh']);
    Route::get('/dssodo', [controllersodo::class, 'dssodo']);
    Route::post('/capnhatsodochucdanh1', [controllersodo::class, 'capnhatsodochucdanh1']);
});
Route::get('/convert', [logincontroller::class, 'convert']);
Route::get('/dkcomchay', [logincontroller::class, 'dkcomchay']);
Route::get('/ktrcomchay', [logincontroller::class, 'ktrcomchay']);
Route::get('/laythongtin', [logincontroller::class, 'laythongtin']);
Route::get('/laythongtincomchay', [logincontroller::class, 'laythongtincomchay']);
Route::get('/checkthongtincomchay', [logincontroller::class, 'checkthongtincomchay']);
Route::get('/getIPAddress', [logincontroller::class, 'getIPAddress']);

Route::get('/tkcomtheongay', [logincontroller::class, 'tkcomtheongay']);
Route::post('/nhapsoluongcom', [logincontroller::class, 'nhapsoluongcom']);
Route::post('/timtkcom', [logincontroller::class, 'timtkcom']);
Route::post('/tkthang', [logincontroller::class, 'tkthang']);
Route::get('/timsoi', [Nhansucontroller::class, 'timsoi']);
Route::get('/timmodel', [Nhansucontroller::class, 'timmodel']);
Route::post('/timlot', [Nhansucontroller::class, 'timlot']);
Route::post('/timmodel1', [Nhansucontroller::class, 'timmodel1']);



Route::get('/checkcn/{manhanvien}', [Nhansucontroller::class, 'checkcn']);
Route::get('/check', [Nhansucontroller::class, 'check']);
Route::get('/con', [Nhansucontroller::class, 'con']);
Route::get('/testapi', [Nhansucontroller::class, 'testapi']);
Route::get('/diemdanh', [Nhansucontroller::class, 'diemdanh']);
Route::get('/testmaycon', [Nhansucontroller::class, 'testmaycon']);
Route::get('/getToken/{manhanvien}/{a}', [Nhansucontroller::class, 'getToken']);