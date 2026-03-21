@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family:'Montserrat','Segoe UI',sans-serif;">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0" style="color:#001f3f; letter-spacing:1px;">
                    <i class="fa fa-shield-alt" style="color:#d4af37;"></i> USER PERMISSIONS
                </h3>
                <a href="{{ route('users.index') }}" class="btn px-4 shadow-sm" 
                   style="background-color:#6c757d; color:#fff; font-weight:500; letter-spacing:0.5px;">
                    <i class="fa fa-arrow-left fa-sm"></i> BACK TO LIST
                </a>
            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm mb-4" style="border-radius:8px;">
                            <div class="card-body text-center p-4">
                                <div class="mb-4">
                                    <img src="{{ $user->image_path ? asset('storage/' . $user->image_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=001f3f&color=d4af37' }}" 
                                         alt="Profile Photo" 
                                         class="rounded-circle img-thumbnail shadow-sm"
                                         style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #d4af37;">
                                </div>

                                <div class="text-start border-top pt-3">
                                    <label class="small fw-bold text-uppercase mb-0" style="color:#d4af37;">Full Name</label>
                                    <p class="h6 mb-3" style="color:#001f3f;">{{ $user->name }}</p>
                                    
                                    <label class="small fw-bold text-uppercase mb-0" style="color:#d4af37;">Email Address</label>
                                    <p class="h6 mb-3" style="color:#001f3f;">{{ $user->email }}</p>

                                    <label class="small fw-bold text-uppercase mb-0" style="color:#d4af37;">User ID</label>
                                    <p class="h6 mb-0" style="color:#001f3f;">#{{ $user->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm" style="border-radius:8px;">
                            <div class="card-header bg-white py-3 border-0">
                                <h6 class="m-0 font-weight-bold" style="color:#001f3f;">ACCESS CONFIGURATION</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row mb-4">
                                    {{-- Role Selection --}}
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="role" class="form-label" style="color:#001f3f; font-weight:500;">System Role</label>
                                        <select class="form-select shadow-sm @error('role') is-invalid @enderror" id="role" name="role" required>
                                            <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Active Status Selection --}}
                                    <div class="col-md-6">
                                        <label for="is_active" class="form-label" style="color:#001f3f; font-weight:500;">Account Status</label>
                                        <select class="form-select shadow-sm @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                                            <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactive / Banned</option>
                                        </select>
                                        @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="p-3 rounded border-start border-4 mb-4" style="background:#f8f9fa; border-color:#d4af37 !important;">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-info-circle me-3" style="color:#001f3f;"></i>
                                        <span class="small text-muted">You are only permitted to modify access levels and status. User-generated content like photos and personal details are locked for administrative security.</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn px-5 shadow-sm" 
                                            style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
                                        <i class="fa fa-save"></i> UPDATE PERMISSIONS
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection