@extends('admin.layouts.master')

@section('title')
    Thêm mới Sản phẩm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
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
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="price_regular" class="form-label">Price Regular</label>
                                        <input type="number" value="0" class="form-control" name="price_regular"
                                            id="price_regular" value="{{ old('price_regular') }}">
                                        @error('price_regular')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="price_sale" class="form-label">Price Sale</label>
                                        <input type="number" value="0" class="form-control" name="price_sale"
                                            id="price_sale" value="{{ old('price_sale') }}">
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
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mt-3">
                                        <label for="image_thumbnail" class="form-label">Img Thumbnail</label>
                                        <input type="file" class="form-control" name="image_thumbnail"
                                            id="image_thumbnail" onchange="previewImage(this, 'coverPreview', '100px')">
                                        @error('image_thumbnail')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div id="coverPreview" class="mt-2"></div>
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
                                                        name="{{ $key }}" value="1" checked>
                                                    <label class="form-check-label"
                                                        for="{{ $key }}">{{ \Str::convertCase($key, MB_CASE_TITLE) }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row">
                                        <div class="mt-3">
                                            <label for="material" class="form-label">Material</label>
                                            <input class="form-control" name="material" id="material"
                                                value="{{ old('material') }}">
                                        </div>
                                        <div class="mt-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="2">{{ old('description') }}</textarea>
                                        </div>
                                        <div class="mt-3">
                                            <label for="content" class="form-label">Content</label>
                                            <textarea class="form-control" name="content" id="content">{{ old('content') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--end col-->
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

@section('script-libs')
    <script src="https:////cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
@endsection

@section('scripts')
    <script>
        CKEDITOR.replace('content');

        function previewImage(input, previewId, maxHeight) {
            const file = input.files[0];
            const previewContainer = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'mt-2');
                    img.style.maxHeight = maxHeight;

                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = '';
            }
        }
    </script>
@endsection
