<!DOCTYPE html>
<html>
<head>
    <title>Updated Gas Cylinder Prices</title>
</head>
<body>
    <h1>Gas Cylinder Price Update</h1>
    <p>The prices for the following gas cylinders have been updated:</p>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>New Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gasCylinders as $cylinder)
            <tr>
                <td>{{ $cylinder['name'] }}</td>
                <td>{{ $cylinder['price'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
