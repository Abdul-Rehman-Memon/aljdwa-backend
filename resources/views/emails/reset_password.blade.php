<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: auto; padding: 20px; }
        .header { background: #007BFF; color: white; padding: 10px; text-align: center; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 0.8em; color: gray; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="content">
            <p>Hello, {{ $user->founder_name }}</p>
            <p>Your new password is: <strong>{{ $newPassword }}</strong></p>
            <p>Please log in with the new password and consider changing it after logging in.</p>
            <p>Thank you!</p>
        </div>
        <div class="footer">
            <p>Best Regards,</p>
            <p>The Support Team</p>
        </div>
    </div>
</body>
</html>
