@extends('welcome')

@section('content')
<div style="background: url('{{ asset('assets/img/1.png') }}') no-repeat center center fixed; 
            background-size: cover;
            min-height: 100vh;
            padding: 40px 0;">
    
    <!-- Overlay avec effet de verre (glass morphism) -->
    <div class="container py-4" style="background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.18);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);">
        
        <!-- Carte avec transparence légère -->
        <div class="card border-0" style="background-color: rgba(255, 255, 255, 0.8);">
            <div class="card-header bg-transparent border-0 text-center">
                <h2 class="mb-0 text-primary">
                    <i class="" data-feather="list"></i> Liste des stagiaires
                </h2>
            </div>
            
            <div class="card-body">
                <!-- Barre de recherche avec transparence -->
                <div class="row mb-3 g-2">
                    <form action="{{route('SearchStagiare')}}" style="display: flex">
                        <input type="text" placeholder="Rechercher..." 
                               class="form-control no-border-input" 
                               style="background: rgba(255, 255, 255, 0.7);"
                               name="search" id="searchInput" 
                               value="{{ $searchTerm ?? '' }}">
                        <button class="btn btn-warning ms-2" type="submit">
                            <i class="align-middle me-2" data-feather="search"></i> Rechercher
                        </button>
                    </form>
                </div>

                <!-- Tableau avec effet de verre -->
                <div class="table-responsive">
                    <table class="table" style="background: rgba(255, 255, 255, 0.6);
                              backdrop-filter: blur(5px);
                              border-radius: 10px;">
                        <thead>
                            <tr style="background-color: rgba(230, 173, 19, 0.84);">
                                <th style="border-top-left-radius: 10px;">Stagiaire</th>
                                <th style="border-top-right-radius: 10px;">Coordonnées</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stagiaires as $stagiaire)
                            <tr style="border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                {{-- <td class="fw-semibold text-primary">
                                    {{ $stagiaire->matricule }}
                                </td> --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px; background-color: rgba(23, 162, 184, 0.8) !important;">
                                            {{ substr($stagiaire->firstname, 0, 1) }}{{ substr($stagiaire->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $stagiaire->firstname }} {{ $stagiaire->name }}</div>
                                            <small style="color: rgba(108, 117, 125, 0.9);">
                                                {{ Carbon\Carbon::parse($stagiaire->birthdate)->age }} ans
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><i class="align-middle me-2" data-feather="mail"></i>{{ $stagiaire->email }}</div>
                                    {{-- <div><i class="align-middle me-2" data-feather=""></i>{{ $stagiaire->country ?? 'Non spécifié' }}</div> --}}
                                    <div><i class="align-middle me-2" data-feather="phone"></i>
                                        @if($stagiaire->phone)
                                            {{ $stagiaire->phone }}
                                        @else
                                            <span style="color: rgba(108, 117, 125, 0.6);">Non renseigné</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{-- <div><i class="bi bi-calendar me-2"></i>
                                        {{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }}
                                    </div> --}}
                                    {{-- <div><i class="bi bi-globe me-2"></i>
                                        {{ $stagiaire->country ?? 'Non spécifié' }}
                                    </div>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination avec transparence -->
                <div class="d-flex justify-content-center mt-4">
                    {{-- {{ $stagiaires->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Effet de transition fluide */
    .table tr {
        transition: all 0.3s ease;
    }
    
    /* Effet au survol */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.15) !important;
        transform: translateX(5px);
    }
    
    /* Style des inputs */
    .no-border-input {
        border: 1px solid rgba(0, 123, 255, 0.3) !important;
        transition: all 0.3s ease;
    }
    
    .no-border-input:focus {
        border-color: rgba(0, 123, 255, 0.6) !important;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15);
    }
    
    /* Adaptation des icônes */
    .bi {
        opacity: 0.8;
    }
</style>
@endsection

<script>

    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.querySelector('tbody');
    const rows = document.querySelectorAll('tbody tr');
    
    // Créer un élément pour le message "Aucun résultat"
    const noResultsRow = document.createElement('tr');
    noResultsRow.id = 'noResultsRow';
    noResultsRow.innerHTML = `
        <td colspan="6" class="text-center text-danger py-4">
            <i class="bi bi-search me-2"></i>Aucun résultat trouvé
        </td>
    `;
    noResultsRow.style.display = 'none';
    tableBody.appendChild(noResultsRow);

    // Fonction de recherche améliorée
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        let hasResults = false;
        
        rows.forEach(row => {
            if (row.id === 'noResultsRow') return;
            
            const cells = row.querySelectorAll('td');
            let shouldShow = false;
            
            // Vérifier chaque cellule sauf la dernière (actions)
            for (let i = 0; i < cells.length - 1; i++) {
                if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                    shouldShow = true;
                    break;
                }
            }
            
            row.style.display = shouldShow ? '' : 'none';
            if (shouldShow) hasResults = true;
        });
        
        // Afficher/masquer le message "Aucun résultat"
        if (searchTerm.length > 0) {
            noResultsRow.style.display = hasResults ? 'none' : '';
        } else {
            noResultsRow.style.display = 'none';
        }
    }
    
    // Écouteur d'événement pour la recherche en temps réel
    searchInput.addEventListener('input', performSearch);
})
</script>
