<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Payment</title>
</head>
<body>
    <h2>Make Payment</h2>
    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    <form action="{{ route('razorpay.payment.store') }}" method="POST">
        @csrf
        <script
            src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ config('services.razorpay.key') }}"
            data-amount="1000"  {{-- Amount in paise (₹10.00) --}}
            data-currency="INR"
            data-buttontext="Pay ₹10"
            data-name="My Laravel App"
            data-description="Test payment"
            data-image="https://your-logo-url"
            data-prefill.name="Test User"
            data-prefill.email="test@example.com"
            data-theme.color="#F37254">
        </script>
        <input type="hidden" name="hidden">
    </form>
</body>
</html>
