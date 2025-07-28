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
								<h1 class="h2">Commmencez avec nous</h1>
								<p class="lead">
									Inscrivez vous pour commencer à utiliser notre application de gestion de la DECOFI. C'est rapide et facile!
								</p>
							</div>

							<div class="card">
								<div class="card-body">
									<div class="m-sm-3">
										<form method="POST" action="{{ route('register') }}">
										@csrf
										{{-- @if($errors->any())
										<div class="alert alert-danger">
											<ul>
												@foreach($errors->all() as $error)
												<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
										@endif --}}
											<div class="mb-3">
												<label class="form-label">Nom complet </label>
												<input class="form-control form-control-lg @if($errors->has('fullname')) is-invalid @elseif(old('fullname')) is-valid @endif" type="text" name="fullname" value="{{ old('fullname') }}" placeholder="Entrer votre nom complet" />
												@if($errors->has('fullname'))
												<span class="text-danger text-small">
													{{ $errors->first('fullname') }}
												</span>
												@endif
											</div>
											<div class="mb-3">
												<label class="form-label">Email</label>
												<input class="form-control form-control-lg  @if($errors->has('email')) is-invalid @elseif(old('email')) is-valid @endif" type="email" name="email" value="{{ old('email')}}" placeholder="Entrer votre email" />
												@if($errors->has('email'))
												<span class="text-danger text-small">
													{{ $errors->first('email') }}
												</span>
												@endif
											</div>
											<div class="mb-3">
												<label class="form-label">Mot de passe </label>
												<div class="input-group">
													<input class="form-control form-control-lg @if($errors->has('password')) is-invalid @endif" type="password" name="password" id="password" placeholder="Entrer votre mot de passe" />
													<span class="input-group-text btn btn-secondary">
														<i class="align-middle me-2" data-feather="eye" id="password-toggle"></i>
													</span>
												</div>

												@if($errors->has('password'))
												<span class="text-danger text-small">
													{{ $errors->first('password') }}
												</span>
												
												@endif
											</div>
											<div class="mb-3">
												<label class="form-label">Confirmer votre mot de passe </label>
												<div class="input-group">
													<input class="form-control form-control-lg @if($errors->has('password_confirmation')) is-invalid @endif" type="password" name="password_confirmation" id="password-confirm" placeholder="Entrer votre mot de passe" />
													<span class="input-group-text btn btn-secondary">
														<i class="align-middle me-2" data-feather="eye" id="password-confirm-toggle"></i>
													</span>
												</div>
												<div id="passwordMatchError" class="invalid-feedback" style="display: none;">
													Les mots de passe ne correspondent pas
												</div>
												@if($errors->has('password_confirmation'))
	
												<div class="invalid-feedback">
													{{ $errors->first('password_confirmation') }}
												</div>
												@endif
											</div>
											<div class="d-grid gap-2 mt-3">
												<button type="submit"  class="btn btn-lg btn-primary">S'inscrire</a>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="text-center mb-3">
								Avez-vous déjà un compte? <a href="\login">Se connecter</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<script>

			// Initialiser Feather Icons après le chargement du DOM
			document.addEventListener('DOMContentLoaded', function() {
				// Initialiser les icônes Feather
				if (feather) {
					feather.replace();
				}

				// Gestionnaire pour le toggle du mot de passe principal
				document.querySelector('.input-group-text.btn.btn-secondary').addEventListener('click', function(e) {
					e.preventDefault();
					const passwordInput = document.getElementById("password");
					const icon = this.querySelector('i');

					if (passwordInput.type === "password") {
						passwordInput.type = "text";
						icon.setAttribute('data-feather', 'eye-off');
					} else {
						passwordInput.type = "password";
						icon.setAttribute('data-feather', 'eye');
					}

					// Replacer l'icône
					if (feather) {
						feather.replace();
					}
				});

				// Gestionnaire pour le toggle de confirmation du mot de passe
				document.getElementById("password-confirm-toggle").closest('.input-group-text.btn.btn-secondary').addEventListener('click', function(e) {
					e.preventDefault();
					const passwordConfirmInput = document.getElementById("password-confirm");
					const icon = this.querySelector('i');

					if (passwordConfirmInput.type === "password") {
						passwordConfirmInput.type = "text";
						icon.setAttribute('data-feather', 'eye-off');
					} else {
						passwordConfirmInput.type = "password";
						icon.setAttribute('data-feather', 'eye');
					}

					// Replacer l'icône
					if (feather) {
						feather.replace();
					}
				});

				 // Validation de la correspondance des mots de passe
				 const passwordInput = document.getElementById('password');
				const confirmPasswordInput = document.getElementById('password-confirm');
				const passwordMatchError = document.getElementById('passwordMatchError');
				const form = document.getElementById('registerForm');

				function validatePasswordMatch() {
					if (passwordInput.value && confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
						confirmPasswordInput.classList.add('is-invalid');
						passwordMatchError.style.display = 'block';
						return false;
					} else {
						confirmPasswordInput.classList.remove('is-invalid');
						passwordMatchError.style.display = 'none';
						return true;
					}
				}
				// Écouteurs d'événements
				passwordInput.addEventListener('input', validatePasswordMatch);
				confirmPasswordInput.addEventListener('input', validatePasswordMatch);

				// form.addEventListener('submit', function (e) {
				// 	if (!validatePasswordMatch()) {
				// 		e.preventDefault();
				// 	}
				// });


			});
			</script>

</body>

</html>