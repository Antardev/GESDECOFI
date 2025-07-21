@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-layers me-2"></i>Liste des Catégories
                    </h5>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Nombre de sous-catégories</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->categorie_name }}</td>
                                    <td>{{ $category->subCategories->count() }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary view-subcategories" 
                                                data-category-id="{{ $category->id }}">
                                            <i class="bi bi-eye"></i> Voir
                                        </button>
                                    </td>
                                </tr>
                                <!-- Ligne des sous-catégories (cachée par défaut) -->
                                <tr id="subcategories-{{ $category->id }}" class="subcategories-row" style="display: none;">
                                    <td colspan="3">
                                        <div class="p-3 bg-light rounded">
                                            <h6 class="fw-bold mb-3">Sous-catégories :</h6>
                                            @if($category->subCategories->count() > 0)
                                                <ul class="list-group">
                                                    @foreach($category->subCategories as $subcategory)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $subcategory->subcategorie_name }}
                                                        <div>
                                                            <a href="" 
                                                               class="btn btn-sm btn-outline-warning me-1">
                                                                <i class="bi bi-pencil"> edit</i>
                                                            </a>
                                                            
                                                            <button class="btn btn-sm btn-outline-danger delete-subcategory" 
                                                            data-id="{{ $subcategory->id }}"
                                                            title="Supprimer">
                                                        <i class="bi bi-trash"> supprimer </i>
                                                    </button>
                                                    
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="alert alert-info mb-0">
                                                    Aucune sous-catégorie disponible
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .subcategories-row td {
        border-top: none;
        padding-top: 0;
        padding-bottom: 0;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'affichage des sous-catégories
    document.querySelectorAll('.view-subcategories').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');
            const subcatRow = document.getElementById(`subcategories-${categoryId}`);
            
            // Masquer toutes les autres lignes de sous-catégories
            document.querySelectorAll('.subcategories-row').forEach(row => {
                if (row.id !== `subcategories-${categoryId}`) {
                    row.style.display = 'none';
                }
            });
            
            // Basculer l'affichage de la ligne courante
            subcatRow.style.display = subcatRow.style.display === 'none' ? 'table-row' : 'none';
            
            // Changer l'icône du bouton
            const icon = this.querySelector('i');
            if (subcatRow.style.display === 'none') {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
                this.innerHTML = '<i class="" data-feather="eye"></i> Voir';
            } else {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
                this.innerHTML = '<i class="bi bi-eye-slash"></i> Masquer';
            }
        });
    });

    document.querySelectorAll('.delete-subcategory').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const subcategoryId = this.getAttribute('data-id');
            const deleteUrl = `/delete-sous-categorie/${subcategoryId}`;
            
            Swal.fire({
                title: 'Confirmer la suppression',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Créer un formulaire virtuel pour la suppression
                    const form = document.createElement('form');
                    form.method = 'get';
                    form.action = deleteUrl;
                    
                    // Ajouter le token CSRF
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrfInput);
                    
                    // Ajouter la méthode spoofing pour DELETE
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                    
                    // Ajouter le formulaire au DOM et le soumettre
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});

</script>
@endsection