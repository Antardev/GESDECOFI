@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <form action="{{ route('stagiaire.ajout_jt').'?year='.request()->get('year') }}" method="POST" enctype="multipart/form-data" class="border rounded-3 shadow-lg overflow-hidden">
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
                    <div class="mb4">
                        <label for="mode"><strong>Mode</strong>  </label>
                        <select name="mode" id="mode" class="form-select">
                            <option value="Presentiel local">Presentiel en local</option>
                            <option value="Presentiel hors pays">Presentiel hors pays</option>
                            <option value="Distanciel">Distanciel</option>
                            <option value="En ligne">En ligne</option>
                        </select>
                    </div>
                    <div class="mb-4" id="modules-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-bold mb-0">Modules</label>

                        </div>
                        
                        <div id="modules-list">
                            <!-- Module initial -->
                            <div class="module-container p-3 mb-4 rounded border" data-module-index="0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0">Module 1</h6>
                                    <button type="button" class="btn btn-sm btn-danger remove-module-btn" style="display: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text">Nom du module</span>
                                            <input type="text" 
                                                   class="form-control module-name" 
                                                   name="modules[0][name]" 
                                                   placeholder="Nom du module" 
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text">Heures totales</span>
                                            <input type="number" 
                                                   class="form-control module-total-hours" 
                                                   name="modules[0][total_heures]" 
                                                   min="0" 
                                                   value="0"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Domaine du module</label>
                                    <select name="modules[0][domain]" class="form-select module-domain-select">
                                        <option value="">Sélectionnez un domaine</option>
                                        @foreach($domains as $domain)
                                            <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sous-domaines-container p-3 rounded" style="display: none; background-color: #f8f9fa;">
                                    <label class="form-label fw-bold">Sous-domaines</label>
                                    <div class="sous-domaines-list">
                                        @foreach($domains as $domain)
                                            <div class="sous-domaines-group" data-domain-id="{{ $domain->id }}" style="display: none;">
                                                @foreach($domain->subdomains as $subd)
                                                    <div class="row mb-3 align-items-center">
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input sous-domaine-checkbox" 
                                                                       type="checkbox" 
                                                                       name="modules[0][sous_domaines][{{ $subd->id }}][id]" 
                                                                       id="module-0-sous-domaine-{{ $subd->id }}" 
                                                                       value="{{ $subd->id }}">
                                                                <label class="form-check-label" for="module-0-sous-domaine-{{ $subd->id }}">
                                                                    {{ $subd->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <span class="input-group-text">Heures</span>
                                                                <input type="number" 
                                                                       class="form-control sous-domaine-heures" 
                                                                       name="modules[0][sous_domaines][{{ $subd->id }}][heures]" 
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
                            </div>
                            <!-- Fin du module initial -->
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <button type="button" id="add-module-btn" class="btn btn-sm btn-success ms-auto">
                                <i class="fas fa-plus me-1" style="font-size: 30px;"></i> Ajouter un autre module
                            </button>
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
                        <label for="rapport" class="form-label fw-bold">Fiche technique (ou capture tableau de bord de la plateforme e-learning)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-file-pdf text-primary"></i>
                            </span>
                            <input type="file" class="form-control @error('rapport') is-invalid @enderror" id="rapport" name="rapport" accept=".pdf" required>
                            @error('rapport')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Format accepté: PDF (max 5MB), ou image jpg,jpeg</small>
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
    .module-container {
        background-color: #fff;
        border-radius: 5px;
        border: 1px solid #dee2e6 !important;
    }
    #modules-container {
        margin-top: 20px;
    }
    .remove-module-btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    #add-module-btn.disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', function() {
            const startDateValue = startDateInput.value;
            if (startDateValue) {
                endDateInput.min = startDateValue; // Définit la date minimale pour la date de fin
            } else {
                endDateInput.min = ''; // Réinitialise si aucune date de début n'est sélectionnée
            }
        });

        endDateInput.addEventListener('change', function() {
            const endDateValue = endDateInput.value;
            if (endDateValue) {
                startDateInput.max = endDateValue; // Définit la date maximale pour la date de début
            } else {
                startDateInput.max = ''; // Réinitialise si aucune date de fin n'est sélectionnée
            }
        });

        let moduleCounter = 1; // Commence à 1 car on a déjà le module initial
        const MAX_MODULES = 5; // Définit le nombre maximum de modules
        
        // Fonction pour vérifier si on peut ajouter un nouveau module
        function canAddModule() {
            return document.querySelectorAll('.module-container').length < MAX_MODULES;
        }

        // Fonction pour mettre à jour l'état du bouton "Ajouter un module"
        function updateAddButtonState() {
            const addButton = document.getElementById('add-module-btn');
            if (!canAddModule()) {
                addButton.disabled = true;
                addButton.classList.add('disabled');
                addButton.innerHTML = '<i class="fas fa-ban me-1"></i> Limite atteinte (5 modules max)';
            } else {
                addButton.disabled = false;
                addButton.classList.remove('disabled');
                addButton.innerHTML = '<i class="fas fa-plus me-1"></i> Ajouter un module';
            }
        }

        // Fonction pour initialiser les événements d'un module
        function initModuleEvents(moduleContainer) {
            const domainSelect = moduleContainer.querySelector('.module-domain-select');
            const sousDomainesContainer = moduleContainer.querySelector('.sous-domaines-container');
            const totalHoursInput = moduleContainer.querySelector('.module-total-hours');
            const removeBtn = moduleContainer.querySelector('.remove-module-btn');

            // Écouteur pour le changement de domaine
            domainSelect.addEventListener('change', function() {
                const selectedDomainId = this.value;

                // Masquer tous les groupes de sous-domaines pour ce module
                moduleContainer.querySelectorAll('.sous-domaines-group').forEach(group => {
                    group.style.display = 'none';
                });

                // Afficher le groupe correspondant si un domaine est sélectionné
                if (selectedDomainId) {
                    sousDomainesContainer.style.display = 'block';
                    const selectedGroup = moduleContainer.querySelector(`.sous-domaines-group[data-domain-id="${selectedDomainId}"]`);
                    if (selectedGroup) {
                        selectedGroup.style.display = 'block';
                    }
                } else {
                    sousDomainesContainer.style.display = 'none';
                }
            });

            // Écouteur délégué pour les cases à cocher et les champs d'heures
            sousDomainesContainer.addEventListener('change', function(e) {
                if (e.target.classList.contains('sous-domaine-checkbox')) {
                    const heuresInput = e.target.closest('.row').querySelector('.sous-domaine-heures');
                    heuresInput.disabled = !e.target.checked;
                    if (!e.target.checked) {
                        heuresInput.value = 0;
                    }
                    updateTotalHours(moduleContainer);
                }
                if (e.target.classList.contains('sous-domaine-heures')) {
                    updateTotalHours(moduleContainer);
                }
            });

            // Écouteur pour le bouton de suppression
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    moduleContainer.remove();
                    updateModuleNumbers();
                    updateAddButtonState(); // Mettre à jour le bouton après suppression
                });
            }
        }

        // Fonction pour mettre à jour le total des heures pour un module
        function updateTotalHours(container) {
            let total = 0;
            container.querySelectorAll('.sous-domaine-checkbox:checked').forEach(checkbox => {
                const heuresInput = checkbox.closest('.row').querySelector('.sous-domaine-heures');
                total += parseInt(heuresInput.value) || 0;
            });
            container.querySelector('.module-total-hours').value = total;
        }

        // Fonction pour mettre à jour les numéros des modules
        function updateModuleNumbers() {
            const modules = document.querySelectorAll('.module-container');
            modules.forEach((module, index) => {
                module.setAttribute('data-module-index', index);
                module.querySelector('h6').textContent = `Module ${index + 1}`;
                
                // Mettre à jour les noms des champs
                module.querySelectorAll('[name^="modules["]').forEach(input => {
                    const name = input.name.replace(/modules\[\d+\]/g, `modules[${index}]`);
                    input.name = name;
                });
                
                // Mettre à jour les IDs des sous-domaines
                module.querySelectorAll('.sous-domaine-checkbox').forEach(checkbox => {
                    const subId = checkbox.id.split('-').pop();
                    checkbox.id = `module-${index}-sous-domaine-${subId}`;
                    checkbox.nextElementSibling.setAttribute('for', `module-${index}-sous-domaine-${subId}`);
                });
                
                // Afficher le bouton de suppression sauf pour le premier module
                const removeBtn = module.querySelector('.remove-module-btn');
                if (removeBtn) {
                    removeBtn.style.display = index === 0 ? 'none' : 'block';
                }
            });
        }

        // Initialiser les événements pour le module initial
        document.querySelectorAll('.module-container').forEach(moduleContainer => {
            initModuleEvents(moduleContainer);
        });

        // Mettre à jour l'état initial du bouton
        updateAddButtonState();

        // Écouteur pour le bouton "Ajouter un module"
        document.getElementById('add-module-btn').addEventListener('click', function() {
            if (!canAddModule()) return;
            
            const modulesList = document.getElementById('modules-list');
            const newModuleIndex = moduleCounter++;
            
            // Cloner le premier module
            const firstModule = document.querySelector('.module-container');
            const newModule = firstModule.cloneNode(true);
            
            // Mettre à jour les attributs et valeurs
            newModule.setAttribute('data-module-index', newModuleIndex);
            newModule.querySelector('h6').textContent = `Module ${newModuleIndex + 1}`;
            newModule.querySelector('.module-name').value = '';
            newModule.querySelector('.module-total-hours').value = '0';
            newModule.querySelector('.module-domain-select').value = '';
            newModule.querySelector('.sous-domaines-container').style.display = 'none';
            
            // Réinitialiser les sous-domaines
            newModule.querySelectorAll('.sous-domaine-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            newModule.querySelectorAll('.sous-domaine-heures').forEach(input => {
                input.value = '0';
                input.disabled = true;
            });
            
            // Afficher le bouton de suppression
            newModule.querySelector('.remove-module-btn').style.display = 'block';
            
            // Ajouter le nouveau module
            modulesList.appendChild(newModule);
            
            // Initialiser les événements pour le nouveau module
            initModuleEvents(newModule);
            
            // Mettre à jour les numéros des modules (au cas où)
            updateModuleNumbers();
            
            // Mettre à jour l'état du bouton après ajout
            updateAddButtonState();
        });
    });
</script>


@endsection