
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vérification de l'email - GestionDECOFI">
    <meta name="author" content="GestionDECOFI">

    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/assets/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/assets/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <title>Vérification de l'Email</title>

    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        
        .verification-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            transition: all 0.3s ease;
            border: none;
        }
        
        .verification-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        .verification-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 50%;
            font-size: 2.5rem;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .resend-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .resend-link:hover {
            color: var(--primary-dark);
            text-decoration: none;
        }
        
        .resend-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .resend-link:hover::after {
            transform: scaleX(1);
        }
        
        .info-alert {
            background-color: rgba(67, 97, 238, 0.1);
            border-left: 4px solid var(--primary);
            border-radius: 8px;
        }
        
        .toast-custom {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border: none;
        }
        
        h1 {
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .lead {
            color: var(--gray);
            line-height: 1.7;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <!-- Toast Notification -->
            @if(session('status'))
            <div class="toast-container position-fixed top-50 start-50 translate-middle p-3" style="z-index: 9999;">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 350px;">
                    <div class="toast-header bg-gradient-primary text-white border-0 rounded-top">
                        <div class="d-flex align-items-center">
                            <div class="pulse-animation me-2">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <strong class="me-auto">Succès</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="toast-body bg-white rounded-bottom shadow-lg p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 text-success me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">Message important</h5>
                                <p class="mb-0">{{ session('status') }}</p>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                 role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <style>
                .bg-gradient-primary {
                    background: linear-gradient(135deg, #4361ee, #3a0ca3);
                }
                
                .pulse-animation {
                    animation: pulse 2s infinite;
                }
                
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.1); }
                    100% { transform: scale(1); }
                }
                
                .toast {
                    border: none;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
                }
                
                .toast-body {
                    border-left: 4px solid #4bb543;
                }
            </style>
        
            @endisset
            
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="verification-card animate__animated animate__fadeInUp">
                            <div class="verification-icon animate__animated animate__bounceIn">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            
                            <h1 class="text-center">{{ __('message.verify_email') }}</h1>
                            
                            <div class="info-alert p-3 mb-4 animate__animated animate__fadeIn">
                                <p class="mb-0">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    {{ __('message.check_your_email') }}
                                </p>
                            </div>
                            
                            <p class="lead text-center mb-4">
                                {{ __('message.if_you_did_not_receive_email') }}
                                <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link resend-link p-0 ms-1">{{ __('message.request_another') }}</button>
                                </form>
                            </p>
                            
                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    {{ __('message.back_to_login') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss after 5 seconds with progress bar animation
        document.addEventListener('DOMContentLoaded', function() {
            const toastEl = document.querySelector('.toast');
            if (toastEl) {
                const progressBar = document.querySelector('.progress-bar');
                let width = 100;
                const interval = setInterval(() => {
                    width -= 0.2;
                    progressBar.style.width = width + '%';
                    if (width <= 0) {
                        clearInterval(interval);
                        const toast = bootstrap.Toast.getInstance(toastEl);
                        if (toast) toast.hide();
                    }
                }, 10);
                
                // Also close on click anywhere
                toastEl.addEventListener('click', function() {
                    const toast = bootstrap.Toast.getInstance(toastEl);
                    if (toast) toast.hide();
                });
            }
        });
    </script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/assets/app.js')}}"></script>
</body>

</html>