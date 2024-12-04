<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار جدولة اجتماع</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            direction: rtl;
            text-align: right;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }
        .header {
            background-color: #dc3545;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content h4 {
            margin-bottom: 10px;
            color: #555;
        }
        .content p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>إشعار جدولة اجتماع</h2>
        </div>
        <div class="content">
            <h4>مرحبًا مشرف،</h4>
            <p>تم جدولة اجتماع بين المستخدمين التاليين:</p>

            <h4>تفاصيل الاجتماع</h4>
            <p><strong>المرسل:</strong> {{ $senderName }} (الدور: {{ $senderRole }})</p>
            <p><strong>المستلم:</strong> {{ $receiverName }} (الدور: {{ $receiverRole }})</p>
            <p><strong>الأجندة:</strong> {{ $agenda }}</p>
            <p><strong>التاريخ والوقت:</strong> {{ $meetingDateTime }}</p>
            <p><strong>رابط الاجتماع:</strong> <a href="{{ $link }}" class="btn">الانضمام إلى الاجتماع</a></p>
            @if($meetingPassword)
                <p><strong>كلمة المرور:</strong> {{ $meetingPassword }}</p>
            @endif

            <p>إذا كان لديك أي استفسارات أو تحتاج إلى مساعدة إضافية، يرجى التواصل معنا.</p>
        </div>
        <div class="footer">
            <p>شكرًا لك،<br>فريق الجدوى</p>
        </div>
    </div>
</body>
</html>
