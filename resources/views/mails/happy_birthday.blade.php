<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Birthday {{ $employee->name }}! 🎉</title>
    <style type="text/css">
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f7f7f7;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #6e48aa, #9d50bb);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .content {
            padding: 30px 25px;
            text-align: center;
        }

        .content p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .highlight {
            color: #6e48aa;
            font-weight: bold;
        }

        .birthday-img {
            width: 150px;
            margin: 0 auto 20px;
        }

        .footer {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }

        .signature {
            margin-top: 20px;
            font-style: italic;
            color: #555555;
        }

    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 Happy Birthday, {{ $employee->name }}! 🎉</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="birthday-img" style="font-size: 70px;">🎂</div>

            <p>Dear <span class="highlight">{{ $employee->name }}</span>,</p>

            <p>We wanted to take a moment to wish you a <strong>fantastic birthday</strong> tomorrow! 🎈</p>

            <p>Your hard work, creativity, and dedication make a huge difference at <span class="highlight">{{ config('app.name') }}</span>. We’re so grateful to have you on our team.</p>

            <p>May your special day be filled with joy, laughter, and everything that makes you happy!</p>

            <p class="signature">
                Warm regards,<br>
                <b>{{ config('app.name') }} Team</b>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>
            <p><a href="{{ url('/') }}">{{ url('/') }}</a></p>
        </div>
    </div>
</body>

</html>
