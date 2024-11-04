<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { background-color: #dc3545; color: #fff; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
        .header h2 { margin: 0; }
        .content { padding: 20px; }
        .content h4 { margin-bottom: 10px; color: #555; }
        .content p { margin: 5px 0; }
        .footer { margin-top: 20px; font-size: 0.9em; color: #666; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Meeting Scheduled Notification</h2>
        </div>
        <div class="content">
            <h4>Hi Admin,</h4>
            <p>A meeting has been scheduled between the following users:</p>

            <h4>Meeting Details</h4>
            <p><strong>Sender:</strong> {{ $senderName }} (Role: {{ $senderRole }})</p>
            <p><strong>Receiver:</strong> {{ $receiverName }} (Role: {{ $receiverRole }})</p>
            <p><strong>Agenda:</strong> {{ $agenda }}</p>
            <p><strong>Date & Time:</strong> {{ $meetingDateTime }}</p>
            <p><strong>Meeting Link:</strong> <a href="{{ $link }}" class="btn">Join Meeting</a></p>
            @if($meetingPassword)
                <p><strong>Password:</strong> {{ $meetingPassword }}</p>
            @endif

            <p>If you have any questions or need further assistance, please feel free to reach out.</p>
        </div>
        <div class="footer">
            <p>Thank you,<br>Aljdwa Team</p>
        </div>
    </div>
</body>
</html>
