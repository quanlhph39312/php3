@extends('client.layouts.master')
@section('content')
@section('title')
    Profile
@endsection
<div class="container-fluid p-5">
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-3 col-xl-2">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Profile Settings</h5>
                        </div>

                        <div class="list-group list-group-flush" role="tablist">
                            <a class="list-group-item list-group-item-action  {{ session('tab') == 'password' ? '' : 'active' }}"
                                data-toggle="list" href="#profile" role="tab">
                                Account
                            </a>
                            <a class="list-group-item list-group-item-action {{ session('tab') == 'password' ? 'active' : '' }}"
                                data-toggle="list" href="#password" role="tab">
                                Password
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-xl-10">
                    <div class="tab-content">

                        <div class="tab-pane fade {{ session('tab') == 'password' ? '' : 'show active' }}"
                            id="profile" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Info</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('account.auth.editProfile', Auth::user()->id) }}"
                                        method="POST" enctype="multipart/form-data" id="validation-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label for="inputEmail">Email</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->email }}" name="email"
                                                        placeholder="Email" disabled />
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputUsername">Name</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->name }}" name="name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPhone">Phone</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->phone }}" name="phone">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress">Address</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->address }}" name="address">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="inputBirthday">Birthday</label>
                                                    <input type="date" class="form-control"
                                                        value="{{ Auth::user()->birthday }}" name="birthday">
                                                </div>
                                                <div class="text-center">
                                                    <input type="hidden" name="oldImage"
                                                        value="{{ Auth::user()->avatar }}">
                                                    <img src="{{ Auth::user()->avatar ? \Storage::url(Auth::user()->avatar) : 'path/to/default/image.jpg' }}"
                                                        class="rounded-circle img-responsive mt-2" width="128"
                                                        height="128" id="avatarPreview" />
                                                    <div class="mt-2">
                                                        <input style="display: none;" type="file" id="fileInput"
                                                            name="avatar" onchange="previewAvatar(this)">
                                                        <label for="fileInput" class="btn btn-primary"><i
                                                                class="fas fa-upload"></i>Avatar</label>
                                                    </div>
                                                    <small>Để có kết quả tốt nhất, hãy sử dụng hình ảnh có kích thước
                                                        tối thiểu 128px x 128px ở định dạng .jpg</small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            Save changes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- password --}}
                        <div class="tab-pane fade {{ session('tab') == 'password' ? 'show active' : '' }}"
                            id="password" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Password</h5>

                                    <form action="{{ route('account.auth.changePassword', Auth::user()->id) }}"
                                        method="post" id="validation-form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="inputPasswordCurrent">Current password</label>
                                            <input type="password" name="current_password" class="form-control"
                                                id="inputPasswordCurrent" />
                                            <small><a href="{{ route('account.password.request') }}">Forgot your
                                                    password?</a></small>
                                            @error('current_password')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPasswordNew">New password</label>
                                            <input name="password" type="password" class="form-control"
                                                id="inputPasswordNew" />
                                            @error('password')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPasswordNew2">Verify password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                id="inputPasswordNew2" />
                                            @error('password_confirmation')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <button name="submit" type="submit" class="btn btn-primary">
                                            Save changes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
    function previewAvatar(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
