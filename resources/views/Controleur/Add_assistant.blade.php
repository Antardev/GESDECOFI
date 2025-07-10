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
                                    <label for="first_name" class="form-label fw-bold">Nom</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Prénom -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">Prénom</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Date de naissance -->
                                <div class="mb-4">
                                    <label for="birth_date" class="form-label fw-bold">Date de naissance</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                           id="birth_date" name="birth_date" max="{{ date('Y-m-d') }}" value="{{ old('birth_date') }}" required>
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Photo -->
                                <div class="mb-4">
                                    <label for="photo" class="form-label fw-bold">Photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                           id="photo" name="photo" accept="image/*" required>
                                    <div class="form-text">Format: JPG, PNG (max 2MB)</div>
                                    @error('photo')
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

                                <!-- Téléphone -->
                                <div class="mb-4">
                                    <label for="phone" class="form-label fw-bold">Téléphone</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Adresse -->
                                <div class="mb-4">
                                    <label for="address" class="form-label fw-bold">Adresse</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address') }}" required>   
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ville -->
                                <div class="mb-4">
                                    <label for="city" class="form-label fw-bold">Ville</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city') }}">
                                    @error('city')
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
                                        <label for="specialty" class="form-label fw-bold">Spécialité</label>
                                        <input type="text" class="form-control @error('specialty') is-invalid @enderror" 
                                               id="specialty" name="specialty" value="{{ old('specialty') }}" >
                                        @error('specialty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Date d'embauche -->
                                    <div class="col-md-6">
                                        <label for="hire_date" class="form-label fw-bold">Date d'embauche</label>
                                        <input type="date" class="form-control @error('hire_date') is-invalid @enderror" 
                                               id="hire_date" name="hire_date" value="{{ old('hire_date') }}">
                                        @error('hire_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Numéro CNSS -->
                                    <div class="col-md-6">
                                        <label for="cnss_number" class="form-label fw-bold">Numéro CNSS</label>
                                        <input type="text" class="form-control @error('cnss_number') is-invalid @enderror" 
                                               id="cnss_number" name="cnss_number" value="{{ old('cnss_number') }}">
                                        @error('cnss_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Diplôme -->
                                    <div class="col-md-6">
                                        <label for="diploma" class="form-label fw-bold">Diplôme</label>
                                        <input type="file" class="form-control @error('diploma') is-invalid @enderror" 
                                               id="diploma" name="diploma" value="{{ old('diploma') }}" >
                                        @error('diploma')
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
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" value="{{ old('password') }}" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Date d'embauche -->
                                    <div class="col-md-6">
                                        <label for="hire_date" class="form-label fw-bold">Comfirmer le mot de passe</label>
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                               id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
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