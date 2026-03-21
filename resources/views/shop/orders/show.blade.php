@extends('layouts.base')

@section('body')
<div class="container py-5" style="font-family: 'Montserrat', sans-serif;">
    {{-- Top Navigation & Print --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('shop.orders.index') }}" class="text-decoration-none fw-bold" style="color: #001f3f;">
            <i class="fa fa-chevron-left me-2"></i> BACK TO ORDERS
        </a>
        <button onclick="window.print()" class="btn btn-sm btn-outline-dark px-3 shadow-sm">
            <i class="fa fa-print me-2"></i> PRINT RECEIPT
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        
        @php
            $statusColors = [
                'pending'    => 'bg-warning text-dark',
                'processing' => 'bg-info text-dark',
                'shipped'    => 'bg-primary text-white',
                'delivered'  => 'bg-success text-white',
                'cancelled'  => 'bg-danger text-white',
            ];
            $currentStatus = strtolower($order->status);
            $badgeClass = $statusColors[$currentStatus] ?? 'bg-secondary';
            $isCancellable = in_array($currentStatus, ['pending', 'processing']);
            $isDelivered = $currentStatus === 'delivered';
        @endphp

        {{-- Receipt Header --}}
        <div class="p-5 text-center border-bottom bg-light">
            <h2 class="fw-bold mb-1" style="color:#001f3f; letter-spacing:2px;">ORDER #{{ strtoupper($order->order_number) }}</h2>
            <p class="text-muted small mb-3">Invoice generated on {{ $order->created_at->format('F d, Y') }}</p>
            
            <div class="d-flex justify-content-center align-items-center gap-3">
                <span class="badge rounded-pill px-4 py-2 text-uppercase {{ $badgeClass }}" style="font-size: 0.85rem; letter-spacing: 1px;">
                    {{ $order->status }}
                </span>
            </div>

            @if($isCancellable)
                <div class="mt-4 pt-3 border-top w-50 mx-auto">
                    <form action="{{ route('shop.orders.cancel', $order->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to cancel this exquisite order?');">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger px-4 fw-bold">
                            <i class="fa fa-times-circle me-2"></i> CANCEL THIS ORDER
                        </button>
                    </form>
                    <p class="text-muted small mt-2 italic" style="font-size: 0.75rem;">
                        Note: Orders can only be cancelled before they are marked as Shipped.
                    </p>
                </div>
            @endif
        </div>

        <div class="card-body p-0">
            {{-- Logistics & Payment Info Grid --}}
            <div class="row g-0 border-bottom">
                <div class="col-md-6 border-end p-4">
                    <h6 class="text-uppercase fw-bold mb-3" style="color: #d4af37; font-size: 0.75rem; letter-spacing: 1.5px;">Shipping To</h6>
                    <p class="mb-0 text-dark" style="line-height: 1.8;">
                        <strong style="color: #001f3f;">{{ Auth::user()->name }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}<br>
                        <i class="fa fa-phone me-2 text-muted"></i>{{ $order->phone }}
                    </p>
                </div>
                <div class="col-md-6 p-4 bg-white">
                    <h6 class="text-uppercase fw-bold mb-3" style="color: #d4af37; font-size: 0.75rem; letter-spacing: 1.5px;">Payment Details</h6>
                    <p class="mb-1 fw-bold text-uppercase" style="color: #001f3f;">
                        <i class="fa fa-credit-card me-2"></i> {{ $order->payment_method }}
                    </p>
                    <p class="small text-muted mb-0">Purchased on: {{ $order->created_at->format('h:i A') }}</p>
                    <p class="small text-muted">Transaction Reference: <span class="text-dark">EJ-{{ $order->id }}-{{ $order->created_at->timestamp }}</span></p>
                </div>
            </div>

            {{-- Itemized Table --}}
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead>
                            <tr class="text-muted small text-uppercase border-bottom">
                                <th class="pb-3">Product Description</th>
                                <th class="pb-3 text-center">Unit Price</th>
                                <th class="pb-3 text-center">Quantity</th>
                                <th class="pb-3 text-end">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr class="border-bottom">
                                    <td class="py-4">
                                        <div class="d-flex align-items-center">
                                            @php $img = $item->product->images->first(); @endphp
                                            <img src="{{ $img ? asset('storage/' . $img->image_path) : asset('images/no-image.png') }}" 
                                                 class="rounded me-3 border shadow-sm" style="width:65px; height:65px; object-fit:cover;">
                                            <div>
                                                <span class="fw-bold d-block" style="color: #001f3f;">{{ $item->product->name }}</span>
                                                <small class="text-muted d-block mb-2">ID: #{{ $item->product_id }}</small>
                                                
                                                {{-- Review Button Logic --}}
                                                @if($isDelivered)
                                                    @php $userReview = $item->product->reviews()->where('user_id', Auth::id())->first(); @endphp
                                                    <button type="button" class="btn btn-sm p-0 text-decoration-underline fw-bold" 
                                                            data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->product->id }}"
                                                            style="color: #d4af37; font-size: 0.75rem;">
                                                        <i class="fa {{ $userReview ? 'fa-edit' : 'fa-star' }} me-1"></i>
                                                        {{ $userReview ? 'UPDATE YOUR REVIEW' : 'LEAVE A REVIEW' }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted">₱{{ number_format($item->price, 2) }}</td>
                                    <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold" style="color: #001f3f;">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>

                                {{-- Review Modal per Item --}}
                                @if($isDelivered)
                                <div class="modal fade" id="reviewModal{{ $item->product->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <form action="{{ route('reviews.store', $item->product->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-0 pt-4 px-4">
                                                    <h5 class="fw-bold" style="color:#001f3f;">Review {{ $item->product->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body px-4 text-center">
                                                    <div class="star-rating mb-4">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $item->id }}_{{ $i }}" 
                                                                {{ ($userReview && $userReview->rating == $i) || (!$userReview && $i == 5) ? 'checked' : '' }} class="d-none">
                                                            <label for="star{{ $item->id }}_{{ $i }}" class="fa fa-star fs-3 star-label"></label>
                                                        @endfor
                                                    </div>
                                                    <textarea name="comment" class="form-control border-2 shadow-none p-3 mb-2" rows="4" 
                                                              style="border-radius: 10px; font-size: 0.9rem;"
                                                              placeholder="Describe your experience...">{{ $userReview->comment ?? '' }}</textarea>
                                                </div>
                                                <div class="modal-footer border-0 pb-4 px-4">
                                                    <button type="submit" class="btn w-100 py-2 fw-bold" 
                                                            style="background: #001f3f; color: #d4af37; border: 2px solid #d4af37; border-radius: 8px;">
                                                        SUBMIT REVIEW
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Summary Section --}}
                <div class="row justify-content-end mt-4 px-3">
                    <div class="col-md-5 col-lg-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium">₱{{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Shipping Fee</span>
                            <span class="text-success fw-bold">COMPLIMENTARY</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 fw-bold mb-0" style="color: #001f3f;">TOTAL AMOUNT</span>
                            <span class="h3 fw-bold mb-0" style="color: #d4af37;">₱{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Footer Branding --}}
        <div class="bg-light p-4 text-center">
            <p class="mb-0 small text-muted text-uppercase fw-bold" style="letter-spacing: 2px;">
                Thank you for choosing Ethereal Jewels
            </p>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, nav, footer, .border-top, .italic, button[data-bs-target^="#reviewModal"] { display: none !important; }
        .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        body { background: white !important; }
    }
    .italic { font-style: italic; }
    
    /* Star Rating CSS */
    .star-rating { display: flex; flex-direction: row-reverse; justify-content: center; }
    .star-label { color: #ddd; cursor: pointer; padding: 0 5px; transition: color 0.2s; }
    input[type="radio"]:checked ~ .star-label,
    .star-label:hover,
    .star-label:hover ~ .star-label { color: #d4af37; }
</style>
@endsection