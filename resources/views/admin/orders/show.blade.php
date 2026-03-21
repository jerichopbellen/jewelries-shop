@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">
    {{-- Breadcrumbs & Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none text-muted">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                </ol>
            </nav>
            <h2 class="fw-bold" style="color: #001f3f;">Order #{{ $order->order_number }}</h2>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary px-4 fw-bold shadow-sm">
            <i class="fa fa-arrow-left me-2"></i> BACK TO LIST
        </a>
    </div>

    <div class="row g-4">
        {{-- Left Column: Product Table & Customer Info --}}
        <div class="col-lg-8">
            {{-- Items Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold" style="color: #001f3f;">
                        <i class="fa fa-gem me-2" style="color: #d4af37;"></i> ORDERED ITEMS
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-uppercase text-muted" style="letter-spacing: 1px;">
                                    <th class="ps-4">Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @php $image = $item->product->images->first(); @endphp
                                                <img src="{{ $image ? asset('storage/' . $image->image_path) : asset('images/no-image.png') }}" 
                                                     class="rounded border me-3" 
                                                     style="width: 55px; height: 55px; object-fit: cover;">
                                                <div>
                                                    <span class="fw-bold d-block" style="color: #001f3f;">{{ $item->product->name }}</span>
                                                    <small class="text-muted">SKU: EJ-{{ $item->product_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-muted">₱{{ number_format($item->price, 2) }}</td>
                                        <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                        <td class="text-end pe-4 fw-bold" style="color: #001f3f;">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light-subtle">
                                <tr>
                                    <td colspan="3" class="text-end py-3 text-muted fw-bold">GRAND TOTAL:</td>
                                    <td class="text-end pe-4 py-3 h5 fw-bold" style="color: #d4af37;">₱{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Shipping & Customer Info Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold" style="color: #001f3f;">
                        <i class="fa fa-shipping-fast me-2" style="color: #d4af37;"></i> LOGISTICS & CUSTOMER
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <label class="small text-muted text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">Shipping Address</label>
                            <p class="mb-0 text-dark" style="line-height: 1.6;">
                                <strong class="text-uppercase">{{ $order->user->name }}</strong><br>
                                {{ $order->address }}<br>
                                {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}<br>
                                <span class="fw-bold">{{ strtoupper($order->country) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <label class="small text-muted text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">Contact Information</label>
                            <p class="mb-2"><i class="fa fa-envelope me-2 text-muted"></i>{{ $order->user->email }}</p>
                            <p class="mb-3"><i class="fa fa-phone me-2 text-muted"></i>{{ $order->phone ?? 'No phone provided' }}</p>
                            
                            <label class="small text-muted text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">Payment Method</label>
                            <p class="mb-0 fw-bold text-uppercase" style="color: #001f3f;">
                                <i class="fa fa-credit-card me-2"></i> {{ $order->payment_method }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Admin Actions --}}
        <div class="col-lg-4">
            {{-- Status Update Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: #001f3f; color: white;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color: #d4af37;">MANAGEMENT</h5>
                    
                    <div class="mb-4">
                        <label class="small text-uppercase opacity-75 mb-2" style="letter-spacing: 1px;">Current Status</label>
                        @php
                            $statusColors = [
                                'pending'    => 'bg-warning text-dark',
                                'processing' => 'bg-info text-dark',
                                'shipped'    => 'bg-primary',
                                'delivered'  => 'bg-success',
                                'cancelled'  => 'bg-danger',
                            ];
                            $badgeClass = $statusColors[strtolower($order->status)] ?? 'bg-secondary';
                        @endphp
                        <div class="h4"><span class="badge {{ $badgeClass }} w-100 py-2 text-uppercase">{{ $order->status }}</span></div>
                    </div>

                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="small text-uppercase opacity-75 mb-2" style="letter-spacing: 1px;">Update Status</label>
                            <select name="status" class="form-select border-0 shadow-none py-2">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-light w-100 fw-bold py-2 shadow-sm" style="color: #001f3f;">
                            <i class="fa fa-sync-alt me-2"></i> APPLY CHANGES
                        </button>
                    </form>
                </div>
            </div>

            {{-- Timestamp Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <i class="fa fa-history text-muted" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                    <h6 class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Order Logged</h6>
                    <p class="mb-0 fw-bold h5" style="color: #001f3f;">{{ $order->created_at->format('M d, Y') }}</p>
                    <p class="text-muted mb-0">{{ $order->created_at->format('h:i A') }}</p>
                    <hr class="my-3 mx-5 opacity-10">
                    <small class="text-muted italic">Last updated {{ $order->updated_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for the dropdown to ensure it doesn't look basic */
    .form-select {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #001f3f;
    }
    .form-select:focus {
        border-color: #d4af37;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: #d4af37;
    }
</style>
@endsection