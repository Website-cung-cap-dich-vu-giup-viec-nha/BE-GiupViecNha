<?php

namespace App\Http\Controllers;

use App\Models\ChiTietNgayLam;
use App\Models\DatDichVu;
use App\Models\DichVu;
use App\Models\NhanVien;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DatDichVuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $idPhieuDichVu = $request->query('idPhieuDichVu');
        $TinhTrang = $request->query('TinhTrang');
        $TinhTrangThanhToan = $request->query('TinhTrangThanhToan');
        $idDichVu = $request->query('idDichVu');
        $start = $request->query('start', null);
        $take = $request->query('take', null);

        $query = DatDichVu::leftJoin('KhachHang', 'KhachHang.idKhachHang', '=', 'PhieuDichVu.idKhachHang')
            ->leftJoin('users', 'users.id', '=', 'KhachHang.idNguoiDung')
            ->leftJoin('DiaChi', 'DiaChi.idDiaChi', '=', 'PhieuDichVu.idDiaChi')
            ->leftJoin('ChiTietDichVu', 'ChiTietDichVu.idChiTietDichVu', '=', 'PhieuDichVu.idChiTietDichVu')
            ->leftJoin('DichVu', 'DichVu.idDichVu', '=', 'ChiTietDichVu.idDichVu')
            ->leftJoin('Ward', 'Ward.ward_id', '=', 'DiaChi.Phuong')
            ->leftJoin('District', 'District.district_id', '=', 'Ward.district_id')
            ->leftJoin('Province', 'Province.province_id', '=', 'District.province_id');

        if (!empty($startDate)) {
            // Chuyển đổi định dạng ngày nếu cần thiết
            $startDate = date('Y-m-d', strtotime($startDate));
            $query->where('NgayBatDau', '>=', $startDate);
        }

        if (!empty($endDate)) {
            // Chuyển đổi định dạng ngày nếu cần thiết
            $endDate = date('Y-m-d', strtotime($endDate));
            $query->where('NgayBatDau', '<=', $endDate);
        }

        if (!empty($idPhieuDichVu)) {
            $query->where('idPhieuDichVu', '=', $idPhieuDichVu);
        }

        if (!empty($TinhTrang) && $TinhTrang != "-1") {
            $query->where('TinhTrang', '=', $TinhTrang);
        }

        if (!empty($TinhTrangThanhToan) && $TinhTrangThanhToan != "-1") {
            $query->where('TinhTrangThanhToan', '=', $TinhTrangThanhToan);
        }

        if (!empty($idDichVu) && $idDichVu != "-1") {
            $query->where('DichVu.idDichVu', '=', $idDichVu);
        }

        $total = $query->count();

        $PhieuDichVu = null;
        if ($start == null || $take == null) {
            $PhieuDichVu = $query->orderBy('NgayBatDau', 'asc')->select('PhieuDichVu.*', 'KhachHang.*', 'DiaChi.*', 'DichVu.*')->get();
        } else {
            $PhieuDichVu = $query->skip($start)
                ->select('PhieuDichVu.*', 'ChiTietDichVu.*', 'users.*', 'KhachHang.*', 'DiaChi.*', 'DichVu.*', 'Province.province_name', 'District.district_name', 'Ward.ward_name')
                ->take($take)
                ->orderBy('NgayBatDau', 'asc')
                ->get();
        }

        return response()->json([
            'total' => $total,
            'data' => $PhieuDichVu,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datDV = DatDichVu::create([
            "Tongtien" => $request->Tongtien,
            "NgayBatDau" => $request->NgayBatDau,
            "SoBuoi" => $request->SoBuoi,
            "SoGio"  => $request->SoGio,
            "SoNguoiDuocChamSoc" => $request->SoNguoiDuocChamSoc,
            "GioBatDau" => $request->GioBatDau,
            "GhiChu" => $request->GhiChu,
            "TinhTrang" => 1,
            "TinhTrangThanhToan" => 1,
            "idDiaChi" => $request->idDiaChi,
            "idKhachHang" => $request->idKhachHang,
            "idChiTietDichVu" => $request->idChiTietDichVu,
            "idNhanVienQuanLyDichVu" => $request->idNhanVienQuanLyDichVu,
        ]);

        $ngayHienTai = Carbon::createFromFormat('Y-m-d', $request->NgayBatDau);

        if ($request->Thu != null) {
            $thu = explode(' - ', $request->Thu); // giả sử Thu có các giá trị như "Thứ 2 - Thứ 4 - Thứ 6"
            $thuMap = [
                'Chủ Nhật' => 0,
                'Thứ 2' => 1,
                'Thứ 3' => 2,
                'Thứ 4' => 3,
                'Thứ 5' => 4,
                'Thứ 6' => 5,
                'Thứ 7' => 6,
            ];

            $thuSo = array_map(function ($day) use ($thuMap) {
                return $thuMap[$day];
            }, $thu);

            $soBuoiDaTao = 0;

            while ($soBuoiDaTao < $request->SoBuoi) {
                if (in_array($ngayHienTai->dayOfWeek, $thuSo)) {
                    ChiTietNgayLam::create([
                        "idPhieuDichVu" => $datDV->idPhieuDichVu,
                        "TinhTrangDichVu" => 1,
                        "NgayLam" => $ngayHienTai->format('Y-m-d')
                    ]);
                    $soBuoiDaTao++;
                }
                $ngayHienTai->addDay();
            }
        } else {
            ChiTietNgayLam::create([
                "idPhieuDichVu" => $datDV->idPhieuDichVu,
                "TinhTrangDichVu" => 1,
                "NgayLam" => $ngayHienTai->format('Y-m-d')
            ]);
        }

        $dichVus = DichVu::distinct()
            ->select('dichvu.*')
            ->join('chitietdichvu', 'chitietdichvu.idDichVu', '=', 'dichvu.idDichVu')
            ->join('phieudichvu', 'phieudichvu.idChiTietDichVu', '=', 'chitietdichvu.idChiTietDichVu')
            ->where('phieudichvu.idPhieuDichVu', $datDV->idPhieuDichVu)
            ->get();
        $ngayBD = Carbon::createFromFormat('Y-m-d', $datDV->NgayBatDau)->format('d/m/Y');

        ThongBao::create([
            "TieuDe" => "Đặt dịch vụ thành công",
            "NoiDung" => "Phiếu dịch vụ " . strtolower($dichVus[0]->tenDichVu) . " bắt đầu vào " . $ngayBD . " lúc " . substr($datDV->GioBatDau, 0, 5) . " của bạn đang được xử lý. Vui lòng kiểm tra lại sau là 30 phút.",
            "idPhieuDichVu" => $datDV->idPhieuDichVu
        ]);

        return response()->json([
            "status" => true,
            "message" => "Tạo phiếu dịch vụ thành công"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return DatDichVu::select('phieudichvu.*', 'dichvu.tenDichVu', 'chitietdichvu.BuoiDangKyDichVu', 'kieudichvu.tenKieuDichVu', 'chitietdichvu.tenChiTietDichVu')
            ->leftJoin('chitietdichvu', 'phieudichvu.idChiTietDichVu', '=', 'chitietdichvu.idChiTietDichVu')
            ->leftJoin('dichvu', 'chitietdichvu.idDichVu', '=', 'dichvu.idDichVu')
            ->leftJoin('kieudichvu', 'chitietdichvu.idKieuDichVu', '=', 'kieudichvu.idKieuDichVu')
            ->where('phieudichvu.idPhieuDichVu', $id)
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DatDichVu $datDichVu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $PhieuDichVu = DatDichVu::findOrFail($id);
        $PhieuDichVu->TinhTrang = 3;
        $PhieuDichVu->save();

        $userData = request()->user();
        $staffData = NhanVien::where('idNguoiDung', $userData->id)->first();
        $DatDichVu = DatDichVu::findOrFail($PhieuDichVu->idPhieuDichVu);
        $DatDichVu->idNhanVienQuanLyDichVu = $staffData->idNhanVien;
        $DatDichVu->save();

        $dichVus = DichVu::distinct()
            ->select('dichvu.*')
            ->join('chitietdichvu', 'chitietdichvu.idDichVu', '=', 'dichvu.idDichVu')
            ->join('phieudichvu', 'phieudichvu.idChiTietDichVu', '=', 'chitietdichvu.idChiTietDichVu')
            ->where('phieudichvu.idPhieuDichVu', $DatDichVu->idPhieuDichVu)
            ->get();
        $ngayBD = Carbon::createFromFormat('Y-m-d', $DatDichVu->NgayBatDau)->format('d/m/Y');

        ThongBao::create([
            "TieuDe" => "Phiếu dịch vụ của bạn đã bị hủy",
            "NoiDung" => "Phiếu dịch vụ " . strtolower($dichVus[0]->tenDichVu) . " bắt đầu vào " . $ngayBD . " lúc " . substr($DatDichVu->GioBatDau, 0, 5) . " của bạn đã bị hủy vì không có nhân viên phù hợp. Rất xin lỗi vì sự bất tiện này nếu bạn vẫn có nhu cầu bạn có thể đặt lại.",
            "idPhieuDichVu" => $DatDichVu->idPhieuDichVu
        ]);

        return response()->json(['message' => ['Hủy phiếu dịch vụ thành công']], 200);
    }

    public function layPhieuDichVuTheoIdKhachHang($id)
    {
        return DatDichVu::select('phieudichvu.*', 'dichvu.tenDichVu')
            ->leftJoin('chitietdichvu', 'phieudichvu.idChiTietDichVu', '=', 'chitietdichvu.idChiTietDichVu')
            ->leftJoin('dichvu', 'chitietdichvu.idDichVu', '=', 'dichvu.idDichVu')
            ->where('phieudichvu.idKhachHang', $id)
            ->orderBy('phieudichvu.idPhieuDichVu', 'desc')
            ->get();
    }
    public function updateTinhTrang($idPhieuDichVu, $TinhTrang)
    {
        $userData = request()->user();
        $staffData = NhanVien::where('idNguoiDung', $userData->id)->first();
        $DatDichVu = DatDichVu::findOrFail($idPhieuDichVu);
        $DatDichVu->TinhTrang = $TinhTrang;
        $DatDichVu->idNhanVienQuanLyDichVu = $staffData->idNhanVien;
        $DatDichVu->save();

        $dichVus = DichVu::distinct()
            ->select('dichvu.*')
            ->join('chitietdichvu', 'chitietdichvu.idDichVu', '=', 'dichvu.idDichVu')
            ->join('phieudichvu', 'phieudichvu.idChiTietDichVu', '=', 'chitietdichvu.idChiTietDichVu')
            ->where('phieudichvu.idPhieuDichVu', $DatDichVu->idPhieuDichVu)
            ->get();
        $ngayBD = Carbon::createFromFormat('Y-m-d', $DatDichVu->NgayBatDau)->format('d/m/Y');

        ThongBao::create([
            "TieuDe" => "Phiếu dịch vụ của bạn đã được duyệt",
            "NoiDung" => "Phiếu dịch vụ " . strtolower($dichVus[0]->tenDichVu) . " bắt đầu vào " . $ngayBD . " lúc " . substr($DatDichVu->GioBatDau, 0, 5) . " của bạn đã được duyệt. Bạn có thể thanh toán trước trên website.",
            "idPhieuDichVu" => $DatDichVu->idPhieuDichVu
        ]);

        return response()->json(['message' => ['Cập nhật trạng thái thành công']], 200);
    }
}
