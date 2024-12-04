<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم تحديد اجتماع - {{ $status }}</title>
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
        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 10px;
            color: #fff;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .btn:hover {
            background-color: #218838;
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
            .btn {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>تم تحديد اجتماع - {{ $status }}</h2>
        </div>
        <div class="content">
            <h4>مرحباً {{ $receiverName }},</h4>
            <p>لقد حدد {{ $senderName }} اجتماعاً معك. يرجى الاطلاع على التفاصيل أدناه:</p>

            <h4>تفاصيل الاجتماع</h4>
            <p><strong>الأجندة:</strong> {{ $agenda }}</p>
            <p><strong>التاريخ والوقت:</strong> {{ $meetingDateTime }}</p>
            <p><strong>رابط الاجتماع:</strong> <a href="{{ $link }}" class="btn">انضم إلى الاجتماع</a></p>
            <p>إذا لم يعمل الزر أعلاه، يمكنك نسخ الرابط التالي ولصقه في متصفحك:</p>
            <p><a href="{{ $link }}">{{ $link }}</a></p>
            @if($meetingPassword)
                <p><strong>كلمة المرور:</strong> {{ $meetingPassword }}</p>
            @endif

            <h4>الحالة</h4>
            <p>الحالة الحالية للاجتماع هي: <strong>{{ $status }}</strong></p>

            <p>إذا كان لديك أي أسئلة أو تحتاج إلى مزيد من المساعدة، لا تتردد في التواصل معنا.</p>
        </div>
        <div class="footer">
            <p>شكراً لك،<br>فريق الجدوة</p>
        </div>
    </div>
</body>
</html>
