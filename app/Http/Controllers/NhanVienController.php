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

        $query = NhanVien::join('users', 'users.id', '=', 'NhanVien.idNguoiDung');

        $query->where('name', 'like', '%' . $searchData . '%')
            ->orWhere('SDT', 'like', '%' . $searchData . '%')
            ->orWhere('email', 'like', '%' . $searchData . '%');

        $nhanVien = $query->select('NhanVien.*', 'users.*')->get();

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
}
