<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to the System</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #333;">Welcome, {{ $user->name }}!</h2>

        <p>Your staff account has been successfully created. Below are your details:</p>

        <ul>
            <li><strong>Name:</strong> {{ $user->name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Staff ID:</strong> {{ $user->id_staff }}</li>
            <li><strong>Department:</strong> {{ $user->department }}</li>
            <li><strong>Position:</strong> {{ $user->position }}</li>
        </ul>

        <p>You can now log in using the following credentials:</p>
        <ul>
            <li><strong>Default Password:</strong> password</li>
            <li><a href="{{ url('/login') }}" style="color: #007bff;">Login Here</a></li>
        </ul>

        <p><em>⚠️ Please change your password immediately after logging in for security purposes.</em></p>

        <hr style="margin: 30px 0;">

        <h3 style="color: #007bff;">Join Our Staff Telegram Group</h3>
        <p>To stay updated on announcements, discussions, and important notices, please join our official staff Telegram group:</p>

        <p>
            <a href="{{ $telegramLink }}" style="display: inline-block; padding: 10px 20px; background-color: #34a853; color: white; text-decoration: none; border-radius: 4px;">
                👉 Join Telegram Group
            </a>
        </p>

        <p>If you have any questions, feel free to reach out to the admin.</p>

        <p>Best regards,<br>System Administrator</p>
    </div>
</body>
</html>
