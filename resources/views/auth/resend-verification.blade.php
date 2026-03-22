@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <h4 class="fw-bold mb-3" style="color: #001f3f;">RESEND VERIFICATION</h4>
                    <p class="text-muted small">Enter your email address and we will send you a new verification link.</p>

                    @if (session('success'))
                        <div class="alert alert-success small border-0">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('verification.resend.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-start">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn w-100" style="background-color: #001f3f; color: #d4af37; font-weight: bold;">
                            SEND LINK
                        </button>
                    </form>
                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="small text-muted text-decoration-none">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection