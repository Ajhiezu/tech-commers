<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pesanan</title>
</head>
<body>
    <h1>Terima Kasih atas Pesanan Anda!</h1>
    <p>Halo {{ $order->buyer->name }},</p>
    <p>Pesanan Anda dengan nomor <strong>{{ $order->order_number }}</strong> telah kami terima dan sedang menunggu pembayaran.</p>
    <p>Total Tagihan: Rp {{ number_format($order->total, 0, ',', '.') }}</p>
    <p>Silakan lakukan pembayaran agar pesanan dapat segera diproses.</p>
    <br>
    <p>Salam,<br>Tim TechCommers</p>
</body>
</html>
