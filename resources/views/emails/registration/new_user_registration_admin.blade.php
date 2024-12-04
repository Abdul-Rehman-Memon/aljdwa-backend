<!DOCTYPE html>
<html lang="ar">
<head>
    <title>طلب تسجيل مستخدم جديد</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            direction: rtl;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            margin: 10px 0;
        }
        .details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f2f2f2;
            border-radius: 6px;
        }
        .details p {
            margin: 5px 0;
            font-weight: bold;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>طلب تسجيل مستخدم جديد</h2>
        <p>عزيزي المسؤول،</p>
        <p>قد طلب مستخدم جديد التسجيل على المنصة. يرجى مراجعة التفاصيل أدناه:</p>
        
        <div class="details">
            <p><strong>اسم المؤسس:</strong> {{ $founder_name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $email }}</p>
        </div>

        <p>يرجى مراجعة طلب التسجيل واتخاذ الإجراء اللازم للموافقة عليه أو رفضه.</p>

        <div class="footer">
            <p>شكرًا لك،</p>
            <p>فريق الجوى</p>
        </div>
    </div>
</body>
</html>
