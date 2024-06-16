<?php

namespace App\Http\Controllers;

use App\Models\ThongBao;
use Illuminate\Http\Request;

class ThongBaoController extends Controller
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
    public function show(ThongBao $thongBao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThongBao $thongBao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThongBao $thongBao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThongBao $thongBao)
    {
        //
    }

    public function layThongBaoByIdND($id)
    {
        return ThongBao::select('thongbao.*')
            ->join('phieudichvu', 'thongbao.idPhieuDichVu', '=', 'phieudichvu.idPhieuDichVu')
            ->join('khachhang', 'phieudichvu.idKhachHang', '=', 'khachhang.idKhachHang')
            ->join('users', 'khachhang.idNguoiDung', '=', 'users.id')
            ->where('users.id', $id)
            ->orderByDesc('thongbao.NgayTao')
            ->get();
    }
}
