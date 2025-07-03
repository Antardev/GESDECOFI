{{-- <!DOCTYPE html>
<html>
<head>
    <title>{{ __('email_verification.subject') }}</title>
</head>
<body>
    <h1>{{ __('email_verification.heading') }}</h1>
    <p>{{ __('email_verification.line_1') }}</p>
    <p>
        <a href="{{ $verificationUrl }}">{{ __('email_verification.action') }}</a>
    </p>
    <p>{{ __('email_verification.line_2') }}</p>
</body>
</html> --}}

<!DOCTYPE html>
<html>
<head>
    <title>{{ __('email_verification.subject') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #0d6efd;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-body {
            padding: 30px;
        }
        .verification-btn {
            background-color: #0d6efd;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s;
        }
        .verification-btn:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }
        .email-footer {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 14px;
        }
        .logo {
            max-height: 50px;
            margin-bottom: 15px;
        }
        .text-white {
            color: white !important;
        }
    </style>
</head>
<body>
    <div class="email-container">

        <div class="email-header">

            <img src="https://via.placeholder.com/150x50?text=Your+Logo" alt="GestionDECOFI Logo" class="logo">
            <h1 class="h3 mb-0">{{ __('email_verification.heading') }}</h1>
        </div>
        
        <div class="email-body">
            <p class="lead">{{ __('email_verification.line_1') }}</p>
            
            <div class="d-grid gap-2 col-md-6 mx-auto">
                <a href="{{ $verificationUrl }}" class="btn verification-btn btn-primary rounded-pill text-white">
                    {{ __('email_verification.action') }}
                </a>
            </div>
            
            <p>{{ __('email_verification.line_2') }}</p>
            
            <div class="alert alert-light mt-4" role="alert">
                <small>
                    {{ __('email_verification.help_text') }}<br>
                    <a href="{{ $verificationUrl }}" class="text-decoration-none">{{ $verificationUrl }}</a>
                </small>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>