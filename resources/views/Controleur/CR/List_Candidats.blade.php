@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
            <h2 class="text-center mb-4">Liste des candidats</h2>
        </div>
        
        <div class="card-body">

            <div class="row mb-3">

                <div class="col">
                    <input type="text" id="searchMatricule" class="form-control" placeholder="Rechercher ">
                </div>
                <div class="col">
                    <select name="" class="form-select" id="yearSelect">
                        <option value="">Année</option>
                    </select>
                </div>
                {{-- 
                    <div class="col">
                        <input type="text" id="searchMatricule" class="form-control" placeholder="Rechercher par Pays">
                    </div>
                    <div class="col">
                        <input type="text" id="searchCoordonnees" class="form-control" placeholder="Rechercher par Coordonnées">
                    </div> 
                --}}
            </div>

            <div class="row mb-4 align-items-center" id="candadmis" style="display: none;">
                <div class="col-md-6">
                    <label for="yearSelect2" class="form-label">Sélectionnez l'année d'admission</label>
                    <select name="" class="form-select" id="yearSelect2">
                        <option value="">Année</option>
                        <!-- Options d'années à ajouter ici -->
                    </select>
                </div>
                <div class="col-md-4 text-end ml-auto mt-2">
                    <button id="submitButton" class="btn btn-primary" style="display: none;">
                        Envoyer les candidats admis
                    </button>
                </div>
            </div>

            <div class="table-responsive">

                <table id="controleursTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Matricule</th>
                            <th>Nom & Prénom</th>
                            <th>Contact</th>
                            <th>Année</th>
                            <th>Fin de stage</th>
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
<style>
    label:has(input[type="search"]) {
        display: none;
    }
</style>
@endsection

@section('scripts_down')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>


    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('change', '.candidat-checkbox', function() {
            const isChecked = $('.candidat-checkbox:checked').length > 0;
            $('#submitButton').css('display', isChecked ? 'block' : 'none');
            $('#candadmis').css('display', isChecked ? 'block' : 'none');

            // Remplir la sélection des années uniquement si des candidats sont cochés
            if (isChecked) {
                const currentY = new Date().getFullYear();
                const startY = 2025;

                // Vider les options précédentes
                $('#yearSelect2').empty().append('<option value="">Année</option>');

                // Boucle pour ajouter les années de 2025 à l'année actuelle
                for (let year = startY; year <= currentY; year++) {
                    $('#yearSelect2').append($('<option>', {
                        value: year,
                        text: year
                    }));
                }
                $('#yearSelect2').val(currentY); // Option par défaut
            }
        });

        // Soumission des candidats
        $('#submitButton').click(function() {
            const selectedIds = $('.candidat-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length > 0) {
                let y = $('#yearSelect2').val();
                $.post('{{ route("CR.passercandidats") }}', { ids: selectedIds, year: y})
                    .done(function(response) {
                        console.log(response);
                        alert('Candidats admis avec succès !');
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.error('Erreur lors de l\'envoi : ' + textStatus, errorThrown);
                        alert('Une erreur est survenue. Veuillez réessayer.');
                    });
            } else {
                alert('Veuillez sélectionner au moins un candidat.');
            }
        });

        const currentYear = new Date().getFullYear();
        const startYear = 2025;

        // Boucle pour ajouter les années de 2025 à l'année actuelle
        for (let year = startYear; year <= currentYear; year++) {
            $('#yearSelect').append($('<option>', {
                value: year,
                text: year
            }));
        }

        const table = $('#controleursTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('CR.candidats') }}',
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
                { 
                    data: null, 
                    name: 'matricule',
                    searchable: false,
                    render: function(data) {
                        return `<strong>${data.matricule}</strong>`;
                    }
                 },
                {
                    data: null, 
                    name: 'firstname',
                    searchable: false,
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
                { data: 'year', name: 'type' },
                { data: 'end_stage', name: 'affiliation' },
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

        $('#yearSelect').on('change', function() {
            table.column(1).search(this.value).draw();
        });

        // $('#searchCoordonnees').on('keyup', function() {
        //     table.column(2).search(this.value).draw();
        // });
        
    });

</script>

@endsection

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
