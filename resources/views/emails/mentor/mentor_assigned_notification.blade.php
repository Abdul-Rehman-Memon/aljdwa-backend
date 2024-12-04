<!DOCTYPE html>
<html lang="ar" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار تعيين مرشد</title>
    <style>
        body {
            direction: rtl;
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h4 {
            margin-bottom: 10px;
            color: #555;
            font-size: 18px;
        }
        .content p {
            margin: 10px 0;
            font-size: 16px;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
            text-align: center;
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            .content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>إشعار تعيين مرشد</h2>
        </div>
        <div class="content">
            <h4>مرحباً {{ $mentorName }},</h4>
            <p>تم تعيينك كمرشد لـ {{ $entrepreneurName }} من قبل المسؤول.</p>
            <p>إذا كان لديك أي أسئلة أو تحتاج إلى مزيد من المعلومات، لا تتردد في التواصل معنا.</p>
        </div>
        <div class="footer">
            <p>شكراً لك،<br>فريق الجدوة</p>
        </div>
    </div>
</body>
</html>
