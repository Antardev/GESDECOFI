@extends('welcome')
@section('title', 'liste des demandes')
@section('content') <br><br><br>

    <div class="container mt-4">
         @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <script>
                Swal.fire({
                icon: 'error',
                title: 'Erreur de validation',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'OK'
                });
            </script>
        @endif

        <h2 class="mb-4 text-center text-decoration-underline fs-3">Liste des demandes d'attestation de fin de stage au titre de 2025</h2>
        <div class="d-flex justify-content-end mb-3 gap-2">
            <a href="{{route('stage_export_pdf')}}" class="btn btn-danger">
                Télécharger PDF
            </a>
            <a href="{{route('stage_export_word')}}" class="btn btn-danger" style="background-color: blue">
                Télécharger Word
            </a>
        </div>
        @if($stagiaires->isEmpty())
            <div class="alert alert-info text-center">Aucune demande n'est disponible pour le moment.</div>
        @else
             <div class="card-body">
                        <table class="table table-bordered text-center align-middle">
                            <thead style="font-size: 10px">
                                <tr class="table-success justify-content-between text-center">
                                    <th colspan="1">N° demande </th>
                                    <th colspan="8">I- INFORMATIONS DU STAGIAIRE</th>
                                    <th colspan="11">II- INFORMATIONS SUR LE STAGE</th>
                                    <th colspan="1">ACTION</th>
                                </tr>
                                <tr class="text-center">
                                    <th rowspan="2"></th>
                                    <th rowspan="2">N° matricule</th>
                                    <th rowspan="2">Nom & prénom (s)</th>
                                    <th rowspan="2">Date de naissance</th>
                                    <th rowspan="2">Lieu de naissance</th>
                                    <th rowspan="2">Nationalité</th>
                                    <th rowspan="2">Adresse</th>
                                    <th rowspan="2">Téléphone</th>
                                    <th rowspan="2">Email</th>
                                    <th rowspan="2">Date de début de stage</th>
                                    <th rowspan="2">Date de fin de stage</th>
                                    <th rowspan="2">Nom & prénom du Contrôleur de Stage</th>
                                    <th colspan="4">Maître de stage</th>
                                    <th colspan="4">Structure d'accueil du stage</th>
                                    <th rowspan="2"></th>
                                </tr>
                                <tr class="text-center">
                                    <th>Nom & prénom</th>
                                    <th>Ordre d'affiliation</th>
                                    <th>N° d'affiliation</th>
                                    <th>Date d'affiliation</th>
                                    <th>Raison sociale</th>
                                    <th>Ordre d'affiliation</th>
                                    <th>N° d'affiliation</th>
                                    <th>Date d'affiliation</th>
                                </tr>
                            </thead>


                            <tbody id="product-list">
                                @foreach($stagiaires as $Stagiaire)
                                    <tr>
                                        <td>{{ $Stagiaire->numerodemande ?? null }}</td>
                                        <td>{{ $Stagiaire->matriculestagiaire ?? '-' }}</td>
                                        <td>{{ $Stagiaire->nomstagiaire ?? null }}</td>
                                        <td>{{ \Carbon\Carbon::parse($Stagiaire->datenaissance)->format('d/m/Y') }}</td>
                                        <td>{{ $Stagiaire->lieunaissance ?? null }}</td>
                                        <td>{{ $Stagiaire->nationalite ?? null }}</td>
                                        <td>{{ $Stagiaire->adresse ?? null }}</td>
                                        <td>{{ $Stagiaire->phonecontact ?? null }}</td>
                                        <td>{{ $Stagiaire->email ?? null }}</td>
                                        <td>{{ \Carbon\Carbon::parse($Stagiaire->datedebutstage ?? null)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($Stagiaire->datefinstage ?? null)->format('d/m/Y') }}</td>
                                        <td>{{ $Stagiaire->prenomcontrolleurstage ?? '-' }}</td>
                                        <td>{{ $Stagiaire->prenomaitrestage ?? null }}</td>
                                        <td>{{ $Stagiaire->orderaffimaitstage ?? null }}</td>
                                        <td>{{ $Stagiaire->numeroaffimaitstage ?? null }}</td>
                                        <td>{{ \Carbon\Carbon::parse($Stagiaire->dateaffimaitstage ?? null)->format('d/m/Y') }}</td>
                                        <td>{{ $Stagiaire->raisonsociastructure ?? null }}</td>
                                        <td>{{ $Stagiaire->ordreaffilistructure ?? null }}</td>
                                        <td>{{ $Stagiaire->numeroaffilistructure ?? null }}</td>
                                        <td>{{ \Carbon\Carbon::parse($Stagiaire->dateaffilistructure ?? null)->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('VoirDemande', ['id'=>$Stagiaire->id]) }}" class="btn btn-sm btn-primary">
                                                Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        </div>

            </div>
        @endif
        <div class="d-flex justify-content-center">
            {{ $stagiaires->links('pagination::bootstrap-5') }}
        </div>
    </div><br><br><br>

        <style>

            .container-fluid {
                padding: 10px;
            }

            .card {
                padding: 10px;
                margin: 10px auto;
            }

            table.table {
                font-size: 7px;
                max-width: 75%;
            }

            table.table th, table.table td {
                padding: 1px 2px; /* Réduction de l'espacement des cellules */
                vertical-align: middle;
                /*width: 75%*/
            }

            h4, h2, h3 {
                font-size: 16px; /* Réduction des titres */
                margin-bottom: 10px;
            }

            input[type="date"] {
                height: 28px;
                font-size: 12px;
            }

            button {
                padding: 4px 10px;
                font-size: 12px;
            }
        </style>
@endsection

