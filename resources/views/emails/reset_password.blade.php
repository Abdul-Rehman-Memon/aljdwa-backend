<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب إعادة تعيين كلمة المرور</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; direction: rtl; }
        .container { max-width: 600px; margin: auto; padding: 20px; }
        .header { background: #007BFF; color: white; padding: 10px; text-align: center; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 0.8em; color: gray; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>طلب إعادة تعيين كلمة المرور</h1>
        </div>
        <div class="content">
            <p>مرحباً، {{ $user->founder_name }}</p>
            <p>كلمة المرور الجديدة الخاصة بك هي: <strong>{{ $newPassword }}</strong></p>
            <p>يرجى تسجيل الدخول باستخدام كلمة المرور الجديدة ويفضل تغييرها بعد تسجيل الدخول.</p>
            <p>شكراً لك!</p>
        </div>
        <div class="footer">
            <p>أطيب التحيات،</p>
            <p>فريق الدعم</p>
        </div>
    </div>
</body>
</html>
