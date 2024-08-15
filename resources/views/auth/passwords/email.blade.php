@extends('auth.layouts.master')
@section('content')
    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">{{ __('Reset Password') }}</h5>

                                <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                    colors="primary:#0ab39c" class="avatar-xl"></lord-icon>

                            </div>

                            <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                                @if (session('status'))
                                    {{ session('status') }}
                                @else
                                    Nhập email của bạn và link đổi mật khẩu sẽ được gửi cho bạn!
                                @endif
                            </div>
                            <div class="p-2">
                                <form method="POST" action="{{ route('account.password.email') }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="text-center mt-4">
                                        <button class="btn btn-success w-100"
                                            type="submit">{{ __('Send Password Reset Link') }}</button>
                                    </div>
                                </form><!-- end form -->
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Wait, I remember my password... <a href="auth-signin-basic.html"
                                class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->
@endsection
