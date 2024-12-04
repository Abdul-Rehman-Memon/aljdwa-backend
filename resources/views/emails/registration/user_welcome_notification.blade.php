<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مرحباً بك في [منصتك]</title>
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
        .welcome-message {
            margin: 20px 0;
            padding: 15px;
            background-color: #e6f7ff;
            border-radius: 6px;
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
        <h2>مرحباً بك في Aljdwa، {{ $founder_name }}!</h2>
        
        <div class="welcome-message">
            <p>شكراً لتسجيلك في منصتنا. نحن متحمسون لانضمامك إلينا!</p>
        </div>

        <p>تم تقديم طلب تسجيلك وهو قيد المراجعة حالياً. سنقوم بإعلامك فور مراجعة طلبك.</p>
        <p>إذا كان لديك أي استفسارات في هذه الأثناء، لا تتردد في التواصل مع فريق الدعم الخاص بنا.</p>

        <div class="footer">
            <p>أطيب التحيات،</p>
            <p>فريق Aljdwa</p>
        </div>
    </div>
</body>
</html>
