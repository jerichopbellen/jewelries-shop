<nav class="navbar navbar-expand-lg navbar-dark" 
     style="background: linear-gradient(135deg, #000a1a 0%, #001428 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            letter-spacing: 1px; padding: 1.5rem 0;">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}" 
           style="font-size: 1rem; letter-spacing: 3px; font-family: 'Montserrat', sans-serif; font-weight: 700;">
            <i class="fa fa-gem" style="color: #FFD700;"></i> Ethereal Jewels
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}" style="transition: all 0.3s ease; font-family: 'Montserrat', sans-serif;">
                        <i class="fa fa-home"></i> Home
                    </a>
                </li>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-family: 'Montserrat', sans-serif;">
                                <i class="fa fa-cog"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="adminDropdown" style="background: linear-gradient(135deg, #001428 0%, #000a1a 100%); font-family: 'Montserrat', sans-serif;">
                                <li><a class="dropdown-item" href="{{ route('products.index') }}"><i class="fa fa-box"></i> Products</a></li>
                                <li><a class="dropdown-item" href="{{ route('categories.index') }}"><i class="fa fa-tags"></i> Categories</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fa fa-clipboard-list"></i> Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="fa fa-users"></i> Users</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link position-relative {{ request()->is('cart') ? 'active' : '' }}" href="{{ route('shop.cart') }}" style="transition: all 0.3s ease; font-family: 'Montserrat', sans-serif;">
                            <i class="fa fa-shopping-cart"></i> Cart
                            @php $cartCount = count(session('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('shop/orders') || request()->is('shop/orders/history') ? 'active' : '' }}"  
                           href="#" id="ordersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="transition: all 0.3s ease; font-family: 'Montserrat', sans-serif;">
                            <i class="fa fa-shopping-bag"></i> Orders
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="ordersDropdown" style="background: linear-gradient(135deg, #001428 0%, #000a1a 100%); font-family: 'Montserrat', sans-serif;">
                            <li><a class="dropdown-item" href="{{ route('shop.orders.index') }}"><i class="fa fa-list"></i> My Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('shop.orders.history') }}"><i class="fa fa-history"></i> Order History</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <span class="nav-link" style="color: #FFD700; font-weight: 500; font-family: 'Montserrat', sans-serif;">{{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background: #FFD700; color: #000a1a; border: none; border-radius: 4px; transition: all 0.3s ease; font-family: 'Montserrat', sans-serif; font-weight: 600;" onmouseover="this.style.background='#FFC700'" onmouseout="this.style.background='#FFD700'">
                                <i class="fa fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-sm" href="{{ route('login') }}" style="background: #FFD700; color: #000a1a; border: none; border-radius: 4px; transition: all 0.3s ease; font-family: 'Montserrat', sans-serif; font-weight: 600;">
                            <i class="fa fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>