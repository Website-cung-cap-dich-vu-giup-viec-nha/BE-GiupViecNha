<?php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use Illuminate\Http\Request;

class DiaChiController extends Controller
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
        DiaChi::create([
            "Duong" => $request->Duong,
            "Phuong" => $request->Phuong,
            "idNguoiDung" => $request->idNguoiDung,
            "MacDinh" => $request->MacDinh
        ]);

        return response()->json([
            "status" => true,
            "message" => "Thêm địa chỉ thành công"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return DiaChi::select('diachi.idDiaChi', 'diachi.Duong', 'ward.ward_name', 'district.district_name', 'province.province_name')
            ->leftJoin('ward', 'diachi.Phuong', '=', 'ward.ward_id')
            ->leftJoin('district', 'ward.district_id', '=', 'district.district_id')
            ->leftJoin('province', 'district.province_id', '=', 'province.province_id')
            ->where('diachi.idDiaChi', $id)
            ->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DiaChi $diaChi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        //
        $diaChi = DiaChi::findOrFail($id);
        $dsDiaChi = DiaChi::where("idNguoiDung", $diaChi->idNguoiDung)->get();
        foreach ($dsDiaChi as $dia) {
            $dia->MacDinh = 0;
            $dia->save();
        }
        $diaChi->MacDinh = 1;
        $diaChi->save();
        return response()->json([
            "status" => true,
            "message" => "Cập nhật thành công"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $diaChi = DiaChi::findOrFail($id);
        $diaChi->delete();

        return response()->json([
            "status" => true,
            "message" => "Xóa địa chỉ thành công"
        ]);
    }

    public function layDiaChiByIdNguoiDung($id)
    {
        return DiaChi::select('diachi.Duong', 'ward.ward_name', 'district.district_name', 'province.province_name', 'diachi.MacDinh', 'diachi.idDiaChi')
            ->join('ward', 'diachi.Phuong', '=', 'ward.ward_id')
            ->join('district', 'ward.district_id', '=', 'district.district_id')
            ->join('province', 'district.province_id', '=', 'province.province_id')
            ->where('diachi.idNguoiDung', $id)
            ->get();
    }
}
