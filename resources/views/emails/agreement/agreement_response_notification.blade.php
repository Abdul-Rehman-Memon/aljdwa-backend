<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار رد على الاتفاقية</title>
    <style>
        body { font-family: Arial, sans-serif; direction: rtl; text-align: right; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9; }
        h2 { color: #333; }
        p { line-height: 1.6; }
        .highlight { font-weight: bold; color: #444; }
        .status { font-size: 1.2em; font-weight: bold; color: #28a745; }
        .rejected { color: #d9534f; }
    </style>
</head>
<body dir="rtl" >
    <div class="container">
        <h2>تم {{ ucfirst($responseStatus) }} الاتفاقية</h2>
        <p>عزيزي المسؤول،</p>
        <p>قام المستخدم <span class="highlight">{{ $userName }}</span> <span class="status {{ $responseStatus === 'rejected' ? 'rejected' : '' }}">{{ ucfirst($responseStatus) === 'Rejected' ? 'برفض' : 'بقبول' }}</span> الاتفاقية.</p>

        <p><strong>تفاصيل الاتفاقية:</strong></p>
        <p>{{ $agreementDetails }}</p>

        <p>شكرًا لك،<br>فريق {{ config('app.name') }}</p>
    </div>
</body>
</html>
