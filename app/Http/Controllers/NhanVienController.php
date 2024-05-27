<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use App\Models\NhanVien;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchData = $request->query('searchData');
        $start = $request->query('start', null);
        $take = $request->query('take', null);

        $query = NhanVien::leftJoin('users', 'users.id', '=', 'NhanVien.idNguoiDung')
            ->leftJoin('ChucVu', 'ChucVu.idChucVu', '=', 'NhanVien.idChucVu');

        $query->where('name', 'like', '%' . $searchData . '%')
            ->orWhere('SDT', 'like', '%' . $searchData . '%')
            ->orWhere('email', 'like', '%' . $searchData . '%');

        $nhanVien = null;

        if ($start == null || $take == null) {
            $nhanVien = $query->select(
                'NhanVien.idNhanVien',
                'users.name',
                'users.email',
                'users.SDT',
                'users.GioiTinh',
                'users.NgaySinh',
                'NhanVien.SoSao',
                'ChucVu.tenChucVu'
            )->get();

            $newRow = [
                'idNhanVien' => "Mã nhân viên",
                'name' => 'Họ và tên nhân viên',
                'email' => 'Email',
                'SDT' => 'Số điện thoại',
                'GioiTinh' => 'Giới tính',
                'NgaySinh' => 'Ngày sinh',
                'SoSao' => "Số sao",
                'tenChucVu' => 'Chức vụ'
            ];

            $nhanVien->prepend($newRow);
        } else {
            $nhanVien = $query->select('NhanVien.*', 'users.*')
                ->skip($start)
                ->take($take)
                ->get();
        }

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

    public function exportImportHeaderData()
    {

        $nhanVien = [];

        $newRow = [
            'idNhanVien' => "Mã nhân viên",
            'name' => 'Họ và tên nhân viên',
            'email' => 'Email',
            'SDT' => 'Số điện thoại',
            'GioiTinh' => 'Giới tính',
            'tenChucVu' => 'Chức vụ'
        ];

        array_unshift($nhanVien, $newRow);

        return response()->json([
            'data' => $nhanVien,
        ]);
    }

    public function importData(Request $request)
    {
        $data = $request->input();

        if (empty($data)) {
            return response()->json(['errors' => ['Không tồn tại dữ liệu']], 422);
        }

        // Header mẫu
        $headers = [
            'idNhanVien' => "Mã nhân viên",
            'name' => 'Họ và tên nhân viên',
            'email' => 'Email',
            'SDT' => 'Số điện thoại',
            'GioiTinh' => 'Giới tính',
            'tenChucVu' => 'Chức vụ'
        ];

        // Kiểm tra dòng đầu tiên có chứa header đúng không
        $firstRow = $data[0];

        // Kiểm tra xem hai mảng có giống nhau không
        $diff = array_diff_assoc($headers, $firstRow);

        if (!empty($diff)) {
            return response()->json(['errors' => $diff], 422);
        }

        $errors = [];
        $validatedUserData = [];
        $validatedNhanVienData = [];

        // Bắt đầu từ dòng thứ hai để bỏ qua header
        for ($rowIndex = 1; $rowIndex < count($data); $rowIndex++) {
            $row = $data[$rowIndex];
            $userData = [
                'name' => $row['name'],
                'email' => $row['email'],
                'SDT' => $row['SDT'],
                'GioiTinh' => $row['GioiTinh'],
            ];

            // Kiểm tra và thêm dữ liệu cho bảng users
            $userValidator = Validator::make($userData, [
                'name' => 'required|string',
                'email' => 'unique:users|email',
                'SDT' => 'required|string',
                'GioiTinh' => 'string',
            ]);

            if ($userValidator->fails()) {
                $errors[] = "Dòng: " . ($rowIndex + 1) . ", Lỗi: " . $userValidator->errors()->first();
            } else {
                $validatedUserData[] = $userData;
            }

            // Thêm dữ liệu cho bảng NhanVien
            $nhanVienData = [
                'idNhanVien' => $row['idNhanVien'],
            ];

            // Lấy idChucVu từ tên chức vụ
            $tenChucVu = $row['tenChucVu'];
            $chucVu = ChucVu::where('tenChucVu', $tenChucVu)->first();
            if ($chucVu) {
                $nhanVienData['idChucVu'] = $chucVu->idChucVu;
            } else {
                $errors[] = "Dòng: " . ($rowIndex + 1) . ", Lỗi: Không tìm thấy chức vụ có tên $tenChucVu";
            }

            // Kiểm tra và thêm dữ liệu cho bảng NhanVien
            $nhanVienValidator = Validator::make($nhanVienData, [
                'idNhanVien' => 'required|numeric',
                'idChucVu' => 'required|exists:ChucVu,idChucVu',
            ]);

            if ($nhanVienValidator->fails()) {
                $errors[] = "Dòng: " . ($rowIndex + 1) . ", Lỗi: " . $nhanVienValidator->errors()->first();
            } else {
                $validatedNhanVienData[] = $nhanVienData;
            }
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        // Thêm dữ liệu vào bảng users
        User::insert($validatedUserData);

        // Thêm dữ liệu vào bảng NhanVien
        NhanVien::insert($validatedNhanVienData);

        return response()->json(['message' => 'Data imported successfully'], 200);
    }
}
