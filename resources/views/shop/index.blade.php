@extends('layouts.base')

@section('body')
<div class="container-fluid py-5" style="background: #ffffff;">
    <div class="container">
        <h1 class="mb-2 text-center" style="font-size: 3rem; font-weight: 300; letter-spacing: 2px; color: #d4af37;">
            EXQUISITE COLLECTION
        </h1>
        <p class="text-center mb-5" style="font-size: 0.95rem; letter-spacing: 1px; color: #001f3f;">
            Discover Timeless Elegance
        </p>

        <!-- Filter by Category -->
        <div class="mb-5">
            <form method="GET" action="{{ route('shop.index') }}" class="d-flex justify-content-center gap-3">
                <select name="category" class="form-select" style="width: 250px;" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('shop.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s ease; overflow: hidden; cursor: pointer; background: #fff;">
                            <div style="position: relative; overflow: hidden; background: #f8f8f8; height: 350px;">
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                         class="card-img-top" 
                                         alt="{{ $product->name }}"
                                         style="height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" 
                                         class="card-img-top" 
                                         alt="No image"
                                         style="height: 100%; object-fit: cover;">
                                @endif
                            </div>

                            <div class="card-body text-center p-4">
                                <h5 class="card-title" style="font-size: 1.1rem; font-weight: 500; letter-spacing: 0.5px; color: #001f3f; margin-bottom: 0.5rem;">
                                    {{ $product->name }}
                                </h5>
                                <p class="card-text text-muted mb-3" style="font-size: 0.85rem; letter-spacing: 0.3px;">
                                    {{ $product->category->name }}
                                </p>
                                <p class="mb-4" style="font-size: 1.3rem; font-weight: 400; color: #d4af37; letter-spacing: 0.5px;">
                                    ₱{{ number_format($product->price, 2) }}
                                </p>
                                <span class="btn btn-sm px-4" 
                                       style="background-color: #001f3f; border-color: #d4af37; color: #d4af37; border: 2px solid #d4af37; transition: all 0.3s ease; letter-spacing: 1px; font-size: 0.85rem;">
                                    EXPLORE
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center py-5" style="font-size: 1.1rem; letter-spacing: 0.5px; color: #001f3f;">
                        No products available at the moment.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection