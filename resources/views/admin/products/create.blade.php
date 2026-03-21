@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm p-4" 
                 style="background:#fff; border-radius:8px; font-family:'Montserrat','Segoe UI',sans-serif;">
                <h3 class="fw-bold mb-4 text-center" 
                    style="color:#001f3f; letter-spacing:1px; font-weight:600;">
                    <i class="fa fa-plus" style="color:#d4af37;"></i> ADD PRODUCT
                </h3>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" style="color:#001f3f; font-weight:500;">Product Name</label>
                        <input type="text" name="name" class="form-control shadow-sm" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color:#001f3f; font-weight:500;">Category</label>
                        <select name="category_id" class="form-select shadow-sm" >
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color:#001f3f; font-weight:500;">Description</label>
                        <textarea name="description" class="form-control shadow-sm" rows="4" ></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color:#001f3f; font-weight:500;">Price</label>
                        <input type="number" name="price" step="0.01" class="form-control shadow-sm" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color:#001f3f; font-weight:500;">Stock</label>
                        <input type="number" name="stock" class="form-control shadow-sm" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color:#001f3f; font-weight:500;">Product Images</label>
                        <input type="file" name="images[]" class="form-control shadow-sm" multiple>
                        <small class="text-muted">You can select multiple images.</small>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" 
                                class="btn px-4" 
                                style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
                            <i class="fa fa-save"></i> SAVE
                        </button>
                        <a href="{{ route('products.index') }}" 
                           class="btn px-4" 
                           style="background-color:#6c757d; color:#fff; font-weight:500; letter-spacing:0.5px;">
                            <i class="fa fa-times"></i> CANCEL
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection