<nav class="navbar navbar-expand-lg navbar-dark sticky-top" 
     style="background: linear-gradient(135deg, #000a1a 0%, #001f3f 100%);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.5);
            font-family: 'Montserrat', sans-serif;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            padding: 1rem 0;">
    <div class="container px-4">
        {{-- Logo Section --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}" 
           style="letter-spacing: 3px; font-weight: 700; color: #fff;">
            <i class="fa fa-gem me-2" style="color: #d4af37; text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);"></i> 
            <span class="text-uppercase" style="font-size: 1.1rem;">Ethereal Jewels</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}" 
                       style="font-weight: 500; transition: color 0.3s ease;">
                        Home
                    </a>
                </li>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-shield-alt text-muted me-1"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark border-0 shadow-lg mt-2" 
                                style="background: #001f3f; border-top: 2px solid #d4af37 !important;">
                                <li><a class="dropdown-item py-2" href="{{ route('products.index') }}"><i class="fa fa-gem me-2"></i> Products</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('categories.index') }}"><i class="fa fa-th-large me-2"></i> Categories</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i class="fa fa-shopping-bag me-2"></i> Orders</a></li>
                                <li><hr class="dropdown-divider bg-secondary"></li>
                                <li><a class="dropdown-item py-2" href="{{ route('users.index') }}"><i class="fa fa-users me-2"></i> User Management</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    {{-- Cart Link --}}
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="{{ route('shop.cart') }}">
                            <i class="fa fa-shopping-cart" style="font-size: 1.1rem;"></i>
                            @php $cartCount = count(session('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" 
                                      style="font-size: 0.65rem; border: 1px solid #000;">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    {{-- User Profile & Logout --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="text-end me-2 d-none d-lg-block">
                                <small class="d-block text-uppercase" 
                                    style="font-size: 0.65rem; 
                                            line-height: 1.2; 
                                            color: rgba(255, 255, 255, 0.6); 
                                            letter-spacing: 0.5px; 
                                            font-weight: 500;">
                                    Logged in as
                                </small>                                
                                <span style="color: #d4af37; font-weight: 600;">{{ Auth::user()->name }}</span>
                            </div>
                            <img src="{{ Auth::user()->image_path ? asset('storage/' . Auth::user()->image_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=d4af37&color=001f3f' }}" 
                                 class="rounded-circle border border-gold" style="width: 35px; height: 35px; object-fit: cover; border-color: #d4af37 !important;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end border-0 shadow-lg mt-2" 
                            style="background: #001f3f; border-top: 2px solid #d4af37 !important;">
                            <li><a class="dropdown-item py-2" href="{{ route('shop.orders.index') }}"><i class="fa fa-list-alt me-2"></i> My Orders</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('shop.orders.history') }}"><i class="fa fa-history me-2"></i> Order History</a></li>
                            <li><hr class="dropdown-divider bg-secondary"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="fa fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-gold px-4" href="{{ route('login') }}" 
                           style="color: #d4af37; border: 1px solid #d4af37; font-weight: 600; border-radius: 0; transition: all 0.3s ease;">
                            LOGIN
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Custom hover effects for Ethereal Jewels */
    .nav-link { color: rgba(255,255,255,0.8) !important; }
    .nav-link:hover, .nav-link.active { color: #d4af37 !important; }
    .dropdown-item:hover { background-color: rgba(212, 175, 55, 0.1) !important; color: #d4af37 !important; }
    .btn-outline-gold:hover { background-color: #d4af37 !important; color: #001f3f !important; }
</style>