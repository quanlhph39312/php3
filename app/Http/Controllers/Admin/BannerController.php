<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banners\StoreRequest;
use App\Http\Requests\Admin\Banners\UpdateRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    const PATH_UPLOAD = 'banners';
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(StoreRequest $storeRequest)
    {
        try {
            $data = $storeRequest->validated();
            if ($storeRequest->hasFile('image')) {
                $data['image'] = $storeRequest->file('image')->store(self::PATH_UPLOAD);
            }
            $data['status'] ??= 0;
            Banner::query()->create($data);
            return redirect()->route('admin.banners.index')->with('success', 'Thêm mới thành công');
        } catch (\Exception $exception) {
            if (isset($data['image']) && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }
            dd($exception->getMessage());
            return back()->with('error', 'Cập nhật thất bại, có lỗi xảy ra vui lòng thử lại sau');
        }
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(UpdateRequest $updateRequest, Banner $banner)
    {
        try {
            $data = $updateRequest->validated();
            $image = $updateRequest->file('image');
            if ($image) {
                $data['image'] = $image->store(self::PATH_UPLOAD);
                $oldImage = $banner->image;
            }
            $data['status'] ??= 0;
            $banner->update($data);
            return back()->with('success', 'Cập nhật thành công');
        } catch (\Exception $exception) {
            if ($image && Storage::exists($image)) {
                Storage::delete($image);
            }
            return back()->with('error', 'Cập nhật thất bại, đã có lỗi xảy ra. Vui lòng thử lại sau');
        }
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        $image = $banner->image;
        if ($image && Storage::exists($image)) {
            Storage::delete($image);
        }
        return back()->with('error', 'Xóa thành công');
    }
}
