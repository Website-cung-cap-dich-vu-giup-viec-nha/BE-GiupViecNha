<?php

namespace App\Http\Controllers;

use App\Models\ChiTietNgayLam;
use App\Models\DatDichVu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DatDichVuController extends Controller
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
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // User model to save user in database
        $datDV = DatDichVu::create([
            "Tongtien" => $request->Tongtien,
            "NgayBatDau" => $request->NgayBatDau,
            "SoBuoi" => $request->SoBuoi,
            "SoGio"  => $request->SoGio,
            "SoNguoiDuocChamSoc" => $request->SoNguoiDuocChamSoc,
            "GioBatDau" => $request->GioBatDau,
            "GhiChu" => $request->GhiChu,
            "TinhTrang" => 1,
            "TinhTrangThanhToan" => 1,
            "idDiaChi" => $request->idDiaChi,
            "idKhachHang" => $request->idKhachHang,
            "idChiTietDichVu" => $request->idChiTietDichVu
        ]);

        $thu = explode(' - ', $request->Thu); // giả sử Thu có các giá trị như "Thứ 2 - Thứ 4 - Thứ 6"
        $thuMap = [
            'Chủ Nhật' => 0,
            'Thứ 2' => 1,
            'Thứ 3' => 2,
            'Thứ 4' => 3,
            'Thứ 5' => 4,
            'Thứ 6' => 5,
            'Thứ 7' => 6,
        ];

        $thuSo = array_map(function ($day) use ($thuMap) {
            return $thuMap[$day];
        }, $thu);

        $ngayHienTai = Carbon::createFromFormat('Y-m-d', $request->NgayBatDau);
        $soBuoiDaTao = 0;

        while ($soBuoiDaTao < $request->SoBuoi) {
            if (in_array($ngayHienTai->dayOfWeek, $thuSo)) {
                ChiTietNgayLam::create([
                    "idPhieuDichVu" => $datDV->id,
                    "TinhTrangDichVu" => 1,
                    "NgayLam" => $ngayHienTai->format('Y-m-d')
                ]);
                $soBuoiDaTao++;
            }
            $ngayHienTai->addDay();
        }

        return response()->json([
            "status" => true,
            "message" => "Tao thanh cong"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DatDichVu $datDichVu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DatDichVu $datDichVu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DatDichVu $datDichVu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DatDichVu $datDichVu)
    {
        //
    }
}
