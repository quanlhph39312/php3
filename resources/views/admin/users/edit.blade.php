@extends('admin.layouts.master')

@section('title')
    Thêm mới người dùng
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới người dùng</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách người dùng</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Danh sách</a>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ $user->name }}">
                                        @error('name')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ $user->email }}">
                                        @error('email')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="{{ $user->password }}">
                                        @error('password')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                    @if ($user->email == 'quanlhph39312@fpt.edu.vn')
                                        <div class="mb-3">
                                            <label for="" class="form-label">role</label>
                                            <select class="form-select form-select-small" name="role" disabled>
                                                <option value="admin" @selected($user->role == 'admin')>Admin</option>
                                                <option value="user" @selected($user->role == 'user')>User</option>
                                            </select>
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <label for="" class="form-label">role</label>
                                            <select class="form-select form-select-small" name="role">
                                                <option value="admin" @selected($user->role == 'admin')>Admin</option>
                                                <option value="user" @selected($user->role == 'user')>User</option>
                                            </select>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone"
                                            value="{{ $user->phone }}">
                                        @error('phone')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" id="address"
                                            value="{{ $user->address }}">
                                        @error('address')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="birthday" class="form-label">Birthday</label>
                                        <input type="date" class="form-control" name="birthday" id="birthday"
                                            value="{{ $user->birthday }}">
                                        @error('birthday')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="avatar" class="form-label">Avatar</label>
                                        <input type="file" class="form-control" name="avatar" id="avatar"
                                            onchange="previewCoverImage()">
                                        <div id="coverPreviewContainer">
                                            <img id="coverPreview" src="{{ \Storage::url($user->avatar) }}"
                                                alt="Current Avatar" width="100px">
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
        let currentCover = "{{ \Storage::url($user->avatar) }}";

        function previewCoverImage() {
            const fileInput = document.getElementById('avatar');
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
            document.getElementById('avatar').value = null;
        }
    </script>
@endsection
