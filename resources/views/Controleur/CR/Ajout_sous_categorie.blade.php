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

                    <form method="POST" id="myForm" action="{{route('save_sous_categorie')}}">
                        @csrf

                        <div class="mb-3">
                            <label for="categorie_id" class="form-label"><strong>Categorie parent</strong></label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                    id="categorie_id" name="categorie_id" required>
                                <option value="">Sélectionnez une Categorie</option>
                                @foreach($categories as $Category)
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
                            
                            <button type="submit"  class="btn btn-primary" form="myForm"  onclick="event.preventDefault(); document.getElementById('myForm').submit();">
                                <i class="align-middle" data-feather="save"></i> Enregistrer
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-layers me-2"></i>Sous-catégories existantes  
                    </h5>
                </div>
                
                <div class="card-body">
                        <div class="mb-3">
                            <!-- <label class="form-label"><strong>Sous-catégories existantes</strong></label> !-->
                            <div id="subcategories-list" class="list-group">
                                <div class="list-group-item text-muted">
                                    Sélectionnez une catégorie pour voir ses sous-catégories
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'édition -->
<div class="modal fade" id="editSubcategoryModal" tabindex="-1" aria-labelledby="editSubcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubcategoryModalLabel">Modifier la sous-catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSubcategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_subcategorie_name" class="form-label">Nom de la sous-catégorie</label>
                        <input type="text" class="form-control" id="edit_subcategorie_name" name="subcategorie_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    function getCsrfToken(form) {
        const tokenInput = form.querySelector('input[name="_token"]');
        return tokenInput ? tokenInput.value : '';
    }

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
                    console.log(subcategory.active == 1);
                        html += `
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                ${subcategory.subcategorie_name} 
                                <div class="ms-auto">
                                    <button onclick="editSubcategory(${subcategory.id}, '${subcategory.subcategorie_name}')" class="btn btn-sm btn-outline-warning me-1">
                                        Modifier
                                    </button>
                                    <form action="/subcategories/${subcategory.id}/${subcategory.active == 1? 'deactivate' : 'activate'}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="confirmToggle(this.form, ${subcategory.id}, ${subcategory.active})" class="btn btn-sm ${subcategory.active ? 'btn-outline-danger' : 'btn-outline-success'}">
                                            ${subcategory.active == 1? 'Désactiver' : 'Activer'}
                                        </button>
                                    </form>
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

    // Fonction d'édition de sous-catégorie
    window.editSubcategory = function(id, name) {
        const form = document.getElementById('editSubcategoryForm');
        form.action = `/subcategories/${id}`; // Mettre à jour l'action du formulaire
        document.getElementById('edit_subcategorie_name').value = name; // Remplir le champ

        // Afficher la modale
        const modal = new bootstrap.Modal(document.getElementById('editSubcategoryModal'));
        modal.show();
    };

    // Fonction de confirmation pour activer/désactiver une sous-catégorie
        window.confirmToggle = function(form, id, isActive) {
            const action = isActive ? 'désactiver' : 'activer';
            Swal.fire({
                title: `Voulez-vous vraiment ${action} cette sous-catégorie ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    toggleSubcategory(form, id, isActive);
                }
            });
        }

    // Fonction pour activer/désactiver une sous-catégorie
    window.toggleSubcategory = function(form, id, isActive) {
        const action = isActive ? 'deactivate' : 'activate';
        fetch(`/subcategories/${id}/${action}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(form),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                loadSubCategories(categorySelect.value); // Recharger la liste
                Swal.fire(`Sous-catégorie ${isActive ? 'désactivée' : 'activée'} avec succès`);
            } else {
                throw new Error('Erreur lors de la mise à jour');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Erreur', 'Erreur lors de la mise à jour', 'error');
        });
    };
});
</script>
@endsection