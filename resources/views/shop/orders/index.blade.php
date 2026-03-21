@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">
    <div class="mb-5">
        <h1 class="mb-2" style="color:#001f3f; letter-spacing:1.5px; font-weight:700;">
            MY ORDERS
        </h1>
        <p class="text-muted" style="letter-spacing: 0.5px;">Track and manage your exquisite collection</p>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-5 shadow-sm bg-white" style="border-radius: 15px;">
            <i class="fa fa-shopping-bag mb-3" style="font-size:3.5rem; color:#d4af37; opacity: 0.5;"></i>
            <p class="text-muted mb-4" style="font-size:1.1rem;">Your order history is currently empty.</p>
            <a href="{{ route('shop.index') }}" 
               class="btn px-5 py-2 fw-bold" 
               style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px;">
                <i class="fa fa-gem me-2"></i> EXPLORE JEWELRY
            </a>
        </div>
    @else
        <div class="d-flex flex-column gap-4">
            @foreach($orders as $order)
                <div class="card border-0 shadow-sm transition-hover" 
                     style="border-radius: 12px; transition: all 0.3s ease; border-left: 5px solid #001f3f !important;">
                    <div class="card-body p-4">
                        
                        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1" style="color:#001f3f; font-weight:700; letter-spacing: 0.5px;">
                                    ORDER #{{ strtoupper($order->order_number) }}
                                </h5>
                                <small class="text-muted fw-medium">
                                    <i class="fa fa-calendar-alt me-1"></i> {{ $order->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            
                            @php
                                $statusStyles = [
                                    'pending'    => 'background: #fff8e1; color: #ff8f00; border: 1px solid #ffe082;',
                                    'processing' => 'background: #e1f5fe; color: #0288d1; border: 1px solid #b3e5fc;',
                                    'shipped'    => 'background: #e3f2fd; color: #1565c0; border: 1px solid #90caf9;',
                                    'delivered'  => 'background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7;',
                                    'cancelled'  => 'background: #ffebee; color: #c62828; border: 1px solid #ef9a9a;',
                                ];
                                $currentStyle = $statusStyles[strtolower($order->status)] ?? 'background: #f5f5f5; color: #616161; border: 1px solid #bdbdbd;';
                            @endphp
                            
                            <span class="badge rounded-pill px-3 py-2 text-uppercase" style="{{ $currentStyle }} font-weight: 700; font-size: 0.75rem; letter-spacing: 1px;">
                                {{ $order->status }}
                            </span>
                        </div>

                        {{-- Order Preview (Items) --}}
                        <div class="mb-4">
                            @foreach($order->items->take(3) as $item)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        @php $image = $item->product->images->first(); @endphp
                                        <img src="{{ $image ? asset('storage/' . $image->image_path) : asset('images/no-image.png') }}" 
                                             class="rounded shadow-sm"
                                             style="width:55px; height:55px; object-fit:cover; border: 1px solid #f0f0f0;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-bold" style="color:#001f3f; font-size: 0.95rem;">{{ $item->product->name }}</p>
                                        <small class="text-muted">{{ $item->quantity }} x ₱{{ number_format($item->price, 2) }}</small>
                                    </div>
                                </div>
                            @endforeach
                            @if($order->items->count() > 3)
                                <p class="text-muted small ps-1">+ {{ $order->items->count() - 3 }} more items...</p>
                            @endif
                        </div>

                        {{-- Card Footer --}}
                        <div class="pt-3 d-flex justify-content-between align-items-center" style="border-top: 1px solid #f8f9fa;">
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Total Amount</small>
                                <span class="h5 mb-0 fw-bold" style="color:#d4af37;">₱{{ number_format($order->total, 2) }}</span>
                            </div>
                            
                            <a href="{{ route('shop.orders.show', $order->id) }}" 
                               class="btn btn-sm px-4 fw-bold shadow-sm" 
                               style="background-color:#001f3f; color:#d4af37; border:1px solid #d4af37; border-radius: 5px;">
                                DETAILS <i class="fa fa-chevron-right ms-2" style="font-size: 0.7rem;"></i>
                            </a>
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
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,31,63,0.1) !important;
    }
    /* Pagination Theming */
    .page-item.active .page-link {
        background-color: #001f3f !important;
        border-color: #d4af37 !important;
        color: #d4af37 !important;
    }
    .page-link {
        color: #001f3f;
    }
</style>
@endsection