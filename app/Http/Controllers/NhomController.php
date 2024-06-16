<?php

namespace App\Http\Controllers;

use App\Models\Nhom;
use App\Models\NhomNguoiDung;
use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class NhomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchData = $request->query('searchData');
        $start = $request->query('start', null);
        $take = $request->query('take', null);

        $query = Nhom::where('tenNhom', 'like', '%' . $searchData . '%');

        $total = $query->count();

        $Nhom = $query->select('Nhom.*')
                ->skip($start)
                ->take($take)
                ->get();
        return response()->json([
            'total' => $total,
            'data' => $Nhom,
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
            'tenNhom' => 'required|unique:Nhom,tenNhom',
        ], [
            'tenNhom.required' => 'Tên nhóm bắt buộc.',
            'tenNhom.unique' => 'Tên nhóm đã tồn tại, vui lòng nhập tên khác.',
        ]);
        Nhom::create($request->all());
        return response()->json(['message' => ['Thêm nhóm thành công']], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nhom $nhom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nhom $nhom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idNhom)
    {
        $request->validate([
            'tenNhom' => [
                'required',
                Rule::unique('Nhom', 'tenNhom')->ignore($request->idNhom, 'idNhom')
            ],
        ], [
            'tenNhom.required' => 'Tên nhóm bắt buộc.',
            'tenNhom.unique' => 'Tên nhóm đã tồn tại, vui lòng nhập tên khác.',
        ]);
        $Nhom = Nhom::findOrFail($idNhom);
        $Nhom->update($request->all());
        return response()->json(['message' => ['Sửa nhóm thành công']], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idNhom)
    {
        $Nhom = Nhom::findOrFail($idNhom);

        NhomNguoiDung::where('idNhom', '=', $Nhom->idNhom)->delete();

        PhanQuyen::where('idNhom', '=', $Nhom->idNhom)->delete();

        $Nhom->delete();
        return response()->json(['message' => ['Xoá nhóm thành công']], 200);
    }
}
