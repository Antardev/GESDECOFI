@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Activités du ... au ...</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th style="background-color: #007bff; color: white;">ACTIVITES</th>
                    <th style="background-color: #28a745; color: white;" class="text-center">Nbre de dossiers</th>
                    <th style="background-color: #ffc107; color: white;" class="text-center">Nbre d’heures</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDossiers = 0;
                    $totalHours = 0;
                @endphp

                @foreach($categories as $categorie)
                    <tr>
                        <td colspan="3" style="background-color: #f8f9fa;"><strong>{{ $categorie->categorie_name }}</strong></td>
                    </tr>

                    @php
                        $categoryDossiers = 0;
                        $categoryHours = 0;
                    @endphp

                    @foreach($categorie->subCategories as $subCategorie) <!-- Changed to access subCategories directly -->
                        <tr>
                            <td>{{ $subCategorie->subcategorie_name }}</td>
                            <td class="text-center">{{ $subCategorie->dossier_n }}</td>
                            <td class="text-center">{{ $subCategorie->hour }}</td>
                        </tr>
                        @php
                            $categoryDossiers += $subCategorie->dossier_n;
                            $categoryHours += $subCategorie->hour;
                            $totalDossiers += $subCategorie->dossier_n;
                            $totalHours += $subCategorie->hour;
                        @endphp
                    @endforeach

                    <tr>
                        <td style="font-weight: bold;">Total ({{ $categorie->categorie_name }})</td>
                        <td class="text-center">{{ $categoryDossiers }}</td>
                        <td class="text-center">{{ $categoryHours }}</td>
                    </tr>
                @endforeach

                <tr class="table-warning">
                    <td class="text-end" style="font-weight: bold;">TOTAL GENERAL</td>
                    <td class="text-center">{{ $totalDossiers }}</td>
                    <td class="text-center">{{ $totalHours }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection