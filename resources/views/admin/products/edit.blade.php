@extends('admin.layouts.master')

@section('title')
    Sửa Sản phẩm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sửa sản phẩm: {{ $product->name }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">Sửa sản phẩm</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Danh sách</a>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-4">
                                    <div>
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ $product->name }}">
                                        @error('name')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="price_regular" class="form-label">Price Regular</label>
                                        <input type="number" class="form-control" name="price_regular"
                                            value="{{ $product->price_regular }}" id="price_regular">
                                        @error('price_regular')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="price_sale" class="form-label">Price Sale</label>
                                        <input type="number" class="form-control" name="price_sale"
                                            value="{{ $product->price_sale ??= 0 }}" id="price_sale">
                                        @error('price_sale')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select type="text" class="form-select" name="category_id" id="catelogue_id">
                                            @foreach ($categories as $id => $name)
                                                <option value="{{ $id }}" @selected($id == $product->category_id)>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <label for="image_thumbnail" class="form-label">Img Thumbnail</label>
                                        <input type="file" class="form-control file-input" name="image_thumbnail"
                                            id="image_thumbnail"
                                            onchange="previewImage(this, 'preview-thumbnail', 'old-thumbnail')">
                                        <input type="hidden" id="old-thumbnail"
                                            value="{{ \Storage::url($product->image_thumbnail) }}">
                                        <div id="preview-thumbnail" class="mt-2">
                                            <img src="{{ \Storage::url($product->image_thumbnail) }}" alt="Thumbnail"
                                                width="80px">
                                        </div>
                                        @error('image_thumbnail')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        @php
                                            $is = [
                                                'status' => 'primary',
                                                'is_trending' => 'danger',
                                                'is_sale' => 'warning',
                                                'is_new' => 'success',
                                                'is_show_home' => 'info',
                                            ];
                                        @endphp

                                        @foreach ($is as $key => $color)
                                            <div class="col-md-2">
                                                <div class="form-check form-switch form-switch-{{ $color }}">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="{{ $key }}" value="1"
                                                        @checked($product->$key === 1)>
                                                    <label class="form-check-label"
                                                        for="{{ $key }}">{{ \Str::convertCase($key, MB_CASE_TITLE) }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row">
                                        <div class="mt-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="2"> {{ $product->description }}</textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="material" class="form-label">Material</label>
                                            <textarea class="form-control" name="material" id="material" rows="2">{{ $product->material }}</textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="content" class="form-label">Content</label>
                                            <textarea class="form-control" name="content" id="content">{{ $product->content }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div><!-- end card header -->
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        function previewImage(input, previewId, oldImageId) {
            let file = input.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).innerHTML =
                        `<img src="${e.target.result}" alt="Preview Image" width="100px">`;
                }
                reader.readAsDataURL(file);
            } else {
                if (!input.value) {
                    let oldImageUrl = document.getElementById(oldImageId).value;
                    document.getElementById(previewId).innerHTML = `<img src="${oldImageUrl}" width="100px">`;
                }
            }
        }
    </script>
@endsection
