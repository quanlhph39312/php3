    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-center">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    {{-- <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a> --}}
                    {{-- <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button> --}}
                    <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
                        <div class="navbar-nav mx-auto py-0">
                            <a href="{{ route('/') }}" class="nav-item nav-link active">Home</a>
                            <a href="{{ route('shop') }}" class="nav-item nav-link">Shop</a>
                            <div class="nav-item dropdown">
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.html" class="nav-item nav-link">Contact</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-lg-3 col-3 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="{{ route('cart') }}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge" id="cart-count">{{ count(session()->get('cart', [])) }}</span>
                </a>
                @if (Auth::check())
                    <div class="btn-group">
                        <a href="" class="btn border dropdown-toggle" data-toggle="dropdown">
                            @if (Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar"
                                    class="rounded-circle" style="width: 30px; height: 30px;">
                            @else
                                <i class="fas fa-user text-primary"></i>
                            @endif
                            <span class="badge">
                                {{ \Illuminate\Support\Str::limit(Auth::user()->name, 15) }}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Admin</a>
                            @endif
                            <a href="{{ route('account.auth.profile') }}" class="dropdown-item">Profile</a>
                            <a href="{{ route('account.password.request') }}" class="dropdown-item">Forgot
                                Password</a>
                            <a href="{{ route('account.logout') }}" class="dropdown-item">Logout</a>

                        </div>
                    </div>
                @else
                    <div class="btn-group">
                        <a href="" class="btn border dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-user text-primary"></i>
                            <span class="badge">Guest</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('account.showLogin') }}" class="dropdown-item">Login</a>
                            <a href="{{ route('account.showRegister') }}" class="dropdown-item">Register</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Topbar End -->
