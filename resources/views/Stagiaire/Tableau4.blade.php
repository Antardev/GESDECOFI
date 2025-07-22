@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center" style="color: #343a40;">Tableau 4 : Récapitulatif des Heures par Activité</h2>

    <div class="table-responsive">
        <table class="table table-bordered text-center" style="border-collapse: collapse;">
            <thead>
                <tr style="background-color: #007bff; color: white;">
                    <th rowspan="2">ACTIVITES</th>
                    <th colspan="6">VOLUME HORAIRE SEMESTRIEL</th>
                    <th rowspan="2">TOTAL PAR ACTIVITE</th>
                </tr>
                <tr style="background-color: #007bff; color: white;">
                    <th>1er</th>
                    <th>2ème</th>
                    <th>3ème</th>
                    <th>4ème</th>
                    <th>5ème</th>
                    <th>6ème</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalGeneral = 0;
                @endphp

                @foreach($categories as $categorie)
                    <tr>
                        <td colspan="9" style="background-color: #f8f9fa; font-weight: bold; font-size: 1.1em;">{{ $categorie->categorie_name }}</td>
                    </tr>

                    @php
                        $categoryTotal = 0;
                    @endphp

                    @foreach($categorie->subCategories as $subCategorie)
                        @php
                            $rowTotal = 0;
                            $s[1] = 0;
                            $s[2] = 0;
                            $s[3] = 0;
                            $s[4] = 0;
                            $s[5] = 0;
                            $s[6] = 0;

                        @endphp
                        
                        <tr style="background-color: #ffffff; transition: background-color 0.3s;">
                            <td>{{ $subCategorie->subcategorie_name }}</td>
                            

                            @for($i = 1; $i <= 6; $i++)
                                @php
                                    $hours = $semesters[$categorie->id][$subCategorie->id][$i] ?? 0; // Fetch hours or default to 0
                                    $rowTotal += $hours; // Sum for this row
                                    $s[$i]= $s[$i] + $hours;
                                @endphp
                                <td style="background-color: #f2f2f2;">{{ $hours }}</td>
                            @endfor

                            <td style="font-weight: bold;">{{ $rowTotal }}</td>
                        </tr>

                        @php
                            $categoryTotal += $rowTotal; // Sum for this category
                        @endphp
                    @endforeach

                    <tr class="total-row" style="background-color: #28a745; color: white;">
                        <td>Total ({{ $categorie->categorie_name }})</td>
                        @for($i = 1; $i <= 6; $i++)
                            <td>{{ $s[$i] ?? 0 }}</td>
                        @endfor
                        <td style="font-weight: bold;">{{ $categoryTotal }}</td>
                    </tr>

                    @php
                        $totalGeneral += $categoryTotal; // Update overall total
                    @endphp
                @endforeach

                <tr class="total-row" style="background-color: #dc3545; color: white;">
                    <td colspan="7" class="text-center">TOTAL GENERAL</td>
                    <td style="font-weight: bold;">{{ $totalGeneral }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    table th, table td {
        padding: 15px;
        border: 1px solid #dee2e6;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    .total-row td {
        font-weight: bold;
    }
</style>
@endsection