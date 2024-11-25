<!DOCTYPE html>
<html>
<head>
    <title>Appointment Status Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{ $appointment['status'] == 'booked' ? 'Appointment Booked' : 'Appointment Cancelled' }}
        </div>
        <div class="content">
            <p>Dear {{ $appointment['first_name'] }} {{ $appointment['last_name'] }},</p>

            @if ($appointment['status'] == 'booked')
                <p>Your appointment request has been booked. Here are the details:</p>
                <p><strong>Date:</strong> {{ $appointment['request_date'] }}</p>
                <p><strong>Time:</strong> {{ $appointment['request_time'] }}</p>
                <p><strong>Meeting Link:</strong> <a href="{{ $appointment['join_url'] }}">{{ $appointment['join_url'] }}</a></p>
                <p><strong>Meeting Id:</strong> {{ $appointment['meeting_id'] }}</p>
                <p><strong>Meeting Password:</strong> {{ $appointment['meeting_password'] }}</p>
                <p>We look forward to seeing you!</p>
            @else
                <p>We regret to inform you that your appointment request has been cancelled. Here are the details:</p>
                <p><strong>Date:</strong> {{ $appointment['request_date'] }}</p>
                <p><strong>Time:</strong> {{ $appointment['request_time'] }}</p>
                <p>We apologize for any inconvenience this may have caused.</p>
            @endif
        </div>
        <div class="footer">
            <p>Thank you,<br>Aljdwa</p>
        </div>
    </div>
</body>
</html>
