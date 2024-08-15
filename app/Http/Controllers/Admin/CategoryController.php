<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    const PATH_UPLOAD = 'categories';

    public function index()
    {
        $data = Category::query()->where('status', 1)->get();
        return view('admin.categories.index', compact('data'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255',
            'status' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ], [], [
            'name' => 'Tên danh mục',
            'image' => 'Ảnh danh mục'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput()
                ->with('error', 'Dữ liệu không hợp lệ');
        }
        $data = $request->except('image');
        $data['status'] = $request->status ? 1 : 0;
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->image);
        }
        Category::query()->create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Thêm mới thành công');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
                'status' => 'boolean',
                'image' => 'nullable|image|max:2048',
            ], [], [
                'name' => 'Tên danh mục',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Dữ liệu không hợp lệ');
            }
            $data = $request->except('image');
            $newImage = $request->file('image');
            if ($newImage) {
                $data['image'] = Storage::put(self::PATH_UPLOAD, $newImage);
                $oldImage = $category->image;
            }
            $data['status'] ??= 0;
            $category->update($data);
            if (isset($oldImage) && Storage::exists($oldImage)) {
                Storage::delete($oldImage);
            }
            return redirect()->back()->with('success', 'Cập nhật thành công');
        } catch (\Exception $exception) {
            return back()->with('error', 'Cập nhật thất bại, đã có lỗi xảy ra');
        }
    }

    public function destroy(Category $category)
    {
        $category->update(['status' => $category->status == 1 ? 0 : 1]);
        if ($category->status == 0) {
            return back()->with('success', 'Xóa danh mục thành công');
        } else {
            return back()->with('success', 'Khôi phục danh mục thành công');
        }
    }


    public function trash()
    {
        $data = Category::query()->where('status', 0)->get();
        return view('admin.categories.trash', compact('data'));
    }
}
