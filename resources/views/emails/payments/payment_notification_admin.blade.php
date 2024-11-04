<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .footer {
            background-color: #f4f4f7;
            color: #666666;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            New Payment Received
        </div>
        <div class="content">
            <p>Hello Admin,</p>
            <p>A payment has been made by <strong>{{ $userName }}</strong> on {{ $paymentDate }}.</p>
            <p>Payment Details:</p>
            <ul>
                <li><strong>Amount:</strong> ${{ number_format($amount, 2) }}</li>
                <li><strong>Date:</strong> {{ $paymentDate }}</li>
            </ul>
            <a href="#" class="button">View Transaction</a>
            <p>Please log in to the system for more details.</p>
            <p>Best regards,<br>{{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
