<!DOCTYPE html>
<html>
<head>
    <title>Important Update: Token Expiration Extended</title>
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
        <h1>Important Update: Token Expiration Extended</h1>
    </div>
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        <p>We wanted to let you know that the expiration period for your token has been extended.</p>
        <p>Here are your updated details:</p>
        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>New Expiration Date:</strong> {{ $newExpirationDate }}</li>
        </ul>
        <p>You can log in using the button below to access your account:</p>
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
