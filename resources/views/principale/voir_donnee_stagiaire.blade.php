@extends('welcome')
@section('title', 'Voir les données stagiaires')
@section('content')
<br><br><br>
<div class="container">
    <div class="row mt-5">
        {{-- @dd($stagiaire->journees) --}}
        {{-- Info générale --}}
        <table class="table table-bordered">
            <tr>
                <td class="fs-5 fw-lighter" colspan="18">
                    Numéro de demande : <strong>{{ $stagiaire->numerodemande }}</strong>
                </td>
            </tr>
        </table>

        {{-- I- INFORMATIONS DU STAGIAIRE --}}
        <table class="table table-bordered">
            <tr>
                <td class="section-title" colspan="18">I- INFORMATIONS DU STAGIAIRE</td>
            </tr>
            <tr>
                <th>Matricule</th>
                <th>Nom & Prénom</th>
                <th>Date Naissance</th>
                <th>Lieu Naissance</th>
                <th>Nationalité</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Email</th>
            </tr>
            <tr>
                <td>{{ $stagiaire->matriculestagiaire ?? '' }}</td>
                <td>{{ $stagiaire->nomstagiaire ?? '' }} {{ $stagiaire->prenomstagiaire ?? '' }}</td>
                <td>{{ $stagiaire->datenaissance ? $stagiaire->datenaissance->format('d/m/Y') : 'Non spécifié' }}</td>
                <td>{{ $stagiaire->lieunaissance ?? '' }}</td>
                <td>{{ $stagiaire->nationalite ?? '' }}</td>
                <td>{{ $stagiaire->adresse ?? '' }}</td>
                <td>{{ $stagiaire->phonecontact ?? '' }}</td>
                <td>{{ $stagiaire->email ?? '' }}</td>
            </tr>
        </table>

        {{-- II- INFORMATIONS SUR LE STAGE --}}
        <table class="table table-bordered">
            <tr>
                <td class="section-title" colspan="18">II- INFORMATIONS SUR LE STAGE</td>
            </tr>
            <tr>
                <th>Date Début Stage</th>
                <th>Date Fin Stage</th>
                <th>Contrôleur Stage</th>
                <th colspan="4">Maître de stage</th>
                <th colspan="4">Structure d'accueil</th>
            </tr>
            <tr>
                <td>{{ $stagiaire->datedebutstage ? $stagiaire->datedebutstage->format('d/m/Y') : 'Non spécifié' }}</td>
                <td>{{ $stagiaire->datefinstage ? $stagiaire->datefinstage->format('d/m/Y') : 'Non spécifié' }}</td>
                <td>{{ $stagiaire->nomcontrolleurstage ?? '' }} {{ $stagiaire->prenomcontrolleurstage ?? '' }}</td>
                <td>{{ $stagiaire->nomaitrestage ?? '' }} {{ $stagiaire->prenomaitrestage ?? '' }}</td>
                <td>{{ $stagiaire->orderaffimaitstage ?? '' }}</td>
                <td>{{ $stagiaire->numeroaffimaitstage ?? '' }}</td>
                <td>{{ $stagiaire->dateaffimaitstage ? $stagiaire->dateaffimaitstage->format('d/m/Y') : 'Non spécifié' }}</td>
                <td>{{ $stagiaire->raisonsociastructure ?? '' }}</td>
                <td>{{ $stagiaire->ordreaffilistructure ?? '' }}</td>
                <td>{{ $stagiaire->numeroaffilistructure ?? '' }}</td>
                <td>{{ $stagiaire->dateaffilistructure ? $stagiaire->dateaffilistructure->format('d/m/Y') : 'Non spécifié' }}</td>
            </tr>
        </table>

        {{-- III- OBLIGATIONS DE STAGE --}}
        <table class="table table-bordered">
            <tr>
                <td class="section-title" colspan="18">III- OBLIGATIONS DE STAGE</td>
            </tr>
            <tr>
                <th colspan="3">3.1- Conditions d'entrée</th>
                <th colspan="15">3.2- Déroulement du stage</th>
            </tr>
            <tr>
                <th>Acceptation Ordre</th>
                <th>Convention Stage</th>
                <th>Carte CNSS</th>
                @foreach($stagiaire->rapports as $key => $rapport)
                    <th>{{ strtoupper($key) }}</th>
                @endforeach
                @foreach($stagiaire->journees as $key => $journee)
                    <th>{{ strtoupper($key) }}</th>
                @endforeach
            </tr>
            <tr>
                {{-- Conditions --}}
                @foreach(['file_decharge','file_convenstage','file_convencnss'] as $cond)
                    <td>
                        @if(!empty($stagiaire->conditions[$cond]))
                            <a href="{{ asset('storage/'.$stagiaire->conditions[$cond]) }}"
                               download class="btn btn-sm btn-warning bi bi-download"></a>
                            <a href="#" class="btn mt-2 btn-sm btn-success bi bi-eye btn-view-doc"
                               data-file="{{ asset('storage/'.$stagiaire->conditions[$cond]) }}"></a>
                        @else
                            <span class="text-danger">Non fourni</span>
                        @endif
                    </td>
                @endforeach

                {{-- Rapports --}}
                @foreach($stagiaire->rapports as $rapport)
                    <td>
                        @if(!empty($rapport['file']))
                            <a href="{{ asset('storage/'.$rapport['file']) }}"
                               download class="btn btn-sm btn-warning bi bi-download"></a>
                            <a href="#" class="btn mt-2 btn-sm btn-success bi bi-eye btn-view-doc"
                               data-file="{{ asset('storage/'.$rapport['file']) }}"></a>
                        @else
                            <span class="text-danger">Non fourni</span>
                        @endif
                    </td>
                @endforeach

                {{-- Journées --}}
                @foreach($stagiaire->journees as $journee)
                    <td>
                        @if(!empty($journee['file']))
                            <a href="{{ asset('storage/'.$journee['file']) }}"
                               download class="btn btn-sm btn-warning bi bi-download"></a>
                            <a href="#" class="btn mt-2 btn-sm btn-success bi bi-eye btn-view-doc"
                               data-file="{{ asset('storage/'.$journee['file']) }}"></a>
                        @else
                            <span class="text-danger">Non fourni</span>
                        @endif
                    </td>
                @endforeach
            </tr>
        </table>

        {{-- Preview --}}
        <div class="card mt-4">
            <div class="card-header">Aperçu du document</div>
            <div class="card-body" id="preview-container" style="min-height:400px; text-align:center;">
                <em>Aucun document sélectionné</em>
            </div>
        </div>

        {{-- Impression --}}
        <div class="col-md-12 d-flex justify-content-center mt-3">
            <button class="btn btn-success" onclick="printPreview()">Imprimer</button>
        </div>
    </div>
</div>

{{-- Styles --}}
<style>
.section-title { background-color:#f0f0f0; font-weight:bold; text-align:center; }
.table th, .table td { vertical-align: middle; text-align:center; font-size:11px; }
@media print {
    button, .btn { display:none; }
}
</style>

{{-- Script preview --}}
<script>



    document.addEventListener('DOMContentLoaded', function() {
        const previewContainer = document.getElementById('preview-container');
        document.querySelectorAll('.btn-view-doc').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let fileUrl = this.getAttribute('data-file');
                if(fileUrl.endsWith('.pdf')) {
                    previewContainer.innerHTML = `<iframe src="${fileUrl}" width="100%" height="500px" style="border:none;"></iframe>`;
                } else if(fileUrl.match(/\.(jpg|jpeg|png|gif)$/i)) {
                    previewContainer.innerHTML = `<img src="${fileUrl}" class="img-fluid rounded shadow">`;
                } else {
                    previewContainer.innerHTML = `<p class="text-danger">Impossible d'afficher ce type de fichier.
                        <a href="${fileUrl}" target="_blank">Ouvrir</a></p>`;
                }
            });
        });
    });

    function printPreview() {
        var printContents = document.getElementById('preview-container').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@endsection