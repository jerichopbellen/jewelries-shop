@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">


            <div class="card border-0 shadow-sm p-4" 
                 style="background:#fff; border-radius:8px; font-family:'Montserrat','Segoe UI',sans-serif;">
                
                <h3 class="fw-bold mb-4 text-center" 
                    style="color:#001f3f; letter-spacing:1px; font-weight:600;">
                    <i class="fa fa-plus" style="color:#d4af37;"></i> ADD CATEGORY
                </h3>

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" style="color:#001f3f; font-weight:500;">Category Name</label>
                        <input type="text" name="name" 
                               class="form-control shadow-sm @error('name') is-invalid @enderror" 
                               placeholder="e.g., Diamond Collections"
                               value="{{ old('name') }}" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" 
                                class="btn px-4" 
                                style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
                            <i class="fa fa-save"></i> SAVE
                        </button>
                        
                        <a href="{{ route('categories.index') }}" 
                           class="btn px-4" 
                           style="background-color:#6c757d; color:#fff; font-weight:500; letter-spacing:0.5px;">
                            <i class="fa fa-times"></i> CANCEL
                        </a>
                    </div>
                </form>
            </div>
            
            <div class="text-center mt-3">
                <small class="text-muted">Tip: Use descriptive names like 'Engagement Rings' or 'Minimalist Earrings'.</small>
            </div>
        </div>
    </div>
</div>
@endsection