<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center; /* center align content */
        }
        h2 {
            color: #333;
        }
        p {
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #000; /* black button */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: left; /* footer left aligned */
        }
        hr {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello!</h2>
        <p>Please click the button below to verify your email address.</p>

        <a href="{{ route('verify.email', $token) }}" class="btn">Verify Email Address</a>

        <p>If you did not create an account, no further action is required.</p>

        <div class="footer">
            Regards,<br>
            Authentication Team
        </div>

        <hr>

        <div class="footer">
            If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:<br>
            <a href="{{ route('verify.email', $token) }}">{{ route('verify.email', $token) }}</a>
        </div>
    </div>
</body>
</html>
