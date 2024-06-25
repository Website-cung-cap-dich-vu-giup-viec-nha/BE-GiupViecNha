<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use Illuminate\Http\Request;

class DanhGiaController extends Controller
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
        DanhGia::create([
            "SoSao" => $request->SoSao,
            "YKien" => $request->YKien,
            "idChiTietNhanVienLamDichVu" => $request->idChiTietNhanVienLamDichVu
        ]);

        return response()->json([
            "status" => true,
            "message" => "Thêm đánh giá thành công"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DanhGia $danhGia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DanhGia $danhGia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $danhGia = DanhGia::findOrFail($id);
        $danhGia->SoSao = $request->SoSao;
        $danhGia->YKien = $request->YKien;
        $danhGia->save();

        return response()->json([
            "status" => true,
            "message" => "Cập nhật thành công"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanhGia $danhGia)
    {
        //
    }

    public function layDanhGiaByIdChiTietNhanVienLamDichVu($id)
    {
        return DanhGia::where("idChiTietNhanVienLamDichVu", $id)->get();
    }
}
