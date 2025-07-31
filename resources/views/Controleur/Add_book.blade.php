@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter un nouveau livre
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('add_book.store') }}" enctype="multipart/form-data" id="bookForm">
                        @csrf
                        
                        <!-- Titre -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre du livre *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sous-titre -->
                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Sous-titre</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                   id="subtitle" name="subtitle" value="{{ old('subtitle') }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Catégories -->
                        <div class="mb-3">
                            <label for="categories_input" class="form-label">Catégories *</label>
                            <input type="text" class="form-control mb-2 @error('categories') is-invalid @enderror" 
                                   id="categories_input" name="categories_input" 
                                   value="{{ old('categories_input') }}" readonly required>
                            <input type="hidden" name="categories" id="categories" value="{{ old('categories') }}">
                            
                            <div class="mb-2">
                                <small>Catégories existantes :</small>
                                <div class="d-flex flex-wrap gap-2 mt-1" id="existing_categories">
                                    @foreach($categories as $category)
                                        <button type="button" class="btn btn-sm btn-outline-primary category-btn" 
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                            {{ $category->name }}
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-category-btn" 
                        data-id="{{ $category->id }}" title="Supprimer cette catégorie">
                    <i class="bi bi-trash"></i>
                </button>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="input-group mt-3">
                                <input type="text" class="form-control @error('new_category') is-invalid @enderror" 
                                       id="new_category" placeholder="Nom de la nouvelle catégorie">
                                <button type="button" class="btn btn-primary" id="add_category">
                                    <i class="bi bi-plus-lg"></i> Ajouter
                                </button>
                            </div>
                            @error('categories')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fichier PDF -->
                        <div class="mb-3">
                            <label for="file" class="form-label">Fichier PDF *</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="livre" accept=".pdf" required>
                            <small class="form-text text-muted">Taille maximale : 10MB</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('add_category');
    const newCatInput = document.getElementById('new_category');
    const categoriesInput = document.getElementById('categories_input');
    const categoriesHidden = document.getElementById('categories');
    const existingCategoriesContainer = document.getElementById('existing_categories');
    
    // Initialiser avec les anciennes valeurs si erreur de validation
    let selectedCategories = [];
    @if(old('categories'))
        const oldCategories = "{{ old('categories') }}".split(',');
        const oldCategoriesNames = "{{ old('categories_input') }}".split(', ');
        
        oldCategories.forEach((id, index) => {
            if(id && oldCategoriesNames[index]) {
                selectedCategories.push({
                    id: id,
                    name: oldCategoriesNames[index]
                });
                
                // Marquer les boutons correspondants comme sélectionnés
                const btn = document.querySelector(`.category-btn[data-id="${id}"]`);
                if(btn) {
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-primary');
                }
            }
        });
        updateCategoriesDisplay();
    @endif
    
    // Gestion du clic sur les boutons de catégories existantes
    existingCategoriesContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('category-btn')) {
            const categoryId = e.target.getAttribute('data-id');
            const categoryName = e.target.getAttribute('data-name');
            
            toggleCategory(categoryId, categoryName, e.target);
        }
    });
    
    // Ajout d'une nouvelle catégorie
    addBtn.addEventListener('click', async function() {
        const categoryName = newCatInput.value.trim();
        if (!categoryName) {
            alert("Veuillez entrer un nom de catégorie.");
            newCatInput.focus();
            return;
        }
        
        // Vérifier si la catégorie existe déjà localement
        const existingBtn = [...document.querySelectorAll('.category-btn')].find(
            btn => btn.textContent.trim().toLowerCase() === categoryName.toLowerCase()
        );
        
        if (existingBtn) {
            const categoryId = existingBtn.getAttribute('data-id');
            const existingName = existingBtn.getAttribute('data-name');
            toggleCategory(categoryId, existingName, existingBtn);
            newCatInput.value = '';
            return;
        }
        
        // Change button text and disable it to prevent multiple submissions
        const originalBtnText = addBtn.innerHTML;
        addBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Ajout...';
        addBtn.disabled = true;
        
        try {
            const response = await fetch("{{ route('categories.quick-add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name: categoryName })
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Erreur lors de l\'ajout de la catégorie');
            }
            
            // Ajouter la nouvelle catégorie aux sélectionnées
            selectedCategories.push({ id: data.id, name: data.name });
            updateCategoriesDisplay();
            
            // Ajouter la catégorie à la liste des existantes
            const newBtn = document.createElement('button');
            newBtn.type = 'button';
            newBtn.className = 'btn btn-sm btn-primary category-btn';
            newBtn.setAttribute('data-id', data.id);
            newBtn.setAttribute('data-name', data.name);
            newBtn.textContent = data.name;
            existingCategoriesContainer.appendChild(newBtn);
            
            newCatInput.value = ''; // Clear input
            newCatInput.focus(); // Focus back on input
            
        } catch (error) {
            console.error('Erreur:', error);
            alert(error.message || "Erreur lors de l'ajout de la catégorie");
        } finally {
            // Reset button text and enable it
            addBtn.innerHTML = originalBtnText;
            addBtn.disabled = false;
        }
    });
    
    // Fonction pour basculer une catégorie
    function toggleCategory(categoryId, categoryName, buttonElement) {
        const index = selectedCategories.findIndex(cat => cat.id === categoryId);
        
        if (index === -1) {
            // Ajouter la catégorie
            selectedCategories.push({ id: categoryId, name: categoryName });
            if(buttonElement) {
                buttonElement.classList.remove('btn-outline-primary');
                buttonElement.classList.add('btn-primary');
            }
        } else {
            // Retirer la catégorie
            selectedCategories.splice(index, 1);
            if(buttonElement) {
                buttonElement.classList.remove('btn-primary');
                buttonElement.classList.add('btn-outline-primary');
            }
        }
        
        updateCategoriesDisplay();
    }
    
    // Mise à jour de l'affichage des catégories sélectionnées
    function updateCategoriesDisplay() {
        // Mettre à jour l'input visible
        categoriesInput.value = selectedCategories.map(cat => cat.name).join(', ');
        
        // Mettre à jour le champ caché avec les IDs
        categoriesHidden.value = selectedCategories.map(cat => cat.id).join(',');
        
        // Valider qu'au moins une catégorie est sélectionnée
        if(selectedCategories.length > 0) {
            categoriesInput.classList.remove('is-invalid');
        } else {
            categoriesInput.classList.add('is-invalid');
        }
    }
});
</script>

<style>
.category-btn {
    transition: all 0.2s ease;
}
</style>
@endsection