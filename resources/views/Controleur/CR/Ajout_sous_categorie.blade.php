{{-- @extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-layers me-2"></i>Ajouter un sous-categorie 
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="">
                        
                        @csrf

                       
                        <div class="mb-3">
                            <label for="Category" class="form-label"> <strong>Categorie parent</strong> </label>
                            <select class="form-select @error('Category') is-invalid @enderror" 
                                    id="Category" name="Category" required>
                                <option value="">Sélectionnez une Categorie</option>
                                @foreach($Categorie as $Category)
                                    <option value="{{ $Category->id }}" 
                                        {{ old('Category') == $Category->categorie_id ? 'selected' : '' }}>
                                        {{ $Category->categorie_name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('domain')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        
                        <div class="mb-3">
                            <label for="subcategorie_name" class="form-label"><strong>Nom de la sous-categorie</strong></label>
                            <input type="text" class="form-control @error('subcategorie_name') is-invalid @enderror" 
                                   id="subcategorie_name" name="subcategorie_name" 
                                   value="{{ old('subcategorie_name') }}" 
                                   placeholder="" required>
                            
                            @error('subcategorie_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                      

                        <div class="d-flex justify-content-between">
                            <a href="" class="btn btn-outline-secondary">
                                <i class="align-middle" data-feather="arrow-left"></i> Retour
                            </a>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="align-middle"  data-feather="save" ></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-layers me-2"></i>Ajouter une sous-categorie 
                    </h5>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <form method="POST" action="{{route('save_sous_categorie')}}">
                        @csrf

                        <!-- Sélection du domaine parent -->
                        <div class="mb-3">
                            <label for="categorie_id" class="form-label"><strong>Categorie parent</strong></label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                    id="categorie_id" name="categorie_id" required>
                                <option value="">Sélectionnez une Categorie</option>
                                @foreach($Categorie as $Category)
                                    <option value="{{ $Category->id }}" 
                                        {{ old('categorie_id') == $Category->id ? 'selected' : '' }}>
                                        {{ $Category->categorie_name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('categorie_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Liste des sous-catégories existantes -->
                        <div class="mb-3">
                            <label class="form-label"><strong>Sous-catégories existantes</strong></label>
                            <div id="subcategories-list" class="list-group">
                                <div class="list-group-item text-muted">
                                    Sélectionnez une catégorie pour voir ses sous-catégories
                                </div>
                            </div>
                        </div>

                        <!-- Nom du sous-domaine -->
                        <div class="mb-3">
                            <label for="subcategorie_name" class="form-label"><strong>Nom de la nouvelle sous-categorie</strong></label>
                            <input type="text" class="form-control @error('subcategorie_name') is-invalid @enderror" 
                                   id="subcategorie_name" name="subcategorie_name" 
                                   value="{{ old('subcategorie_name') }}" 
                                   placeholder="Ajouter une nouvelle sous-categorie" required>
                            
                            @error('subcategorie_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="" class="btn btn-outline-secondary">
                                <i class="align-middle" data-feather="arrow-left"></i> Retour
                            </a>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="align-middle" data-feather="save"></i> Enregistrer
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
    const categorySelect = document.getElementById('categorie_id');
    const subcategoriesList = document.getElementById('subcategories-list');
    
    // Fonction pour charger les sous-catégories
    function loadSubCategories(categoryId) {
        if (!categoryId) {
            subcategoriesList.innerHTML = `
                <div class="list-group-item text-muted">
                    Sélectionnez une catégorie pour voir ses sous-catégories
                </div>`;
            return;
        }
        
        // Afficher un indicateur de chargement
        subcategoriesList.innerHTML = `
            <div class="list-group-item text-center">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                Chargement des sous-catégories...
            </div>`;
        
        // Récupérer les sous-catégories via AJAX
        fetch(`/get-subcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let html = '';
                    data.forEach(subcategory => {
                        html += `
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                ${subcategory.subcategorie_name} 
                                <div class="ms-auto">
                                    <a href="" class="btn btn-sm btn-outline-primary me-1">Edit</a>

                                     <button onclick="confirmDelete(${subcategory.id})" class="btn btn-sm btn-outline-danger">
                                        <i class="align-middle" data-feather="trash"> delete</i>
                                    </button>
                                </div>
                            </div>`;
                    });
                    subcategoriesList.innerHTML = html;
                } else {
                    subcategoriesList.innerHTML = `
                        <div class="list-group-item text-muted">
                            Aucune sous-catégorie existante pour cette catégorie
                        </div>`;
                }
            })
            .catch(error => {
                subcategoriesList.innerHTML = `
                    <div class="list-group-item text-danger">
                        Erreur lors du chargement des sous-catégories
                    </div>`;
                console.error('Error:', error);
            });
    }
    
    // Écouter les changements de sélection
    categorySelect.addEventListener('change', function() {
        loadSubCategories(this.value);
    });
    
    // Charger les sous-catégories au démarrage si une catégorie est déjà sélectionnée
    if (categorySelect.value) {
        loadSubCategories(categorySelect.value);
    }


     // Fonction de confirmation de suppression
     window.confirmDelete = function(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette sous-catégorie ?')) {
            fetch(`/delete-sous-categorie/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    loadSubCategories(categorySelect.value); // Recharger la liste
                    // Afficher un message de succès (vous pouvez utiliser Toast ou autre)
                    alert('Sous-catégorie supprimée avec succès');
                } else {
                    throw new Error('Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la suppression');
            });
        }
    };
    
    categorySelect.addEventListener('change', function() {
        loadSubCategories(this.value);
    });
    
    if (categorySelect.value) {
        loadSubCategories(categorySelect.value);
    }
});
</script>
@endsection