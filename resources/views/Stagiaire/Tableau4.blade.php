@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center" style="color: #343a40;">
        Tableau 4 : Récapitulatif des Heures par Activité
        <button class="btn btn-warning" id="downloadWord">
            <i data-feather="file-text"></i> Word
        </button>
        <button class="btn btn-success" id="downloadExcel">
            <i data-feather="file-text"></i> Excel
        </button>
    </h2>

    <!-- Formulaire de sélection
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
    -->

    <div class="table-responsive">
        <table id="myTable" class="table table-bordered text-center" style="border-collapse: collapse;">
            <thead>
                <tr style="background-color: #eceff1; color: white;">
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
                    <tr style="border: none;  text-align: left;">
                        <td colspan="9" style="background-color: #f8f9fa; font-weight: bold; font-size: 1.1em; border: none;">{{ $categorie->categorie_name }}</td>
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
                         
                        <tr style="background-color: #ffffff; transition: background-color 0.3s; text-align: left;" >
                            <td style="border: none;">{{ $subCategorie->subcategorie_name }}</td>
                            

                            @for($i = 1; $i <= 6; $i++)
                                @php
                                    $hours = $semesters[$categorie->id][$subCategorie->id][$i] ?? 0; // Fetch hours or default to 0
                                    $rowTotal += $hours; // Sum for this row
                                    $s[$i]= $s[$i] + $hours;
                                @endphp
                                <td style="background-color: #f2f2f2; border: solid 1px;">{{ $hours }}</td>
                            @endfor

                            <td style="font-weight: bold; border: solid 1px; text-align: center;">{{ $rowTotal }}</td>
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
                        <td style="font-weight: bold; text-align: center;">{{ $categoryTotal }}</td>
                    </tr>

                    @php
                        $totalGeneral += $categoryTotal; // Update overall total
                    @endphp
                @endforeach

                <tr class="total-row" style="background-color: #dc3545; color: white;">
                    <td colspan="7" class="text-center">TOTAL GENERAL</td>
                    <td style="font-weight: bold; text-align: center;">{{ $totalGeneral }}</td>
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

        const fileName = `tableau 4${s ? 'S' + s : ''}${y ? 'A' + y : ''}.doc`;

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

        const fileName = `tableau 4${s ? 'S' + s : ''}${y ? 'A' + y : ''}.doc`;

        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });


    // Initialiser Feather Icons
    feather.replace();
</script>

@endsection