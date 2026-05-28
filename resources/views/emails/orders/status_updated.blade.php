<!DOCTYPE html>
<html>
<head>
    <title>Update Status Pesanan</title>
</head>
<body>
    <h1>Update Pesanan Anda</h1>
    <p>Halo {{ $order->buyer->name }},</p>
    <p>Status pesanan Anda (<strong>{{ $order->order_number }}</strong>) telah diperbarui menjadi: <strong>{{ $order->status->label() }}</strong>.</p>
    <p>Terima kasih telah berbelanja di TechCommers.</p>
    <br>
    <p>Salam,<br>Tim TechCommers</p>
</body>
</html>
