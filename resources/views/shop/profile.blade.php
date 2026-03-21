@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                    {{-- Profile Header / Cover --}}
                    <div style="height: 120px; background: linear-gradient(135deg, #000a1a 0%, #001f3f 100%);"></div>
                    
                    <div class="card-body p-4 text-center" style="margin-top: -70px;">
                        {{-- Profile Image --}}
                        <div class="position-relative d-inline-block mb-3">
                            <img id="preview" src="{{ Auth::user()->image_path ? asset('storage/' . Auth::user()->image_path) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=d4af37&color=001f3f' }}" 
                                 alt="Profile" 
                                 class="rounded-circle border border-4 border-white shadow-sm" 
                                 style="width: 130px; height: 130px; object-fit: cover; border-color: #ffffff !important;">
                            
                            {{-- Invisible File Input triggered by the Camera Button --}}
                            <label for="image_path" class="btn btn-sm btn-light position-absolute bottom-0 end-0 rounded-circle shadow-sm" style="cursor: pointer;">
                                <i class="fa fa-camera text-muted"></i>
                                <input type="file" name="image_path" id="image_path" class="d-none" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                            </label>
                        </div>

                        {{-- Editable Name --}}
                        <div class="d-flex justify-content-center mb-1">
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                                   class="form-control form-control-lg border-0 text-center fw-bold shadow-none" 
                                   style="color: #001f3f; letter-spacing: 1px; background: transparent; max-width: 400px;" 
                                   placeholder="Your Name">
                        </div>
                        <p class="text-muted small text-uppercase" style="letter-spacing: 2px;">Valued Member</p>
                        
                        <hr class="my-4" style="opacity: 0.1;">

                        <div class="row text-start px-md-4">
                            {{-- Account Information --}}
                            <div class="col-md-6 mb-4">
                                <h6 class="text-uppercase fw-bold mb-3" style="color: #d4af37; font-size: 0.8rem; letter-spacing: 1px;">Account Details</h6>
                                <div class="mb-3">
                                    <label class="small text-muted d-block">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                                           class="form-control border-0 p-0 shadow-none fw-medium" 
                                           style="color: #001f3f; background: transparent;">
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted d-block">Member Since</label>
                                    <span class="fw-medium" style="color: #001f3f; padding-top: 5px; display: block;">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            {{-- Shopping Summary --}}
                            <div class="col-md-6 mb-4">
                                <h6 class="text-uppercase fw-bold mb-3" style="color: #d4af37; font-size: 0.8rem; letter-spacing: 1px;">Shopping Summary</h6>
                                <div class="d-flex gap-3 mt-2">
                                    <a href="{{ route('shop.orders.index') }}" class="text-decoration-none flex-fill">
                                        <div class="p-3 border rounded text-center" style="background: #fcfcfc; border-color: #f0f0f0 !important;">
                                            <i class="fa fa-shopping-bag mb-2" style="color: #001f3f;"></i>
                                            <div class="small text-muted">My Orders</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('shop.cart') }}" class="text-decoration-none flex-fill">
                                        <div class="p-3 border rounded text-center" style="background: #fcfcfc; border-color: #f0f0f0 !important;">
                                            <i class="fa fa-shopping-cart mb-2" style="color: #001f3f;"></i>
                                            <div class="small text-muted">View Cart</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <button type="submit" class="btn btn-sm px-4 fw-bold" 
                                    style="background-color: #001f3f; color: #d4af37; border: 1px solid #d4af37;">
                                SAVE CHANGES
                            </button>
                        </form> {{-- End Form --}}
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger px-4 fw-bold">
                                LOGOUT
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection