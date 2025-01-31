<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDichVu;
use App\Models\ChiTietNgayLam;
use App\Models\ChucVu;
use App\Models\DatDichVu;
use App\Models\DichVu;
use App\Models\NhanVien;
use App\Models\PhongBan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\confirm;

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
            ->orWhere('SDT', 'like', '%' . $searchData . '%');
        // ->orWhere('email', 'like', '%' . $searchData . '%');

        $nhanVien = null;

        $total = $query->count();

        if ($start == null || $take == null) {
            $nhanVien = $query->select(
                'NhanVien.idNhanVien',
                'users.name',
                // 'users.email',
                'users.SDT',
                'users.GioiTinh',
                'users.NgaySinh',
                'NhanVien.SoSao',
                'ChucVu.tenChucVu'
            )->get();

            $newRow = [
                'idNhanVien' => "Mã nhân viên",
                'name' => 'Họ và tên nhân viên',
                // 'email' => 'Email',
                'SDT' => 'Số điện thoại',
                'GioiTinh' => 'Giới tính',
                'NgaySinh' => 'Ngày sinh',
                'SoSao' => "Số sao",
                'tenChucVu' => 'Chức vụ'
            ];

            $nhanVien->prepend($newRow);
        } else {
            $nhanVien = $query->select('NhanVien.*', 'users.*', 'ChucVu.*')
                ->skip($start)
                ->take($take)
                ->get();
        }

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
        $request->validate([
            'name' => 'required|string',
            // 'email' => 'required|unique:users|email',
            'SDT' => 'required|phone_number|unique:users,SDT',
            // 'password' => 'required|confirmed',
            'GioiTinh' => 'required|string',
            'idPhongBan' => 'required|exists:PhongBan,idPhongBan',
            'idChucVu' => 'required|exists:ChucVu,idChucVu',
            'NgaySinh' => 'required',
        ], [
            'name.required' => 'Tên bắt buộc',
            'name.string' => 'Tên phải là chuỗi ký tự',
            // 'email.required' => 'Email bắt buộc',
            // 'email.unique' => 'Email đã tồn tại',
            // 'email.email' => 'Email không hợp lệ',
            'SDT.required' => 'Số điện thoại bắt buộc',
            'SDT.phone_number' => 'Số điện thoại không hợp lệ',
            'SDT.unique' => 'Số điện thoại đã tồn tại',
            // 'password.required' => 'Mật khẩu bắt buộc',
            // 'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'GioiTinh.required' => 'Giới tính bắt buộc',
            'GioiTinh.string' => 'Giới tính phải là chuỗi ký tự',
            'idPhongBan.required' => 'Phòng ban bắt buộc',
            'idPhongBan.exists' => 'Phòng ban không tồn tại',
            'idChucVu.required' => 'Chức vụ bắt buộc',
            'idChucVu.exists' => 'Chức vụ không tồn tại',
            'NgaySinh.required' => 'Ngày sinh bắt buộc',
        ]);
        if (Carbon::parse($request->NgaySinh)->age < 18) {
            return response()->json(['message' => ['Nhân sự chưa đủ 18 tuổi. Vui lòng từ chối nhân sự này.']], 201);
        }
        $userData = $request->except(["idChucVu", "idPhongBan", "password_confirmation"]);
        $userData["NgaySinh"] = Carbon::parse($request->NgaySinh)->toDateString();
        $userData["status"] = 1;
        $userData["password"] = bcrypt($userData["SDT"]);
        $user = User::create($userData);
        $NhanVienData = $request->only(["idChucVu", "idPhongBan"]);
        $NhanVienData["idNguoiDung"] = $user->id;
        $NgaySinh = Carbon::parse($request->NgaySinh)->toDateString();
        $userData['NgaySinh'] = $NgaySinh;
        $NhanVienData["SoSao"] = 5;
        NhanVien::create($NhanVienData);
        return response()->json(['message' => ['Thêm nhân viên thành công']], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = NhanVien::select('nhanvien.SoSao', 'users.name', 'users.NgaySinh', 'users.GioiTinh', 'users.Anh', 'chucvu.tenChucVu')
            ->leftJoin('users', 'nhanvien.idNguoiDung', '=', 'users.id')
            ->leftJoin('chucvu', 'nhanvien.idChucVu', '=', 'chucvu.idChucVu')
            ->where('nhanvien.idNhanVien', $id)
            ->first();

        if ($result) {
            return response()->json($result);
        } else {
            return response()->json(['message' => 'NhanVien not found'], 404);
        }
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            // 'email' => [
            //     'required',
            //     'email',
            //     Rule::unique('users', 'email')->ignore($request->idNguoiDung),
            // ],
            'SDT' => [
                'required',
                'phone_number',
                Rule::unique('users', 'SDT')->ignore($request->idNguoiDung)
            ],
            // 'password' => 'required|confirmed',
            'GioiTinh' => 'required|string',
            'idPhongBan' => 'required|exists:PhongBan,idPhongBan',
            'idChucVu' => 'required|exists:ChucVu,idChucVu',
            'NgaySinh' => 'required',
        ]);
        $dataNhanVien = NhanVien::findOrFail($id);
        $dataUser = User::findOrFail($dataNhanVien->idNguoiDung);
        $userData = $request->except(["idChucVu", "idPhongBan", "password_confirmation"]);
        $NhanVienData = $request->only(["idNguoiDung", "SoSao", "idChucVu", "idPhongBan"]);
        $PhongBan = PhongBan::findOrFail($NhanVienData["idChucVu"]);
        if ($PhongBan->idPhongBan != $NhanVienData["idPhongBan"]) {
            return response()->json(['message' => ['Vui lòng chọn chức vụ']], 422);
        }
        $dataNhanVien->update($NhanVienData);
        $NgaySinh = Carbon::parse($request->NgaySinh)->toDateString();
        $userData['NgaySinh'] = $NgaySinh;
        $userData['password'] = $dataUser->password;
        $dataUser->update($userData);
        return response()->json(['message' => ['Sửa thông tin nhân viên thành công']], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $staffData = NhanVien::findOrFail($id);
        $userData = User::findOrFail($id);
        $userData->status = 0;
        $userData->save();
        return response()->json(['message' => ['Xóa nhân viên thành công']], 200);
    }

    public function exportImportHeaderData()
    {

        $nhanVien = [];

        $newRow = [
            'idNhanVien' => "Mã nhân viên",
            'name' => 'Họ và tên nhân viên',
            // 'email' => 'Email',
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
            return response()->json(['message' => ['Không tồn tại dữ liệu']], 422);
        }

        // Header mẫu
        $headers = [
            'idNhanVien' => "Mã nhân viên",
            'name' => 'Họ và tên nhân viên',
            // 'email' => 'Email',
            'SDT' => 'Số điện thoại',
            'GioiTinh' => 'Giới tính',
            'tenChucVu' => 'Chức vụ'
        ];

        // Kiểm tra dòng đầu tiên có chứa header đúng không
        $firstRow = $data[0];

        // Kiểm tra xem hai mảng có giống nhau không
        $diff = array_diff_assoc($headers, $firstRow);

        if (!empty($diff)) {
            return response()->json(['message' => $diff], 422);
        }

        $errors = [];
        $validatedUserData = [];
        $validatedNhanVienData = [];

        // Bắt đầu từ dòng thứ hai để bỏ qua header
        for ($rowIndex = 1; $rowIndex < count($data); $rowIndex++) {
            $row = $data[$rowIndex];
            $userData = [
                'name' => $row['name'],
                // 'email' => $row['email'],
                'SDT' => $row['SDT'],
                'GioiTinh' => $row['GioiTinh'],
            ];

            // Kiểm tra và thêm dữ liệu cho bảng users
            $userValidator = Validator::make($userData, [
                'name' => 'required|string',
                // 'email' => 'unique:users|email',
                'SDT' => 'required|phone_number|unique:users,SDT',
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
                'idNhanVien' => 'required|numeric|unique:NhanVien,idNhanVien',
                'idChucVu' => 'required|exists:ChucVu,idChucVu',
            ]);

            if ($nhanVienValidator->fails()) {
                $errors[] = "Dòng: " . ($rowIndex + 1) . ", Lỗi: " . $nhanVienValidator->errors()->first();
            } else {
                $validatedNhanVienData[] = $nhanVienData;
            }
        }

        if (!empty($errors)) {
            return response()->json(['message' => $errors], 422);
        }

        // Thêm dữ liệu vào bảng users
        $insertedUsers = [];
        foreach ($validatedUserData as $userData) {
            $user = User::create($userData);
            $insertedUsers[] = $user;
        }

        // Cập nhật idNguoiDung cho bảng NhanVien
        foreach ($validatedNhanVienData as $index => $nhanVienData) {
            $nhanVienData['idNguoiDung'] = $insertedUsers[$index]->id;
            NhanVien::create($nhanVienData);
        }

        return response()->json(['message' => ['Thêm dữ liệu vào hệ thống thành công']], 200);
    }
    public function getStaffIsNotAddChiTietNgayLam(Request $request)
    {
        $idChiTietNgayLam = $request->query('idChiTietNgayLam');

        if ($idChiTietNgayLam !== null && $idChiTietNgayLam !== '' && $idChiTietNgayLam !== "null") {

            $ChiTietNgayLam = ChiTietNgayLam::findOrFail($idChiTietNgayLam);

            $PhieuDichVu = DatDichVu::findOrFail($ChiTietNgayLam->idPhieuDichVu);

            $ChiTietDichVu = ChiTietDichVu::findOrFail($PhieuDichVu->idChiTietDichVu);

            $DichVu = DichVu::findOrFail($ChiTietDichVu->idDichVu);
        }

        $NhanVien = NhanVien::leftJoin('users', 'users.id', '=', 'NhanVien.idNguoiDung');
        $NhanVien = $NhanVien->leftJoin('ChiTietNhanVienLamDichVu', 'ChiTietNhanVienLamDichVu.idNhanVien', '=', 'NhanVien.idNhanVien');

        if ($idChiTietNgayLam !== null && $idChiTietNgayLam !== '' && $idChiTietNgayLam !== "null") {
            $NhanVien = $NhanVien->leftJoin('nanglucnhanvien', 'nanglucnhanvien.idNhanVien', '=', 'NhanVien.idNhanVien')
                                    ->where('nanglucnhanvien.idDichVu', '=', $DichVu->idDichVu);
        }
        $NhanVien = $NhanVien->where('NhanVien.idChucVu', '=', 3)->select('NhanVien.idNhanVien', 'users.name', 'users.SDT', 'NhanVien.soSao');

        if ($idChiTietNgayLam !== null && $idChiTietNgayLam !== '') {
            $NhanVien->whereNotIn('NhanVien.idNhanVien', function ($query) use ($idChiTietNgayLam) {
                $query->select('idNhanVien')
                    ->from('ChiTietNhanVienLamDichVu')
                    ->where('idChiTietNgayLam', $idChiTietNgayLam);
            });
        }

        $NhanVien = $NhanVien->groupBy('NhanVien.idNhanVien', 'users.name', 'users.SDT', 'NhanVien.soSao')->get();
        return response()->json([
            'data' => $NhanVien,
        ]);
    }
    public function isStaff()
    {
        $user = request()->user();
        $staffData = NhanVien::where('idNguoiDung', $user->id)->first();
        if ($staffData == null) {
            return response()->json(['data' => false], 201);
        } else {
            return response()->json(['data' => true], 200);
        }
    }
    public function getStaffIsNotAddNhom(Request $request)
    {
        $idNhom = $request->query('idNhom');

        $NhanVien = NhanVien::leftJoin('users', 'users.id', '=', 'NhanVien.idNguoiDung')
            ->leftJoin('NhomNguoiDung', 'NhomNguoiDung.idNhanVien', '=', 'NhanVien.idNhanVien')
            ->select('NhanVien.idNhanVien', 'users.name', 'users.SDT');

        if ($idNhom !== null && $idNhom !== '') {
            $NhanVien->whereNotIn('NhanVien.idNhanVien', function ($query) use ($idNhom) {
                $query->select('idNhanVien')
                    ->from('NhomNguoiDung')
                    ->where('idNhom', $idNhom);
            });
        }

        $NhanVien = $NhanVien->groupBy('NhanVien.idNhanVien', 'users.name', 'users.SDT')->get();
        return response()->json([
            'data' => $NhanVien,
        ]);
    }

    public function layThongTinNhanVienTheoIdNV($id)
    {
    }
}
