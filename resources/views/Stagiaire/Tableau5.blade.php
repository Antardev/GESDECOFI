@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Tableau 5 : Récapitulatif des Modules et Observations</h2>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr style="background-color: #007bff; color: white;">
                    <th>Modules (Domaine)</th>
                    <th>Volume Horaire</th>
                    <th>%</th>
                    <th>Observation (Sous domaine)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doms as $domain)

                    @php
                        $volumeHoraire = array_sum(array_column($domain['subdomains'], 'hour', 'id')) ?? 0;
                        $percentage = $totalHours > 0 ? ($volumeHoraire / $totalHours) * 100 : 0; // Vérification pour éviter la division par zéro
                    @endphp
                    <tr>
                        <td>{{ $domain['name'] }}</td>
                        <td>{{ $volumeHoraire }}</td>
                        <td>{{ number_format($percentage, 2) }}%</td>
                        <td>
                            @foreach($domain['subdomains'] as $subdomain)
                                <div>{{ $subdomain['name'] }} ({{ $subdomain['hour'] }}H)</div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                <tfooter>

                    <tr>
                            <th>Total</th>
                            <th>{{$totalHours}}</th>
                            <th>100 %</th>
                            <th></th>

                    </tr>

                </tfooter>
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

    h2 {
        color: #343a40;
    }
</style>
@endsection