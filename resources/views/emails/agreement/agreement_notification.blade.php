<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار الاتفاقية</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; direction: rtl; text-align: right; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        h2 { color: #007bff; }
        .details { margin: 20px 0; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover { background-color: #0056b3; }
    </style>
</head>
<body  dir="rtl">
    <div class="container">
        <h2>إشعار الاتفاقية</h2>
        <p>عزيزي/عزيزتي {{ $userName }},</p>

        <p>تم إنشاء اتفاقية لك. فيما يلي التفاصيل:</p>

        <div class="details">
            <p><strong>تفاصيل الاتفاقية:</strong></p>
            <p>{{ $agreementDetails }}</p>
        </div>

        @if($agreementDocumentPath)
            <p>تم إرفاق مستند الاتفاقية مع هذا البريد الإلكتروني.</p>
        @endif

        <p>شكرًا لك،</p>
        <p>فريق الإدارة</p>
    </div>
</body>
</html>
