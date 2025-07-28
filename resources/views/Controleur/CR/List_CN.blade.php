@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
            <h2 class="text-center mb-4">Liste des controleurs</h2>
        </div>
        
        <div class="card-body">

            <div class="row mb-3">
                <div class="col">
                    <input type="text" id="searchMatricule" class="form-control" placeholder="Rechercher par Pays">
                </div>
                <div class="col">
                    <input type="text" id="searchStagiaire" class="form-control" placeholder="Rechercher par Nom complet">
                </div>
                <div class="col">
                    <input type="text" id="searchCoordonnees" class="form-control" placeholder="Rechercher par Coordonnées">
                </div>
            </div>

            <div class="table-responsive">

                <table id="controleursTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Pays</th>           {{-- colonne 0 --}}
                            <th>Nom & Prénom</th>   {{-- colonne 1 --}}
                            <th>Contact</th>        {{-- colonne 2 --}}
                            <th>Type</th>
                            <th>Affiliation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>

        </div>
    </div>
</div>
@endsection

@section('styles_up')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('scripts_down')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>


    $(document).ready(function () {
        const table = $('#controleursTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('CR.controleurs') }}',
                dataType: 'json',
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
            columns: [
                { data: 'country', name: 'country' },
                { 
                    data: null, 
                    name: 'firstname',
                    render: function(data) {
                        return `<strong>${data.firstname}</strong> ${data.name}`;
                    }
                },
                {
                    data: null,
                    name: 'email',
                    render: function(data) {
                        let phone = data.phone ? data.phone : '<span class="text-muted">Non renseigné</span>';
                        return `<div>${data.email}</div><div>${phone}</div>`;
                    }
                },
                { data: 'type', name: 'type' },
                { data: 'affiliation', name: 'affiliation' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']]
        });

        // Voir bouton
        $('#controleursTable').on('click', '.btn-outline-secondary', function () {
            const id = $(this).data('id');
            if (id) {
                window.location.href = `/admin/details_controleurs/${id}`;
            }
        });

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

</script>

@endsection
