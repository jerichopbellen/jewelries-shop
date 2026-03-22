@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            @if (session('verification_link'))
                <div class="alert alert-warning border-0 small shadow-sm mb-3">
                    <i class="fa fa-exclamation-circle me-1"></i>
                    {!! session('verification_link') !!}
                </div>
            @endif

            <div class="card border-0 shadow-sm p-4" 
                 style="background:#fff; border-radius:8px; font-family:'Montserrat','Segoe UI',sans-serif;">
                <h3 class="fw-bold mb-3 text-center" 
                    style="color:#001f3f; letter-spacing:1px; font-weight:600;">
                    <i class="fa fa-sign-in-alt" style="color:#d4af37;"></i> LOGIN
                </h3>

                <form action="{{ route('login') }}" method="POST" novalidate>
                    @csrf

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
                            autofocus>
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
                            class="form-control shadow-sm @error('password') is-invalid @enderror" >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="btn w-100 py-2" 
                            style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
                        <i class="fa fa-sign-in-alt"></i> SIGN IN
                    </button>
                </form>

                <p class="text-center mt-3 small" style="color:#001f3f;">
                    New here? 
                    <a href="{{ route('register') }}" style="color:#d4af37; font-weight:500;">
                        Create account
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection