<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use Illuminate\Http\Request;

class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchData = $request->query('searchData');
        $start = $request->query('start', null);
        $take = $request->query('take', null);

        $query = NhanVien::leftJoin('users', 'users.id', '=', 'NhanVien.idNguoiDung')
                        ->leftJoin('ChucVu', 'ChucVu.idChucVu', '=', 'NhanVien.idChucVu');

        $query->where('name', 'like', '%' . $searchData . '%')
            ->orWhere('SDT', 'like', '%' . $searchData . '%')
            ->orWhere('email', 'like', '%' . $searchData . '%');

        $nhanVien = null;

        if ($start == null || $take == null) {
            $nhanVien = $query->select(
                'NhanVien.idNhanVien',
                'users.name',
                'users.email',
                'users.SDT',
                'users.GioiTinh',
                'users.NgaySinh',
                'NhanVien.SoSao',
                'ChucVu.tenChucVu'
            )->get();

            $newRow = [
                'idNhanVien' => "Mã nhân viên",
                'name' => 'Họ và tên nhân viên',
                'email' => 'Email',
                'SDT' => 'Số điện thoại',
                'GioiTinh' => 'Giới tính',
                'NgaySinh' => 'Ngày sinh',
                'SoSao' => "Số sao",
                'tenChucVu' => 'Chức vụ'
            ];

            $nhanVien->prepend($newRow);
        } else {
            $nhanVien = $query->select('NhanVien.*', 'users.*')
                ->skip($start)
                ->take($take)
                ->get();
        }

        $total = $query->count();

        return response()->json([
            'total' => $total,
            'data' => $nhanVien,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NhanVien $nhanVien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NhanVien $nhanVien)
    {
        //
    }

    public function exportImportHeaderData()
    {

        $nhanVien = [];

        $newRow = [
            'idNhanVien' => "Mã nhân viên",
            'name' => 'Họ và tên nhân viên',
            'email' => 'Email',
            'SDT' => 'Số điện thoại',
            'GioiTinh' => 'Giới tính',
            'NgaySinh' => 'Ngày sinh',
            'SoSao' => "Số sao",
            'tenChucVu' => 'Chức vụ'
        ];

        array_unshift($nhanVien, $newRow);

        return response()->json([
            'data' => $nhanVien,
        ]);
    }
}
