@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('stagiaire.ajout_mission') }}" method="POST" enctype="multipart/form-data" class="border rounded-3 shadow-lg overflow-hidden">
                @csrf
                
                <!-- En-tête du formulaire -->
                <div class="modal-header bg-gradient-primary text-white p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tasks fa-2x me-3"></i>
                        <div>
                            <h3 class="modal-title fw-bold mb-0">Ajouter une mission</h3>
                            <p class="mb-0 small">Renseignez les détails de votre nouvelle mission</p>
                        </div>
                    </div>
                    <i class="fas fa-info-circle fa-lg"></i>
                </div>

                <!-- Corps du formulaire -->
                <div class="modal-body p-4 bg-light">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">
                            <i class="fas fa-map-marked-alt me-2"></i>Détails de la mission
                        </h2>
                        <div class="divider bg-primary mx-auto"></div>
                    </div>

                    <!-- Champ Nom de la mission -->
                    <div class="mb-4">
                        <label for="mission_name" class="form-label fw-bold">
                            <i class="fas fa-heading me-2 text-primary"></i>Nom de la mission
                        </label>
                        <input type="text" class="form-control form-control-lg @error('mission_name') is-invalid @enderror" 
                               id="mission_name" name="mission_name" value="{{old('mission_name')}}" required>
                        @error('mission_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catégorie de la mission -->
                    <div class="mb-4">
                        <label for="categorie_mission" class="form-label fw-bold">
                            <i class="fas fa-tags me-2 text-primary"></i>Catégorie de la mission
                        </label>
                        <select class="form-select form-select-lg @error('categorie_mission') is-invalid @enderror" 
                                id="categorie_mission" name="categorie_mission" required onchange="showSubcategories()">
                            <option value="" disabled selected>Choisissez une catégorie</option>
                            <option value="Travaux de base">Travaux de base</option>
                            <option value="Mission de conseil">Mission de conseil</option>
                            <option value="Mission d'Audit">Mission d'Audit et de commissariat aux comptes</option>
                            <option value="Expertise judiciaire">Expertise judiciaire</option>
                            <option value="Gestion du Cabinet">Gestion du Cabinet</option>
                        </select>
                        @error('categorie_mission')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sous-catégories -->
                    <div id="subcategories-container" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-list-ul me-2 text-primary"></i>Sous-catégories et heures
                            </label>
                            
                            <div id="subcategories-list" class="border rounded p-3 bg-white">
                                <!-- Les sous-catégories seront générées ici par JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dates de la mission -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="mission_begin_date" class="form-label fw-bold">
                                <i class="far fa-calendar-check me-2 text-primary"></i>Date de début
                            </label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('mission_begin_date') is-invalid @enderror" 
                                       id="mission_begin_date" name="mission_begin_date" 
                                       value="{{ old('mission_begin_date') }}" required>
                            </div>
                            @error('mission_begin_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="mission_end_date" class="form-label fw-bold">
                                <i class="far fa-calendar-times me-2 text-primary"></i>Date de fin
                            </label>
                            <div class="input-group">
                                <input type="date" class="form-control @error('mission_end_date') is-invalid @enderror" 
                                       id="mission_end_date" name="mission_end_date" 
                                       value="{{ old('mission_end_date') }}" required>
                            </div>
                            @error('mission_end_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Année de mission -->
                    <div class="mb-4 bg-white p-3 rounded shadow-sm">
                        <label for="jt_year" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Année de mission
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-lock text-primary"></i>
                            </span>
                            <input type="text" class="form-control bg-light" id="jt_year" name="jt_year" value="{{$year}}" readonly>
                            <span class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $delai }}
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="mission_description" class="form-label fw-bold">
                            <i class="fas fa-align-left me-2 text-primary"></i>Description
                        </label>
                        <textarea class="form-control @error('mission_description') is-invalid @enderror" 
                                  id="mission_description" name="mission_description" rows="5" 
                                  placeholder="Décrivez les objectifs et détails de la mission..." required>{{old('mission_description')}}</textarea>
                        @error('mission_description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rapport -->
                    <div class="mb-4">
                        <label for="rapport" class="form-label fw-bold">
                            <i class="fas fa-file-upload me-2 text-primary"></i>Rapport (facultatif)
                        </label>
                        <div class="file-upload-wrapper">
                            <input type="file" class="form-control @error('rapport') is-invalid @enderror" 
                                   id="rapport" name="rapport" accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <small class="form-text text-muted">Formats acceptés: PDF, Word, Excel (max 10MB)</small>
                            @error('rapport')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                            <i class="fas fa-save me-2"></i>{{ __('message.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Styles personnalisés -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
    }
    .divider {
        width: 80px;
        height: 3px;
        opacity: 0.7;
    }
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
    }
    .file-upload-wrapper {
        position: relative;
    }
    .file-upload-wrapper:after {
        content: "Parcourir";
        position: absolute;
        top: 0;
        right: 0;
        padding: 0.375rem 0.75rem;
        background: #e9ecef;
        border-left: 1px solid #ced4da;
        border-radius: 0 0.25rem 0.25rem 0;
        pointer-events: none;
    }
    .file-upload-wrapper input {
        padding-right: 90px;
    }
    .subcategory-item {
        margin-bottom: 10px;
    }
    .hours-input {
        max-width: 100px;
    }


    /* defilement de texte */
    #subcategories-list {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
    }
    
    .subcategory-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .subcategory-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* Style pour les champs de sous-catégories avec défilement */
    .subcategory-input {
        white-space: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        text-overflow: ellipsis;
        scrollbar-width: thin;
        padding-right: 30px; /* Espace pour le dégradé */
        background: linear-gradient(to right, rgba(255,255,255,0) 90%, white 100%);
    }

    .subcategory-input::-webkit-scrollbar {
        height: 5px;
    }

    .subcategory-input::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .subcategory-input::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .subcategory-input::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Ajustement de la largeur des colonnes */
    .subcategory-item .col-md-8 {
        max-width: 65%;
        flex: 0 0 65%;
    }

    .subcategory-item .col-md-3 {
        max-width: 30%;
        flex: 0 0 30%;
    }
    
    

</style>

@section('scripts_down')
<script>
    // Données des sous-catégories par catégorie
    const subcategoriesData = {
        "Travaux de base": [
            "Mission de tenue comptable",
            "Revue comptable",
            "Mission de présentation des comptes"
        ],
        "Mission de conseil": [
            "Assistance et conseil en organisation (procédures administratives et comptables, plan de comptes, etc.…)",
            "Assistance et conseil en matière juridique (secrétariat juridique, restructuration, transmission de patrimoine, etc.…",
            "Assistance et conseil en matière sociale (bulletins de paie, déclarations sociales…)",
            "Assistance et conseil en matière fiscale (établissement de déclarations fiscales, déclarations de résultats, etc.…)",
            "Assistance et conseil en gestion (comptabilité analytique, analyse de coûts, tableaux de bord, études prévisionnelles,…)",
            "Assistance et conseil en informatique (implantation de systèmes informatiques, choix de systèmes informatiques, etc.…)"
        ],
        "Mission d'Audit": [
            "Orientation et planification de la mission",
            "Appréciation du contrôle interne",
            "Contrôle direct des comptes",
            "Travaux de fin de mission, note de synthèse, examen critique/revue analytique, comptes annuels",
            "Expression d'opinion (rapports et attestations)",
            "Vérifications spécifiques du Commissariat aux comptes",
            "Missions particulières connexes (apports, fusions, procédures d’alerte, etc.)",
            "Autres (vérification des comptes)"
        ],
        "Expertise judiciaire": [
            "Expertise judiciaire"
        ],
        "Gestion du Cabinet": [
            "Propositions de service",
            "Formation",
            "Autres activités (à préciser) Assistance à la préparation des offres"
        ]
    };

    // function showSubcategories() {
    //     const categorie = document.getElementById('categorie_mission').value;
    //     const container = document.getElementById('subcategories-container');
    //     const list = document.getElementById('subcategories-list');
        
    //     list.innerHTML = ''; // Vider la liste
        
    //     if (categorie && subcategoriesData[categorie]) {
    //         // Afficher chaque sous-catégorie avec son champ d'heures
    //         subcategoriesData[categorie].forEach((sub, index) => {
    //             const item = document.createElement('div');
    //             item.className = 'row g-3 align-items-center subcategory-item';
    //             item.innerHTML = `
    //                 <div class="col-md-8">
    //                     <input type="text" class="form-control" 
    //                            name="sous_categories[${index}][nom]" 
    //                            value="${sub}" readonly>
    //                 </div>
    //                 <div class="col-md-3">
    //                     <div class="input-group">
    //                         <input type="number" class="form-control hours-input" 
    //                                name="sous_categories[${index}][heures]" 
    //                                placeholder="Heures" min="0" step="0.5">
    //                         <span class="input-group-text">h</span>
    //                     </div>
    //                 </div>
    //             `;
    //             list.appendChild(item);
    //         });
            
    //         container.style.display = 'block';
    //     } else {
    //         container.style.display = 'none';
    //     }
    // }
    function showSubcategories() {
        const categorie = document.getElementById('categorie_mission').value;
        const container = document.getElementById('subcategories-container');
        const list = document.getElementById('subcategories-list');
        
        list.innerHTML = ''; // Vider la liste
        
        if (categorie && subcategoriesData[categorie]) {
            // Afficher chaque sous-catégorie avec son champ d'heures
            subcategoriesData[categorie].forEach((sub, index) => {
                const item = document.createElement('div');
                item.className = 'row g-3 align-items-center subcategory-item';
                item.innerHTML = `
                    <div class="col-md-8">
                        <input type="text" class="form-control subcategory-input" 
                               name="sous_categories[${index}][nom]" 
                               value="${sub}" readonly
                               onmouseover="this.title=this.value">
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="number" class="form-control hours-input" 
                                   name="sous_categories[${index}][heures]" 
                                   placeholder="Heures" min="0" step="0.5">
                            <span class="input-group-text">h</span>
                        </div>
                    </div>
                `;
                list.appendChild(item);
            });
            
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }
</script>
@endsection

<!-- Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection