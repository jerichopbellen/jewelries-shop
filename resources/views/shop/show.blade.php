@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row">
        {{-- Product Images --}}
        <div class="col-md-6">
            @if($product->images->count())
                <div id="productCarousel" class="carousel slide shadow-sm rounded" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->images as $index => $image)
                            <div class="carousel-item @if($index === 0) active @endif">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="d-block w-100 rounded" 
                                     alt="{{ $product->name }}"
                                     style="object-fit:cover; max-height:450px;">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @else
                <img src="{{ asset('images/no-image.png') }}" 
                     class="img-fluid rounded shadow-sm mb-3" 
                     alt="No image"
                     style="object-fit:cover; max-height:450px;">
            @endif
        </div>

        {{-- Product Info --}}
        <div class="col-md-6">
            <h2 class="fw-bold" style="color:#001f3f; letter-spacing:1px;">
                {{ $product->name }}
            </h2>
            <p class="text-muted mb-2" style="letter-spacing:0.5px;">
                {{ $product->category->name }}
            </p>
            <p class="text-muted mb-3" style="font-size:0.95rem; letter-spacing:0.3px;">
                {{ $product->description }}
            </p>
            <p class="fs-4 fw-bold mb-2" style="color:#d4af37; letter-spacing:0.5px;">
                ₱{{ number_format($product->price, 2) }}
            </p>
            <p class="mb-3" style="color:#001f3f; font-size:0.9rem;">
                Stock: {{ $product->stock }}
            </p>

            {{-- Add to Cart Form --}}
            <form action="{{ route('shop.addToCart', $product->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label for="quantity" class="form-label" style="color:#001f3f; font-weight:500;">
                        Quantity
                    </label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1"  
                           class="form-control shadow-sm" style="width:120px;">
                </div>
                <button type="submit" 
                        class="btn px-4" 
                        style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px; transition:all 0.3s ease;">
                    <i class="fa fa-shopping-cart"></i> ADD TO CART
                </button>
            </form>
        </div>
    </div>

    {{-- Related Products --}}
    <div class="mt-5 py-4" style="background:#f8f8f8;">
        <h4 class="text-center mb-4" style="color:#001f3f; letter-spacing:1px;">
            YOU MAY ALSO LIKE
        </h4>
        <div class="row">
            @foreach($relatedProducts as $related)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm" style="transition:all 0.3s ease; cursor:pointer;">
                        @if($related->images->first())
                            <img src="{{ asset('storage/' . $related->images->first()->image_path) }}" 
                                 class="card-img-top" 
                                 alt="{{ $related->name }}"
                                 style="height:250px; object-fit:cover; transition:transform 0.3s ease;">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" 
                                 class="card-img-top" 
                                 alt="No image"
                                 style="height:250px; object-fit:cover;">
                        @endif
                        <div class="card-body text-center">
                            <h6 class="card-title" style="color:#001f3f; font-weight:500; letter-spacing:0.5px;">
                                {{ $related->name }}
                            </h6>
                            <p class="fw-bold mb-3" style="color:#d4af37;">
                                ₱{{ number_format($related->price, 2) }}
                            </p>
                            <a href="{{ route('shop.show', $related->id) }}" 
                               class="btn btn-sm px-3" 
                               style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:0.5px;">
                                VIEW
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection