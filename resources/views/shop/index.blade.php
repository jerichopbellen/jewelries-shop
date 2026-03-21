@extends('layouts.base')

@section('body')
<div class="container-fluid py-5" style="background: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container">
        <h1 class="mb-2 text-center" style="font-size: 3rem; font-weight: 300; letter-spacing: 2px; color: #d4af37;">
            EXQUISITE COLLECTION
        </h1>
        <p class="text-center mb-5" style="font-size: 0.95rem; letter-spacing: 1px; color: #001f3f;">
            Discover Timeless Elegance
        </p>

        <div class="mb-5 p-4 shadow-sm" style="background: #fcfcfc; border-radius: 8px; border: 1px solid #f0f0f0;">
            <form method="GET" action="{{ route('shop.index') }}" class="row g-3 align-items-end justify-content-center">
                
                {{-- Keyword Search --}}
                <div class="col-md-4">
                    <label class="small text-uppercase fw-bold mb-2" style="color: #001f3f; letter-spacing: 1px;">Search Jewelry</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fa fa-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="form-control border-start-0 shadow-none" placeholder="Find your piece...">
                    </div>
                </div>

                {{-- Category Filter --}}
                <div class="col-md-3">
                    <label class="small text-uppercase fw-bold mb-2" style="color: #001f3f; letter-spacing: 1px;">Category</label>
                    <select name="category" class="form-select shadow-none">
                        <option value="">All Collections</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Price Filter --}}
                <div class="col-md-3">
                    <label class="small text-uppercase fw-bold mb-2" style="color: #001f3f; letter-spacing: 1px;">Price Range (₱)</label>
                    <div class="d-flex gap-2 align-items-center">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control shadow-none" placeholder="Min">
                        <span class="text-muted">-</span>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control shadow-none" placeholder="Max">
                    </div>
                </div>

                {{-- Filter Buttons --}}
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn w-100 fw-bold shadow-sm" 
                            style="background: #001f3f; color: #d4af37; border: 1px solid #d4af37;">
                        FILTER
                    </button>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="fa fa-sync-alt"></i>
                    </a>
                </div>
            </form>
        </div>

        {{-- Product Grid --}}
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('shop.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="card h-100 border-0 shadow-sm product-card" style="transition: all 0.4s ease; background: #fff;">
                            <div style="position: relative; overflow: hidden; background: #f8f8f8; height: 350px;">
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                         class="card-img-top" alt="{{ $product->name }}"
                                         style="height: 100%; width: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" class="card-img-top" style="height: 100%; object-fit: cover;">
                                @endif
                                
                                {{-- Hover Overlay --}}
                                <div class="overlay d-flex align-items-center justify-content-center" 
                                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,31,63,0.1); opacity: 0; transition: opacity 0.3s ease;">
                                </div>
                            </div>

                            <div class="card-body text-center p-4">
                                <h5 class="card-title text-uppercase" style="font-size: 0.95rem; font-weight: 600; color: #001f3f; margin-bottom: 0.5rem;">
                                    {{ $product->name }}
                                </h5>
                                <p class="card-text text-muted mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    {{ $product->category->name }}
                                </p>
                                <p class="mb-3" style="font-size: 1.2rem; font-weight: 500; color: #d4af37;">
                                    ₱{{ number_format($product->price, 2) }}
                                </p>
                                <div class="explore-btn" style="font-size: 0.8rem; font-weight: 700; color: #001f3f; letter-spacing: 2px; border-bottom: 1px solid #d4af37; display: inline-block; padding-bottom: 3px;">
                                    EXPLORE
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fa fa-search mb-3" style="font-size: 2rem; color: #f0f0f0;"></i>
                        <p style="font-size: 1.1rem; color: #001f3f;">No items found matching your criteria.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-link shadow-none" style="color: #d4af37; text-decoration: none;">View All Jewelry</a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
</div>

<style>
    .product-card:hover { transform: translateY(-10px); }
    .product-card:hover img { transform: scale(1.08); }
    .product-card:hover .overlay { opacity: 1; }
    .product-card:hover .explore-btn { color: #d4af37; border-color: #001f3f; }
    .pagination .page-link { color: #001f3f; border: none; }
    .pagination .page-item.active .page-link { background-color: #d4af37; border-color: #d4af37; }
</style>
@endsection