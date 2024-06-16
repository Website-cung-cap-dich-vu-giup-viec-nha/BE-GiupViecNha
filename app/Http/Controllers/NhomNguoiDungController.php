<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\NhomNguoiDung;
use Illuminate\Http\Request;

class NhomNguoiDungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idNhom = $request->query('idNhom');

        $NhanVien = NhanVien::leftJoin('users', 'users.id', '=', 'NhanVien.idNguoiDung')
            ->leftJoin('NhomNguoiDung', 'NhomNguoiDung.idNhanVien', '=', 'NhanVien.idNhanVien')
            ->where('NhomNguoiDung.idNhom', '=', $idNhom)
            ->select('NhanVien.*', 'users.*', 'NhomNguoiDung.idNhomNguoiDung', 'NhomNguoiDung.idNhom')
            ->get();

        return response()->json([
            'data' => $NhanVien,
        ]);
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
        $request->validate([
            'idNhom' => 'required',
            'idNhanVien' => 'required',
        ], [
            'idNhom.required' => 'Vui lòng chọn nhóm cần thêm nhân viên.',
            'idNhanVien.required' => 'Vui lòng chọn nhân viên cần thêm vào nhóm.',
        ]);
        NhomNguoiDung::create($request->all());
        // return response()->json(['message' => ['Thêm nhân viên vào nhóm thành công']], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(NhomNguoiDung $nhomNguoiDung)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NhomNguoiDung $nhomNguoiDung)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NhomNguoiDung $nhomNguoiDung)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idNhomNguoiDung)
    {
        $NhomNguoiDung = NhomNguoiDung::findOrFail($idNhomNguoiDung);
        $NhomNguoiDung->delete();
    }
}
