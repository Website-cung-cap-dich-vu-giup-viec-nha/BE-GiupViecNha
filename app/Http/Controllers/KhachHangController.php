<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $KhachHang = KhachHang::leftJoin('users', 'users.id', '=', 'KhachHang.idNguoiDung')->select('KhachHang.*', 'users.*')->get();
        return response()->json([
            'data' => $KhachHang,
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
    public function show(KhachHang $khachHang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KhachHang $khachHang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KhachHang $khachHang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KhachHang $khachHang)
    {
        //
    }

    public function layIdKhachHang($id)
    {
        return KhachHang::where("idNguoiDung", $id)->pluck("idKhachHang");
    }
}
