<!DOCTYPE html>
<html>

<head>
    <title>New Contact Message</title>
</head>

<body>
    <h1>New Contact Message</h1>
    <p><strong>Name:</strong> {{ $emailMessage->name }}</p>
    <p><strong>Email:</strong> {{ $emailMessage->email }}</p>
    <p><strong>Message:</strong> {{ $emailMessage->message }}</p>
</body>

</html>
