@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card border-0 shadow-sm p-4" 
                 style="background:#fff; border-radius:8px; font-family:'Montserrat','Segoe UI',sans-serif;">
                
                <h3 class="fw-bold mb-1 text-center" 
                    style="color:#001f3f; letter-spacing:1px; font-weight:600;">
                    <i class="fa fa-user-plus" style="color:#d4af37;"></i> CREATE ACCOUNT
                </h3>
                <p class="text-center text-muted small mb-4">Start your journey with Ethereal Jewels</p>

                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="mb-4 text-center">
                        <label for="image_path" class="form-label d-block mb-3" style="color:#001f3f; font-weight:500;">
                            Profile Portrait <span class="text-muted fw-normal">(Optional)</span>
                        </label>
                        <div class="d-flex justify-content-center">
                            <div class="position-relative">
                                <img id="preview" src="https://ui-avatars.com/api/?name=User&background=001f3f&color=d4af37" 
                                     class="rounded-circle border shadow-sm mb-2" 
                                     style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #d4af37 !important;">
                                <input type="file" name="image_path" id="image_path" 
                                       class="form-control form-control-sm mt-2 @error('image_path') is-invalid @enderror" 
                                       accept="image/*"
                                       onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])"
                                       style="max-width: 250px; margin: 0 auto; font-size: 0.8rem;">
                            </div>
                        </div>
                        @error('image_path')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label" style="color:#001f3f; font-weight:500;">Full Name</label>
                        <input type="text" name="name" id="name" 
                               class="form-control shadow-sm @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="color:#001f3f; font-weight:500;">Email Address</label>
                        <input type="email" name="email" id="email" 
                               class="form-control shadow-sm @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label" style="color:#001f3f; font-weight:500;">Password</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control shadow-sm @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label" style="color:#001f3f; font-weight:500;">Confirm</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 py-2 mt-2 shadow-sm" 
                            style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
                        <i class="fa fa-gem me-1"></i> JOIN ETHEREAL
                    </button>
                </form>

                <p class="text-center mt-3 small" style="color:#001f3f;">
                    Already have an account? 
                    <a href="{{ route('login') }}" style="color:#d4af37; font-weight:500; text-decoration: none;">
                        Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection