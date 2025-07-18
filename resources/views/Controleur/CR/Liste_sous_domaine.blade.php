@extends('welcome')
@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">
                    <i class="bi bi-diagram-2 me-2"></i>Liste des Sous-Domaines
                </h1>
                <a href="" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter un Sous-Domaine
                </a>
            </div>
            <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sous-Domaines</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Barre de recherche et filtres -->
            <div class="row mb-3 g-2">
                <div class="col-md-6">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Rechercher..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end gap-2">
                        {{-- <select class="form-select w-auto" name="domain" id="domainFilter">
                            <option value="">Tous les domaines</option>
                            @foreach($domains as $domain)
                                <option value="{{ $domain->id }}" {{ request('domain') == $domain->id ? 'selected' : '' }}>
                                    {{ $domain->name }}
                                </option>
                            @endforeach
                        </select> --}}
                        <button class="btn btn-outline-primary" id="exportBtn">
                            <i class="bi bi-download me-1"></i> Exporter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tableau des sous-domaines -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Domaine Parent</th>
                            {{-- <th>Description</th> --}}
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sub_domains as $subdomain)
                        <tr>
                            <td>{{ $subdomain->id }}</td>
                            <td>
                                <strong>{{ $subdomain->name }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $subdomain->domain->name }}
                                </span>
                            </td>
                            {{-- <td>
                                @if($subdomain->description)
                                    {{ Str::limit($subdomain->description, 50) }}
                                @else
                                    <span class="text-muted">Aucune description</span>
                                @endif
                            </td> --}}
                            <td>
                                {{ $subdomain->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="" 
                                       class="btn btn-outline-primary"
                                       
                                       title="Modifier">
                                       modifier
                                        <i class="" data-feather=""> </i>
                                    </a>
                                    <form action="" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger"
                                                data-bs-toggle="tooltip"
                                                title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sous-domaine ?')">
                                            <i class="align-middle" data-feather="trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-folder-x fs-1 text-muted"></i>
                                    <span class="mt-2">Aucun sous-domaine trouvé</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{-- {{ $subdomains->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activation des tooltips
    const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltips.map(function (tooltipTrigger) {
        return new bootstrap.Tooltip(tooltipTrigger);
    });

    // Filtre par domaine
    document.getElementById('domainFilter').addEventListener('change', function() {
        const domainId = this.value;
        const url = new URL(window.location.href);
        
        if (domainId) {
            url.searchParams.set('domain', domainId);
        } else {
            url.searchParams.delete('domain');
        }
        
        window.location.href = url.toString();
    });

    // Export des données
    document.getElementById('exportBtn').addEventListener('click', function() {
        // Ici vous pouvez ajouter la logique d'export
        alert('Fonctionnalité d\'export à implémenter');
    });
});
</script>
@endpush

<style>
    .badge {
        font-weight: normal;
        padding: 0.35em 0.65em;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>