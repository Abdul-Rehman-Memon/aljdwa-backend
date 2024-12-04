<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد الموعد</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .header h1 {
            color: #4CAF50;
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>تم استلام طلب الموعد</h1>
        </div>
        <div class="content">
            <p>عزيزي/عزيزتي {{ $appointment['first_name'] }} {{ $appointment['last_name'] }},</p>
            <p>شكرًا لتقديم طلب الموعد. فيما يلي تفاصيل الطلب:</p>
            <p><strong>تاريخ الطلب:</strong> {{ $appointment['request_date'] }}</p>
            <p><strong>وقت الطلب:</strong> {{ $appointment['request_time'] }}</p>
            <p>سنقوم بإبلاغك بمجرد تأكيد الموعد. إذا كان لديك أي استفسارات، لا تتردد في التواصل معنا.</p>
        </div>
        <div class="footer">
            <p>شكرًا لك،<br>الجدوى</p>
        </div>
    </div>
</body>
</html>
