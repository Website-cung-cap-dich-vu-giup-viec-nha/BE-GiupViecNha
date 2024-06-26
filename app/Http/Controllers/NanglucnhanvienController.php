<?php

namespace App\Http\Controllers;

use App\Models\nanglucnhanvien;
use Illuminate\Http\Request;

class NanglucnhanvienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idnhanvien = $request->query('idnhanvien');
        $nanglucnhanvien = nanglucnhanvien::leftjoin('dichvu', 'dichvu.iddichvu', '=',  'nanglucnhanvien.iddichvu')
                            ->where('nanglucnhanvien.idnhanvien', '=', $idnhanvien)
                            ->select('nanglucnhanvien.*', 'dichvu.tenDichVu')
                            ->get();
        return response()->json([
            'data' => $nanglucnhanvien,
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
            'idNhanVien' => 'required',
            'idDichVu' => 'required',
        ], [
            'idNhanVien.required' => 'Vui lòng chọn nhân viên cần thêm năng lực.',
            'idDichVu.required' => 'Vui lòng chọn dịch vụ cần thêm cho nhân viên.',
        ]);
        nanglucnhanvien::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(nanglucnhanvien $nanglucnhanvien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(nanglucnhanvien $nanglucnhanvien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, nanglucnhanvien $nanglucnhanvien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idNangLucNhanVien)
    {
        $nanglucnhanvien = nanglucnhanvien::findOrFail($idNangLucNhanVien);
        $nanglucnhanvien->delete();
        return response()->json([
            'data' => $nanglucnhanvien  ,
        ]);
    }
}
