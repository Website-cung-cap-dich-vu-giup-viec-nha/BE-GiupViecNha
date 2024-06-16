<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\Quyen;
use Illuminate\Http\Request;

class QuyenController extends Controller
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
    public function show(Quyen $quyen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quyen $quyen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quyen $quyen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quyen $quyen)
    {
        //
    }
    public function getQuyenByIdNhanVien()
    {
        $userData = request()->user();
        $staffData = NhanVien::where('idNguoiDung', $userData->id)->first();
        $Quyen = Quyen::join('PhanQuyen', 'PhanQuyen.idQuyen', '=', 'Quyen.idQuyen')
                        ->join('Nhom', 'Nhom.idNhom', '=', 'PhanQuyen.idNhom')
                        ->join('NhomNguoiDung', 'NhomNguoiDung.idNhom', '=', 'Nhom.idNhom')
                        ->where('NhomNguoiDung.idNhanVien', '=', $staffData->idNhanVien)
                        ->select('Quyen.*')
                        ->get();

        return response()->json([
            'data' => $Quyen,
        ]);
    }
    public function getPermissionIsNotAddNhom(Request $request)
    {
        $idNhom = $request->query('idNhom');

        $Quyen = Quyen::leftJoin('PhanQuyen', 'PhanQuyen.idQuyen', '=', 'Quyen.idQuyen')
            ->select('Quyen.*');

        if ($idNhom !== null && $idNhom !== '') {
            $Quyen->whereNotIn('Quyen.idQuyen', function ($query) use ($idNhom) {
                $query->select('idQuyen')
                    ->from('PhanQuyen')
                    ->where('idNhom', $idNhom);
            });
        }

        $Quyen = $Quyen->groupBy('Quyen.idQuyen', 'Quyen.tenQuyen')->get();
        return response()->json([
            'data' => $Quyen,
        ]);
    }
}
