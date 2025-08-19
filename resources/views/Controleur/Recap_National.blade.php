@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 rounded-4 shadow-lg">
                <div class="card-header bg-white text-black rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Récapitulatif des Stagiaires du : {{ $country_contr }}</h3>
                        <button class="btn btn-success" id="downloadExcel">
                            <i data-feather="file-text"></i> Télécharger Excel
                        </button>
                        <span class="badge bg-light text-primary fs-6">Aujourd'hui {{ now()->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="3" class="bg-light align-middle">Nom</th>
                                    <th rowspan="3" class="bg-light align-middle">Prénom</th>
                                    <th rowspan="3" class="bg-light align-middle">Début Stage</th>
                                    
                                    <!-- Première Année -->
                                    <th colspan="5" class="bg-info text-white text-center">Première Année</th>
                                    
                                    <!-- Deuxième Année -->
                                    <th colspan="5" class="bg-info text-white text-center">Deuxième Année</th>
                                    
                                    <!-- Troisième Année -->
                                    <th colspan="5" class="bg-info text-white text-center">Troisième Année</th>
                                </tr>
                                <tr>
                                    <!-- Sous-titres Première Année -->
                                    <th colspan="2" class="bg-success text-white text-center">Rapports</th>
                                    <th colspan="3" class="bg-warning text-dark text-center">Journées Techniques</th>
                                    
                                    <!-- Sous-titres Deuxième Année -->
                                    <th colspan="2" class="bg-success text-white text-center">Rapports</th>
                                    <th colspan="3" class="bg-warning text-dark text-center">Journées Techniques</th>
                                    
                                    <!-- Sous-titres Troisième Année -->
                                    <th colspan="2" class="bg-success text-white text-center">Rapports</th>
                                    <th colspan="3" class="bg-warning text-dark text-center">Journées Techniques</th>
                                </tr>
                                <tr>
                                    <!-- Colonnes Première Année -->
                                    <th class="bg-light">S1</th>
                                    <th class="bg-light">S2</th>
                                    <th class="bg-light">JT1</th>
                                    <th class="bg-light">JT2</th>
                                    <th class="bg-light">JT3</th>
                                    
                                    <!-- Colonnes Deuxième Année -->
                                    <th class="bg-light">S3</th>
                                    <th class="bg-light">S4</th>
                                    <th class="bg-light">JT1</th>
                                    <th class="bg-light">JT2</th>
                                    <th class="bg-light">JT3</th>
                                    
                                    <!-- Colonnes Troisième Année -->
                                    <th class="bg-light">S5</th>
                                    <th class="bg-light">S6</th>
                                    <th class="bg-light">JT1</th>
                                    <th class="bg-light">JT2</th>
                                    <th class="bg-light">JT3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stagiaires as $stagiaire)
                                <tr>
                                    <td class="fw-bold">{{ $stagiaire->firstname }}</td>
                                    <td>{{ $stagiaire->name }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($stagiaire->stage_begin)->format('d/m/Y') }}</td>
                                    
                                    <!-- Première Année - Rapports S1 et S2 -->
                                    @for ($i = 0; $i <= 1; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    <span class="badge bg-danger">Retard</span>
                                                @else
                                                    <span class="badge bg-success">Soumis</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    
                                    <!-- Première Année - JT -->
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_1[$i]))
                                                <span class="badge bg-success">Présent</span>
                                                <span class="badge bg-danger"> {{ $stagiaire->display_mode }} </span>
                                            @else
                                                <span class="badge bg-secondary">Absent</span>
                                            @endif 
                                        </td>
                                    @endfor
                                    
                                    <!-- Deuxième Année - Rapports S3 et S4 -->
                                    @for ($i = 2; $i <= 3; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    <span class="badge bg-danger">Retard</span>
                                                @else
                                                    <span class="badge bg-success">Soumis</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    
                                    <!-- Deuxième Année - JT -->
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_2[$i]))
                                                <span class="badge bg-success">Présent</span>
                                                <span class="badge bg-danger"> {{ $stagiaire->display_mode }} </span>
                                            @else
                                                <span class="badge bg-secondary">Absent</span>
                                            @endif 
                                        </td>
                                    @endfor
                                    
                                    <!-- Troisième Année - Rapports S5 et S6 -->
                                    @for ($i = 4; $i <= 5; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    <span class="badge bg-danger">Retard</span>
                                                @else
                                                    <span class="badge bg-success">Soumis</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    
                                    <!-- Troisième Année - JT -->
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_3[$i]))
                                                <span class="badge bg-success">Présent</span>
                                                <span class="badge bg-danger"> {{ $stagiaire->display_mode }} </span>
                                            @else
                                                <span class="badge bg-secondary">Absent</span>
                                            @endif 
                                        </td>
                                    @endfor
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        min-width: 1200px;
    }
    th {
        text-align: center;
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>
@endsection

@section('scripts_down')
<script>
    document.getElementById('downloadExcel').addEventListener('click', function() {
        var table = document.getElementById('myTable');
        var html = table.outerHTML;

        var style = '<style>';
        style += 'table { border-collapse: collapse; width: 100%; }';
        style += 'th, td { border: 1px solid black; padding: 6px; text-align: center; font-size: 11px; }';
        style += 'th { background-color: #f2f2f2; font-weight: bold; }';
        style += '.bg-info { background-color: #17a2b8 !important; color: white !important; }';
        style += '.bg-success { background-color: #28a745 !important; color: white !important; }';
        style += '.bg-warning { background-color: #ffc107 !important; color: black !important; }';
        style += '.bg-light { background-color: #f8f9fa !important; }';
        style += '</style>';
        
        var blob = new Blob(['\uFEFF' + style + html], {
            type: 'application/vnd.ms-excel;charset=utf-8'
        });

        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;

        const fileName = `Recapitulatif_{{ $country_contr }}.xls`;
        a.download = fileName;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
</script>
@endsection