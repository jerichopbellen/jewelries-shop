@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">
    {{-- Top Navigation / Breadcrumb --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('shop.orders.index') }}" class="text-decoration-none fw-bold" style="color: #001f3f;">
            <i class="fa fa-chevron-left me-2"></i> BACK TO ORDERS
        </a>
        <button onclick="window.print()" class="btn btn-sm btn-outline-secondary px-3">
            <i class="fa fa-print me-2"></i> PRINT INVOICE
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        {{-- Header Section --}}
        <div class="p-4 text-center border-bottom" style="background: #fafafa;">
            <h2 class="fw-bold mb-1" style="color:#001f3f; letter-spacing:2px;">ORDER #{{ strtoupper($order->order_number) }}</h2>
            <p class="text-muted small mb-3">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            
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
            
            <span class="badge rounded-pill px-4 py-2 text-uppercase" style="{{ $currentStyle }} font-weight: 700; font-size: 0.85rem; letter-spacing: 1px;">
                {{ $order->status }}
            </span>
        </div>

        <div class="card-body p-0">
            {{-- Information Grid --}}
            <div class="row g-0 border-bottom">
                <div class="col-md-6 border-end p-4">
                    <h6 class="text-uppercase fw-bold mb-3" style="color: #d4af37; font-size: 0.75rem; letter-spacing: 1.5px;">Shipping Destination</h6>
                    <p class="mb-0 text-dark" style="line-height: 1.8;">
                        <strong style="color: #001f3f;">{{ Auth::user()->name }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}<br>
                        {{ strtoupper($order->country) }}<br>
                        <span class="text-muted"><i class="fa fa-phone me-2"></i>{{ $order->phone }}</span>
                    </p>
                </div>
                <div class="col-md-6 p-4 bg-light-subtle">
                    <h6 class="text-uppercase fw-bold mb-3" style="color: #d4af37; font-size: 0.75rem; letter-spacing: 1.5px;">Payment Method</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 bg-white border rounded me-3">
                            <i class="fa fa-credit-card" style="color: #001f3f;"></i>
                        </div>
                        <span class="fw-bold text-uppercase" style="color: #001f3f;">{{ $order->payment_method }}</span>
                    </div>
                    <small class="text-muted d-block">All transactions are secure and encrypted. Thank you for choosing Ethereal Jewels.</small>
                </div>
            </div>

            {{-- Items Table --}}
            <div class="p-4">
                <h6 class="text-uppercase fw-bold mb-4" style="color: #d4af37; font-size: 0.75rem; letter-spacing: 1.5px;">Order Summary</h6>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead>
                            <tr class="text-muted" style="font-size: 0.8rem; border-bottom: 1px solid #eee;">
                                <th class="pb-3" colspan="2">PRODUCT</th>
                                <th class="pb-3 text-center">PRICE</th>
                                <th class="pb-3 text-center">QTY</th>
                                <th class="pb-3 text-end">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr style="border-bottom: 1px solid #fafafa;">
                                    <td style="width: 80px;" class="py-3">
                                        @php $image = $item->product->images->first(); @endphp
                                        <img src="{{ $image ? asset('storage/' . $image->image_path) : 'https://via.placeholder.com/60' }}" 
                                             class="rounded" 
                                             style="width:60px; height:60px; object-fit:cover; border: 1px solid #eee;">
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold d-block" style="color: #001f3f;">{{ $item->product->name }}</span>
                                        <small class="text-muted">SKU: EJ-{{ str_pad($item->product_id, 5, '0', STR_PAD_LEFT) }}</small>
                                    </td>
                                    <td class="py-3 text-center text-muted">₱{{ number_format($item->price, 2) }}</td>
                                    <td class="py-3 text-center">{{ $item->quantity }}</td>
                                    <td class="py-3 text-end fw-bold" style="color: #001f3f;">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Grand Total Section --}}
                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium">₱{{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success fw-medium">FREE</span>
                        </div>
                        <hr class="my-3" style="opacity: 0.1;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 fw-bold mb-0" style="color: #001f3f;">GRAND TOTAL</span>
                            <span class="h4 fw-bold mb-0" style="color: #d4af37;">₱{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-white p-4 border-top-0 text-center">
            <p class="text-muted small mb-0">If you have any questions about your order, please contact our support team at <span style="color: #d4af37;">support@etherealjewels.com</span></p>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, nav, footer, .d-flex.justify-content-between.align-items-center.mb-4 {
            display: none !important;
        }
        .container {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #eee !important;
        }
    }
</style>
@endsection