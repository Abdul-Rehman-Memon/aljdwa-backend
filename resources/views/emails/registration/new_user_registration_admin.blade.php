<!DOCTYPE html>
<html>
<head>
    <title>New User Registration Request</title>
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
        .details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f2f2f2;
            border-radius: 6px;
        }
        .details p {
            margin: 5px 0;
            font-weight: bold;
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
        <h2>New User Registration Request</h2>
        <p>Dear Admin,</p>
        <p>A new user has requested to register on the platform. Please review the details below:</p>
        
        <div class="details">
            <p><strong>Founder Name:</strong> {{ $founder_name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
        </div>

        <p>Please review the registration request and take the necessary action to approve or reject it.</p>

        <div class="footer">
            <p>Thank you,</p>
            <p>Aljdwa Team</p>
        </div>
    </div>
</body>
</html>
