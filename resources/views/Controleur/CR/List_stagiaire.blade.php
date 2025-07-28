@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white text-black">
            <h2 class="mb-0 text-center">Liste des stagiaires</h2>
            <h1>
                <i class="bi bi-person-check text-primary me-2"></i>
            </h1>
        </div>

        @if(session('success'))
            <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Succès</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        @if (session('access_denied'))
            <div class="toast-container position-fixed top-50 start-50 translate-middle p-3" style="z-index: 9999;">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 350px;">
                    <div class="toast-header bg-danger text-white border-0 rounded-top">
                        <div class="d-flex align-items-center">
                            <div class="pulse-animation me-2">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <strong class="me-auto">Erreur</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="toast-body bg-white rounded-bottom shadow-lg p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 text-success me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ session('acces_denied') }}</h5>
                                <p class="mb-0">{{ session('access_denied') }}</p>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" 
                                role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" id="searchMatricule" class="form-control" placeholder="Rechercher par Matricule">
                </div>
                <div class="col">
                    <input type="text" id="searchStagiaire" class="form-control" placeholder="Rechercher par Nom complet">
                </div>
                <div class="col">
                    <input type="text" id="searchCoordonnees" class="form-control" placeholder="Rechercher par Coordonnées">
                </div>
            </div>
            <div class="row mb-3">

                <a href="{{ route('CR.stagiaires.export.excel') }}" class="btn btn-success mb-3">
                    <i class="bi bi-file-earmark-excel"></i> Exporter Excel
                </a>

                <a href="{{ route('CR.stagiaires.export.pdf') }}" class="btn btn-danger mb-3">
                    <i class="bi bi-file-earmark-pdf"></i> Exporter PDF
                </a>

            </div>
            <div class="table-responsive">
                <table id="stagiaires-table" class="table table-hover order-column">
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
        </div>

    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
    }
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .toast {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .toast-body {
        border-left: 4px solid #4bb543;
    }
</style>

@endsection

@section('styles_up')
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" rel="stylesheet">
@endsection

@section('scripts_down')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script>

        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(t => new bootstrap.Tooltip(t));

            // Gestion des clics sur les boutons "Voir"
            const voirButtons = document.querySelectorAll('.btn-secondary');

            voirButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    if (id) {
                        window.location.href = `/superadmin/valider_stagiaire/${id}`;
                    } else {
                        console.error('ID de stagiaire non trouvé');
                    }
                });
            });
        });


    $(document).ready(function() {
        const table = $('#stagiaires-table').DataTable({
            processing: true,
            serverSide: true,
            // searching: false,
            ajax: '{{ route('CR.stagiaires') }}',
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
            columns: [
                { data: 'matricule', name: 'matricule', orderable: true },
                { data: null, orderable: false, render: function(data, type, row) {
                    return row.firstname + ' ' + row.name; // Combinez les colonnes
                }},
                { 
                    data: 'coordonnees', 
                    orderable: false, 
                    searchable: false, // important ici pour éviter l'erreur
                    render: function(data, type, row) {
                        return '<div><i class="bi bi-envelope me-2"></i>' + row.email + '</div>' +
                            '<div><i class="bi bi-telephone me-2"></i>' + (row.phone ? row.phone : 'Non renseigné') + '</div>';
                    }
                },

                { data: 'informations', name: 'informations', searchable: false, render: function(data, type, row) {
                    return '<div><i class="bi bi-calendar me-2"></i>' + row.birthdate + '</div>' +
                        '<div><i class="bi bi-globe me-2"></i>' + (row.country ?? 'Non spécifié') + '</div>';
                }},
                { data: 'statut', name: 'statut', orderable: false, searchable: false, render: function(data, type, row) {
                    return '<span class="badge bg-' + (row.validated == 1 ? 'success' : 'warning') + '">' +
                        (row.validated == 1 ? 'validé' : 'Non-validé') + '</span>';
                }},
                { data: 'action', name: 'action', orderable: false, searchable: false, render: function(data, type, row) {
                    return '<button class="btn btn-secondary" onclick="voirStagiaire(' + row.id + ')">Voir</button>';
                }}
            ]
        });

    // // Filtre de recherche
    // $('#searchInput').on('keyup', function() {
    //     table.search(this.value).draw();
    // });

    $('#searchMatricule').on('keyup', function() {
        table.column(0).search(this.value).draw();
    });

    $('#searchStagiaire').on('keyup', function() {
        table.column(1).search(this.value).draw();
    });

    $('#searchCoordonnees').on('keyup', function() {
        table.column(2).search(this.value).draw();
    });





});

    function voirStagiaire(id) {
        window.location.href = `/superadmin/valider_stagiaire/${id}`;
    }
</script>
@endsection