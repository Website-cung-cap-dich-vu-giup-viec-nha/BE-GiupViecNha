<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\PhanQuyen;
use App\Models\Quyen;
use Illuminate\Http\Request;

class PhanQuyenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idNhom = $request->query('idNhom');

        $Quyen = Quyen::leftJoin('PhanQuyen', 'PhanQuyen.idQuyen', '=', 'Quyen.idQuyen')
            ->where('PhanQuyen.idNhom', '=', $idNhom)
            ->select('Quyen.*', 'PhanQuyen.idPhanQuyen', 'PhanQuyen.idNhom')
            ->get();

        return response()->json([
            'data' => $Quyen,
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
            'idQuyen' => 'required',
        ], [
            'idNhom.required' => 'Vui lòng chọn nhóm cần thêm nhân viên.',
            'idQuyen.required' => 'Vui lòng chọn quyền cần thêm vào nhóm.',
        ]);
        PhanQuyen::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(PhanQuyen $phanQuyen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhanQuyen $phanQuyen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhanQuyen $phanQuyen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idPhanQuyen)
    {
        $PhanQuyen = PhanQuyen::findOrFail($idPhanQuyen);
        $PhanQuyen->delete();
    }
    public function checkQuyen($idQuyen)
    {
        // Kiểm tra xem người dùng có idQuyen tương ứng trong bảng PhanQuyen hay không
        // $result = PhanQuyen::where('idNhom', function ($query) use ($idNguoiDung) {
        //         $query->select('idNhom')
        //             ->from('tbl_NhomNguoiDung')
        //             ->where('idNguoiDung', $idNguoiDung);
        //     })
        //     ->where('idQuyen', $idQuyen)
        //     ->exists();

        $userData = request()->user();
        $staffData = NhanVien::where('idNguoiDung', $userData->id)->first();

        $result = PhanQuyen::whereIn('idNhom', function ($query) use ($staffData) {
            $query->select('idNhom')
                ->from('NhomNguoiDung')
                ->where('idNhanVien', $staffData->idNhanVien);
        })
        ->where('idQuyen', $idQuyen)
        ->exists();


        // Trả về kết quả true hoặc false
        return response()->json(['message' => $result], 200);
    }
}
