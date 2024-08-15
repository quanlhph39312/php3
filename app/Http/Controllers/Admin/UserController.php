<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const PATH_UPLOAD = 'users';
    public function index()
    {
        $users = User::query()->where('status', 1)->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreRequest $storeRequest)
    {
        try {
            $data = $storeRequest->validated();
            $avatar = $storeRequest->file('avatar');
            if ($avatar) {
                $data['avatar'] = $avatar->store(self::PATH_UPLOAD);
            }
            $data['status'] ??= 0;
            User::query()->create($data);
            return redirect()->route('admin.users.index')->with('success', 'Thêm mới người dùng thành công');
        } catch (\Exception $exception) {
            if (isset($data['avatar']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avatar']);
            }
            return back()->with('error', 'Thêm mới thất bại, đã có lỗi xảy ra.Vui lòng thử lại sau');
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateRequest $updateRequest, User $user)
    {
        try {
            $data = $updateRequest->validated();
            $avatar = $updateRequest->file('avatar');
            if ($avatar) {
                $data['avatar'] = $avatar->store(self::PATH_UPLOAD);
                $oldAvatar = $user->avatar;
            }
            $user->update($data);
            if (isset($oldAvatar) && Storage::exists($oldAvatar)) {
                Storage::delete($oldAvatar);
            }
            return back()->with('success', 'Cập nhật người dùng thành công');
        } catch (\Exception $exception) {
            if (isset($data['avatar']) && Storage::exists($data['avatar'])) {
                Storage::delete($data['avatar']);
            }
            return back()->with('error', 'Cập nhật thất bại, đã có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    public function destroy(User $user)
    {
        if (auth()->user()->id == $user->id) {
            return back()->with('info', 'Bạn không thể tự hủy');
        }
        $user->update(['status' => $user->status == 1 ? 0 : 1]);
        if ($user->status == 0) {
            return back()->with('success', 'Thêm tài khoản vào danh sách hạn chế thành công');
        } else {
            return back()->with('success', 'Xóa tài khoản khỏi danh sách hạn chế thành công');
        }
    }

    public function blockUser()
    {
        $users = User::query()->where('status', 0)->get();
        return view('admin.users.block', compact('users'));
    }
}
