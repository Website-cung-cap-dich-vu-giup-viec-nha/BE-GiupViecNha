<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDatDichVu;
use Illuminate\Http\Request;

class ChiTietDatDichVuController extends Controller
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
        // return response()->json(['message' => $request], 422);
        $request->validate([
            'idChiTietNgayLam' => 'required|exists:ChiTietNgayLam,idChiTietNgayLam',
            'idNhanVien' => 'required|exists:NhanVien,idNhanVien',
        ], [
            'idChiTietNgayLam.required' => 'Ngày làm bắt buộc',
            'idChiTietNgayLam.exists' => 'Ngày làm không tồn tại',
            'idNhanVien.required' => 'Nhân viên bắt buộc',
            'idNhanVien.exists' => 'Nhân viên không tồn tại',
        ]);
        $checking = ChiTietDatDichVu::where('idChiTietNgayLam', '=', $request["idChiTietNgayLam"])
            ->where('idNhanVien', '=', $request["idNhanVien"])
            ->get();
        if (sizeof($checking) > 0) {
            return response()->json(['message' => ['Nhân viên này đã đươc thêm vào ngày làm này']], 422);
        }
        $data = $request->only(["idChiTietNgayLam", "idNhanVien"]);
        ChiTietDatDichVu::create($data);
        return response()->json(['message' => ['Thêm nhân viên thực hiện dịch vụ thành công']], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChiTietDatDichVu $chiTietDatDichVu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChiTietDatDichVu $chiTietDatDichVu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChiTietDatDichVu $chiTietDatDichVu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChiTietDatDichVu $chiTietDatDichVu)
    {
        //
    }
    public function getDataByIdChiTietNgayLam($idChiTietNgayLam)
    {
        $ChiTietNhanVienLamDichVu = ChiTietDatDichVu::leftjoin('NhanVien', 'NhanVien.idNhanVien', '=', 'ChiTietNhanVienLamDichVu.idNhanVien')
                                                    ->leftJoin('users', 'users.id', '=', 'NhanVien.idNguoiDung')
                                                    ->where('idChiTietNgayLam', '=', $idChiTietNgayLam)
                                                    ->select('ChiTietNhanVienLamDichVu.*', 'NhanVien.*', 'users.*')->get();
        return response()->json(['data' => $ChiTietNhanVienLamDichVu], 200);
    }
}
