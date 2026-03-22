<!DOCTYPE html>
<html>
<head>
    <style>
        body { margin: 0; padding: 0; font-family: 'Arial', sans-serif; background-color: #f4f4f4; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f4f4f4; padding-bottom: 40px; }
        .main { background-color: #ffffff; width: 100%; max-width: 600px; margin: 0 auto; border-spacing: 0; }
        .header { background-color: #001f3f; padding: 30px; text-align: center; }
        .content { padding: 40px 30px; text-align: left; line-height: 1.6; color: #444; }
        .button { background-color: #d4af37; color: #001f3f; padding: 15px 25px; text-decoration: none; font-weight: bold; border-radius: 5px; display: inline-block; margin: 20px 0; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main">
            <tr>
                <td class="header">
                    <h1 style="color: #d4af37; margin: 0; letter-spacing: 3px;">GLOW</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2 style="color: #001f3f;">Order Confirmed!</h2>
                    <p>Hi {{ $order->user->name }},</p>
                    <p>Thank you for your purchase! We've received your order <strong>#{{ $order->order_number }}</strong> and our team is already getting it ready for you.</p>
                    
                    <p>Attached to this email, you will find your official receipt in PDF format.</p>

                    <center>
                        <a href="{{ route('shop.orders.index') }}" class="button">Track My Order</a>
                    </center>

                    <p>If you have any questions about your order, simply reply to this email. We're happy to help!</p>
                    <p>Best regards,<br><strong>The GLOW Team</strong></p>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    <p>&copy; {{ date('Y') }} Ethereak Jewelry Official Store. Philippines.</p>
                    <p>Premium Skincare & Jewelry</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>