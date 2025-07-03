<!DOCTYPE html>
<html>
<head>
    <title>{{ __('password_reset.subject') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            background: #fff;
            max-width: 480px;
            margin: 40px auto;
            padding: 32px 24px;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }
        h1 {
            color: #2d7ff9;
            margin-bottom: 18px;
        }
        p {
            margin-bottom: 18px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 12px 28px;
            background: #2d7ff9;
            color: #fff !important;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 18px;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #195bb5;
        }
        .footer {
            font-size: 13px;
            color: #888;
            margin-top: 24px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ __('password_reset.heading') }}</h1>
        <p>{{ __('password_reset.line_1') }}</p>
        <p>
            <a href="{{ $emailResetUrl }}" class="btn">{{ __('password_reset.action') }}</a>
        </p>
        <p>{{ __('password_reset.line_2') }}</p>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>
</body>
</html>
