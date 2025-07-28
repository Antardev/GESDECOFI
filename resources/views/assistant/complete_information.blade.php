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
								<h1 class="h2">Avant de Continuer</h1>
								<p class="lead">
                                    Completez vos informations.
								</p>
							</div>

							<div class="card">
								<div class="card-body">
									<div class="m-sm-3">
									<form method="POST" action="{{ route('assistant.complete') }}" enctype="multipart/form-data">
										@csrf
										@if($errors->any())
										<div class="alert alert-danger">
											<ul>
												@foreach($errors->all() as $error)
												<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
										@endif
											<div class="mb-3">
												<label class="form-label">Nom</label>
												<input class="form-control form-control-lg @if($errors->has('first_name')) is-invalid @elseif(old('first_name')) is-valid @endif" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Entrer votre nom" required/>
												@if($errors->has('first_name'))
												<span class="text-danger text-small">
													{{ $errors->first('first_name') }}
												</span>
												@endif
											</div>

                                            <div class="mb-3">
												<label class="form-label">Prénom</label>
												<input class="form-control form-control-lg @if($errors->has('name')) is-invalid @elseif(old('name')) is-valid @endif" type="text" name="name" value="{{ old('name') }}" placeholder="Entrer votre prénom" required/>
												@if($errors->has('name'))
												<span class="text-danger text-small">
													{{ $errors->first('name') }}
												</span>
												@endif
											</div>

                                            <div class="mb-3">
												<label class="form-label">Téléphone</label>
												<input class="form-control form-control-lg @if($errors->has('phone')) is-invalid @elseif(old('phone')) is-valid @endif" type="text" name="phone" value="{{ old('phone') }}" placeholder="Entrer votre numéro de téléphone" required/>
												@if($errors->has('phone'))
												<span class="text-danger text-small">
													{{ $errors->first('phone') }}
												</span>
												@endif
											</div>

                                            <div class="mb-3">
												<label class="form-label">Pays </label>
												<input class="form-control form-control-lg @if($errors->has('country')) is-invalid @elseif(old('country')) is-valid @endif" type="text" name="country" value="{{ old('country') }}" placeholder="Entrer votre Pays" required/>
												@if($errors->has('country'))
												<span class="text-danger text-small">
													{{ $errors->first('country') }}
												</span>
												@endif
											</div>


                                            <div class="mb-3">
												<label class="form-label">Ville </label>
												<input class="form-control form-control-lg @if($errors->has('city')) is-invalid @elseif(old('city')) is-valid @endif" type="text" name="city" value="{{ old('city') }}" placeholder="Entrer votre Ville" required/>
												@if($errors->has('city'))
												<span class="text-danger text-small">
													{{ $errors->first('city') }}
												</span>
												@endif
											</div>

                                            <div class="mb-3">
												<label class="form-label">Date de naissance </label>
												<input class="form-control form-control-lg @if($errors->has('birth_date')) is-invalid @elseif(old('birth_date')) is-valid @endif" type="date" name="birth_date" value="{{ old('birth_date') }}" max="{{date('Y-m-d')}}" required/>
												@if($errors->has('birth_date'))
												<span class="text-danger text-small">
													{{ $errors->first('birth_date') }}
												</span>
												@endif
											</div>

                                            <div class="mb-3">
												<label class="form-label">Date d'embauche </label>
												<input class="form-control form-control-lg @if($errors->has('hire_date')) is-invalid @elseif(old('hire_date')) is-valid @endif" type="date" name="hire_date" value="{{ old('hire_date') }}" max="{{date('Y-m-d')}}" required/>
												@if($errors->has('hire_date'))
												<span class="text-danger text-small">
													{{ $errors->first('hire_date') }}
												</span>
												@endif
											</div>

                                            <div class="mb-3">
												<label class="form-label">Numéro Cnss </label>
												<input class="form-control form-control-lg @if($errors->has('cnss_number')) is-invalid @elseif(old('cnss_number')) is-valid @endif" type="text" name="cnss_number" value="{{ old('cnss_number') }}" placeholder="Entrer votre numéro cnss" required/>
												@if($errors->has('cnss_number'))
												<span class="text-danger text-small">
													{{ $errors->first('cnss_number') }}
												</span>
												@endif
											</div>

                                            <div class="mb-3">
												<label class="form-label">Diplôme </label>
												<input class="form-control form-control-lg @if($errors->has('diploma')) is-invalid @elseif(old('diploma')) is-valid @endif" type="file" name="diploma" required/>
												@if($errors->has('diploma'))
												<span class="text-danger text-small">
													{{ $errors->first('diploma') }}
												</span>
												@endif
											</div>


                                            <div class="mb-3">
												<label class="form-label">Photo </label>
												<input class="form-control form-control-lg @if($errors->has('photo')) is-invalid @elseif(old('photo')) is-valid @endif" type="file" name="photo" required/>
												@if($errors->has('photo'))
												<span class="text-danger text-small">
													{{ $errors->first('photo') }}
												</span>
												@endif
											</div>

											<div class="mb-3">
												<label class="form-label"> Changez votre Mot de passe </label>
												<div class="input-group">
													<input class="form-control form-control-lg @if($errors->has('password')) is-invalid @endif" type="password" name="password" id="password" placeholder="Entrer votre mot de passe" required/>
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
													<input class="form-control form-control-lg @if($errors->has('password_confirmation')) is-invalid @endif" type="password" name="password_confirmation" id="password-confirm" placeholder="Entrer votre mot de passe" required/>
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
												<button type="submit"  class="btn btn-lg btn-primary">Valider</a>
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