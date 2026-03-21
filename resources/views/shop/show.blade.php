@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none text-muted small uppercase">Shop</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted small uppercase">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active small uppercase text-dark fw-bold" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Product Images Column --}}
        <div class="col-lg-7">
            @if($product->images->count())
                <div id="productCarousel" class="carousel slide carousel-fade shadow-sm overflow-hidden rounded-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->images as $index => $image)
                            <div class="carousel-item @if($index === 0) active @endif">
                                <div class="zoom-container">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="d-block w-100 img-main" 
                                         alt="{{ $product->name }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($product->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon p-3 bg-dark rounded-circle" style="width: 1rem; height: 1rem;"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon p-3 bg-dark rounded-circle" style="width: 1rem; height: 1rem;"></span>
                        </button>
                    @endif
                </div>
                
                {{-- Thumbnails --}}
                <div class="d-flex mt-3 gap-2 overflow-auto pb-2">
                    @foreach($product->images as $index => $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                             data-bs-target="#productCarousel" 
                             data-bs-slide-to="{{ $index }}"
                             class="rounded border shadow-sm thumb-img {{ $index === 0 ? 'active-thumb' : '' }}" 
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                    @endforeach
                </div>
            @else
                <div class="rounded-4 overflow-hidden shadow-sm border">
                    <img src="{{ asset('images/no-image.png') }}" class="w-100" style="max-height: 500px; object-fit: cover;">
                </div>
            @endif
        </div>

        {{-- Product Info Column --}}
        <div class="col-lg-5">
            <div class="ps-lg-4">
                <span class="text-uppercase tracking-widest text-muted small mb-2 d-block">{{ $product->category->name }}</span>
                <h1 class="display-6 fw-bold mb-3" style="color: #001f3f;">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center mb-4">
                    <h2 class="fw-bold mb-0 me-3" style="color: #d4af37;">₱{{ number_format($product->price, 2) }}</h2>
                    <span class="badge border text-dark fw-normal px-3 py-2 rounded-pill bg-light">
                        @if($product->stock > 0)
                            <i class="fa fa-check-circle text-success me-1"></i> {{ $product->stock }} in stock
                        @else
                            <i class="fa fa-times-circle text-danger me-1"></i> Out of Stock
                        @endif
                    </span>
                </div>

                <div class="mb-4">
                    <h6 class="text-uppercase fw-bold small text-muted mb-2">Description</h6>
                    <p class="text-secondary leading-relaxed" style="font-size: 0.95rem;">{{ $product->description }}</p>
                </div>

                <hr class="my-4 opacity-50">

                {{-- Add to Cart Form --}}
                @if($product->stock > 0)
                    <form action="{{ route('shop.addToCart', $product->id) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-4">
                                <label class="small fw-bold text-muted text-uppercase mb-2 d-block">Qty</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                       class="form-control form-control-lg text-center border-2" style="border-radius: 10px;">
                            </div>
                            <div class="col-8 d-flex align-items-end">
                                <button type="submit" class="btn btn-lg w-100 py-3 shadow-sm cart-btn"
                                        style="background-color: #001f3f; color: #d4af37; border: 2px solid #d4af37; font-weight: bold; border-radius: 10px;">
                                    <i class="fa fa-shopping-bag me-2"></i> ADD TO CART
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <button class="btn btn-lg w-100 py-3 disabled" style="background: #eee; border-radius: 10px;">SOLD OUT</button>
                @endif
                
                <div class="mt-5 p-4 rounded-4 bg-light border border-dashed border-dark opacity-75">
                    <div class="d-flex align-items-start mb-3">
                        <i class="fa fa-truck me-3 mt-1" style="color: #d4af37;"></i>
                        <div>
                            <h6 class="mb-0 fw-bold small">Insured Shipping</h6>
                            <p class="small text-muted mb-0">Complimentary secure delivery for this exquisite piece.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fa fa-certificate me-3 mt-1" style="color: #d4af37;"></i>
                        <div>
                            <h6 class="mb-0 fw-bold small">Authenticity Guaranteed</h6>
                            <p class="small text-muted mb-0">Comes with a certificate of authenticity and luxury packaging.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Customer Reviews Section --}}
    <div class="mt-5 pt-5 border-top">
        <div class="row g-5">
            {{-- Review Summary --}}
            <div class="col-md-4">
                <div class="p-4 rounded-4 shadow-sm bg-white border">
                    <h4 class="fw-bold mb-3" style="color: #001f3f;">Acquisition Feedback</h4>
                    <div class="d-flex align-items-center mb-2">
                        <div class="text-warning me-2">
                            @php 
                                $avgRating = $product->reviews()->avg('rating') ?? 0;
                                $fullStars = floor($avgRating);
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $fullStars ? 'fas' : 'far' }} fa-star" style="color: #d4af37;"></i>
                            @endfor
                        </div>
                        <span class="fw-bold h5 mb-0">{{ number_format($avgRating, 1) }}</span>
                    </div>
                    <p class="text-muted small">Based on {{ $product->reviews()->count() }} verified reviews</p>
                    <hr>
                    <div class="review-bars">
                        @for($i = 5; $i >= 1; $i--)
                            @php 
                                $count = $product->reviews()->where('rating', $i)->count();
                                $total = $product->reviews()->count();
                                $percent = $total > 0 ? ($count / $total) * 100 : 0;
                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                <span class="small me-2" style="min-width: 50px;">{{ $i }} Stars</span>
                                <div class="progress flex-grow-1" style="height: 6px; background-color: #eee;">
                                    <div class="progress-bar" style="width: {{ $percent }}%; background-color: #d4af37;"></div>
                                </div>
                                <span class="small ms-2 text-muted" style="min-width: 20px;">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Reviews List --}}
            <div class="col-md-8">
                <h5 class="fw-bold mb-4 text-uppercase" style="color: #001f3f; letter-spacing: 1px;">Customer Testimonials</h5>
                @forelse($product->reviews()->latest()->get() as $review)
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star" style="color: #d4af37; font-size: 0.8rem;"></i>
                                    @endfor
                                </div>
                                <h6 class="fw-bold mb-0" style="color: #001f3f;">{{ $review->user->name }}</h6>
                            </div>
                            <span class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <p class="text-secondary mb-0 italic" style="font-size: 0.95rem; line-height: 1.6;">
                            "{{ $review->comment ?? 'No written comment provided.' }}"
                        </p>
                    </div>
                @empty
                    <div class="text-center py-5 bg-light rounded-4">
                        <i class="fa fa-gem mb-3 opacity-25" style="font-size: 2.5rem; color: #001f3f;"></i>
                        <p class="text-muted italic mb-0">No testimonials yet for this exquisite piece.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    <div class="mt-5 pt-5 border-top">
        <h3 class="text-center mb-5 fw-bold" style="color: #001f3f; letter-spacing: 2px;">THE CURATED COLLECTION</h3>
        <div class="row">
            @foreach($relatedProducts as $related)
                <div class="col-6 col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-hover transition-all rounded-4 overflow-hidden">
                        <div class="position-relative overflow-hidden">
                            <a href="{{ route('shop.show', $related->id) }}">
                                <img src="{{ $related->images->first() ? asset('storage/' . $related->images->first()->image_path) : asset('images/no-image.png') }}" 
                                     class="card-img-top related-img" alt="{{ $related->name }}">
                            </a>
                        </div>
                        <div class="card-body px-0 text-center">
                            <h6 class="fw-bold text-dark mb-1">{{ $related->name }}</h6>
                            <p class="small mb-0 fw-bold" style="color: #d4af37;">₱{{ number_format($related->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .tracking-widest { letter-spacing: 0.15em; }
    .leading-relaxed { line-height: 1.7; }
    .img-main { height: 500px; object-fit: cover; transition: transform 0.5s ease; }
    .zoom-container:hover .img-main { transform: scale(1.05); }
    .active-thumb { border: 2px solid #d4af37 !important; }
    .cart-btn:hover { background-color: #d4af37 !important; color: #001f3f !important; transform: translateY(-2px); }
    .related-img { height: 280px; object-fit: cover; transition: all 0.4s ease; }
    .shadow-hover:hover { transform: translateY(-10px); box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important; }
    .shadow-hover:hover .related-img { transform: scale(1.1); }
    .transition-all { transition: all 0.3s ease; }
    .uppercase { text-transform: uppercase; }
    .italic { font-style: italic; }
</style>
@endsection