@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">
        Fiche semestrielle des heures d’intervention
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
        <table id="myTable" class="table table-bordered table-hover">
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

        const fileName = `tableau 1${s ? 'S' + s : ''}${y ? 'A' + y : ''}.doc`;

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

        const fileName = `tableau 1${s ? 'S' + s : ''}${y ? 'A' + y : ''}.XLS`;

        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });

    // Initialiser Feather Icons
    feather.replace();
</script>

@endsection