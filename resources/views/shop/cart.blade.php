@extends('layouts.base')

@section('body')
<div class="container py-5">
    <h1 class="mb-4 text-center" style="color:#001f3f; letter-spacing:1px; font-weight:600;">
        YOUR CART
    </h1>

    @if(empty($cart))
        <p class="text-muted text-center mb-4" style="font-size:1rem; letter-spacing:0.5px;">
            Your cart is empty.
        </p>
        <div class="text-center">
            <a href="{{ route('shop.index') }}" 
               class="btn px-4" 
               style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px;">
                CONTINUE SHOPPING
            </a>
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table align-middle">
                <thead style="background:#f8f8f8; color:#001f3f; letter-spacing:0.5px;">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $key => $item)
                        @php 
                            $subtotal = $item['price'] * $item['quantity']; 
                            $total += $subtotal; 
                        @endphp
                        <tr>
                            <td>
                                @if(!empty($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}"  
                                         alt="{{ $item['name'] }}"  
                                         class="img-thumbnail shadow-sm"  
                                         style="width:80px; object-fit:cover;">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}"  
                                         alt="No image"  
                                         class="img-thumbnail shadow-sm"  
                                         style="width:80px; object-fit:cover;">
                                @endif
                            </td>
                            <td style="color:#001f3f; font-weight:500;">
                                {{ $item['name'] }}
                            </td>
                            <td style="color:#d4af37; font-weight:500;">
                                ₱{{ number_format($item['price'], 2) }}
                            </td>
                            <td>{{ $item['quantity'] }}</td>
                            <td style="color:#d4af37; font-weight:500;">
                                ₱{{ number_format($subtotal, 2) }}
                            </td>
                            <td>
                                <form action="{{ route('shop.removeFromCart', $item['product_id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm px-3" 
                                            style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:0.5px;">
                                        <i class="fa fa-trash"></i> REMOVE
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#f8f8f8;">
                    <tr>
                        <th colspan="4" class="text-end" style="color:#001f3f;">TOTAL:</th>
                        <th colspan="2" style="color:#d4af37; font-weight:600;">
                            ₱{{ number_format($total, 2) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('shop.index') }}" 
               class="btn px-4" 
               style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px;">
                CONTINUE SHOPPING
            </a>
            <a href="{{ route('shop.checkoutForm') }}" 
               class="btn px-4" 
               style="background-color:#001f3f; color:#d4af37; border:2px solid #d4af37; letter-spacing:1px;">
                <i class="fa fa-credit-card"></i> CHECKOUT
            </a>
        </div>
    @endif
</div>
@endsection