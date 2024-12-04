<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار تعيين مرشد</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            direction: rtl;
            text-align: right;
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
            background-color: #28a745;
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
            margin-top: 0;
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
            <h2>إشعار تعيين مرشد</h2>
        </div>
        <div class="content">
            <h4>مرحبًا {{ $entrepreneurName }}،</h4>
            <p>تهانينا! تم تعيينك كمرشد لـ {{ $mentorName }} بواسطة المسؤول.</p>
            <p>إذا كان لديك أي أسئلة أو تحتاج إلى مزيد من المعلومات، يرجى التواصل معنا.</p>
        </div>
        <div class="footer">
            <p>شكرًا لك،<br>فريق الجدوى</p>
        </div>
    </div>
</body>
</html>
