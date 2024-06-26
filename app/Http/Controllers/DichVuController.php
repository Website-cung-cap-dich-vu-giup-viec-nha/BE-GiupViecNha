<?php

namespace App\Http\Controllers;

use App\Models\DichVu;
use Hamcrest\Text\IsEmptyString;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\IsEmpty;

class DichVuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DichVu::all();
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
    public function show(DichVu $dichVu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DichVu $dichVu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DichVu $dichVu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DichVu $dichVu)
    {
        //
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $query = DichVu::query();
        if ($keyword) {
            $query
                ->where('tenDichVu', 'like', "%$keyword%")
                ->orWhere('MoTa', 'like', "%$keyword%");
        }
        return $query->get();
    }
    public function getProductIsNotAddStaffCapacityByStaffId(Request $request)
    {
        $idnhanvien = $request->query('idNhanVien');

        $dichvu = DichVu::leftJoin('nanglucnhanvien', 'nanglucnhanvien.idnhanvien', '=', 'dichvu.iddichvu')
            ->select('dichvu.idDichVu', 'dichvu.tenDichVu');

        if ($idnhanvien !== null && $idnhanvien !== '') {
            $dichvu->whereNotIn('dichvu.iddichvu', function ($query) use ($idnhanvien) {
                $query->select('iddichvu')
                    ->from('nanglucnhanvien')
                    ->where('idnhanvien', $idnhanvien);
            });
        }

        $dichvu = $dichvu->groupBy('dichvu.idDichVu', 'dichvu.tenDichVu')->get();
        return response()->json([
            'data' => $dichvu,
        ]);
    }
}
