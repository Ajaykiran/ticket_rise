<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>registration Confirmation</title>
</head>
<body>
<PRE><h1>Thank you for registering!</h1>
    <p>Dear {{ $user->name }},</p>
    <p>Thank you for registering on our website.</p>
    <p>Here are the details you provided:</p>
    <ul>
        <li><strong>Name:</strong> {{ $user->name }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Birth Date:</strong> {{ $user->birth_date }}</li>
        <li><strong>Phone:</strong> {{ $user->phone }}</li>
        <li><strong>Qualification:</strong> {{ $user->qualification }}</li>
        <li><strong>Gender:</strong> {{ $user->gender }}</li>
        <li><strong>Address:</strong> {{ $user->address }}</li>
    </ul>
        <p>Thank you for choosing our website!</p>
                                                          Thanks And Regards,
                                                                    S.ajaykiran<PRE>
</body>
</html>
