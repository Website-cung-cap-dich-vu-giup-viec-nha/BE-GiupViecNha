<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDichVu;
use Illuminate\Http\Request;

class ChiTietDichVuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function show(ChiTietDichVu $chiTietDichVu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChiTietDichVu $chiTietDichVu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChiTietDichVu $chiTietDichVu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChiTietDichVu $chiTietDichVu)
    {
        //
    }

    public function layChiTietDVTheoIdDV($id){
        return ChiTietDichVu::where("idDichVu",$id)->get();
    }
}
