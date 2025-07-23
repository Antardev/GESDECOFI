

@extends('welcome')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
          
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Assistants</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('access_denied'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('access_denied') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">
                    <i class="bi bi-people-fill me-2"></i>Liste des Assistants
                </h1>
                <a href="{{ route('controleur.Add_assistant') }}" class="btn btn-primary">
                    <i class="align-middle" data-feather="plus"></i> Ajouter un Assistant
                </a>
            </div>
            <!-- Barre de recherche -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Rechercher un assistant..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tableau des assistants -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            {{-- <th>Statut</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assistants as $assistant)
                        <tr class="{{ $assistant->is_active ? '' : 'table-secondary' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $assistant->full_name }}</td>
                            <td>{{ $assistant->email }}</td>
                            <td>{{ $assistant->phone ?? 'Non renseigné' }}</td>
                            {{-- <td>
                                <span class="badge rounded-pill bg-{{ $assistant->is_active ? 'success' : 'danger' }}">
                                    {{ $assistant->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td> --}}
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('controleur.assistant_feature', $assistant->id) }}" 
                                       class="btn btn-outline-primary"
                                       title="Modifier">
                                        <i class="align-middle" data-feather="eye"> </i> voir
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-people fs-1 text-muted"></i>
                                    <span class="mt-2">Aucun assistant trouvé</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .badge {
        font-weight: 500;
    }
    .table-secondary {
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activation des tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Confirmation avant désactivation/activation
    const statusForms = document.querySelectorAll('form[action*="toggle-status"]');
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const isActive = this.querySelector('button').title === 'Désactiver';
            
            Swal.fire({
                title: `Confirmer ${isActive ? 'la désactivation' : 'l\'activation'}`,
                text: `Êtes-vous sûr de vouloir ${isActive ? 'désactiver' : 'activer'} cet assistant ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Oui, ${isActive ? 'désactiver' : 'activer'}`,
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
});
</script>
@endpush