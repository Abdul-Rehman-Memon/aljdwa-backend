<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HyperPay Card Payment</title>
    <?php
    $checkoutId = '2CABB25A4BF8656A4CC792299A23813B.prod02-vm-tx09';
    $integrity  = 'sha384-8oJNo16Mh47uY71kWWdD5AHLXyaLAD11xNyGaEhulnR0DmHbUVPszTqnTBco3ATl';
    
    ?>
    <script 
	src="https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId=<?php echo $checkoutId?>"integrity="<?php echo $integrity?>"crossorigin="anonymous" async = true>
</script>

</head>
<body>
    <h1>Enter Your Payment Details</h1>
    <!-- Payment Form -->
    <form action="{{ route('hyper.post') }}" class="paymentWidgets" data-brands="VISA MASTER MADA APPLEPAY"></form>

</body>
</html>
