@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
            <h2 class="text-center mb-4">Liste des Missions</h2>
        </div>
        
        <div class="card-body">
            <!-- Barre de recherche et filtres -->
            <div class="row mb-3 g-2">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select" id="typeFilter">
                        <option value="">Tous les types</option>
                        <option value="National">National</option>
                        <option value="Regional">Régional</option>
                        <option value="Local">Local</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Pays</th>
                            <th>Type</th>
                            <th>Affiliation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($controleurs as $controleur)
                        <tr>
                            <td>{{ $controleur->name }}</td>
                            <td>{{ $controleur->firstname }}</td>
                            <td>{{ $controleur->email }}</td>
                            <td>
                                @if($controleur->phone)
                                    +{{ $controleur->phone_code }} {{ $controleur->phone }}
                                @else
                                    <span class="text-muted">Non renseigné</span>
                                @endif
                            </td>
                            <td>{{ $controleur->country }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $controleur->type == 'National' ? 'primary' : 
                                    ($controleur->type == 'Regional' ? 'info' : 'secondary')
                                }}">
                                    {{ $controleur->type }}
                                </span>
                            </td>
                            <td>{{ $controleur->affiliation ?? '-' }}</td>
                            <td>
                                {{-- <div class="btn-group btn-group-sm">
                                    <a href="" 
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip" 
                                       title="Voir détails">
                                        <i class="align-item" data-feather="eye"></i>
                                        voir
                                    </a>
                                   
                                </div> --}}
                                <button class="btn btn-outline-secondary" data-id="{{ $controleur->id }}">  <i class="align-item" data-feather="eye"></i> Voir </button>
                            </td>
                        </tr>
                       
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{-- {{ $controleurs->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function(){

        const voirButtons = document.querySelectorAll('.btn-outline-secondary');

        voirButtons.forEach(button => {
            button.addEventListener('click', function(){
                const id = this.getAttribute('data-id');

                if(id){
                    window.location.href = `/admin/details_controleurs/${id}`;
                }
                else {
                    console.error('ID du controleur non trouvé');
                }
            })
        })
    })
</script>
{{-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activation des tooltips
    const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltips.map(function (tooltipTrigger) {
        return new bootstrap.Tooltip(tooltipTrigger)
    })

    // Filtre par type
    document.getElementById('typeFilter').addEventListener('change', function() {
        const type = this.value.toLowerCase()
        document.querySelectorAll('tbody tr').forEach(row => {
            if (!type) {
                row.style.display = ''
                return
            }
            const rowType = row.querySelector('td:nth-child(6)').textContent.toLowerCase()
            row.style.display = rowType.includes(type) ? '' : 'none'
        })
    })

    // Recherche
    document.getElementById('searchInput').addEventListener('input', function() {
        const term = this.value.toLowerCase()
        document.querySelectorAll('tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase()
            row.style.display = text.includes(term) ? '' : 'none'
        })
    })
})
</script>
@endpush --}}