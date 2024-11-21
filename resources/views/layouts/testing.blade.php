<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HyperPay Card Payment</title>
    <script 
	src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId=F118790C28EF587C019D2B2C5A40A2D2.uat01-vm-tx03"integrity="sha384-IYx/b++r8lxpr0Qw0QP4TOtBSK61lEHiXKfNGQVAcVBd580LqoBRp26BIzEE2Fqz"crossorigin="anonymous" async = true>
</script>

</head>
<body>
    <h1>Enter Your Payment Details</h1>
    <!-- Payment Form -->
    <form action="{{ route('hyper.post') }}" class="paymentWidgets" data-brands="VISA MASTER MADA APPLEPAY"></form>

</body>
</html>
