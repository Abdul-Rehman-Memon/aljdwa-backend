<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Update Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f7f7f7;
            color: #333;
            padding: 20px;
        }
        .container {
            background: #ffffff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50; /* Green */
        }
        p {
            margin: 0 0 10px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello, {{ $founder_name }}</h1>
        <p>{{ $status_message }}</p>
        <p>If you have any questions, feel free to reach out.</p>
    </div>
    <div class="footer">
        <p>Thank you for using {{ config('app.name') }}!</p>
    </div>
</body>
</html>
