<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDatDichVu;
use App\Models\ChiTietNgayLam;
use App\Models\DatDichVu;
use App\Models\NhanVien;
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
            return response()->json(['message' => ['Nhân viên này đã đươc thêm vào ngày làm này']], 201);
        }
        $data = $request->only(["idChiTietNgayLam", "idNhanVien"]);
        ChiTietDatDichVu::create($data);

        $userData = request()->user();
        $staffData = NhanVien::where('idNguoiDung', $userData->id)->first();
        $ChiTietNgayLam = ChiTietNgayLam::findOrFail($request["idChiTietNgayLam"]);
        $DatDichVu = DatDichVu::findOrFail($ChiTietNgayLam->idPhieuDichVu);
        $DatDichVu->idNhanVienQuanLyDichVu = $staffData->idNhanVien;
        $DatDichVu->save();

        return response()->json(['message' => ['Thêm nhân viên thực hiện dịch vụ thành công']], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $results = ChiTietDatDichVu::leftJoin('nhanvien', 'chitietnhanvienlamdichvu.idNhanVien', '=', 'nhanvien.idNhanVien')
            ->leftJoin('users', 'users.id', '=', 'nhanvien.idNguoiDung')
            ->leftJoin('chitietngaylam', 'chitietnhanvienlamdichvu.idChiTietNgayLam', '=', 'chitietngaylam.idChiTietNgayLam')
            ->leftJoin('phieudichvu', 'phieudichvu.idPhieuDichVu', '=', 'chitietngaylam.idPhieuDichVu')
            ->leftJoin('chitietdichvu', 'phieudichvu.idChiTietDichVu', '=', 'chitietdichvu.idChiTietDichVu')
            ->leftJoin('dichvu', 'dichvu.idDichVu', '=', 'chitietdichvu.idDichVu')
            ->select('users.name', 'chitietngaylam.NgayLam', 'phieudichvu.GioBatDau', 'dichvu.tenDichVu', 'phieudichvu.idPhieuDichVu')
            ->where('chitietnhanvienlamdichvu.idChiTietNhanVienLamDichVu', $id)
            ->get();

        return response()->json($results);
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
    public function destroy($idChiTietNhanVienLamDichVu)
    {
        $ChiTietNhanVienLamDichVu = ChiTietDatDichVu::findOrFail($idChiTietNhanVienLamDichVu);

        $userData = request()->user();
        $staffData = NhanVien::where('idNguoiDung', $userData->id)->first();
        $ChiTietNgayLam = ChiTietNgayLam::findOrFail($ChiTietNhanVienLamDichVu->idChiTietNgayLam);
        $DatDichVu = DatDichVu::findOrFail($ChiTietNgayLam->idPhieuDichVu);
        $DatDichVu->idNhanVienQuanLyDichVu = $staffData->idNhanVien;
        $DatDichVu->save();

        $ChiTietNhanVienLamDichVu->delete();

        return response()->json(['message' => 'Xoá nhân viên thực hiện dịch vụ thành công'], 200);
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
