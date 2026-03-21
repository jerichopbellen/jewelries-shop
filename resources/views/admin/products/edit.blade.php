@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Flash messages --}}

            <div class="card border-0 shadow-sm p-4" 
                 style="background:#fff; border-radius:8px; font-family:'Montserrat','Segoe UI',sans-serif;">
                <h3 class="fw-bold mb-4 text-center" 
                    style="color:#001f3f; letter-spacing:1px; font-weight:600;">
                    <i class="fa fa-edit" style="color:#d4af37;"></i> EDIT PRODUCT
                </h3>

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Left Column: Product Details --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" style="color:#001f3f; font-weight:500;">Product Name</label>
                                <input type="text" name="name" value="{{ $product->name }}" 
                                       class="form-control shadow-sm" >
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#001f3f; font-weight:500;">Category</label>
                                <select name="category_id" class="form-select shadow-sm" >
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" 
                                            @if($product->category_id == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#001f3f; font-weight:500;">Description</label>
                                <textarea name="description" class="form-control shadow-sm" rows="4" >{{ $product->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#001f3f; font-weight:500;">Price</label>
                                <input type="number" name="price" step="0.01" value="{{ $product->price }}" 
                                       class="form-control shadow-sm" >
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color:#001f3f; font-weight:500;">Stock</label>
                                <input type="number" name="stock" value="{{ $product->stock }}" 
                                       class="form-control shadow-sm" >
                            </div>
                        </div>

                        {{-- Right Column: Images --}}
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" style="color:#001f3f; font-weight:500;">Product Images</label>
                                <input type="file" name="images[]" class="form-control shadow-sm" multiple>
                                <small class="text-muted">Upload new images to replace or add to existing ones.</small>
                            </div>

                            {{-- Show existing images with removal option --}}
                            <div class="mb-3">
                                <label class="form-label" style="color:#001f3f; font-weight:500;">Current Images</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($product->images as $image)
                                        <div class="border p-2 text-center rounded shadow-sm" style="background:#f9f9f9;">
                                            <img src="{{ asset("storage/{$image->image_path}") }}" 
                                                 alt="Product Image" 
                                                 class="img-thumbnail mb-2" 
                                                 style="max-width: 150px; border:1px solid #e0e0e0; border-radius:6px;">
                                            <div class="form-check">
                                                <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="form-check-input" id="removeImage{{ $image->id }}">
                                                <label class="form-check-label small text-muted" for="removeImage{{ $image->id }}">
                                                    Remove
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" 
                                class="btn px-4" 
                                style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; font-weight:600; letter-spacing:0.5px;">
                            <i class="fa fa-save"></i> UPDATE
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