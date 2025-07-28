<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard to manage DECOFI Stage">
	<meta name="author" content="GestionDECOFI">
	<meta name="keywords" content="Student, dashboard, Management, DECOFI, accountant, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title>Gestion DECOFI</title>

	<link href="{{asset('assets/css/assets/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<script src="https://unpkg.com/feather-icons"></script>

</head>

<body>
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Réinitialiser votre mot de passe</h1>
                        <p class="lead">
                            Entrez votre nouveau mot de passe.
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ request()->token }}">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control form-control-lg" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="Entrer votre email" />
                                        @if($errors->has('email'))
                                            <span class="text-danger text-small">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nouveau mot de passe</label>
                                        <input class="form-control form-control-lg" type="password" name="password" required placeholder="Entrer votre nouveau mot de passe" />
                                        @if($errors->has('password'))
                                            <span class="text-danger text-small">
                                                {{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirmer le mot de passe</label>
                                        <input class="form-control form-control-lg" type="password" name="password_confirmation" required placeholder="Confirmer votre mot de passe" />
                                        @if($errors->has('password_confirmation'))
                                            <span class="text-danger text-small">
                                                {{ $errors->first('password_confirmation') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary">Réinitialiser le mot de passe</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

</body>

</html>