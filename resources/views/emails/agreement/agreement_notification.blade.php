<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement Notification</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
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
        <h2>Agreement Notification</h2>
        <p>Dear {{ $userName }},</p>

        <p>An agreement has been created for you. Below are the details:</p>

        <div class="details">
            <p><strong>Agreement Details:</strong></p>
            <p>{{ $agreementDetails }}</p>
        </div>

        @if($agreementDocumentPath)
            <p>An agreement document is also attached to this email.</p>
        @endif

        <p>Thank you,</p>
        <p>The Admin Team</p>
    </div>
</body>
</html>
