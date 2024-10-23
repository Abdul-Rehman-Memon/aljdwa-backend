<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
            <h1>Welcome to {{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <p>Hello {{ $name ?? 'User' }},</p>
            <p>Thank you for signing up for our platform. We’re excited to have you on board.</p>
            <!-- <p>To get started, please verify your email by clicking the button below:</p> -->
            <!-- <a href="{{ $verification_url ?? '#' }}" class="button">Verify Email</a>
            <p>If you did not sign up for an account, you can safely ignore this email.</p> -->
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>If you need assistance, contact our support team at 
                <a href="mailto:{{ config('mail.support_address', 'support@example.com') }}">
                    {{ config('mail.support_address', 'support@example.com') }}
                </a>.
            </p>
        </div>
    </div>
</body>
</html>
