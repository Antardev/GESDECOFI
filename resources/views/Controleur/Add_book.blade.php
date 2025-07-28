@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                <!-- En-tête avec fond coloré -->
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-book-open fa-3x me-4"></i>
                        <div>
                            <h2 class="mb-1 text-center">Ajouter un nouveau livre</h2>
                            <p class="mb-0 text-center opacity-75">Complétez les informations ci-dessous</p>
                        </div>
                    </div>
                </div>
                
                <!-- Corps du formulaire -->
                <div class="card-body p-5">
                    <form id="addBookForm" method="POST" action="{{ route('add_book.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Titre -->
                        <div class="mb-4 form-floating">
                            <input type="text" class="form-control border-2 border-primary rounded-pill" 
                                   id="bookTitle" name="title" placeholder=" " required>
                            <label for="bookTitle" class="ms-3">Titre du livre*</label>
                            <div class="invalid-feedback ps-3">Veuillez saisir un titre</div>
                        </div>
                        
                        <!-- Sous-titre -->
                        <div class="mb-4 form-floating">
                            <input type="text" class="form-control border-2 rounded-pill" 
                                   id="bookSubtitle" name="subtitle" placeholder=" ">
                            <label for="bookSubtitle" class="ms-3">Sous-titre (optionnel)</label>
                        </div>
                        
                        <!-- Catégorie -->
                        <div class="mb-4 form-floating">
                            <input type="text" class="form-control border-2 border-primary rounded-pill" 
                                   id="bookCategory" name="category" placeholder=" " required>
                            <label for="bookCategory" class="ms-3">Categorie*</label>
                            <div class="invalid-feedback ps-3">Veuillez saisir une categorie</div>
                        </div>
                        
                        <!-- Fichier PDF -->
                        <div class="mb-4">
                            <label for="bookFile" class="form-label ps-2 fw-bold">Fichier PDF*</label>
                            <div class="file-upload-wrapper border-2 rounded-pill p-1 bg-light">
                                <input type="file" class="form-control d-none" id="bookFile" name="livre" accept=".pdf" required>
                                <label for="bookFile" class="d-flex align-items-center justify-content-between p-3">
                                    <span class="text-truncate pe-2" id="fileLabel">Choisir un fichier...</span>
                                    <span class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>Parcourir
                                    </span>
                                </label>
                            </div>
                            <div class="invalid-feedback ps-3">Un fichier PDF est requis</div>
                            <div class="form-text ps-3">Taille maximale : 10MB</div>
                        </div>
                        
                        <!-- Bouton de soumission -->
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold">
                                <i class="fas fa-plus-circle me-2"></i>AJOUTER LE LIVRE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles personnalisés */
.bg-gradient-primary {
    background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
}

.card {
    border: none;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.form-control, .form-select {
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #3a7bd5;
    box-shadow: 0 0 0 0.25rem rgba(58, 123, 213, 0.25);
}

.file-upload-wrapper {
    transition: all 0.3s ease;
    border-color: #dee2e6;
}

.file-upload-wrapper:hover {
    border-color: #3a7bd5;
    background-color: rgba(58, 123, 213, 0.05) !important;
}

.rounded-pill {
    border-radius: 50rem !important;
}

.btn-primary {
    background-color: #3a7bd5;
    border-color: #3a7bd5;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #2c65b8;
    border-color: #2c65b8;
    transform: translateY(-2px);
}

.invalid-feedback {
    font-size: 0.85rem;
}

/* Animation pour les champs flottants */
.form-floating>label {
    transition: all 0.2s ease;
}

@media (max-width: 768px) {
    .card-body {
        padding: 2rem;
    }
}
</style>

<script>
// Afficher le nom du fichier sélectionné
document.getElementById('bookFile').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Choisir un fichier...';
    document.getElementById('fileLabel').textContent = fileName;
});

// Validation du formulaire
(function() {
    'use strict';
    const form = document.getElementById('addBookForm');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
})();
</script>
@endsection