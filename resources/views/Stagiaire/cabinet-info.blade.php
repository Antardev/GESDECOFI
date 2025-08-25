@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Informations de Cabinet Requises - 2ème Année de Stage
                    </h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Important</h6>
                        <p class="mb-0">
                            Votre première année de stage en entreprise est terminée. 
                            Conformément au règlement, votre deuxième année doit se dérouler dans un cabinet agréé.
                            Veuillez compléter les informations ci-dessous pour continuer à utiliser la plateforme.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('') }}" enctype="multipart/form-data">
                        @csrf

                        <h6 class="text-primary mb-3">Informations du Cabinet</h6>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom_cabinet" class="form-label">Nom du Cabinet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom_cabinet') is-invalid @enderror" 
                                       id="nom_cabinet" name="nom_cabinet" value="{{ old('nom_cabinet') }}" required>
                                @error('nom_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email_cabinet" class="form-label">Email du Cabinet <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email_cabinet') is-invalid @enderror" 
                                       id="email_cabinet" name="email_cabinet" value="{{ old('email_cabinet') }}" required>
                                @error('email_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tel_cabinet" class="form-label">Téléphone du Cabinet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tel_cabinet') is-invalid @enderror" 
                                       id="tel_cabinet" name="tel_cabinet" value="{{ old('tel_cabinet') }}" required>
                                @error('tel_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nom_representant" class="form-label">Nom du Représentant <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom_representant') is-invalid @enderror" 
                                       id="nom_representant" name="nom_representant" value="{{ old('nom_representant') }}" required>
                                @error('nom_representant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="lieu_cabinet" class="form-label">Lieu du Cabinet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lieu_cabinet') is-invalid @enderror" 
                                       id="lieu_cabinet" name="lieu_cabinet" value="{{ old('lieu_cabinet') }}" required>
                                @error('lieu_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="numero_inscription_cabinet" class="form-label">Numéro d'Inscription <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('numero_inscription_cabinet') is-invalid @enderror" 
                                       id="numero_inscription_cabinet" name="numero_inscription_cabinet" value="{{ old('numero_inscription_cabinet') }}" required>
                                @error('numero_inscription_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="affiliation_cabinet" class="form-label">Ordre d'Affiliation <span class="text-danger">*</span></label>
                                <select class="form-select @error('affiliation_cabinet') is-invalid @enderror" 
                                        id="affiliation_cabinet" name="affiliation_cabinet" required>
                                    <option value="">Sélectionner l'ordre</option>
                                    <option value="OECCA Bénin" {{ old('affiliation_cabinet') == 'OECCA Bénin' ? 'selected' : '' }}>OECCA Bénin</option>
                                    <option value="OEC Côte d'Ivoire" {{ old('affiliation_cabinet') == "OEC Côte d'Ivoire" ? 'selected' : '' }}>OEC Côte d'Ivoire</option>
                                    <!-- autres options -->
                                </select>
                                @error('affiliation_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- <h6 class="text-primary mb-3">Informations du Maître de Stage</h6> --}}
                        
                        <!-- Champs pour le maître de stage similaires aux champs cabinet -->

                        {{-- <h6 class="text-primary mb-3">Documents Requis</h6>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contrat" class="form-label">Contrat de Stage Signé <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('contrat') is-invalid @enderror" 
                                       id="contrat" name="contrat" accept=".pdf,.jpg,.jpeg,.png" required>
                                @error('contrat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: PDF, JPG, PNG (Max: 5MB)</small>
                            </div>
                            <div class="col-md-6">
                                <label for="attestation_maitre" class="form-label">Attestation d'Acceptation <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('attestation_maitre') is-invalid @enderror" 
                                       id="attestation_maitre" name="attestation_maitre" accept=".pdf,.jpg,.jpeg,.png" required>
                                @error('attestation_maitre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: PDF, JPG, PNG (Max: 5MB)</small>
                            </div>
                        </div> --}}

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Soumettre les Informations
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection