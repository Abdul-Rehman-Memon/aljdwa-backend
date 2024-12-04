<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار بتحديث الملف الشخصي</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; direction: rtl; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        h2 { color: #007bff; }
        .details { margin: 20px 0; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>إشعار بتحديث الملف الشخصي</h2>
        <p>مرحباً Admin،</p>
        <p>قام المستخدم <strong>{{ $user->founder_name }}</strong> بتحديث ملفه الشخصي بعد أن تم إرجاعه لإجراء تعديلات إضافية. إليك التفاصيل:</p>

        <div class="details">
            <p><strong>اسم المؤسس:</strong> {{ $user->founder_name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
            <p><strong>الهاتف:</strong> {{ $user->phone_number }}</p>
        </div>

        <p>يرجى مراجعة الملف الشخصي المحدث لاتخاذ الإجراءات اللازمة.</p>

    </div>
</body>
</html>
