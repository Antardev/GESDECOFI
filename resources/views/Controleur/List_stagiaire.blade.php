@extends('welcome')

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0 text-center">
                        <i class="bi bi-person-check text-primary me-2" data-feather="list"></i>
                        Liste des stagiaires du : {{$country}}
                    </h2>
                </div>
                <div class="btn-group">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-download me-1"></i> Exporter
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" id="hrPDF" href="{{route('CN.stagiaires.export.pdf').'?r=CN'}}" id="exportPdf"><i class="bi bi-filetype-pdf me-2"></i>PDF</a></li>
                        <li><a class="dropdown-item" id="hrExcel" href="{{route('CN.stagiaires.export.excel').'?r=CN'}}" id="exportExcel"><i class="bi bi-file-earmark-excel me-2"></i>Excel</a></li>
                        <li><a class="dropdown-item" href="#" id="exportWord"><i class="bi bi-filetype-docx me-2"></i>Word</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" id="searchMatricule" class="form-control" placeholder="Rechercher">
            </div>
            {{-- <div class="col">
                <input type="text" id="searchStagiaire" class="form-control" placeholder="Rechercher par Nom complet">
            </div>
            <div class="col">
                <input type="text" id="searchCoordonnees" class="form-control" placeholder="Rechercher par Coordonnées">
            </div> --}}
            <div class="col">
                <div class="input-group">
                    <span class="input-group-text">Année</span>
                    <select name="" class="form-select" id="searchYear">
                        <option value="">Selectionnez l'année</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('access_denied'))
            <div class="alert alert-danger mt-3">
                {{ session('access_denied') }}
            </div>
        @endif

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
                </table>
            </div>
        </div>
    </div>
    {{-- @dd($stagiaires) --}}
    
@endsection

@section('styles_up')
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" rel="stylesheet">
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

    /* function voirStagiaire($stagiaire) {
        if (id) {
            window.location.href = `/valider_stagiaire/${stagiaire.id}`;
        } else {
            console.error('ID de stagiaire non trouvé');
        }
    } */

    $(document).ready(function () {
         $('#searchYear').val("");
        const table = $('#stagiaires-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('CN.stagiaires') }}',
            columns: [
                { 
                    data: null,
                    name: 'matricule',
                    searchable: false,
                    render: function (data, type, row) {
                        return `${data.matricule}`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: true,
                    render: function (data, type, row) {
                        return `
                            <div class="d-flex align-items-center">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px">
                                    ${data.firstname.charAt(0)}${data.name.charAt(0)}
                                </div>
                                <div>
                                    <div class="fw-semibold">${data.firstname} ${data.name}</div>
                                    <small class="text-muted">${calculateAge(data.birthdate)} ans</small>
                                </div>
                            </div>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: true,
                    render: function (data, type, row) 
                    {
                        const phone = data.phone ? data.phone : '<span class="text-muted">Non renseigné</span>';
                        return `<div><i class="bi bi-envelope me-2"></i>${data.email}</div>
                                <div><i class="bi bi-telephone me-2"></i>${phone}</div>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: true,
                    render: function (data, type, row) {
                        return `<div><i class="bi bi-calendar me-2"></i>${formatDate(data.birthdate)}</div>
                                <div><i class="bi bi-globe me-2"></i>${data.country ?? 'Non spécifié'}</div>`;
                    }
                },
                {
                    data: 'validated',
                    name: 'validated',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        const status = data == 1 ? 'validé' : 'Non-validé';
                        const badge = data == 1 ? 'success' : 'warning';
                        return `<span class="badge bg-${badge}">${status}</span>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
               
            ],
            language: {
                "decimal": "",
                "emptyTable": "Aucune donnée disponible dans le tableau",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
                "infoFiltered": "(filtré à partir de _MAX_ entrées au total)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Afficher _MENU_ entrées",
                "loadingRecords": "Chargement...",
                "processing": "Traitement...",
                "search": "Rechercher :",
                "zeroRecords": "Aucun enregistrement correspondant trouvé",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                },
                "aria": {
                    "sortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sortDescending": ": activer pour trier la colonne par ordre décroissant"
                }
            },
        });

        $('#searchMatricule').on('keyup', function() {
            table.column(0).search(this.value).draw();
        });

        // $('#searchStagiaire').on('keyup', function() {
        //     table.column(1).search(this.value).draw();
        // });

        // $('#searchCoordonnees').on('keyup', function() {
        //     table.column(2).search(this.value).draw();
        // });

        $('#searchYear').on('change', function() {
            var selectedYear = $(this).val();
            var currentPDF = $('#hrPDF').attr('href');
            var currentExcel = $('#hrExcel').attr('href');

            // Fonction pour mettre à jour l'URL
            function updateUrl(url, year) {
                var newUrl = new URL(url, window.location.origin); // Crée une nouvelle URL
                newUrl.searchParams.set('y', year); // Définit ou remplace le paramètre y
                return newUrl.href; // Retourne l'URL mise à jour
            }

            // Mettre à jour les href
            $('#hrPDF').attr('href', updateUrl(currentPDF, selectedYear));
            $('#hrExcel').attr('href', updateUrl(currentExcel, selectedYear));

            // Mettre à jour la colonne de la table
            table.column(3).search(selectedYear).draw();
        });

        function calculateAge(birthdate) {
            const birth = new Date(birthdate);
            const ageDifMs = Date.now() - birth.getTime();
            const ageDate = new Date(ageDifMs);
            return Math.abs(ageDate.getUTCFullYear() - 1970);
        }

        function formatDate(date) {
            const d = new Date(date);
            return d.toLocaleDateString('fr-FR');
        }
    });

</script>
@endsection
