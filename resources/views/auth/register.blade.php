@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            {{-- Flash messages --}}
            @include('layouts.flash-messages')

            <div class="card border-0 shadow-sm p-4" 
                 style="background:#fff; border-radius:8px; font-family:'Montserrat','Segoe UI',sans-serif;">
                <h3 class="fw-bold mb-3 text-center" 
                    style="color:#001f3f; letter-spacing:1px; font-weight:600;">
                    <i class="fa fa-user-plus" style="color:#d4af37;"></i> CREATE ACCOUNT
                </h3>

                <form action="{{ route('register') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label" style="color:#001f3f; font-weight:500;">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control shadow-sm @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="color:#001f3f; font-weight:500;">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control shadow-sm @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}" 
                            required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label" style="color:#001f3f; font-weight:500;">
                            Password
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control shadow-sm @error('password') is-invalid @enderror" 
                            required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label" style="color:#001f3f; font-weight:500;">
                            Confirm Password
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="form-control shadow-sm" 
                            required>
                    </div>

                    <button type="submit" 
                            class="btn w-100 py-2" 
                            style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
                        <i class="fa fa-user-plus"></i> JOIN ETHEREAL
                    </button>
                </form>

                <p class="text-center mt-3 small" style="color:#001f3f;">
                    Already have an account? 
                    <a href="{{ route('login') }}" style="color:#d4af37; font-weight:500;">
                        Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection