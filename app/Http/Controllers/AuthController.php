<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChucVu;
use App\Models\NhanVien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Register API - POST (name, email, password)
    public function register(Request $request)
    {

        // Validation
        $request->validate([
            "name" => "required|string",
            "SDT" => 'required|phone_number|unique:users,SDT',
            "password" => "required|confirmed" // password_confirmation
        ]);

        // User model to save user in database
        User::create([
            "name" => $request->name,
            "SDT" => $request->SDT,
            "password" => bcrypt($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "data" => []
        ]);
    }

    // Login API - POST (email, password)
    public function login(Request $request)
    {

        // Validation
        $request->validate([
            "SDT" => "required|phone_number",
            "password" => "required"
        ]);

        // Auth Facade
        // $token = Auth::attempt([
        //     "email" => $request->email,
        //     "password" => $request->password
        // ]);

        $token = auth()->attempt([
            "SDT" => $request->SDT,
            "password" => $request->password
        ]);

        if (!$token) {

            return response()->json([
                "status" => false,
                "message" => "Invalid login details"
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "User logged in",
            "token" => $token,
            "expires_in" => auth()->factory()->getTTL() * 60
        ]);
    }

    // Profile API - GET (JWT Auth Token)
    public function profile()
    {

        //$userData = auth()->user();
        $userData = request()->user();

        $staffData = NhanVien::where('idNguoiDung', $userData->id)->first();

        if ($staffData != null) {
            $position = ChucVu::findOrFail($staffData->idChucVu);
        }
        if ($staffData != null) {
            return response()->json([
                "status" => true,
                "message" => "Profile data",
                "user" => $userData,
                "position" => $position,
                "user_id" => request()->user()->id,
                "SDT" => request()->user()->SDT
            ]);
        } else {
            return response()->json([
                "status" => true,
                "message" => "Profile data",
                "user" => $userData,
                "user_id" => request()->user()->id,
                "SDT" => request()->user()->SDT
            ]);
        }
    }

    // Refresh Token API - GET (JWT Auth Token)
    public function refreshToken()
    {

        $token = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "Refresh token",
            "token" => $token,
            "expires_in" => auth()->factory()->getTTL() * 60
        ]);
    }

    // Logout API - GET (JWT Auth Token)
    public function logout()
    {

        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        // Xác thực dữ liệu yêu cầu
        $request->validate([
            'name' => 'required|string',
            'GioiTinh' => 'nullable|string',
            'NgaySinh' => 'nullable|date',
        ]);

        // Tìm người dùng cần cập nhật
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Cập nhật thông tin người dùng
        $user->name = $request->input('name');
        $user->GioiTinh = $request->input('GioiTinh');
        $user->NgaySinh = $request->input('NgaySinh');

        // Kiểm tra xem có file ảnh mới được upload hay không
        if ($request->hasFile('Anh')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($user->Anh) {
                File::delete($user->Anh);
            }

            // Lưu ảnh mới
            $user->Anh = $request->file('Anh')->store('users');
        }

        // Lưu các thay đổi
        $user->save();

        // Trả về phản hồi
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function doiMatKhau(Request $request)
    {
        $request->validate([
            "id" => "required",
            "password" => "required",
            "newPass" => "required",
            "rePass" => "required"
        ]);

        if ($request->newPass != $request->rePass) {
            return response()->json([
                "status" => false,
                "message" => "Mật khẩu nhập lại không khớp!"
            ]);
        }

        $user = User::findOrFail($request->id);
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "Mật khẩu không đúng!"
            ]);
        }

        $user->password = bcrypt($request->newPass);
        $user->save();

        return response()->json([
            "status" => true,
            "message" => "Đổi mật khẩu thành công!"
        ]);
    }
}
