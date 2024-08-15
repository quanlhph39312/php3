@extends('admin.layouts.master')

@section('title')
    Danh mục Sản phẩm: {{ $category->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh mục Sản phẩm: {{ $category->name }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục Sản phẩm</a></li>
                        <li class="breadcrumb-item active">{{ $category->name }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Danh sách</a>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-4">
                                    <div>
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ $category->name }}">
                                        @error('name')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="image" id="image"
                                            onchange="previewCoverImage()">
                                        <div id="coverPreviewContainer">
                                            <img id="coverPreview" src="{{ \Storage::url($category->image) }}"
                                                alt="Current Image" width="100px">
                                        </div>
                                    </div>
                                    <div class="form-check form-switch form-switch-primary mt-3">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            @checked($category->status) value="1" name="status" id="is_active">
                                        <label class="form-check-label" for="is_active">Status</label>
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
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>

    </form>
@endsection

@section('scripts')
    <script>
        let currentCover = "{{ \Storage::url($category->image) }}";

        function previewCoverImage() {
            const fileInput = document.getElementById('image');
            const file = fileInput.files[0];
            const coverPreview = document.getElementById('coverPreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                coverPreview.src = currentCover;
            }
        }

        function resetFileInput() {
            document.getElementById('image').value = null;
        }
    </script>
@endsection
