<?php

namespace App\Http\Controllers;

use App\Models\PhongBan;
use Illuminate\Http\Request;

class PhongBanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PhongBan::all();
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
    public function show(PhongBan $phongBan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhongBan $phongBan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhongBan $phongBan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhongBan $phongBan)
    {
        //
    }
}
