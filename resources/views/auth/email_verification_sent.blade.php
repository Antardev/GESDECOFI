<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Email de Vérification Envoyé">
    <meta name="author" content="GestionDECOFI">

    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />
    <link href="{{ asset('assets/css/assets/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <title>{{ __('email_verification_sent.verification_email_sent') }}</title>
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle text-center">
                        <h1 class="h2">{{ __('email_verification_sent.verify_email') }}</h1>
                        <p class="lead">
                            {{ __('email_verification_sent.email_sent_to', ['email' => $user->email]) }}
                        </p>
                        <p>
                            {{ __('email_verification_sent.check_your_email') }}
                        </p>
                        <p>
                            {{ __('email_verification_sent.if_you_did_not_receive_email') }}
                            <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">{{ __('email_verification_sent.request_another') }}</button>.
                            </form>
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">{{ __('email_verification_sent.back_to_login') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>