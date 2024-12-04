<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            color: #333333;
            margin: 0;
            padding: 0;
            direction: rtl;
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
            تأكيد الدفع
        </div>
        <div class="content">
            <p>عزيزي {{ $userName }}،</p>
            <p>شكرًا لدفعك مبلغ <strong>${{ number_format($amount, 2) }}</strong> الذي تم في {{ $paymentDate }}.</p>
            <p>نحن نقدر سرعة استجابتك ويسعدنا أن نكون جزءًا من مجتمعنا!</p>
            <a href="{{ $detailsLink }}" class="button">عرض التفاصيل</a>
            <p>إذا كانت لديك أي أسئلة، لا تتردد في التواصل مع فريق الدعم لدينا.</p>
            <p>مع أطيب التحيات،<br>فريق {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.
        </div>
    </div>
</body>
</html>
