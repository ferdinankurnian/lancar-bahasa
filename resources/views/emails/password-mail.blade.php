<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email - {{ config('app.name') }}</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>

    <p>Welcome to {{ config('app.name') }}! Your account has been created successfully.</p>

    <p>Your password: {{ $password }}</p>

    <p>You can log in to your account at <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>

    <p>Thank you for joining us.</p>
</body>
</html>
