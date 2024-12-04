<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} البريد الإلكتروني</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            direction: rtl;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #dddddd;
            max-width: 600px;
        }
        .header {
            text-align: center;
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #888888;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>مرحباً بك في {{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <p>مرحباً {{ $name ?? 'المستخدم' }}،</p>
            <p>شكرًا لك على التسجيل في منصتنا. نحن متحمسون لانضمامك إلينا.</p>
            <!-- <p>للبدء، يرجى التحقق من بريدك الإلكتروني من خلال النقر على الزر أدناه:</p> -->
            <!-- <a href="{{ $verification_url ?? '#' }}" class="button">تحقق من البريد الإلكتروني</a>
            <p>إذا لم تقم بالتسجيل للحصول على حساب، يمكنك تجاهل هذا البريد الإلكتروني بأمان.</p> -->
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
            <p>إذا كنت بحاجة إلى المساعدة، يمكنك الاتصال بفريق الدعم لدينا عبر البريد الإلكتروني 
                <a href="mailto:{{ config('mail.support_address', 'support@example.com') }}">
                    {{ config('mail.support_address', 'support@example.com') }}
                </a>.
            </p>
        </div>
    </div>
</body>
</html>
