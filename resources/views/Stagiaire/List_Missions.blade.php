@extends('welcome')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Liste des Missions</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{route('SearchMission')}}" style="display: flex">

                <input type="text" placeholder="Rechercher" class="form-control no-border-input" name="search" id="searchInput">
                <button class="btn btn-primary" type="submit"> Rechercher</button>
            </form>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nom de la mission </th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Catégories</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($missions as $mission)
                        <tr>
                            <td>{{ $mission->mission_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($mission->mission_begin_date)->format('d/m/Y') }}</td>

                            <td>{{ \Carbon\Carbon::parse($mission->mission_end_date)->format('d/m/Y') }}</td>
                            <td>
                                {{ $mission->categorie_name}} 
                            <td>
                                <button class="btn btn-secondary" data-id="{{ $mission->id }}"> voir</button>
                         
                            </td>
                        </tr>
                       
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucune mission trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- <div class="d-flex justify-content-center mt-4">
                {{ $missions->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-secondary');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const missionId = this.getAttribute('data-id');
                window.location.href = `/stagiaire/mission_details/${missionId}`;
            });
        });
    });
    const buttons = document.querySelectorAll('.btn-secondary');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const missionId = this.getAttribute('data-id');
            window.location.href = `/stagiaire/mission_details/${missionId}`;
        });


    });

    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.querySelector('tbody');
    const rows = document.querySelectorAll('tbody tr');
    
    // Créer un élément pour le message "Aucun résultat"
    const noResultsRow = document.createElement('tr');
    noResultsRow.id = 'noResultsRow';
    noResultsRow.innerHTML = `
        <td colspan="6" class="text-center text-muted py-4">
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
//     document.addEventListener('DOMContentLoaded', function() {
//     const searchInput = document.getElementById('searchInput');
//     const tableBody = document.querySelector('tbody');
//     const rows = document.querySelectorAll('tbody tr');
    
//     // Fonction de recherche
//     function performSearch() {
//         const searchTerm = searchInput.value.toLowerCase();
        
//         rows.forEach(row => {
//             const cells = row.querySelectorAll('td');
//             let shouldShow = false;
            
//             // Vérifier chaque cellule sauf la dernière (actions)
//             for (let i = 0; i < cells.length - 1; i++) {
//                 if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
//                     shouldShow = true;
//                     break;
//                 }
//             }
            
//             row.style.display = shouldShow ? '' : 'none';
//         });
//     }
    
//     // Écouteur d'événement pour la recherche en temps réel
//     searchInput.addEventListener('input', performSearch);
    
// });

    
</script>