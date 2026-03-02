@extends('layouts.base')

@section('body')
<div class="container py-5">
    <h1 class="mb-4 text-center" style="color:#001f3f; letter-spacing:1px; font-weight:600;">
        CHECKOUT
    </h1>

    <div class="row g-4">
        {{-- Left Column: Order Summary --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-3" style="color:#001f3f; letter-spacing:0.5px;">ORDER SUMMARY</h4>
                    <table class="table align-middle shadow-sm">
                        <thead style="background:#f8f8f8; color:#001f3f; letter-spacing:0.5px;">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart as $item)
                                @php 
                                    $subtotal = $item['price'] * $item['quantity']; 
                                    $total += $subtotal; 
                                @endphp
                                <tr>
                                    <td style="color:#001f3f; font-weight:500;">
                                        @if(isset($item['image']))
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width:50px; height:50px; object-fit:cover; margin-right:10px;">
                                        @endif
                                        {{ $item['name'] }}
                                    </td>
                                    <td style="color:#d4af37; font-weight:500;">₱{{ number_format($item['price'], 2) }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td style="color:#d4af37; font-weight:500;">₱{{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background:#f8f8f8;">
                            <tr>
                                <th colspan="3" class="text-end" style="color:#001f3f;">TOTAL:</th>
                                <th style="color:#d4af37; font-weight:600;">₱{{ number_format($total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column: Shipping Details --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-3" style="color:#001f3f; letter-spacing:0.5px;">SHIPPING DETAILS</h4>
                    <form action="{{ route('shop.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="phone" class="form-label" style="color:#001f3f; font-weight:500;">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label" style="color:#001f3f; font-weight:500;">Street Address</label>
                            <textarea name="address" id="address" class="form-control shadow-sm" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label" style="color:#001f3f; font-weight:500;">City</label>
                            <input type="text" name="city" id="city" class="form-control shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="province" class="form-label" style="color:#001f3f; font-weight:500;">Province</label>
                            <input type="text" name="province" id="province" class="form-control shadow-sm">
                        </div>
                        <div class="mb-3">
                            <label for="postal_code" class="form-label" style="color:#001f3f; font-weight:500;">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control shadow-sm">
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label" style="color:#001f3f; font-weight:500;">Country</label>
                            <input type="text" name="country" id="country" class="form-control shadow-sm" value="Philippines" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label" style="color:#001f3f; font-weight:500;">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select shadow-sm" required>
                                <option value="cod">Cash on Delivery</option>
                            </select>
                        </div>
                        <button type="submit" 
                                class="btn px-4 mt-3 w-100" 
                                style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px; transition:all 0.3s ease;">
                            <i class="fa fa-credit-card"></i> PLACE ORDER
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection