@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">
    <div class="mb-5">
        <h1 class="mb-2" style="color:#001f3f; letter-spacing:1.5px; font-weight:700;">ORDER HISTORY</h1>
        <p class="text-muted">Track and review your past acquisitions</p>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-5 shadow-sm bg-white" style="border-radius: 15px;">
            <i class="fa fa-history mb-3" style="font-size:3rem; color:#d4af37; opacity: 0.5;"></i>
            <p class="text-muted mb-4">You haven't placed any orders yet.</p>
            <a href="{{ route('shop.index') }}" class="btn px-5 py-2 fw-bold" style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37;">
                START SHOPPING
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-4">
            @foreach($orders as $order)
                <div class="card border-0 shadow-sm transition-hover" style="border-radius: 12px; border-left: 5px solid #d4af37 !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <h5 class="mb-1 fw-bold" style="color:#001f3f;">ORDER #{{ strtoupper($order->order_number) }}</h5>
                                <small class="text-muted"><i class="fa fa-calendar-alt me-1"></i> {{ $order->created_at->format('M d, Y') }}</small>
                            </div>
                            
                            @php
                                $statusColors = [
                                    'pending'    => 'background: #fff8e1; color: #ff8f00; border: 1px solid #ffe082;',
                                    'processing' => 'background: #e1f5fe; color: #0288d1; border: 1px solid #b3e5fc;',
                                    'shipped'    => 'background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9;',
                                    'delivered'  => 'background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7;',
                                    'cancelled'  => 'background: #ffebee; color: #c62828; border: 1px solid #ef9a9a;',
                                ];
                                $style = $statusColors[strtolower($order->status)] ?? 'background: #f5f5f5; color: #616161;';
                            @endphp
                            
                            <span class="badge rounded-pill px-3 py-2 text-uppercase" style="{{ $style }} font-size: 0.7rem; letter-spacing: 1px;">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">TOTAL AMOUNT</span>
                                <span class="fw-bold h5" style="color: #d4af37;">₱{{ number_format($order->total, 2) }}</span>
                            </div>
                            <a href="{{ route('shop.orders.show', $order->id) }}" class="btn btn-sm px-4 fw-bold" style="background: #001f3f; color: white; border-radius: 5px;">
                                VIEW DETAILS
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection