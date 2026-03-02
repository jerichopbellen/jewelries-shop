@extends('layouts.base')

@section('body')
<div class="container py-5">
    <h1 class="mb-4 text-center" style="color:#001f3f; letter-spacing:1px; font-weight:600;">
        ORDER #{{ $order->order_number }}
    </h1>

    @include('layouts.flash-messages')

    <!-- Order Status -->
    <div class="mb-4 text-center">
        <span class="badge 
            @if($order->status === 'pending') bg-warning text-dark 
            @elseif($order->status === 'completed') bg-success 
            @elseif($order->status === 'cancelled') bg-danger 
            @else bg-secondary 
            @endif" 
            style="padding:0.6rem 1.2rem; font-size:1rem;">
            {{ ucfirst($order->status) }}
        </span>
        <p class="mt-2 text-muted">
            Placed on {{ $order->created_at->format('M d, Y \a\t H:i A') }}
        </p>
    </div>

    <!-- Shipping Details -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-3" style="color:#001f3f; letter-spacing:0.5px;">SHIPPING DETAILS</h4>
            <p style="color:#001f3f; font-size:0.95rem;">
                {{ $order->address }}, {{ $order->city }},
                {{ $order->province }} {{ $order->postal_code }},
                {{ $order->country }} <br>
                <small class="text-muted">Phone: {{ $order->phone }}</small>
            </p>
        </div>
    </div>

    <!-- Items -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h4 class="mb-3" style="color:#001f3f; letter-spacing:0.5px;">ITEMS</h4>
            <table class="table align-middle shadow-sm">
                <thead style="background:#f8f8f8; color:#001f3f; letter-spacing:0.5px;">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if($item->product->images->first())
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" 
                                         alt="{{ $item->product->name }}" 
                                         style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" 
                                         alt="No image" 
                                         style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                                @endif
                            </td>
                            <td style="color:#001f3f; font-weight:500;">{{ $item->product->name }}</td>
                            <td style="color:#d4af37; font-weight:500;">₱{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="color:#d4af37; font-weight:600;">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#f8f8f8;">
                    <tr>
                        <th colspan="4" class="text-end" style="color:#001f3f;">TOTAL:</th>
                        <th style="color:#d4af37; font-weight:600;">₱{{ number_format($order->total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="{{ route('shop.orders.index') }}" 
           class="btn px-5" 
           style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px; font-weight:500;">
            <i class="fa fa-arrow-left"></i> BACK TO MY ORDERS
        </a>
    </div>
</div>
@endsection