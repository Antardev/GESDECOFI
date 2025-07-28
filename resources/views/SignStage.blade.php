@extends('welcome')

@section('content')

<div class="hero-section" style="position: relative; text-align: center; height: calc(100vh - 60px);  overflow: hidden;">
    <img src="{{ asset('assets/img/1.png') }}" alt="Bienvenue" style="width: 100%; height: 100%; max-height: 600px; object-fit: cover;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background-color: rgba(0, 0, 0, 0.7); padding: 30px; border-radius: 10px;">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color:blanchedalmond;">{{__('message.pre-registration_phase')}}</h1>
        <p style="font-size: 1.2rem; color: #bebcbc;">{{__('sign_stage.download_pre-registration_phase')}}</p>
        
        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
            <!-- Bouton pour modal d'ajout -->
            <a href="{{route('stagiaire.inscription')}}" type="button" class="btn btn-primary" >
                <i class="align-middle me-2" data-feather="upload"></i> {{__('sign_stage.submit_my_form')}}
            </a>
            
            <!-- Bouton pour rediriger vers la procédure de préinscription -->
            <button type="button" class="btn btn-success">
                <i class="align-middle me-2" data-feather="download"></i>
                <a href="{{ route('download_form') }}" class="text-white text-decoration-none">
                    {{ __('sign_stage.download_a_form') }}
                </a>
            </button>
        </div>
    </div>
</div>

{{-- <!-- Modal Ajouter Fiche -->
<div class="modal fade" id="ajouterModal" tabindex="-1" aria-labelledby="ajouterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ajouterModalLabel">
                    <i class="align-middle me-2" data-feather="cloud-upload">{{__('sign_stage.submit_my_form')}}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('stagiaire.edit') }}" id="formStagiaire" method="PUT" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="matricule" class="form-label">{{ __('sign_stage.your_matricule') }}</label>
                        <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule" name="matricule" required maxlength="14" onblur="fetchData()">
                        @error('matricule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="user-info" style="display: none;">
                        <h5>{{ __('sign_stage.user_info') }}</h5>

                        <div class="mb-3">
                            <label for="firstname" class="form-label">{{ __('sign_stage.firstname') }}</label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" readonly>
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('sign_stage.name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" readonly>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('sign_stage.email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="birth_date" class="form-label">{{ __('sign_stage.birth_date') }}</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" readonly>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">{{ __('sign_stage.country') }}</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" readonly>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('sign_stage.phone') }}</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" readonly>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ficheFile" class="form-label">{{ __('sign_stage.select_completed_form') }}</label>
                            <input class="form-control @error('fiche') is-invalid @enderror" type="file" id="ficheFile" name="fiche" accept=".pdf,.doc,.docx" required>
                            @error('fiche')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('sign_stage.accepted_formats') }} : PDF, Word (max. 5Mo)</div>
                        </div>

                        <h5>{{ __('sign_stage.degree_info') }}</h5>

                        <div class="mb-3">
                            <label for="diplome" class="form-label">{{ __('sign_stage.diplome') }}</label>
                            <input class="form-control @error('diplome') is-invalid @enderror" type="file" id="diplome" name="diplome" accept=".pdf,.doc,.docx" required>
                            @error('diplome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('sign_stage.accepted_formats') }} : PDF, Word (max. 5Mo)</div>
                        </div>

                        <div class="mb-3">
                            <label for="date_obtention" class="form-label">{{ __('sign_stage.date_obtention') }}</label>
                            <input type="date" class="form-control @error('date_obtention') is-invalid @enderror" id="date_obtention" name="date_obtention" required>
                            @error('date_obtention')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5>{{ __('sign_stage.cab_info') }}</h5>

                        <div class="mb-3">
                            <label for="nom_cabinet" class="form-label">{{ __('sign_stage.nom_cabinet') }}</label>
                            <input type="text" class="form-control @error('nom_cabinet') is-invalid @enderror" id="nom_cabinet" name="nom_cabinet" required>
                            @error('nom_cabinet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_entree" class="form-label">{{ __('sign_stage.date_entree') }}</label>
                            <input type="date" class="form-control @error('date_entree') is-invalid @enderror" id="date_entree" name="date_entree" required>
                            @error('date_entree')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lieu_cabinet" class="form-label">{{ __('sign_stage.lieu_cabinet') }}</label>
                            <input type="text" class="form-control @error('lieu_cabinet') is-invalid @enderror" id="lieu_cabinet" name="lieu_cabinet" required>
                            @error('lieu_cabinet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tel_cabinet" class="form-label">{{ __('sign_stage.tel_cabinet') }}</label>
                            <input type="tel" class="form-control @error('tel_cabinet') is-invalid @enderror" id="tel_cabinet" name="tel_cabinet" required>
                            @error('tel_cabinet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email_cabinet" class="form-label">{{ __('sign_stage.email_cabinet') }}</label>
                            <input type="email" class="form-control @error('email_cabinet') is-invalid @enderror" id="email_cabinet" name="email_cabinet" required>
                            @error('email_cabinet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nom_representant" class="form-label">{{ __('sign_stage.nom_representant') }}</label>
                            <input type="text" class="form-control @error('nom_representant') is-invalid @enderror" id="nom_representant" name="nom_representant" required>
                            @error('nom_representant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5>{{ __('sign_stage.master_info') }}</h5>

                        <div class="mb-3">
                            <label for="nom_maitre" class="form-label">{{ __('sign_stage.nom_maitre') }}</label>
                            <input type="text" class="form-control @error('nom_maitre') is-invalid @enderror" id="nom_maitre" name="nom_maitre" required>
                            @error('nom_maitre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prenom_maitre" class="form-label">{{ __('sign_stage.prenom_maitre') }}</label>
                            <input type="text" class="form-control @error('prenom_maitre') is-invalid @enderror" id="prenom_maitre" name="prenom_maitre" required>
                            @error('prenom_maitre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tel_maitre" class="form-label">{{ __('sign_stage.tel_maitre') }}</label>
                            <input type="tel" class="form-control @error('tel_maitre') is-invalid @enderror" id="tel_maitre" name="tel_maitre" required>
                            @error('tel_maitre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> {{ __('sign_stage.your_form_will_be_revivewed_in_48') }}.
                    </div>

                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formStagiaire">{{__('sign_stage.send')}}</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('sign_stage.cancel')}}</button>
            </div>
        </div>
    </div>
</div> --}}

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const ajouterForm = document.getElementById('ajouterModalForm');
        if (ajouterForm) {
            ajouterForm.addEventListener('submit', function(e) {
                // Validation supplémentaire ici
            });
        }
    });
</script>

@section('scripts')
<script>

    function fetchData() {
        const matricule = document.getElementById('matricule').value;
        if (matricule.length === 14) {
            fetch(`http://192.168.100.146:8001/stagiaire/${matricule}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('firstname').value = data.firstname;
                        document.getElementById('name').value = data.name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('birth_date').value = data.birthdate;
                        document.getElementById('country').value = data.country;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('user-info').style.display = 'block';
                    } else {
                        alert('Matricule non trouvé.');
                    }
                })
                .catch(error => console.error('Erreur:', error));
        } else {
            document.getElementById('user-info').style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const formst = document.getElementById('formStagiaire');
        
        formst.addEventListener('submit', function(e) {
            e.preventDefault();
            const csrfToken = document.querySelector('input[name="_token"]').value;
            const formData = new FormData(this);
        
            fetch('http://192.168.100.146:8001/stagiaire/edit', {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: Object.fromEntries(formData.entries()),
            })
            .then(response => response.json())
            .then(data => {
                clearErrors(); // Appelle la fonction pour nettoyer les erreurs précédentes

                if (data.success) {
                    alert(data.success);
                    // Optionnel : Fermer le modal ou rediriger l'utilisateur
                } else {
                    // Gestion des erreurs
                    if (data.errors) {
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const input = document.querySelector(`[name="${field}"]`);
                            if (input) {
                                // Créer un message d'erreur
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'invalid-feedback d-block';
                                errorDiv.innerText = messages[0];
                                input.classList.add('is-invalid'); // Ajoute la classe d'erreur
                                input.parentNode.appendChild(errorDiv); // Ajoute le message d'erreur
                            }
                        }
                    } else {
                        // Pour les autres erreurs
                        alert(data.message || 'Une erreur est survenue.');
                    }
                }
            })
            .catch(error => console.log('Erreur:', error));
        });
    });

    function clearErrors() {
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => {
            field.classList.remove('is-invalid'); // Supprime la classe d'erreur
            const errorDiv = field.parentNode.querySelector('.invalid-feedback');
            if (errorDiv) {
                errorDiv.remove(); // Supprime le message d'erreur
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const openModal = urlParams.get('openModal');
        if (openModal === 'ajouterModal') {
            const modal = new bootstrap.Modal(document.getElementById('ajouterModal'));
            modal.show();
        }
    });
</script>