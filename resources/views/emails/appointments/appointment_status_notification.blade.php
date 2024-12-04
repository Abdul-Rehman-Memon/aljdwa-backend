<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار حالة الموعد</title>
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
            padding: 10px;
            font-size: 24px;
            color: {{ $appointment['status'] == 'booked' ? '#4CAF50' : '#f44336' }};
        }
        .content p {
            font-size: 16px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{ $appointment['status'] == 'booked' ? 'تم تأكيد الموعد' : 'تم إلغاء الموعد' }}
        </div>
        <div class="content">
            <p>عزيزي/عزيزتي {{ $appointment['first_name'] }} {{ $appointment['last_name'] }},</p>

            @if ($appointment['status'] == 'booked')
                <p>لقد تم تأكيد موعدك. فيما يلي التفاصيل:</p>
                <p><strong>التاريخ:</strong> {{ $appointment['request_date'] }}</p>
                <p><strong>الوقت:</strong> {{ $appointment['request_time'] }}</p>
                <p><strong>رابط الاجتماع:</strong> <a href="{{ $appointment['join_url'] }}">{{ $appointment['join_url'] }}</a></p>
                <p><strong>معرّف الاجتماع:</strong> {{ $appointment['meeting_id'] }}</p>
                <p><strong>كلمة مرور الاجتماع:</strong> {{ $appointment['meeting_password'] }}</p>
                <p>نتطلع إلى رؤيتك!</p>
            @else
                <p>نأسف لإبلاغك بأن طلب الموعد الخاص بك قد تم إلغاؤه. فيما يلي التفاصيل:</p>
                <p><strong>التاريخ:</strong> {{ $appointment['request_date'] }}</p>
                <p><strong>الوقت:</strong> {{ $appointment['request_time'] }}</p>
                <p>نعتذر عن أي إزعاج قد تسبب فيه ذلك.</p>
            @endif
        </div>
        <div class="footer">
            <p>شكرًا لك،<br>الجدوى</p>
        </div>
    </div>
</body>
</html>
