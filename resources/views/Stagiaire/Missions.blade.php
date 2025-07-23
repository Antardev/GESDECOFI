@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('stagiaire.create_mission') }}" method="POST" enctype="multipart/form-data" class="border rounded-3 shadow-lg overflow-hidden">
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
                                id="categorie_id" name="categorie_mission" required onchange="showSubcategories()">
                            <option value="" selected>Choisissez une catégorie</option>
                            @foreach($Categorie as $Category)
                                    <option value="{{ $Category->id }}" 
                                        {{ old('categorie_mission') == $Category->categorie_id ? 'selected' : '' }}>
                                        {{ $Category->categorie_name }}
                                    </option>
                                @endforeach
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
                                       value="{{ old('mission_begin_date') }}" max="{{ date('Y-m-d') }}" required
                                       onchange="updateEndDateMin()">
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
                                       value="{{ old('mission_end_date') }}" required
                                       max="{{ date('Y-m-d') }}" required min="" >
                            </div>
                            @error('mission_end_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Année de mission -->
                    <div class="mb-4 bg-white p-3 rounded shadow-sm">
                        <label for="year" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Semestre de la mission
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-lock text-primary"></i>
                            </span>
                            <select name="semester" class="form-select form-select-lg @error('year') is-invalid @enderror" id="">
                                <option value="">Selectionnez un semestre</option>
                                <option value="1">Première semestre {{ $year['first']['begin'].' au '.$year['first']['end'] }}</option>
                                <option value="2">Deuxième semestre {{ $year['second']['begin'].' au '.$year['second']['end'] }}</option>     
                            </select>
                            <span id='default' class="input-group-text bg-warning text-dark fw-bold">
                                Délai: Sélectionnez
                            </span>
                            <span id='first' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['first']['limite'] }}
                            </span>
                            <span id='second' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['second']['limite'] }}
                            </span>
                        </div>
                        
                        @error('year')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

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

    // function updateEndDateMin() {
    //     const beginDate = document.getElementById('mission_begin_date').value;
    //     const endDateInput = document.getElementById('mission_end_date');
    //     //const today = date();
        
    //     if (beginDate) {
    //         endDateInput.min = beginDate;
    //         //endDateInput.max = today;

    //     } else {
    //         endDateInput.min = '';
    //         //endDateInput.max = today;

    //     }
    // }


    // function showSubcategories() {
    //     const categorie = document.getElementById('categorie_mission').value;
    //     const container = document.getElementById('subcategories-container');
    //     const list = document.getElementById('subcategories-list');
        
    //     list.innerHTML = '';

    //     if (categorie && subcategoriesData[categorie]) {
    //         subcategoriesData[categorie].forEach((sub, index) => {
    //             const item = document.createElement('div');
    //             const key = sub[0]; // Utilise la première valeur comme clé
    //             const name = sub[1]; // Utilise la deuxième valeur comme nom

    //             item.className = 'row g-3 align-items-center subcategory-item';
    //             item.innerHTML = `
    //                 <div class="col-md-8">
    //                     <input type="text" class="form-control subcategory-input" 
    //                            name="sous_categories[${index}][nom]" 
    //                            value="${name}" readonly
    //                            onmouseover="this.title=this.value">
    //                 </div>
    //                 <div class="col-md-3">
    //                     <div class="input-group">
    //                         <input type="number" class="form-control hours-input" 
    //                                name="sous_categories[${index}][heures]" 
    //                                placeholder="Heures" value="0" min="0" step="0.5">
    //                         <span class="input-group-text">h</span>
    //                     </div>
    //                 </div>
    //                 <input type="number" hidden name="sous_categories[${index}][ref]" value="${key}">
    //             `;
    //             list.appendChild(item);
    //         });
            
    //         container.style.display = 'block';
    //     } else {
    //         container.style.display = 'none';
    //     }
    //      }

    // Au début de votre script
document.addEventListener('DOMContentLoaded', function() {
    // Stockez toutes les sous-catégories dans un objet global
    window.allSubcategories = {};
    
    // Remplissez l'objet avec les données des catégories
    @foreach($Categorie as $category)
        window.allSubcategories["{{ $category->id }}"] = [
            @foreach($category->subCategories as $sub)
                {
                    id: "{{ $sub->id }}",
                    name: "{{ $sub->subcategorie_name }}"
                },
            @endforeach
        ];
    @endforeach

    // Initialisez les autres fonctions
    updateDeadlineDisplay();
    
    // Chargez les sous-catégories si une catégorie est déjà sélectionnée
    const initialCategory = document.getElementById('categorie_id').value;
    if (initialCategory) {
        showSubcategories();
    }
});

// Modifiez la fonction showSubcategories
function showSubcategories() {
    const categorieId = document.getElementById('categorie_id').value;
    const container = document.getElementById('subcategories-container');
    const list = document.getElementById('subcategories-list');
    
    list.innerHTML = '';
    container.style.display = 'none';

    if (!categorieId || !window.allSubcategories[categorieId]) {
        return;
    }

    const subcategories = window.allSubcategories[categorieId];
    
    if (subcategories.length > 0) {
        subcategories.forEach((subcategory, index) => {
            const item = document.createElement('div');
            item.className = 'row g-3 align-items-center subcategory-item';
            item.innerHTML = `
                <div class="col-md-8">
                    <input type="text" class="form-control subcategory-input" 
                           name="sous_categories[${index}][nom]" 
                           value="${subcategory.name}" readonly
                           title="${subcategory.name}">
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="number" class="form-control hours-input" 
                               name="sous_categories[${index}][heures]" 
                               placeholder="Heures" value="0" min="0" step="0.5">
                        <span class="input-group-text">h</span>
                    </div>
                </div>
                <input type="hidden" name="sous_categories[${index}][ref]" value="${subcategory.id}">
            `;
            list.appendChild(item);
        });
        
        container.style.display = 'block';
    } else {
        list.innerHTML = '<div class="alert alert-info">Aucune sous-catégorie disponible</div>';
        container.style.display = 'block';
    }
}
    document.addEventListener('DOMContentLoaded', function() {
    // Récupération des éléments
    const semestreSelect = document.querySelector('select[name="year"]');
    const deadlineSpans = {
        default: document.getElementById('default'),
        first: document.getElementById('first'),
        second: document.getElementById('second'),
    };

    // Fonction pour gérer le changement de sélection
    function updateDeadlineDisplay() {
        // Masquer tous les spans de délai
        Object.values(deadlineSpans).forEach(span => {
            span.style.display = 'none';
        });

        // Afficher le span correspondant ou le span par défaut
        const selectedValue = semestreSelect.value;
        if (selectedValue && deadlineSpans[selectedValue]) {
            deadlineSpans[selectedValue].style.display = 'inline-block';
        } else {
            deadlineSpans.default.style.display = 'inline-block';
        }
    }



    // Écouteur d'événement pour le changement de sélection
    semestreSelect.addEventListener('change', updateDeadlineDisplay);

    // Initialisation au chargement de la page
    updateDeadlineDisplay();
});

function updateEndDateMin() {
    const beginDate = document.getElementById('mission_begin_date').value;
    const endDateInput = document.getElementById('mission_end_date');
    
    if (beginDate) {
        // Définir le min de la date de fin comme la date de début
        endDateInput.min = beginDate;
        
        // Si la date de fin actuelle est avant la nouvelle date de début, la réinitialiser
        if (endDateInput.value && endDateInput.value < beginDate) {
            endDateInput.value = '';
        }
    }
    
    // Activer le champ date de fin seulement si date de début est sélectionnée
    endDateInput.disabled = !beginDate;
}
</script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/assets/app.js')}}"></script>
@endsection

<!-- Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection