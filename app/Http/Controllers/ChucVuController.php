<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ChucVu::all();
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
    public function show(ChucVu $chucVu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChucVu $chucVu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChucVu $chucVu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChucVu $chucVu)
    {
        //
    }

    public function getPositionByDepartment($idPhongBan)
    {
        return ChucVu::where('idPhongBan', $idPhongBan)->get();
    }
}
