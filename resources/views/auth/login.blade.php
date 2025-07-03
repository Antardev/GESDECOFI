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
							<h1 class="h2">{{__('message.welcome')}}</h1>
							<p class="lead">
								{{__('message.connect_to_continue')}}.
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="POST" action="{{ route('login') }}" >
									@csrf
                                        <div class="mb-3">
											<label class="form-label">{{__('message.email')}}</label>
											<input class="form-control form-control-lg @if ($errors->has('email')) is-invalid @elseif(old('email')) is-valid @endif
												@if($errors->has('email'))
													is-invalid
													@elseif(old('email'))
													is-valid
												@endif" type="email" name="email" placeholder="{{__('message.enter_your_mail')}}" value="{{ old('email') }}" />
											@if($errors->has('email'))
											<span class="text-danger text-small">
												{{ $errors->first('email') }}
											</span>
											@endif
										</div>
										<div class="mb-3">
											<label class="form-label">{{__('message.password')}}</label>
											<div class="input-group">
												<input class="form-control form-control-lg @if($errors->has('password')) is-invalid @endif
													" type="password" name="password" id="password"  class="form-control is-invalid" placeholder="{{__('message.enter_your_password')}}"/>
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
										<div>
											<div class="form-check align-items-center">
												<input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
												<label class="form-check-label text-small" for="customControlInline">{{__('message.remember_me')}}</label>
											</div>
											<div>
												<a href="{{ route('password.request') }}" class="form-text link-secondary">
													{{__('message.forgot_password')}}
												</a>
											</div>
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">{{__('message.login')}}</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							{{__('message.dont_get_account')}} <a href="\register">{{__('message.register')}}</a>
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
		});
		</script>

</body>

</html>

