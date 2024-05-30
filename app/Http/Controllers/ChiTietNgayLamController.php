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
}
