<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { background-color: #007bff; color: #fff; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
        .header h2 { margin: 0; }
        .content { padding: 20px; }
        .footer { margin-top: 20px; font-size: 0.9em; color: #666; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Mentor Assigned Notification</h2>
        </div>
        <div class="content">
            <h4>Hi {{ $mentorName }},</h4>
            <p>You have been assigned as a mentor to {{ $entrepreneurName }} by the admin.</p>
            <p>If you have any questions or need further information, please reach out.</p>
        </div>
        <div class="footer">
            <p>Thank you,<br>Aljdwa Team</p>
        </div>
    </div>
</body>
</html>
