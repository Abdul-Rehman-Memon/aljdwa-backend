<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement Response Notification</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9; }
        h2 { color: #333; }
        p { line-height: 1.6; }
        .highlight { font-weight: bold; color: #444; }
        .status { font-size: 1.2em; font-weight: bold; color: #28a745; }
        .rejected { color: #d9534f; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Agreement {{ ucfirst($responseStatus) }}</h2>
        <p>Dear Admin,</p>
        <p>The user <span class="highlight">{{ $userName }}</span> has <span class="status {{ $responseStatus === 'rejected' ? 'rejected' : '' }}">{{ ucfirst($responseStatus) }}</span> the agreement.</p>

        <p><strong>Agreement Details:</strong></p>
        <p>{{ $agreementDetails }}</p>

        <p>Thank you,<br>The {{ config('app.name') }} Team</p>
    </div>
</body>
</html>
