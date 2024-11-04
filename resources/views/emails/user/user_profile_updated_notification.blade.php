<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Updated Notification</title>
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
        <h2>Profile Update Notification</h2>
        <p>Hello Admin,</p>
        <p>The user <strong>{{ $user->founder_name }}</strong> has updated their profile after it was returned for further modifications. Here are the details:</p>

        <div class="details">
            <p><strong>Founder Name:</strong> {{ $user->founder_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
        </div>

        <p>Please review the updated profile to take further action.</p>

    </div>
</body>
</html>
