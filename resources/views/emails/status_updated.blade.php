<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #eee; padding: 20px; }
        .header { background-color: #001f3f; color: #d4af37; padding: 10px; text-align: center; }
        .status-box { background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; text-align: center; }
        .footer { font-size: 12px; color: #777; margin-top: 30px; text-align: center; }
        .gold { color: #d4af37; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ethereal Jewelry Official Store</h1>
        </div>

        <h2>Hello, {{ $order->user->name }}!</h2>
        
        <p>We are writing to inform you that the status of your order <strong>#{{ $order->id }}</strong> has changed.</p>

        <div class="status-box">
            <p>New Status: <span class="gold">{{ strtoupper($order->status) }}</span></p>
        </div>

        @if($order->status === 'shipped')
            <p>Your items are now on their way! You can expect delivery soon.</p>
        @elseif($order->status === 'delivered')
            <p>Your order has been marked as delivered. We hope you love your new Ethereal Jewelry products!</p>
        @endif

        <h3>Order Summary:</h3>
        <ul>
            @foreach($order->items as $item)
                <li>{{ $item->product->name }} (x{{ $item->quantity }})</li>
            @endforeach
        </ul>

        <p>If you have any questions, feel free to reply to this email.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Ethereal Jewelry. All rights reserved.</p>
            <p>Premium Jewelry</p>
        </div>
    </div>
</body>
</html>