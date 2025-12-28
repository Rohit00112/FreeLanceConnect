<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4CAF50; color: white; padding: 10px 0; text-align: center; }
        .content { margin: 20px 0; }
        .footer { text-align: center; color: #888; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Freelance Connect</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            <p>Thank you for registering with Freelance Connect. We are excited to have you on board!</p>
            <p>Feel free to explore our platform and connect with freelancers and clients to start your projects.</p>
            <p>If you have any questions, please do not hesitate to contact us.</p>
            <p>Best regards,<br>Freelance Connect Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Freelance Connect. All rights reserved.
        </div>
    </div>
</body>
</html>
