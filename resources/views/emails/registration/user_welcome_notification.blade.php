<!DOCTYPE html>
<html>
<head>
    <title>Welcome to [Your Platform]</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
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
        <h2>Welcome to Aljdwa, {{ $founder_name }}!</h2>
        
        <div class="welcome-message">
            <p>Thank you for registering on our platform. We’re thrilled to have you join us!</p>
        </div>

        <p>Your registration request has been submitted and is currently pending approval. We will notify you once it has been reviewed.</p>
        <p>If you have any questions in the meantime, feel free to reach out to our support team.</p>

        <div class="footer">
            <p>Best regards,</p>
            <p>Aljdwa Team</p>
        </div>
    </div>
</body>
</html>
