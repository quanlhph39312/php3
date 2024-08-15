@extends('admin.layouts.master')

@section('title')
    Sửa Banner: {{ $banner->title }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Banner: {{ $banner->title }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Banner</a></li>
                        <li class="breadcrumb-item active">{{ $banner->title }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-primary">Danh sách</a>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-8">
                                    <div>
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            value="{{ $banner->title }}">
                                        @error('title')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="text" class="form-control" name="link" id="link"
                                            value="{{ $banner->link }}">
                                        @error('link')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label for="position" class="form-label">Position</label>
                                        <select class="form-select form-select" name="position" id="position"
                                            value="{{ $banner->position }}">
                                            <option selected value="top-banner">Top Banner</option>
                                            <option value="middle-banner">Middle Banner</option>
                                            <option value="bottom-banner">Bottom Banner</option>
                                        </select>
                                    </div>

                                    <div class="mt-2">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="3">{{ $banner->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="image" id="image"
                                            onchange="previewCoverImage()">
                                        @error('image')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div id="coverPreviewContainer">
                                        <img id="imagePreview" src="{{ \Storage::url($banner->image) }}"
                                            alt="Current Image" width="100px">
                                    </div>
                                    <div class="mt-2">
                                        <label for="start_date" class="form-label">Start_Date</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date"
                                            value="{{ $banner->start_date ? \Carbon\Carbon::createFromFormat('d/m/Y', $banner->start_date)->format('Y-m-d') : '' }}">
                                        @error('start_date')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label for="end_date" class="form-label">End_Date</label>
                                        <input type="date" class="form-control" name="end_date" id="end_date"
                                            value="{{ $banner->end_date ? \Carbon\Carbon::createFromFormat('d/m/Y', $banner->end_date)->format('Y-m-d') : '' }}">
                                        @error('end_date')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label for="priority" class="form-label">Priority</label>
                                        <input type="number" class="form-control" value="{{ $banner->priority }}"
                                            name="priority" id="priority">
                                        @error('priority')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch form-switch-primary mt-4">
                                        <input class="form-check-input" type="checkbox" role="switch" name="status"
                                            id="is_active" @checked($banner->status == 1) value="1">
                                        <label class="form-check-label" for="status">Status</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center justify-content-center d-flex">
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
        let currentImage = "{{ \Storage::url($banner->image) }}";

        function previewCoverImage() {
            const fileInput = document.getElementById('image');
            const file = fileInput.files[0];
            const imagePreview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = currentImage;
            }
        }

        function resetFileInput() {
            document.getElementById('image').value = null;
        }
    </script>
@endsection
