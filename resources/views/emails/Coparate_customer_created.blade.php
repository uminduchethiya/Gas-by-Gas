<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Gas by Gas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: auto;
        }
        .header {
            background-color: #f4f4f4;
            padding: 10px 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Gas by Gas</h1>
    </div>
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        <p>We’re excited to welcome you to our platform!</p>
        <p>Your account has been activated with the following details:</p>
        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
        </ul>
        <p>You can log in using the button below and change your password after your first login:</p>
        <p style="text-align: center;">
            <a href="{{ $loginUrl }}" style="background-color: #007BFF; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">Login to Your Account</a>
        </p>
        <p>If you have any questions, feel free to reach out to our support team.</p>
        <p>Thank you, <br> The Gas by Gas Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Gas by Gas. All rights reserved.</p>
    </div>
</body>
</html>
