<!DOCTYPE html>
<html>
<head>
    <title>Discrepancy Notification</title>
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
        <h1>Discrepancy Notification</h1>
    </div>
    <div class="content">
        <p>Dear Admin,</p>
        <p>A discrepancy has been reported for the following delivery plan:</p>
        <ul>
            <li><strong>Delivery Date:</strong> {{ $deliveryPlan->DeliveryDate }}</li>
            <li><strong>Quantity Planned:</strong> {{ $deliveryPlan->QuantityPlanned }}</li>
            <li><strong>Quantity Received:</strong> {{ $deliveryPlan->QuantityReceived }}</li>
            <li><strong>Status:</strong> {{ $deliveryPlan->Status }}</li>
        </ul>
        <p><strong>Note:</strong></p>
        <p>{{ $note }}</p>
        <p>Please review the details and take the necessary actions.</p>
        <p>Thank you, <br> The Gas by Gas Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Gas by Gas. All rights reserved.</p>
    </div>
</body>
</html>
