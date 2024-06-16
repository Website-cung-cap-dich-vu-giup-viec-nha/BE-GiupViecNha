<?php

namespace App\Http\Controllers;

use App\Models\ChiTietNgayLam;
use Illuminate\Http\Request;

class ChiTietNgayLamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChiTietNgayLam $chiTietNgayLam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChiTietNgayLam $chiTietNgayLam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChiTietNgayLam $chiTietNgayLam)
    {
        //
    }

    public function layChiTietNgayLamByIdPhieuDichVu($id)
    {
        return ChiTietNgayLam::select('chitietngaylam.*', 'nhanvien.idNhanVien', 'users.name', 'users.Anh')
            ->leftJoin('phieudichvu', 'phieudichvu.idPhieuDichVu', '=', 'chitietngaylam.idPhieuDichVu')
            ->leftJoin('chitietnhanvienlamdichvu', 'chitietngaylam.idChiTietNgayLam', '=', 'chitietnhanvienlamdichvu.idChiTietNgayLam')
            ->leftJoin('nhanvien', 'chitietnhanvienlamdichvu.idNhanVien', '=', 'nhanvien.idNhanVien')
            ->leftJoin('users', 'nhanvien.idNguoiDung', '=', 'users.id')
            ->where('phieudichvu.idPhieuDichVu', $id)
            ->get();
    }
    public function getDataByIdPhieuDichVu($idPhieuDichVu)
    {
        $query = ChiTietNgayLam::leftjoin('PhieuDichVu', 'PhieuDichVu.idPhieuDichVu', '=', 'ChiTietNgayLam.idPhieuDichVu')
            ->leftJoin('ChiTietDichVu', 'ChiTietDichVu.idChiTietDichVu', '=', 'PhieuDichVu.idChiTietDichVu')
            ->where('ChiTietNgayLam.idPhieuDichVu', '=', $idPhieuDichVu);
        $ChiTietNgayLam = $query->select('ChiTietNgayLam.*', 'ChiTietDichVu.*')->get();
        $total = $query->count();
        return response()->json([
            'total' => $total,
            'data' => $ChiTietNgayLam,
        ]);
    }


    public function layChiTietNgayLamCuaTatCaPhieuDichVuCuaKhachHangTheoTuan(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $idKH = $request->query('idKH');
        if (!$startDate || !$endDate || !$idKH) {
            return response()->json(['error' => 'Thời gian bắt đầu, kết thúc, idKh không được trống'], 400);
        }

        $results = ChiTietNgayLam::select('dichvu.tenDichVu', 'phieudichvu.idPhieuDichVu', 'phieudichvu.GioBatDau', 'users.name', 'chitietngaylam.NgayLam', 'nhanvien.idNhanVien', 'chitietngaylam.TinhTrangDichVu')
            ->leftJoin('chitietnhanvienlamdichvu', 'chitietngaylam.idChiTietNgayLam', '=', 'chitietnhanvienlamdichvu.idChiTietNgayLam')
            ->leftJoin('nhanvien', 'nhanvien.idNhanVien', '=', 'chitietnhanvienlamdichvu.idNhanVien')
            ->leftJoin('users', 'users.id', '=', 'nhanvien.idNguoiDung')
            ->leftJoin('phieudichvu', 'chitietngaylam.idPhieuDichVu', '=', 'phieudichvu.idPhieuDichVu')
            ->leftJoin('chitietdichvu', 'phieudichvu.idChiTietDichVu', '=', 'chitietdichvu.idChiTietDichVu')
            ->leftJoin('dichvu', 'dichvu.idDichVu', '=', 'chitietdichvu.idDichVu')
            ->where('phieudichvu.idKhachHang', $idKH)
            ->where('phieudichvu.TinhTrang', 2)
            ->whereBetween('chitietngaylam.NgayLam', [$startDate, $endDate])
            ->orderBy('phieudichvu.GioBatDau', 'asc')
            ->get();

        return response()->json($results);
    }

    public function updateTinhTrangDichVu($idChiTietNgayLam, $TinhTrangDichVu)
    {
        $ChiTietNgayLam = ChiTietNgayLam::findOrFail($idChiTietNgayLam);
        if($ChiTietNgayLam->TinhTrangDichVu === 2 && $ChiTietNgayLam->TinhTrangDichVu == $TinhTrangDichVu){
            return response()->json(['message' => ['Dịch vụ đã được băt đầu.']], 201);
        }
        if($ChiTietNgayLam->TinhTrangDichVu === 3 && $ChiTietNgayLam->TinhTrangDichVu == $TinhTrangDichVu){
            return response()->json(['message' => ['Dịch vụ đã kết thúc.']], 201);
        }
        $ChiTietNgayLam["TinhTrangDichVu"] = $TinhTrangDichVu;
        $ChiTietNgayLam->update();
        if ($TinhTrangDichVu === 2) {
            return response()->json(['message' => ['Xác nhận bắt đầu thực hiện dịch vụ thành công.']], 200);
        } else {
            return response()->json(['message' => ['Xác nhận kết thúc thực hiện dịch vụ thành công.']], 200);
        }
    }
}
