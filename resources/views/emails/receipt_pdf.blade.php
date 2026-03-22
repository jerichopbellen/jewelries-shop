<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #333; font-size: 14px; }
        .invoice-header { border-bottom: 2px solid #001f3f; padding-bottom: 10px; margin-bottom: 20px; }
        .brand { font-size: 28px; font-weight: bold; color: #001f3f; letter-spacing: 2px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th { background-color: #001f3f; color: #d4af37; padding: 10px; text-align: left; }
        .table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total-section { margin-top: 30px; text-align: right; }
        .total-amount { font-size: 18px; font-weight: bold; color: #001f3f; }
        .footer { margin-top: 50px; text-align: center; font-size: 11px; color: #999; }
    </style>
</head>
<body>
    <div class="invoice-header">
        <table style="width: 100%;">
            <tr>
                <td class="brand">Ethereal Jewelry</td>
                <td style="text-align: right;">
                    <strong>Order Summary</strong><br>
                    ID: {{ $order->order_number }}<br>
                    Date: {{ $order->created_at->format('M d, Y') }}
                </td>
            </tr>
        </table>
    </div>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td>
                <strong>Billed To:</strong><br>
                {{ $order->user->name }}<br>
                {{ $order->phone }}
            </td>
            <td style="text-align: right;">
                <strong>Shipping Address:</strong><br>
                {{ $order->address }}<br>
                {{ $order->city }}, {{ $order->province }}<br>
                {{ $order->country }}
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($order->items as $item)
                @php 
                    $sub = $item->price * $item->quantity; 
                    $grandTotal += $sub;
                @endphp
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">₱{{ number_format($item->price, 2) }}</td>
                    <td style="text-align: right;">₱{{ number_format($sub, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p>Payment Method: {{ strtoupper($order->payment_method) }}</p>
        <p class="total-amount">Total Paid: ₱{{ number_format($grandTotal, 2) }}</p>
    </div>

    <div class="footer">
        <p>Thank you for shopping with Ethereak Jewelry. Stay Radiant.</p>
        <p>This is a computer-generated receipt. No signature required.</p>
    </div>
</body>
</html>