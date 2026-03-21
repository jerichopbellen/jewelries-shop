@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">User Permissions</h1>
            <p class="text-muted small">Viewing profile for <strong>{{ $user->name }}</strong></p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="fa fa-arrow-left fa-sm"></i> Back to List
        </a>
    </div>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <div class="mb-4">
                            {{-- Image is strictly for display --}}
                            <img src="{{ $user->image_path ? asset('storage/' . $user->image_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0D6EFD&color=fff' }}" 
                                 alt="Profile Photo" 
                                 class="rounded-circle img-thumbnail shadow-sm"
                                 style="width: 160px; height: 160px; object-fit: cover;">
                        </div>

                        <div class="text-start border-top pt-3">
                            <label class="text-muted small fw-bold text-uppercase mb-0">Full Name</label>
                            <p class="h6 mb-3">{{ $user->name }}</p>
                            
                            <label class="text-muted small fw-bold text-uppercase mb-0">Email Address</label>
                            <p class="h6 mb-3">{{ $user->email }}</p>

                            <label class="text-muted small fw-bold text-uppercase mb-0">User ID</label>
                            <p class="h6 mb-0">#{{ $user->id }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Access Control</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            {{-- Role Selection --}}
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="role" class="form-label fw-bold">System Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Active Status Selection --}}
                            <div class="col-md-6">
                                <label for="is_active" class="form-label fw-bold">Account Status</label>
                                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                                    <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactive / Banned</option>
                                </select>
                                @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="p-3 rounded border bg-light">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-info-circle text-primary me-3"></i>
                                <span class="small text-muted">You are only permitted to modify access levels and status. To change user details or photos, the user must update their own profile settings.</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold">
                                Update Permissions
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection