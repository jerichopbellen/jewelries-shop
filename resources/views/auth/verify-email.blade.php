@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                <div class="card-body p-5">
                    <i class="fa fa-envelope-open-text fa-4x mb-4" style="color: #d4af37;"></i>
                    <h2 class="fw-bold" style="color: #001f3f;">VERIFY YOUR EMAIL</h2>
                    <p class="text-muted mb-4">
                        Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you.
                    </p>

                    <div class="d-grid gap-3">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-2" style="background-color: #001f3f; border: none; font-weight: 600; letter-spacing: 1px;">
                                RESEND VERIFICATION EMAIL
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none" style="color: #6c757d; font-size: 0.9rem;">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection