<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $account = User::where('email', $request->email)->first();
        $email = auth()->user()->email;

        if (!$account) {
            return back()->with(['info' => 'Email không tồn tại.']);
        }

        if (auth()->user()->email != $account->email) {
            return back()->with('error', 'Bạn không có quyền đặt lại mật khẩu cho email này');
        }

        $cacheKey = $email;
        $cacheTTL = 3;
        $maxAttempts = 3;
        $attempts = Cache::get($cacheKey, 0);

        if ($attempts >= $maxAttempts) {
            return back()->with('error', 'Bạn đã gửi quá nhiều yêu cầu. Vui lòng thử lại sau 3 phút');
        }

        $token = Str::random(60);
        $minutes = config('auth.passwords.users.expire');

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token, $minutes, $account->email));

        Cache::put($cacheKey, $attempts + 1, now()->addMinutes($cacheTTL));

        return back()->with(['status' => 'Link đặt lại mật khẩu đã được gửi đến email của bạn!']);
    }

    public function showResetForm($token, $email)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $email]);
    }

    public function reset(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = auth()->user();
        $email = $request->email;
        $token = $request->token;
        $password = $request->password;

        $passwordReset = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            return back()->with('error', 'Token không hợp lệ hoặc đã hết hạn');
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->password = Hash::make($password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        Auth::logout();
        return redirect()->route('account.showLogin')->with(['success' => 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập lại']);
    }
}
