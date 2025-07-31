{{-- @extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border rounded-3 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Récapitulatif des Stagiaires du : {{ $country_contr }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th colspan="3">Informations</th>
                                    <th colspan="1">Semestre 1</th>
                                    <th colspan="1">Semestre 2</th>
                                    <th colspan="3">JT Anée 1</th>
                                    <th colspan="1">Semestre 3</th>
                                    <th colspan="1">Semestre 4</th>
                                    <th colspan="3">JT Anée 2</th>
                                    <th colspan="1">Semestre 5</th>
                                    <th colspan="1">Semestre 6</th>
                                    <th colspan="3">JT Anée 3</th>
                                </tr>
                                <tr>
                                    <th >Noms </th>
                                    <th >Prénoms </th>
                                    <th >Date de Début de Stage</th>
                                    <th>Dépôt Rapport</th>
                                    <th>Dépôt Rapport</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>Dépôt Rapport</th>
                                    <th>Dépôt Rapport</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>Dépôt Rapport</th>
                                    <th>Dépôt Rapport</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stagiaires as $stagiaire)
                                <tr>
                                    <td>{{ $stagiaire->firstname }}</td>
                                    <td>{{ $stagiaire->name }}</td>

                                    <td>{{ $stagiaire->stage_begin }}</td>
                                    
                                    @for ($i = 0; $i <= 1; $i++)
                                        <td>
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    {{ 'Retard' }}
                                                @else
                                                    {{ 'Soumis le ' . $stagiaire->rapports[$i]->created_at->format('d/m/Y H:i') }}
                                                    <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[$i]->id])}}" class="btn btn-primary">Voir</a>
                                                    <a href="" class="btn btn-primary"> Listes</a>
                                                @endif
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                    @endfor
                                    @for ($i = 0; $i <= 2; $i++)
                                    <td>
                                        @if(!empty($stagiaire->jt_year_1[$i]))
                                        {{ 'Soumis le ' .$stagiaire->jt_year_1[0]->created_at->format('d/m/Y H:i') }}
                                        @else
                                        -
                                        @endif 
                                    </td>
                                    @endfor

                                                                        
                                    @for ($i = 2; $i <= 3; $i++)
                                        <td>
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    {{ 'Retard' }}
                                                @else
                                                    {{ 'Soumis le ' . $stagiaire->rapports[$i]->created_at->format('d/m/Y H:i') }}
                                                    <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[$i]->id])}}" class="btn btn-primary">Voir</a>
                                                    <a href="" class="btn btn-primary"> Listes</a>
                                                @endif
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                    @endfor
                                    @for ($i = 0; $i <= 2; $i++)
                                    <td>
                                        @if(!empty($stagiaire->jt_year_3[$i]))
                                        {{ 'Soumis le ' .$stagiaire->jt_year_1[0]->created_at->format('d/m/Y H:i') }}
                                        @else
                                        -
                                        @endif 
                                    </td>
                                    @endfor

                                    
                                    @for ($i = 4; $i <= 5; $i++)
                                        <td>
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    {{ 'Retard' }}
                                                @else
                                                    {{ 'Soumis le ' . $stagiaire->rapports[$i]->created_at->format('d/m/Y H:i') }}
                                                    <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[$i]->id])}}" class="btn btn-primary">Voir</a>
                                                    <a href="" class="btn btn-primary"> Listes</a>
                                                @endif
                                            @else
                                                {{ '' }}
                                            @endif
                                        </td>
                                    @endfor
                                    @for ($i = 0; $i <= 2; $i++)
                                    <td>
                                        @if(!empty($stagiaire->jt_year_1[$i]))
                                        {{ 'Soumis le ' .$stagiaire->jt_year_3[0]->created_at->format('d/m/Y H:i') }}
                                        @else
                                        -
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
    }
</style>
@endsection  --}}
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
                                    <th colspan="3" class="bg-light">Informations</th>
                                    <th colspan="2" class="bg-info text-white">Première Année</th>
                                    <th colspan="3" class="bg-warning text-dark">Journée Technique Année 1</th>
                                    <th colspan="2" class="bg-info text-white">Deuxième Année</th>
                                    <th colspan="3" class="bg-warning text-dark">Journée Technique Année 2</th>
                                    <th colspan="2" class="bg-info text-white">Troisième Année</th>
                                    <th colspan="3" class="bg-warning text-dark">Journée Technique Année 3</th>
                                </tr>
                                <tr>
                                    <th class="text-center bg-light">Nom</th>
                                    <th class="text-center bg-light">Prénom</th>
                                    <th class="text-center bg-light">Début Stage</th>
                                    <th class="text-center bg-light">Rapport Semestre 1</th>
                                    <th class="text-center bg-light">Rapport Semestre 2</th>
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    <th class="text-center bg-light">Rapport Semestre 3</th>
                                    <th class="text-center bg-light">Rapport Semestre 4</th>
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    <th class="text-center bg-light">Rapport Semestre 5</th>
                                    <th class="text-center bg-light">Rapport Semestre 6</th>
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stagiaires as $stagiaire)
                                <tr>
                                    <td class="fw-bold">{{ $stagiaire->firstname }}</td>
                                    <td>{{ $stagiaire->name }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($stagiaire->stage_begin)->format('d/m/Y') }}</td>
                                    @for ($i = 0; $i <= 1; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    <span class="badge bg-danger">Retard</span>
                                                @else
                                                    <span class="text-success">Soumis</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_1[$i]))
                                                <span class="badge bg-success">Présent</span>
                                            @else
                                                <span class="badge bg-secondary">Non soumis</span>
                                            @endif 
                                        </td>
                                    @endfor
                                    @for ($i = 2; $i <= 3; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    <span class="badge bg-danger">Retard</span>
                                                @else
                                                    <span class="text-success">Soumis</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_2[$i]))
                                                <span class="badge bg-success">Présent</span>
                                            @else
                                                <span class="badge bg-secondary">Non soumis</span>
                                            @endif 
                                        </td>
                                    @endfor
                                    @for ($i = 4; $i <= 5; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                                @if($stagiaire->rapports[$i]->delayed)
                                                    <span class="badge bg-danger">Retard</span>
                                                @else
                                                    <span class="text-success">Soumis</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_3[$i]))
                                                <span class="badge bg-success">Présent</span>
                                            @else
                                                <span class="badge bg-secondary">Non soumis</span>
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
</style>
@endsection

@section('scripts_down')
<script>
    document.getElementById('downloadExcel').addEventListener('click', function() {
        var table = document.getElementById('myTable');
        var html = table.outerHTML;

        // Adding CSS styles to make the table look good in Excel
        var style = '<style>';
        style += 'table { border-collapse: collapse; width: 100%; }';
        style += 'th, td { border: 1px solid black; padding: 8px; text-align: center; }';
        style += 'th { background-color: #f2f2f2; }';
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