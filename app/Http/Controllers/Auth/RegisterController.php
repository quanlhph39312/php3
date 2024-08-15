<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    const PATH_VIEW = 'auth.account.';
    public function showRegister()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|min:6|max:100',
            'password' => 'required|min:6|max:100',
            'confirmPassword' => 'required|same:password',
        ],[],[
            'name' => 'Tên',
            'password' => 'Mật khẩu',
            'confirmPassword' => 'Mật khẩu nhập lại'
        ]);
        $password = Hash::make($data['password']);
        $user = DB::table('users')->insertGetId([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => $password,
        ]);
        if ($user) {
            Auth::loginUsingId($user);
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->with('error', "Có lỗi xảy ra");
    }
}
