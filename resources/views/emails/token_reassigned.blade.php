<!DOCTYPE html>
<html>
<head>
    <title>Your Token Has Been Reassigned</title>
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
        .button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            display: block;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Your Token Has Been Reassigned</h1>
    </div>
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        <p>We wanted to let you know that your token (ID: {{ $tokenId }}) has been reassigned to a new user.</p>
        <p>Please log in to your account using the button below to check your account details:</p>
        <p style="text-align: center;">
            <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
        </p>
        <p>If you have any questions, feel free to contact our support team.</p>
        <p>Thank you, <br> The Gas by Gas Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Gas by Gas. All rights reserved.</p>
    </div>
</body>
</html>
