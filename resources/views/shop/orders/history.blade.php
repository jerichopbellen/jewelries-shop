@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">
    <div class="mb-5">
        <h1 class="mb-2" style="color:#001f3f; letter-spacing:1.5px; font-weight:700;">
            ORDER HISTORY
        </h1>
        <p class="text-muted" style="letter-spacing: 0.5px;">Review your past acquisitions and details</p>
    </div>

    @include('layouts.flash-messages')

    @if($orders->isEmpty())
        <div class="text-center py-5 shadow-sm bg-white" style="border-radius: 15px;">
            <i class="fa fa-history mb-3" style="font-size:3.5rem; color:#d4af37; opacity: 0.5;"></i>
            <p class="text-muted mb-4" style="font-size:1.1rem;">You haven't placed any orders yet.</p>
            <a href="{{ route('shop.index') }}" 
               class="btn px-5 py-2 fw-bold" 
               style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px;">
                START YOUR COLLECTION
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-4">
            @foreach($orders as $order)
                <div class="card border-0 shadow-sm transition-hover" 
                     style="border-radius: 12px; transition: all 0.3s ease; border-left: 5px solid #d4af37 !important;">
                    <div class="card-body p-4">
                        
                        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1" style="color:#001f3f; font-weight:700; letter-spacing: 0.5px;">
                                    ORDER #{{ strtoupper($order->order_number) }}
                                </h5>
                                <small class="text-muted fw-medium">
                                    <i class="fa fa-clock me-1"></i> {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                </small>
                            </div>
                            
                            @php
                                $statusStyles = [
                                    'pending'   => 'background: #fff8e1; color: #ff8f00; border: 1px solid #ffe082;',
                                    'paid'      => 'background: #e1f5fe; color: #0288d1; border: 1px solid #b3e5fc;',
                                    'shipped'   => 'background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9;',
                                    'completed' => 'background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7;',
                                    'cancelled' => 'background: #ffebee; color: #c62828; border: 1px solid #ef9a9a;',
                                ];
                                $currentStyle = $statusStyles[strtolower($order->status)] ?? 'background: #f5f5f5; color: #616161; border: 1px solid #bdbdbd;';
                            @endphp
                            
                            <span class="badge rounded-pill px-3 py-2 text-uppercase" style="{{ $currentStyle }} font-weight: 700; font-size: 0.75rem; letter-spacing: 1px;">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="mb-4">
                            @foreach($order->items as $item)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-gem me-2" style="color: #d4af37; font-size: 0.8rem;"></i>
                                    <span class="flex-grow-1 fw-medium" style="color:#001f3f;">{{ $item->product->name }}</span>
                                    <span class="text-muted small">{{ $item->quantity }}x</span>
                                    <span class="ms-3 fw-bold" style="color:#001f3f; min-width: 80px; text-align: right;">
                                        ₱{{ number_format($item->price * $item->quantity, 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <div class="row g-3">
                            <div class="col-md-4">
                                <small class="text-muted d-block text-uppercase fw-bold mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">Shipping To</small>
                                <p class="small mb-0 text-dark" style="line-height: 1.6;">
                                    <strong>{{ Auth::user()->name }}</strong><br>
                                    {{ $order->address }}<br>
                                    {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block text-uppercase fw-bold mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">Payment Method</small>
                                <p class="small mb-0 fw-bold" style="color:#001f3f;">
                                    <i class="fa fa-credit-card me-1"></i> {{ strtoupper($order->payment_method) }}
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">Grand Total</small>
                                <span class="h4 mb-0 fw-bold" style="color:#d4af37;">₱{{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    .transition-hover:hover {
        transform: scale(1.01);
        box-shadow: 0 15px 30px rgba(0,31,63,0.08) !important;
    }
    .page-item.active .page-link {
        background-color: #001f3f !important;
        border-color: #d4af37 !important;
        color: #d4af37 !important;
    }
</style>
@endsection