<!DOCTYPE html>
<html>
<head>
    <title>Token Status Update - Gas by Gas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: auto;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 0.9em;
            border-radius: 0 0 8px 8px;
        }
        .details {
            list-style: none;
            padding: 0;
        }
        .details li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .details li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Your Gas Token Status Has Changed
        </div>
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            <p>The status of your gas token has been updated. Here are the details:</p>
            <ul class="details">
                <li><strong>Token ID:</strong> {{ $tokenId }}</li>
                <li><strong>Token Code:</strong> {{ $tokenCode }}</li>
                <li><strong>New Status:</strong> {{ $newStatus }}</li>
                <li><strong>Reasone:</strong> {{ $Reasone }}</li>

            </ul>
            <p>Please check your account for more details or contact our support team if you have any questions.</p>
            <p>Thank you, <br> <strong>The Gas by Gas Team</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Gas by Gas. All rights reserved.
        </div>
    </div>
</body>
</html>
