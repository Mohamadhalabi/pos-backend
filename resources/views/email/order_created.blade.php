<!DOCTYPE html>
<html>
<head>
    <title>Order Created</title>
</head>
<body>
    <h1>Order Created</h1>
    <p>Your order has been created successfully. Here are the details:</p>
    <p>Order ID: {{ $order->uuid }}</p>
    <p>Order Total: {{ $order->total }}</p>
    <p>Shipping Address: {{ $order->address }}</p>
    <p>Click the link below to view your order details on WhatsApp:</p>
    <a href="{{ $whatsappLink }}">View Order on WhatsApp</a>
</body>
</html>
