<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header img {
            width: 100px;
            border-radius: 50%;
        }
        .header h1 {
            margin: 0;
            color: #333333;
            font-size: 24px;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            margin: 5px 0;
            color: #555555;
            font-size: 16px;
        }
        @media (max-width: 600px) {
            .email-container {
                padding: 10px;
            }
            .header h1 {
                font-size: 20px;
            }
            .details p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://via.placeholder.com/100" alt="Logo">
            <h1>Contact Details</h1>
        </div>
        <div class="details">
            <p><strong>Name:</strong> {{ $details['name'] }}</p>
            <p><strong>Email:</strong> {{ $details['email'] }}</p>
            <p><strong>Message:</strong> {{ $details['message'] }}</p>
        </div>
    </div>
</body>
</html>
