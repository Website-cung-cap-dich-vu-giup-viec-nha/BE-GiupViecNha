<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    //
    public function index(Request $request)
    {
        return DB::table('dichvu as dv')
            ->leftJoin('chitietdichvu as ct', 'dv.idDichVu', '=', 'ct.idDichVu')
            ->leftJoin('phieudichvu as pd', function ($join) use ($request) {
                $join->on('ct.idChiTietDichVu', '=', 'pd.idChiTietDichVu')
                    ->whereBetween(DB::raw("DATE_FORMAT(pd.NgayDat, '%Y-%m-%d')"), [$request->NgayBD, $request->NgayKT])
                    ->where('pd.TinhTrangThanhToan', 2);
            })
            ->select('dv.tenDichVu as TenDichVu', DB::raw('COALESCE(SUM(pd.Tongtien), 0) as DoanhThu'))
            ->groupBy('dv.tenDichVu')
            ->get();
    }

    public function thongKeSoGioLam(Request $request)
    {
        $query = DB::table('nhanvien')
            ->leftJoin('users', 'nhanvien.idNguoiDung', '=', 'users.id')
            ->leftJoin('chitietnhanvienlamdichvu', 'chitietnhanvienlamdichvu.idNhanVien', '=', 'nhanvien.idNhanVien')
            ->leftJoin('chitietngaylam', 'chitietngaylam.idChiTietNgayLam', '=', 'chitietnhanvienlamdichvu.idChiTietNgayLam')
            ->leftJoin('phieudichvu', 'phieudichvu.idPhieuDichVu', '=', 'chitietngaylam.idPhieuDichVu')
            ->select('nhanvien.idNhanVien', 'users.name', DB::raw('SUM(phieudichvu.SoGio) as SoGio'))
            ->whereBetween('chitietngaylam.NgayLam', [$request->NgayBD, $request->NgayKT])
            ->groupBy('nhanvien.idNhanVien', 'users.name')
            ->havingRaw('SUM(phieudichvu.SoGio) IS NOT NULL');

        if ($request->has('idNhanVien')) {
            $query->where('nhanvien.idNhanVien', $request->idNhanVien);
        }

        $result = $query->get();

        return $result;
    }
}
