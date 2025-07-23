
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
                                        <th class="text-center">Nombre de sous-catégories</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->categorie_name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $category->subCategories->count() }}
                                            </span>
                                        </td>
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
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-outline-warning me-1 edit-subcategory"
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#editSubcategoryModal"
                                                                        data-id="{{ $subcategory->id }}"
                                                                        data-name="{{ $subcategory->subcategorie_name }}">
                                                                    <i class="bi bi-pencil"></i> Modifier
                                                                </button>

                                                                <form action="{{ $subcategory->active ? route('subcategories.deactivate', $subcategory->id) : route('subcategories.activate', $subcategory->id) }}" 
                                                                    method="POST" 
                                                                    class="d-inline toggle-activation-form">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" 
                                                                        class="btn btn-sm {{ $subcategory->active ? 'btn-outline-danger' : 'btn-outline-success' }} toggle-activation"
                                                                        data-id="{{ $subcategory->id }}">
                                                                    <i class="bi {{ $subcategory->active ? 'bi-slash-circle' : 'bi-check-circle' }}"></i> 
                                                                    {{ $subcategory->active ? 'Désactiver' : 'Activer' }}
                                                                </button>
                                                              </form>
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
                            <label for="subcategoryName" class="form-label">Nom de la sous-catégorie</label>
                            <input type="text" class="form-control" id="subcategoryName" name="subcategorie_name" required>
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
        .badge {
            font-size: 0.9em;
            padding: 0.35em 0.65em;
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
                    this.innerHTML = '<i class="bi bi-eye"></i> Voir';
                } else {
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                    this.innerHTML = '<i class="bi bi-eye-slash"></i> Masquer';
                }
            });
        });

        // Gestion du modal d'édition
        const editModal = document.getElementById('editSubcategoryModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const subcategoryId = button.getAttribute('data-id');
                const subcategoryName = button.getAttribute('data-name');

                // Mettre à jour le formulaire
                const form = document.getElementById('editSubcategoryForm');
                form.action = `/subcategories/${subcategoryId}`;

                // Remplir les champs
                document.getElementById('subcategoryName').value = subcategoryName;
            });
        }

        // Gestion de la désactivation
        document.addEventListener('DOMContentLoaded', function() {
    // Autres gestionnaires...

    // Gestion de la désactivation
    document.querySelectorAll('.toggle-activation').forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const subcategoryId = this.getAttribute('data-id');
            const isActive = this.getAttribute('data-active') === 'true';

            const confirmation = await Swal.fire({
                title: `Voulez-vous vraiment ${isActive ? 'désactiver' : 'activer'} cette sous-catégorie ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Oui, ${isActive ? 'désactiver' : 'activer'}`,
                cancelButtonText: 'Annuler'
            });

            if (confirmation.isConfirmed) {
                try {
                    const response = await fetch(form.action, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Mise à jour de l'interface
                        const newActiveState = !isActive; // Inverse l'état
                        const button = form.querySelector('.toggle-activation');

                        // Changement du bouton
                        button.setAttribute('data-active', newActiveState);
                        button.innerHTML = `<i class="bi ${newActiveState ? 'bi-slash-circle' : 'bi-check-circle'}"></i> ${newActiveState ? 'Désactiver' : 'Activer'}`;
                        button.className = `btn btn-sm ${newActiveState ? 'btn-outline-danger' : 'btn-outline-success'} toggle-activation`;

                        // Mise à jour de l'action du formulaire
                        form.action = newActiveState 
                            ? `/subcategories/${subcategoryId}/deactivate` 
                            : `/subcategories/${subcategoryId}/activate`;

                        // Notification
                        Swal.fire(
                            'Succès!',
                            `Sous-catégorie ${newActiveState ? 'désactivée' : 'activée'} avec succès.`,
                            'success'
                        );
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire(
                        'Erreur!',
                        'Une erreur est survenue lors de la mise à jour.',
                        'error'
                    );
                }
            }
        });
    });
});
    });
    </script>
@endsection