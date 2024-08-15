<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    const PATH_UPLOAD = 'products';

    public function index()
    {
        $data = Product::where('status', 1)->get();
        return view('admin.products.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image_thumbnail')) {
            $validatedData['image_thumbnail'] = $request->file('image_thumbnail')->store(self::PATH_UPLOAD);
        }

        $booleanArray = ['status', 'is_show_home', 'is_new', 'is_sale', 'is_trending'];
        $validatedData = $this->booleanFields($validatedData, $booleanArray);

        Product::create($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Thêm mới thành công');
    }

    public function edit(Product $product)
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.products.edit', compact('categories', 'product'));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image_thumbnail')) {
                $newImagePath = $request->file('image_thumbnail')->store(self::PATH_UPLOAD);
                $data['image_thumbnail'] = $newImagePath;

                $oldImagePath = $product->image_thumbnail;
            }

            $booleanArray = ['status', 'is_show_home', 'is_sale', 'is_new', 'is_trending'];
            $data = $this->booleanFields($data, $booleanArray);

            $product->update($data);

            if (isset($oldImagePath) && Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }

            return back()->with('success', 'Cập nhật thành công');
        } catch (\Exception $exception) {
            if (isset($newImagePath) && Storage::exists($newImagePath)) {
                Storage::delete($newImagePath);
            }

            return back()->with('error', 'Cập nhật thất bại, có lỗi xảy ra vui lòng thử lại sau');
        }
    }

    public function destroy(Product $product)
    {
        $product->update(['status' => $product->status == 1 ? 0 : 1]);
        if ($product->status == 0) {
            return back()->with('success', 'Xóa sản phẩm thành công');
        } else {
            return back()->with('success', 'Khôi phục sản phẩm thành công');
        }
    }

    public function trash()
    {
        $data = Product::where('status', 0)->get();
        return view('admin.products.trash', compact('data'));
    }

    protected function booleanFields($data, $fields)
    {
        foreach ($fields as $field) {
            $data[$field] = $data[$field] ?? 0;
        }
        return $data;
    }
}
