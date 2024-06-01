<?php

namespace App\Http\Controllers;

use App\Models\ward;
use Illuminate\Http\Request;

class WardController extends Controller
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
    public function show(ward $ward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ward $ward)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ward $ward)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ward $ward)
    {
        //
    }

    public function layXaByDistrictId($id)
    {
        return ward::where("district_id", $id)->orderBy('ward_name', 'asc')->get();
    }
}
