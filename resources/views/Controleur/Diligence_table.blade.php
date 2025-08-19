{{-- 
    @extends('welcome')

    @section('content')

        <div class="container py-4">
            @if(isset($stagiaires_not_validated) && !empty($stagiaires_not_validated))
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0 text-center">
                                <i class="bi bi-person-check text-primary me-2" data-feather="list"></i>
                                Inscription en attente de validation 
                            </h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="stagiaires-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Stagiaire</th>
                                        <th>Coordonnées</th>
                                        <th>Informations</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">

                                    @foreach($stagiaires_not_validated as $stagiaire)
                                        <tr>
                                            <td class="fw-semibold text-primary">
                                                {{ $stagiaire->matricule }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                        style="width: 40px; height: 40px">
                                                        {{ substr($stagiaire->firstname, 0, 1) }}{{ substr($stagiaire->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $stagiaire->firstname }} {{ $stagiaire->name }}</div>
                                                        <small class="text-muted">
                                                            {{ Carbon\Carbon::parse($stagiaire->birthdate)->age }} ans
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-envelope me-2"></i>{{ $stagiaire->email }}</div>
                                                <div><i class="bi bi-telephone me-2"></i>
                                                    @if($stagiaire->phone)
                                                        {{ $stagiaire->phone }}
                                                    @else
                                                        <span class="text-muted">Non renseigné</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-calendar me-2"></i>
                                                    {{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }}
                                                </div>
                                                <div><i class="bi bi-globe me-2"></i>
                                                    {{ $stagiaire->country ?? 'Non spécifié' }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $stagiaire->validated == 1 ? 'success' : 'warning' }}">
                                                    {{ $stagiaire->validated == 1 ? 'validé' : 'Non-validé' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                    <!-- Bouton Voir -->
                                                    <button class="btn btn-secondary d-flex align-items-center" data-id="{{ $stagiaire->matricule }}">
                                                        <i class="fas fa-eye me-2"></i> Voir
                                                    </button>
                                                    
                                                    <!-- Dropdown Gérer -->
                                                    
                                                        <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button" 
                                                                id="manageDropdown{{ $stagiaire->id }}" 
                                                                data-bs-toggle="dropdown" 
                                                                aria-expanded="false">
                                                            <i class="fas fa-cog me-2"></i> Gérer
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" 
                                                            aria-labelledby="manageDropdown{{ $stagiaire->id }}"
                                                            style="min-width: 220px; z-index: 1000;">
                                                            <li>
                                                                <a class="dropdown-item py-2 d-flex align-items-center" 
                                                                href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}">
                                                                    <i class="fas fa-history me-3" style="width: 20px; text-align: center;"></i>
                                                                    <span>Historique des rapports</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2 d-flex align-items-center" 
                                                                href="{{ route('controleur.stagiaire_recap', ['id' => $stagiaire->id]) }}">
                                                                    <i class="fas fa-file-alt me-3" style="width: 20px; text-align: center;"></i>
                                                                    <span>Récapitulatif du stage</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                
                                                </div>
                                            </td>
                                                
                                            </tr>
                                            
                                    @endforeach
                                    

                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">


                        </div>
                    </div>
                </div>
            @endif

            @if(isset($stagiaires_to_issue) && !empty($stagiaires_to_issue))
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0 text-center">
                                <i class="bi bi-person-check text-primary me-2" data-feather="list"></i>
                                Stagiaires dont les certificats doivent être délivrés
                            </h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="stagiaires-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Stagiaire</th>
                                        <th>Coordonnées</th>
                                        <th>Informations</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">

                                    @foreach($stagiaires_to_issue as $stagiaire)
                                        <tr>
                                            <td class="fw-semibold text-primary">
                                                {{ $stagiaire->matricule }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                        style="width: 40px; height: 40px">
                                                        {{ substr($stagiaire->firstname, 0, 1) }}{{ substr($stagiaire->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $stagiaire->firstname }} {{ $stagiaire->name }}</div>
                                                        <small class="text-muted">
                                                            {{ Carbon\Carbon::parse($stagiaire->birthdate)->age }} ans
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-envelope me-2"></i>{{ $stagiaire->email }}</div>
                                                <div><i class="bi bi-telephone me-2"></i>
                                                    @if($stagiaire->phone)
                                                        {{ $stagiaire->phone }}
                                                    @else
                                                        <span class="text-muted">Non renseigné</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-calendar me-2"></i>
                                                    {{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }}
                                                </div>
                                                <div><i class="bi bi-globe me-2"></i>
                                                    {{ $stagiaire->country ?? 'Non spécifié' }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $stagiaire->validated == 1 ? 'success' : 'warning' }}">
                                                    {{ $stagiaire->validated == 1 ? 'validé' : 'Non-validé' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                    <!-- Bouton Voir -->
                                                    <button class="btn btn-secondary d-flex align-items-center" data-id="{{ $stagiaire->matricule }}">
                                                        <i class="fas fa-eye me-2"></i> Voir
                                                    </button>
                                                    
                                                    <!-- Dropdown Gérer -->
                                                    
                                                        <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button" 
                                                                id="manageDropdown{{ $stagiaire->id }}" 
                                                                data-bs-toggle="dropdown" 
                                                                aria-expanded="false">
                                                            <i class="fas fa-cog me-2"></i> Gérer
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" 
                                                            aria-labelledby="manageDropdown{{ $stagiaire->id }}"
                                                            style="min-width: 220px; z-index: 1000;">
                                                            <li>
                                                                <a class="dropdown-item py-2 d-flex align-items-center" 
                                                                href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}">
                                                                    <i class="fas fa-history me-3" style="width: 20px; text-align: center;"></i>
                                                                    <span>Historique des rapports</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2 d-flex align-items-center" 
                                                                href="{{ route('controleur.stagiaire_recap', ['id' => $stagiaire->id]) }}">
                                                                    <i class="fas fa-file-alt me-3" style="width: 20px; text-align: center;"></i>
                                                                    <span>Récapitulatif du stage</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                
                                                </div>
                                            </td>
                                                
                                            </tr>
                                            
                                    @endforeach
                                    

                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">

                        </div>
                    </div>
                </div>
            @endif

            @if(isset($stagiaires_issued) && !empty($stagiaires_issued))
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0 text-center">
                                <i class="bi bi-person-check text-primary me-2" data-feather="list"></i>
                                Stagiaires dont les certificats ont déjà été délivrés
                            </h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="stagiaires-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Stagiaire</th>
                                        <th>Coordonnées</th>
                                        <th>Informations</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">

                                    @foreach($stagiaires_issued as $stagiaire)
                                        <tr>
                                            <td class="fw-semibold text-primary">
                                                {{ $stagiaire->matricule }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                        style="width: 40px; height: 40px">
                                                        {{ substr($stagiaire->firstname, 0, 1) }}{{ substr($stagiaire->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $stagiaire->firstname }} {{ $stagiaire->name }}</div>
                                                        <small class="text-muted">
                                                            {{ Carbon\Carbon::parse($stagiaire->birthdate)->age }} ans
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-envelope me-2"></i>{{ $stagiaire->email }}</div>
                                                <div><i class="bi bi-telephone me-2"></i>
                                                    @if($stagiaire->phone)
                                                        {{ $stagiaire->phone }}
                                                    @else
                                                        <span class="text-muted">Non renseigné</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-calendar me-2"></i>
                                                    {{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }}
                                                </div>
                                                <div><i class="bi bi-globe me-2"></i>
                                                    {{ $stagiaire->country ?? 'Non spécifié' }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $stagiaire->validated == 1 ? 'success' : 'warning' }}">
                                                    {{ $stagiaire->validated == 1 ? 'validé' : 'Non-validé' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                    <!-- Bouton Voir -->
                                                    <a href="{{route('CR.show_stagiaire', ['id' => $stagiaire->id])}}" class="btn btn-secondary d-flex align-items-center" data-id="{{ $stagiaire->matricule }}">
                                                        <i class="fas fa-eye me-2"></i> Voir
                                                    </a>
                                                    
                                                    <!-- Dropdown Gérer -->
                                                    
                                                        <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button" 
                                                                id="manageDropdown{{ $stagiaire->id }}" 
                                                                data-bs-toggle="dropdown" 
                                                                aria-expanded="false">
                                                            <i class="fas fa-cog me-2"></i> Gérer
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" 
                                                            aria-labelledby="manageDropdown{{ $stagiaire->id }}"
                                                            style="min-width: 220px; z-index: 1000;">
                                                            <li>
                                                                <a class="dropdown-item py-2 d-flex align-items-center" 
                                                                href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}">
                                                                    <i class="fas fa-history me-3" style="width: 20px; text-align: center;"></i>
                                                                    <span>Historique des rapports</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2 d-flex align-items-center" 
                                                                href="{{ route('CR.stagiaire_recap', ['id' => $stagiaire->id]) }}">
                                                                    <i class="fas fa-file-alt me-3" style="width: 20px; text-align: center;"></i>
                                                                    <span>Récapitulatif du stage</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                
                                                </div>
                                            </td>
                                                
                                            </tr>
                                            
                                    @endforeach
                                    

                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">


                        </div>
                    </div>
                </div>
            @endif

            @if(isset($stagiaires_in) && !empty($stagiaires_in))
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0 text-center">
                                <i class="bi bi-person-check text-primary me-2" data-feather="list"></i>
                                Stagiaires dont les stages sont en cours
                            </h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="stagiaires-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Stagiaire</th>
                                        <th>Coordonnées</th>
                                        <th>Informations</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">

                                    @foreach($stagiaires_in as $stagiaire)
                                        <tr>
                                            <td class="fw-semibold text-primary">
                                                {{ $stagiaire->matricule }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                        style="width: 40px; height: 40px">
                                                        {{ substr($stagiaire->firstname, 0, 1) }}{{ substr($stagiaire->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $stagiaire->firstname }} {{ $stagiaire->name }}</div>
                                                        <small class="text-muted">
                                                            {{ Carbon\Carbon::parse($stagiaire->birthdate)->age }} ans
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-envelope me-2"></i>{{ $stagiaire->email }}</div>
                                                <div><i class="bi bi-telephone me-2"></i>
                                                    @if($stagiaire->phone)
                                                        {{ $stagiaire->phone }}
                                                    @else
                                                        <span class="text-muted">Non renseigné</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-calendar me-2"></i>
                                                    {{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }}
                                                </div>
                                                <div><i class="bi bi-globe me-2"></i>
                                                    {{ $stagiaire->country ?? 'Non spécifié' }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $stagiaire->validated == 1 ? 'success' : 'warning' }}">
                                                    {{ $stagiaire->validated == 1 ? 'validé' : 'Non-validé' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                    <!-- Bouton Voir -->
                                                    <button class="btn btn-primary d-flex align-items-center voirCR" data-id="{{ $stagiaire->id }}" onclick="voir({{$stagiaire->id}})">
                                                        <i class="fas fa-eye me-2"></i> Voir
                                                    </button>
                                                    
                                                    <!-- Dropdown Gérer -->
                                                    <!-- 
                                                        <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button" 
                                                                id="manageDropdown{{ $stagiaire->id }}" 
                                                                data-bs-toggle="dropdown" 
                                                                aria-expanded="false">
                                                            <i class="fas fa-cog me-2"></i> Gérer
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" 
                                                            aria-labelledby="manageDropdown{{ $stagiaire->id }}"
                                                            style="min-width: 220px; z-index: 1000;">
                                                            <li>
                                                                <a class="dropdown-item py-2 d-flex align-items-center" 
                                                                href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}">
                                                                    <i class="fas fa-history me-3" style="width: 20px; text-align: center;"></i>
                                                                    <span>Historique des rapports</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2 d-flex align-items-center" 
                                                                href="{{ route('controleur.stagiaire_recap', ['id' => $stagiaire->id]) }}">
                                                                    <i class="fas fa-file-alt me-3" style="width: 20px; text-align: center;"></i>
                                                                    <span>Récapitulatif du stage</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    -->
                                                </div>
                                            </td>
                                                
                                            </tr>
                                            
                                    @endforeach
                                    

                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">


                        </div>
                    </div>
                </div>
            @endif

    @endsection

    @section('scripts_down')
    <script>

        function voir(id) 
        {
            if (id) {
                window.location.href = `/CR/details_stagiaire/${id}`;
            } else {
                console.error('ID de stagiaire non trouvé');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {

            // Gestion des clics sur les boutons "Voir"
            const voirButtons = document.querySelectorAll('.btn-secondary');
            const CRButton = document.querySelector('.voirCR');

            voirButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    if (id) {
                        window.location.href = `/valider_stagiaire/${id}`;
                    } else {
                        console.error('ID de stagiaire non trouvé');
                    }
                });
            });
        });
    </script>
    @endsection 
--}}

@extends('welcome')

@section('content')

    <div class="container py-4">

        
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" id="searchMatricule" class="form-control" placeholder="Rechercher">
                </div>
                <div class="col">
                    {{-- <select name="pays" id="searchPays" class="form-select">
                        <option value="">Pays</option>
                        @foreach(__('message.countries_phone') as $country)
                            <option value="{{$country['code']}}">{{$country['name']}}</option>
                        @endforeach
                    </select> --}}
                </div>

            </div>
            <div class="row mb-3 ms-3" style="font-size: 1.3rem;">
                @if($_GET['a'] == 'ic')
                    Stagiaires dont les certificats ont été délivrés
                @elseif($_GET['a'] == 'sav')
                    Inscriptions en attente 
                @elseif($_GET['a'] == 'r')
                    Rapport en attente de validation
                @endif

            </div>
            @if($_GET['a'] == 'sav')
            <div class="table-responsive">
                <table id="table" class="table table-hover order-column">
                    <thead class="table-light">
                        <tr>
                            <th>Matricule</th>
                            <th>Stagiaire</th>
                            <th>Coordonnées</th>
                            <th>Informations</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            @endif
            @if($_GET['a'] == 'r')
            <div class="table-responsive">
                <table id="rapport_table" class="table table-hover order-column">
                    <thead class="table-light">
                        <tr>
                            <th>Stagiaire</th>
                            <th>Nom du rapport</th>
                            <th>Date de soumission</th>
                            <th >Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            @endif
        </div>

@endsection



@section('styles_up')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        label:has(input[type="search"]) {
            display: none;
        }
    </style>
@endsection

@section('scripts_down')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
            const notValidatedTable = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('CN.diligence_t') }}?a={{ request()->get('a') }}',
                    dataSrc: function(json) {
                        console.log(json);
                        return json.data;
                    }
                },
                language: {
                    "decimal":        "",
                    "emptyTable":     "Aucune donnée disponible dans le tableau",
                    "info":           "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    "infoEmpty":      "Affichage de 0 à 0 sur 0 entrées",
                    "infoFiltered":   "(filtré à partir de _MAX_ entrées au total)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Afficher _MENU_ entrées",
                    "loadingRecords": "Chargement...",
                    "processing":     "Traitement...",
                    "search":         "Rechercher :",
                    "zeroRecords":    "Aucun enregistrement correspondant trouvé",
                    "paginate": {
                        "first":      "Premier",
                        "last":       "Dernier",
                        "next":       "Suivant",
                        "previous":   "Précédent"
                    },
                    "aria": {
                        "sortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sortDescending": ": activer pour trier la colonne par ordre décroissant"
                    }
                },
                columns: 
                [
                    { 
                        data: null,
                        name: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) { return data.matricule} 
                    },
                    { 
                        data: null, 
                        orderable: false,
                        render: function(data) { return data.firstname + ' ' + data.name; }
                    },
                    {
                        data: 'email', 
                        orderable: false,
                        name: 'email' },
                    {
                        data: 'birthdate', 
                        orderable: false,
                        name: 'birthdate' },
                    { 
                        data: 'validated', 
                        orderable: false,
                        render: function(data) { 
                            return '<span class="badge bg-' + (data == 1 ? 'success' : 'warning') + '">' + (data == 1 ? 'validé' : 'Non-validé') + '</span>'; 
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false }
                ]
            });

            $('#searchMatricule').on('keyup', function() {
                notValidatedTable.column(0).search(this.value).draw();
            });

            $('#searchPays').on('change', function() {
                notValidatedTable.column(1).search(this.value).draw();
            });

            const rapportTable = $('#rapport_table').DataTable(
            {
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('CN.diligence_t') }}?a={{ request()->get('a') }}',
                    dataSrc: function(json) {
                        console.log(json);
                        return json.data;
                    }
                },
                language: 
                {
                    "decimal":        "",
                    "emptyTable":     "Aucune donnée disponible dans le tableau",
                    "info":           "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    "infoEmpty":      "Affichage de 0 à 0 sur 0 entrées",
                    "infoFiltered":   "(filtré à partir de _MAX_ entrées au total)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Afficher _MENU_ entrées",
                    "loadingRecords": "Chargement...",
                    "processing":     "Traitement...",
                    "search":         "Rechercher :",
                    "zeroRecords":    "Aucun enregistrement correspondant trouvé",
                    "paginate": {
                        "first":      "Premier",
                        "last":       "Dernier",
                        "next":       "Suivant",
                        "previous":   "Précédent"
                    },
                    "aria": {
                        "sortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sortDescending": ": activer pour trier la colonne par ordre décroissant"
                    }
                },
                columns: 
                [
                    { 
                        data: null,
                        name: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) { return data.stagiaire.firstname + ' ' + data.stagiaire.name}
                    },
                    { 
                        data: null,
                        name: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) { return data.rapport_name}
                    },
                    { 
                        data: null,
                        name: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) { return data.created_at}
                    },
                    { 
                        data: null,
                        name: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) { return data.is_delayed}
                    },
                    { 
                        data: null,
                        name: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) { return data.action}
                    },
                ]
            });

        $(document).on('click', '.btn-secondary', function() {
            const id = $(this).data('id');
            if (id) {
                window.location.href = '/valider_stagiaire/' + id;
            } else {
                console.error('ID de stagiaire non trouvé');
            }
        });
    });
</script>
@endsection