@extends('welcome')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="h4 mb-0">
                                <i class="fas fa-user-plus me-2"></i>Ajouter un nouvel assistant
                            </h2>
                            <p class="mb-0 opacity-75">Remplissez les informations de l'assistant</p>
                        </div>
                        <i class="fas fa-hands-helping fa-2x opacity-50"></i>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{route('controleur.add_assistant')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                        <div class="row g-4">
                            <!-- Section Informations personnelles -->
                            <div class="col-md-6">
                                <div class="section-title mb-4">
                                    <h5 class="fw-bold text-primary">
                                        <i class="fas fa-id-card me-2"></i>Informations personnelles <span class="text-small text-danger">*</span>
                                    </h5>
                                    <div class="divider bg-primary"></div>
                                </div>

                                <!-- Nom -->
                                <div class="mb-4">
                                    <label for="full_name" class="form-label fw-bold">Nom Complet</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="full_name" name="full_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Section Coordonnées -->
                            <div class="col-md-6">
                                <div class="section-title mb-4">
                                    <h5 class="fw-bold text-primary">
                                        <i class="fas fa-address-book me-2"></i>Coordonnées<span class="text-small text-danger">*</span>
                                    </h5>
                                    <div class="divider bg-primary"></div>
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Section Professionnelle -->
                            <div class="col-12">
                                <div class="section-title mb-4 mt-2">
                                    <h5 class="fw-bold text-primary">
                                        <i class="fas fa-briefcase me-2"></i>Informations professionnelles
                                    </h5>
                                    <div class="divider bg-primary"></div>
                                </div>

                                <div class="row g-4">
                                    <!-- Spécialité -->
                                    <div class="col-md-6">
                                        <label for="specialty" class="form-label fw-bold">Titre</label>
                                        <input type="text" class="form-control @error('specialty') is-invalid @enderror" 
                                               id="specialty" name="specialty" value="{{ old('specialty') }}" >
                                        @error('titre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                  
                                    <!-- Titre -->
                                    <div class="col-md-6">
                                        <label for="fonction" class="form-label fw-bold">Fonction</label>
                                        <input type="text" class="form-control @error('fonction') is-invalid @enderror" 
                                               id="fonction" name="fonction" value="{{ old('fonction') }}">
                                        @error('fonction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                   
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="section-title mb-4 mt-2">
                                    <h5 class="fw-bold text-primary">
                                        <i class="fas fa-briefcase me-2"></i>Mot de Passe<span class="text-small text-danger">*</span>
                                    </h5>
                                    <div class="divider bg-primary"></div>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-bold">Mot de passe</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" value="{{ old('password') }}" required>
                                               <span class="input-group-text btn btn-secondary">
                                                <i class="align-middle my-2" data-feather="eye" id="password-toggle"></i>
                                            </span>
                                        </div>
                                        
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                 
                                    <div class="col-md-6">
                                        <label for="hire_date" class="form-label fw-bold">Comfirmer le mot de passe</label>
                                        <div class="input-group ">
                                            <input class="form-control form-control-lg @if($errors->has('password_confirmation')) is-invalid @endif" type="password" name="password_confirmation" id="password-confirm"  />
                                            <span class="input-group-text btn btn-secondary">
                                                <i class="align-middle my-2" data-feather="eye" id="password-confirm-toggle"></i>
                                            </span>
                                        </div>
                                        <div id="passwordMatchError" class="invalid-feedback" style="display: none;">
                                            Les mots de passe ne correspondent pas
                                        </div>
                                        
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        </div>
                        <!-- Boutons de soumission -->
                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-eraser me-2"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Enregistrer l'assistant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles personnalisés -->
<style>
    .section-title {
        position: relative;
        padding-bottom: 10px;
    }
    .divider {
        height: 3px;
        width: 50px;
        background: var(--bs-primary);
        opacity: 0.7;
        margin-top: 8px;
    }
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>

<!-- Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
<script>
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