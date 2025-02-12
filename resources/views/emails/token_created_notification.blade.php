<!DOCTYPE html>
<html>
<head>
    <title>Token Created - Gas by Gas</title>
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
        <h1>Your Gas Token is Ready!</h1>
    </div>
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        <p>Your gas token has been successfully created. Here are the details:</p>
        <ul>
            <li><strong>Token ID:</strong> {{ $tokenId }}</li>
            <li><strong>Gas Cylinder Type:</strong> {{ $cylinderType }}</li>
            <li><strong>Number Of cilinders:</strong> {{ $cylinderCount }}</li>

            <li><strong>Price:</strong> LKR {{ number_format($price, 2) }}</li>
            <li><strong>Expiration Date:</strong> {{ $expiresAt }}</li>

        </ul>
        <p>Please ensure to use your token before the expiration date.</p>
        <p>If you have any questions, feel free to contact our support team.</p>
        <p>Thank you, <br> The Gas by Gas Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Gas by Gas. All rights reserved.</p>
    </div>
</body>
</html>
