<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\String_;

class ProfileController extends Controller
{
    const PATH_UPLOAD = 'profiles';
    public function profile()
    {
        return view('client.profile');
    }
    public function editProfile(String $id, Request $request)
    {
        $data = $request->except('avatar', 'oldImage');
        $request->hasFile('avatar')
            ? $data['avatar'] = Storage::put(self::PATH_UPLOAD, $request->file('avatar'))
            : $data['avatar'] = $request->oldImage;
        $oldImage = DB::table('users')->where('id', $id)->first(['avatar']);
        DB::table('users')->where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'birthday' => $data['birthday'],
            'avatar' => $data['avatar'],
        ]);
        if ($oldImage->avatar && Storage::exists($oldImage->avatar)) {
            Storage::delete($oldImage->avatar);
        }
        return back();
    }

    public function changePassword(Request $request, int $id)
    {
        try {
            $data = $request->validate([
                'current_password' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->errors())->with('tab', 'password');
        }
        $user = DB::table('users')->where('id', $id)->first();

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng'])->with('tab', 'password');
        }
        $newPassword = Hash::make($data['password']);
        $updated = DB::table('users')->where('id', $id)->update(['password' => $newPassword]);

        if ($updated) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('account.showLogin')->with('success', 'Mật khẩu đã được thay đổi thành công. Vui lòng đăng nhập lại.');
        }
        return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.')->with('tab', 'password');
    }
}
