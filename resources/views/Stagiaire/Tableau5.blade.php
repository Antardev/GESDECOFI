@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">
        Tableau 5 : Récapitulatif des Modules et Observations
        <button class="btn btn-warning" id="downloadWord">
            <i data-feather="file-text"></i> Word
        </button>
        <button class="btn btn-success" id="downloadExcel">
            <i data-feather="file-text"></i> Excel
        </button>
    </h2>

    <!-- Formulaire de sélection -->
    <form method="GET" action="" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="year" class="form-label">Choisir l'année</label>
                <select name="y" id="year" class="form-select">
                <option value="">-- Sélectionnez une année --</option>
                    <option value="1" {{ request('y') == 1 ? 'selected' : '' }}>Année 1</option>
                    <option value="2" {{ request('y') == 2 ? 'selected' : '' }}>Année 2</option>
                    <option value="3" {{ request('y') == 3 ? 'selected' : '' }}>Année 3</option>

                </select>
            </div>
            <div class="col-md-4">
                <label for="semester" class="form-label">Choisir le semestre</label>
                <select name="s" id="semester" class="form-select">
                    <option value="">-- Sélectionnez un semestre --</option>
                <option value="1" {{ request('s') == 1 ? 'selected' : '' }}>Semestre 1</option>
                <option value="2" {{ request('s') == 2 ? 'selected' : '' }}>Semestre 2</option>
                </select>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table id="myTable" class="table table-bordered text-center">
            <thead>
                <tr style="background-color: whitesmoke; color: white;">
                    <th> <strong>Modules (Domaine)</strong> </th>
                    <th> <strong> Volume Horaire </strong></th> 
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
                        <td  style="text-align: left;">{{ $domain['name'] }}</td>
                        <td>{{ $volumeHoraire }}</td>
                        <td >{{ number_format($percentage, 2) }}%</td>
                        <td  style="text-align: left;">
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

@section('scripts_down')

<script>
    document.getElementById('downloadWord').addEventListener('click', function() {
        var table = document.getElementById('myTable');
        var html = table.outerHTML;

        var blob = new Blob(['\uFEFF' + html], {
            type: 'application/vnd.ms-word;charset=utf-8'
        });

        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;

        let y = null;
        let s = null;

        const selects = document.querySelectorAll('select');

        selects.forEach(select => {
            if (select.name === 'y') {
                y = select.value;
            }
            if (select.name === 's') {
                s = select.value;
            }
        });

        const fileName = `tableau 5${s ? 'S' + s : ''}${y ? 'A' + y : ''}.doc`;

        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });


    document.getElementById('downloadExcel').addEventListener('click', function() {
        var table = document.getElementById('myTable');
        var html = table.outerHTML;

        var blob = new Blob(['\uFEFF' + html], { type: 'application/vnd.ms-excel;charset=utf-8' });

        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;

        let y = null;
        let s = null;

        const selects = document.querySelectorAll('select');

        selects.forEach(select => {
            if (select.name === 'y') {
                y = select.value;
            }
            if (select.name === 's') {
                s = select.value;
            }
        });

        const fileName = `tableau 5${s ? 'S' + s : ''}${y ? 'A' + y : ''}.doc`;

        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });


    // Initialiser Feather Icons
    feather.replace();
</script>

@endsection