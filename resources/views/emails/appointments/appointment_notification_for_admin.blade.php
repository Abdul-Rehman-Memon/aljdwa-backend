<!DOCTYPE html>
<html>
<head>
    <title>New Appointment Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .header h1 {
            color: #ff5722;
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Appointment Request</h1>
        </div>
        <div class="content">
            <p>A new appointment request has been submitted. Here are the details:</p>
            <p><strong>Name:</strong> {{ $appointment['first_name'] }} {{ $appointment['last_name'] }}</p>
            <p><strong>Email:</strong> {{ $appointment['email'] }}</p>
            <p><strong>Phone:</strong> {{ $appointment['phone'] }}</p>
            <p><strong>Request Date:</strong> {{ $appointment['request_date'] }}</p>
            <p><strong>Request Time:</strong> {{ $appointment['request_time'] }}</p>
            <p>Please review and approve the appointment at your earliest convenience.</p>
        </div>
        <div class="footer">
            <p>Thank you,<br>Aljdwa</p>
        </div>
    </div>
</body>
</html>
