@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="mb-5">
        <h1 class="mb-2" style="color:#001f3f; letter-spacing:1px; font-weight:600;">
            MY ORDERS
        </h1>
        <p class="text-muted">Track and manage all your orders</p>
    </div>

    @include('layouts.flash-messages')

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="fa fa-shopping-bag" style="font-size:3rem; color:#d4af37;"></i>
            <p class="text-muted mt-3 mb-4" style="font-size:1.1rem;">
                No orders yet
            </p>
            <a href="{{ route('shop.index') }}" 
               class="btn px-5" 
               style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px;">
                <i class="fa fa-shopping-cart"></i> START SHOPPING
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-4">
            @foreach($orders as $order)
                <div class="card border-0 shadow-sm hover-shadow" style="transition: box-shadow 0.3s ease;">
                    <div class="card-body p-4">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1" style="color:#001f3f; font-weight:600; font-size:1.1rem;">
                                    Order #{{ $order->order_number }}
                                </h5>
                                <small class="text-muted">{{ $order->created_at->format('M d, Y \a\t H:i A') }}</small>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge 
                                    @if($order->status === 'pending') bg-warning text-dark 
                                    @elseif($order->status === 'completed') bg-success 
                                    @elseif($order->status === 'cancelled') bg-danger 
                                    @else bg-secondary 
                                    @endif" style="padding:0.5rem 1rem; font-size:0.9rem;">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Items Summary -->
                        <div class="mb-4 pb-4" style="border-bottom:1px solid #e0e0e0;">
                            <div class="d-flex flex-column gap-3">
                                @foreach($order->items as $item)
                                    <div class="d-flex gap-3 align-items-center">
                                        <div style="flex-shrink:0;">
                                            @if($item->product->images->first())
                                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                                    alt="{{ $item->product->name }}" 
                                                    style="width:70px; height:70px; object-fit:cover; border-radius:6px; border:1px solid #e0e0e0;">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" 
                                                    alt="No image" 
                                                    style="width:70px; height:70px; object-fit:cover; border-radius:6px; border:1px solid #e0e0e0;">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <p class="mb-1" style="color:#001f3f; font-weight:500; margin:0;">{{ $item->product->name }}</p>
                                            <small class="text-muted d-block">{{ $item->quantity }}x ₱{{ number_format($item->price, 2) }}</small>
                                        </div>
                                        <div style="text-align:right; flex-shrink:0;">
                                            <small style="color:#d4af37; font-weight:600; display:block;">₱{{ number_format($item->quantity * $item->price, 2) }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="row mb-4 text-sm">
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block mb-1">TOTAL</small>
                                <p class="mb-0" style="color:#d4af37; font-weight:600; font-size:1.2rem;">₱{{ number_format($order->total, 2) }}</p>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block mb-1">PAYMENT</small>
                                <p class="mb-0" style="color:#001f3f; font-weight:500;">{{ strtoupper($order->payment_method) }}</p>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('shop.orders.show', $order->id) }}" 
                           class="btn btn-block w-100" 
                           style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:0.5px; padding:0.75rem; font-weight:500;">
                            <i class="fa fa-arrow-right"></i> VIEW DETAILS
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
