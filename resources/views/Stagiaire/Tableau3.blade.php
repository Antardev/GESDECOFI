@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">
        Tableau 2 : Récapitulatif du Volume Horaire Effectué Durant le Stage
        <button class="btn btn-warning" id="downloadWord">
            <i data-feather="file-text"></i> Word
        </button>
        <button class="btn btn-success" id="downloadExcel">
            <i data-feather="file-text"></i> Excel
        </button>
    </h2>

    <div class="table-responsive">
        <table id="myTable" class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th style="background-color: #343a40; color: white;">ACTIVITES</th>
                    <th style="background-color: #343a40; color: white;" class="text-center">1er</th>
                    <th style="background-color: #343a40; color: white;" class="text-center">2ème</th>
                    <th style="background-color: #343a40; color: white;" class="text-center">3ème</th>
                    <th style="background-color: #343a40; color: white;" class="text-center">4ème</th>
                    <th style="background-color: #343a40; color: white;" class="text-center">5ème</th>
                    <th style="background-color: #343a40; color: white;" class="text-center">6ème</th>
                    <th style="background-color: #343a40; color: white;" class="text-center">TOTAL PAR ACTIVITE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hours1 = 0;

                    $hours2[1] = 0;
                    $hours2[2] = 0;
                    $hours2[3] = 0;
                    $hours2[4] = 0;
                    $hours2[5] = 0;
                    $hours2[6] = 0;

                @endphp

                @foreach($semesters as $semester)
                <tr>
                @php
                    $hours = 0;

                @endphp

                    <td style="background-color: #f8f9fa;"><strong>{{$semester[1]['category']}}</strong></td>
                    @foreach($semester as $i => $semester1)

                        <td class="text-center">{{$semester1['hour']}}</td>
                        @php
                            $hours+=$semester1['hour'];
                            $hours2[$i]+=$semester1['hour'];
                        @endphp
                    @endforeach
                    <td class="text-center" style="background-color: #f8f9fa;"><strong>{{$hours}}</strong></td>
                </tr>
                @php
                    $hours1+=$hours;

                @endphp
                @endforeach
                </tr>
                <tr class="table-warning">
                    <td class="text-end" style="font-weight: bold;">TOTAL PAR SEMESTRE</td>
                    @foreach($semester as $i => $semester1)

                        <td class="text-center">{{$hours2[$i]}}</td>

                    @endforeach
                    <td class="text-center" style="font-weight: bold;">{{$hours1}}</td>
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

        const fileName = `tableau 2${s ? 'S' + s : ''}${y ? 'A' + y : ''}.doc`;
        
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

        const fileName = `tableau 2${s ? 'S' + s : ''}${y ? 'A' + y : ''}.doc`;

        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });

    // Initialiser Feather Icons
    feather.replace();
</script>

@endsection