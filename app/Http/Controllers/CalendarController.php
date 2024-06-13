<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDatDichVu;
use App\Models\ChiTietNgayLam;
use App\Models\DatDichVu;
use App\Models\NhanVien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function getCalendar($startDate, $endDate)
    {
        $userData = request()->user();
        $staffData = NhanVien::where('idNguoiDung', $userData->id)->first();
        $idChiTietNgayLam = ChiTietDatDichVu::where('idNhanVien', '=', $staffData->idNhanVien)->pluck('idChiTietNgayLam');
        $idPhieuDichVu = ChiTietNgayLam::whereIn('idChiTietNgayLam', $idChiTietNgayLam);
        if (!empty($startDate)) {
            // Chuyển đổi định dạng ngày nếu cần thiết
            $startDate = date('Y-m-d', strtotime($startDate));
            $idPhieuDichVu->where('NgayLam', '>=', $startDate);
        }
        if (!empty($endDate)) {
            // Chuyển đổi định dạng ngày nếu cần thiết
            $endDate = date('Y-m-d', strtotime($endDate));
            $idPhieuDichVu->where('NgayLam', '<=', $endDate);
        }
        $idPhieuDichVu = $idPhieuDichVu->pluck('idPhieuDichVu');
        // $PhieuDichVu = DatDichVu::whereIn('idPhieuDichVu', $idPhieuDichVu)->get();
        $ChiTietNgayLam = ChiTietNgayLam::leftjoin('PhieuDichVu', 'PhieuDichVu.idPhieuDichVu', '=', 'ChiTietNgayLam.idPhieuDichVu')
                                        ->leftjoin('KhachHang', 'KhachHang.idKhachHang', '=', 'PhieuDichVu.idKhachHang')
                                        ->leftjoin('users', 'users.id', '=', 'KhachHang.idNguoiDung')
                                        ->leftjoin('DiaChi', 'DiaChi.idDiaChi', '=', 'PhieuDichVu.idDiaChi')
                                        ->leftjoin('ward', 'ward.ward_id', '=', 'DiaChi.Phuong')
                                        ->leftjoin('district', 'district.district_id', '=', 'ward.district_id')
                                        ->leftjoin('province', 'province.province_id', '=', 'district.province_id')
                                        ->leftjoin('ChiTietDichVu', 'ChiTietDichVu.idChiTietDichVu', '=', 'PhieuDichVu.idChiTietDichVu')
                                        ->leftjoin('DichVu', 'DichVu.idDichVu', '=', 'ChiTietDichVu.idDichVu')
                                        ->whereIn('idChiTietNgayLam', $idChiTietNgayLam)
                                        ->whereIn('PhieuDichVu.idPhieuDichVu', $idPhieuDichVu)
                                        ->select('PhieuDichVu.idPhieuDichVu', 'PhieuDichVu.SoGio', 'PhieuDichVu.GioBatDau'
                                                , 'PhieuDichVu.GhiChu', 'ChiTietNgayLam.TinhTrangDichVu'
                                                , 'ChiTietNgayLam.NgayLam', 'users.name', 'users.SDT'
                                                , 'DiaChi.Duong', 'ward.ward_name', 'district.district_name', 'province.province_name'
                                                , 'DichVu.tenDichVu')
                                        ->orderby('PhieuDichVu.GioBatDau')
                                        ->get();

        $transactionsByDayOfWeek = [];

        // Lặp qua từng mục trong mảng $ChiTietNgayLam
        foreach ($ChiTietNgayLam as $item) {
            // Lấy ngày làm từ mục hiện tại
            $ngayLam = Carbon::parse($item['NgayLam']);

            // Lấy ngày trong tuần (từ 0 - 6, 0 là Chủ Nhật)
            $dayOfWeek = $ngayLam->dayOfWeek;

            // Thêm mục vào mảng tương ứng với ngày trong tuần
            if (!isset($transactionsByDayOfWeek[$dayOfWeek])) {
                $transactionsByDayOfWeek[$dayOfWeek] = [];
            }
            $transactionsByDayOfWeek[$dayOfWeek][] = $item;
        }
        return response()->json([
            'data' => $transactionsByDayOfWeek
        ]);
    }
}
