<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChiTietDatDichVuController;
use App\Http\Controllers\ChiTietDichVuController;
use App\Http\Controllers\ChiTietNgayLamController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\DatDichVuController;
use App\Http\Controllers\DiaChiController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\KieuDichVuController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\WardController;
use App\Models\DatDichVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post("auth/register", [AuthController::class, "register"]);
Route::post("auth/login", [AuthController::class, "login"]);
Route::put('auth/doimatkhau', [AuthController::class,'doiMatKhau']);
Route::post("user/{id}", [AuthController::class, "updateUser"]);
Route::group([
    "prefix" => "auth",
    "middleware" => ["auth:api"]
], function(){
    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("refresh-token", [AuthController::class, "refreshToken"]);
    Route::get("logout", [AuthController::class, "logout"]);
});

Route::group([
    "middleware" => ["auth:api"]
], function(){
    Route::get('ChiTietNhanVienLamDichVu/getDataByIdChiTietNgayLam/{idChiTietNgayLam}', [ChiTietDatDichVuController::class, 'getDataByIdChiTietNgayLam']);
    Route::get('NhanVien/getStaffIsNotAddChiTietNgayLam', [NhanVienController::class, 'getStaffIsNotAddChiTietNgayLam']);
    Route::get('ChiTietNgayLam/getDataByIdPhieuDichVu/{idPhieuDichVu}', [ChiTietNgayLamController::class, 'getDataByIdPhieuDichVu']);
    Route::post('DiaChi/insertAddress', [DiaChiController::class, 'insertAddress']);
    Route::get('ChucVu/getPositionByDepartment/{idPhongBan}', [ChucVuController::class, 'getPositionByDepartment']);
    Route::post('NhanVien/importData', [NhanVienController::class, 'importData']);
    Route::get('NhanVien/exportImportHeaderData', [NhanVienController::class, 'exportImportHeaderData']);
    Route::apiResource('ChiTietNhanVienLamDichVu', ChiTietDatDichVuController::class);
    Route::apiResource('PhieuDichVu', DatDichVuController::class);
    Route::apiResource('DichVu', DichVuController::class);
    Route::apiResource('KhachHang', KhachHangController::class);
    Route::apiResource('NhanVien', NhanVienController::class);
    Route::apiResource('ChucVu', ChucVuController::class);
    Route::apiResource('PhongBan', PhongBanController::class);
});

Route::get("layChiTietDVTheoIdDV/{id}", [ChiTietDichVuController::class, "layChiTietDVTheoIdDV"]);
Route::resource('dichvu', DichVuController::class);
Route::resource('phieudichvu', DatDichVuController::class);
Route::get('layIdKhachHang/{id}', [KhachHangController::class, "layIdKhachHang"]);
Route::resource('diachi', DiaChiController::class);
Route::resource('province', ProvinceController::class);
Route::get('layDiaChiByIdNguoiDung/{id}', [DiaChiController::class,'layDiaChiByIdNguoiDung']);
Route::get('layHuyenByProvinceId/{id}', [DistrictController::class,'layHuyenByProvinceId']);
Route::get('layXaByDistrictId/{id}', [WardController::class,'layXaByDistrictId']);
Route::get("layPhieuDichVuTheoIdKhachHang/{id}",[DatDichVuController::class,"layPhieuDichVuTheoIdKhachHang"]);
Route::resource('phieudichvu', DatDichVuController::class);
Route::get('layKieuDVByIdDV/{id}', [KieuDichVuController::class,'layKieuDVByIdDV']);
Route::get("layChiTietDVTheoIdKieuDV/{id}", [ChiTietDichVuController::class, "layChiTietDVTheoIdKieuDV"]);
Route::resource('chitietngaylam', ChiTietNgayLamController::class);
Route::get('layChiTietNLTheoIdPDV/{id}', [ChiTietNgayLamController::class,'layChiTietNgayLamByIdPhieuDichVu']);

Route::post('thanhtoanvnpay', [ThanhToanController::class,'thanhToanVnPay']);
Route::get('xacnhanthanhtoan', [ThanhToanController::class,'xacNhanThanhToan']);
Route::resource('thongke', ThongKeController::class);
