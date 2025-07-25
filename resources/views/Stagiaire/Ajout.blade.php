@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <form action="{{ route('stagiaire.ajout_jt') }}" method="POST" enctype="multipart/form-data" class="border rounded-3 shadow-lg overflow-hidden">
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

                <div class="modal-header bg-primary text-white p-4">
                    <div class="d-flex align-items-center">
                        <i class="feather-icon me-2" data-feather="file-text" style="width: 24px; height: 24px;"></i>
                        <h3 class="modal-title fw-bold mb-0">Ajouter une activité</h3>
                    </div>
                    <i class="feather-icon" data-feather="alert-circle" style="width: 24px; height: 24px;"></i>
                </div>

                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Journée Technique</h2>
                        <p class="text-muted">Veuillez renseigner les informations concernant votre JT</p>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label for="jt_name" class="form-label fw-bold">Section</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-heading text-primary"></i>
                            </span>
                            <select name="jt_name" class="form-select @error('jt_name') is-invalid @enderror" id="jt_name" required>
                                <option value="JT1" {{ old('jt_name') == 'JT1' ? 'selected' : '' }}>Section 1</option>
                                <option value="JT2" {{ old('jt_name') == 'JT2' ? 'selected' : '' }}>Section 2</option>
                                <option value="JT3" {{ old('jt_name') == 'JT3' ? 'selected' : '' }}>Section 3</option>
                                @for ($i = 4; $i <= $jtd; $i++)
                                    <option value="JT{{ $i }}" {{ old('jt_name') == 'JT' . $i ? 'selected' : '' }}>Section {{ $i }}</option>
                                @endfor
                            </select>
                            @error('jt_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror  
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="form-label fw-bold">Date de début</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="far fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" max="{{ date('Y-m-d') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="form-label fw-bold">Date de fin</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="far fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" max="{{ date('Y-m-d') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="affiliation_order" class="form-label fw-bold">Lieu de tenue de la Journée technique</label>
                        <select name="affiliation_order" class="form-select @error('affiliation_order') is-invalid @enderror" id="affiliation_order">
                            @foreach($affiliation_orders as $affiliation_order)
                                <option value="{{ $affiliation_order->id }}">
                                    {{ $affiliation_order->name . ' - ' . $affiliation_order->principal_city }}
                                </option>
                            @endforeach
                        </select>
                        @error('affiliation_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="domaine" class="form-label fw-bold">Domaine</label>
                        <select name="domain" class="form-select @error('domain') is-invalid @enderror" id="domaine">
                            <option value="">Sélectionnez un domaine</option>
                            @foreach($domains as $domain)
                                <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                            @endforeach
                        </select>
                        @error('domain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 p-3 rounded" id="sous-domaines-container" style="display: none; background-color: #abbfd1;">
                        <label class="form-label fw-bold">Sous-domaines</label>
                        <div id="sous-domaines-list">
                            @foreach($domains as $domain)
                                <div class="sous-domaines-group" data-domain-id="{{ $domain->id }}" style="display: none;">
                                    @foreach($domain->subdomains as $subd)
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input sous-domaine-checkbox" 
                                                           type="checkbox" 
                                                           name="sous_domaines[{{ $subd->id }}][id]" 
                                                           id="sous-domaine-{{ $subd->id }}" 
                                                           value="{{ $subd->id }}">
                                                    <label class="form-check-label" for="sous-domaine-{{ $subd->id }}">
                                                        {{ $subd->name }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">Heures</span>
                                                    <input type="number" 
                                                           class="form-control heures-input" 
                                                           name="sous_domaines[{{ $subd->id }}][heures]" 
                                                           min="0" 
                                                           value="0" 
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4" id="masse-horaire-container" style="display: none;">
                        <label for="masse_horaire" class="form-label fw-bold">Masse horaire totale</label>
                        <input type="text" class="form-control" id="masse_horaire" name="masse_horaire" readonly>
                    </div>

                    <div class="mb-4" id="modules-container">
                        <label class="form-label fw-bold">Modules (5 obligatoires)</label>
                        <div id="modules-list">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text">Module {{ $i + 1 }}</span>
                                            <input type="text" 
                                                   class="form-control module-name" 
                                                   name="modules[{{ $i }}][name]" 
                                                   placeholder="Nom du module" 
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Heures</span>
                                            <input type="number" 
                                                   class="form-control module-hours" 
                                                   name="modules[{{ $i }}][heures]" 
                                                   min="0" 
                                                   value="0"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="jt_description" class="form-label fw-bold">Commentaire</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light align-items-start pt-2">
                                <i class="fas fa-align-left text-primary"></i>
                            </span>
                            <textarea class="form-control @error('jt_description') is-invalid @enderror" id="jt_description" name="jt_description" rows="4" placeholder="Décrivez le contenu de la JT..." required>{{ old('jt_description') }}</textarea>
                            @error('jt_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="rapport" class="form-label fw-bold">Rapport (PDF) (facultatif)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-file-pdf text-primary"></i>
                            </span>
                            <input type="file" class="form-control @error('rapport') is-invalid @enderror" id="rapport" name="rapport" accept=".pdf">
                            @error('rapport')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Format accepté: PDF (max 5MB)</small>
                    </div>

                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                            <i class="fas fa-save me-2"></i>{{ __('message.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .feather-icon {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .form-label {
        margin-bottom: 0.5rem;
        color: #495057;
    }
    .module-row {
        margin-bottom: 15px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    #modules-container {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const domaineSelect = document.getElementById('domaine');
        const sousDomainesContainer = document.getElementById('sous-domaines-container');
        const masseHoraireContainer = document.getElementById('masse-horaire-container');
        const masseHoraireInput = document.getElementById('masse_horaire');
        let totalMasseHoraire = 0;

        // Écouteur pour le changement de domaine
        domaineSelect.addEventListener('change', function() {
            const selectedDomainId = this.value;

            // Masquer tous les groupes de sous-domaines
            document.querySelectorAll('.sous-domaines-group').forEach(group => {
                group.style.display = 'none';
            });

            // Afficher le groupe correspondant si un domaine est sélectionné
            if (selectedDomainId) {
                sousDomainesContainer.style.display = 'block';
                const selectedGroup = document.querySelector(`.sous-domaines-group[data-domain-id="${selectedDomainId}"]`);
                if (selectedGroup) {
                    selectedGroup.style.display = 'block';
                }
                masseHoraireContainer.style.display = 'block';
            } else {
                sousDomainesContainer.style.display = 'none';
                masseHoraireContainer.style.display = 'none';
            }
        });

        // Écouteur délégué pour les cases à cocher et les champs d'heures
        sousDomainesContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('sous-domaine-checkbox')) {
                const heuresInput = e.target.closest('.row').querySelector('.heures-input');
                heuresInput.disabled = !e.target.checked;
                if (!e.target.checked) {
                    heuresInput.value = 0;
                }
                updateTotalMasseHoraire();
            }
            if (e.target.classList.contains('heures-input')) {
                updateTotalMasseHoraire();
            }
        });

        // Fonction pour mettre à jour le total
        function updateTotalMasseHoraire() {
            totalMasseHoraire = 0;
            document.querySelectorAll('.sous-domaine-checkbox:checked').forEach(checkbox => {
                const heuresInput = checkbox.closest('.row').querySelector('.heures-input');
                totalMasseHoraire += parseInt(heuresInput.value) || 0;
            });
            masseHoraireInput.value = totalMasseHoraire + ' heures';
        }
    });
</script>
@endsection