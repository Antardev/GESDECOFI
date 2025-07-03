<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Verification Email Page">
    <meta name="author" content="GestionDECOFI">

    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
    <link href="{{ asset('assets/css/assets/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <title>Vérification de l'Email</title>
</head>

<body>
    <main class="d-flex w-100">
        
        <div class="container d-flex flex-column">
            
            @if(session('status'))
<div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Succès</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('status') }}
        </div>
    </div>
</div>
@endif
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle text-center">
                        <h1 class="h2">{{ __('message.verify_email') }}</h1>
                        <p class="lead">
                            {{ __('message.check_your_email') }}
                        </p>
                        <p>
                            {{ __('message.if_you_did_not_receive_email') }}
                            <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">{{ __('message.request_another') }}</button>.
                            </form>
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">{{ __('message.back_to_login') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>