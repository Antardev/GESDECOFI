
@extends('welcome')

@section('content')
<div class="container py-5">
    

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 rounded-4 shadow-lg">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Récapitulatif du Stagiaire : {{ $stagiaire->firstname.' '.$stagiaire->name }}</h3>
                        <span class="badge bg-light text-primary fs-6">{{ $stagiaire->stage_begin }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="2" class="align-middle text-center bg-light">Semestres</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre  1</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 2</th>
                                    <th colspan="3" class="text-center bg-warning text-dark">Journée technique 1 année</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 3</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 4</th>
                                    <th colspan="3" class="text-center bg-warning text-dark">Journée technique 2 année</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 5</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 6</th>
                                    <th colspan="3" class="text-center bg-warning text-dark">Journée technique 3 année</th>

                                </tr>
                                <tr>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                     <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center fw-bold bg-light">Statut</td>
                                   
                                        @for ($i = 0; $i <= 1; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                            <div class="d-flex flex-column align-items-center">
                                                @if($stagiaire->rapports[$i]->delayed)
                                                <span class="badge bg-danger rounded-pill mb-1">Retard</span>
                                                @else
                                                <span class="text-success fw-bold mb-1">Soumis</span>
                                                <small class="text-muted">{{ $stagiaire->rapports[0]->created_at->format('d/m/Y H:i') }}</small>
                                                @endif
                                                <div class="btn-group btn-group-sm mt-1">
                                                    <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[0]->id])}}" class="btn btn-outline-primary">Voir</a>
                                                    <a href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}" class="btn btn-outline-secondary">Liste</a>
                                                </div>
                                            </div>
                                            @else
                                            <span class="text-muted">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                            {{-- @if(!empty($stagiaire->rapports[0]))
                                                <div class="d-flex flex-column align-items-center">
                                                    @if($stagiaire->rapports[0]->delayed)
                                                        <span class="badge bg-danger rounded-pill mb-1">Retard</span>
                                                    @else
                                                        <span class="text-success fw-bold mb-1">Soumis</span>
                                                        <small class="text-muted">{{ $stagiaire->rapports[0]->created_at->format('d/m/Y H:i') }}</small>
                                                    @endif
                                                    <div class="btn-group btn-group-sm mt-1">
                                                        <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[0]->id])}}" class="btn btn-outline-primary">Voir</a>
                                                        <a href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}" class="btn btn-outline-secondary">Liste</a>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Non soumis</span>
                                            @endif --}}
                                    

                                     <!-- Semestre 2 -->
                                    {{-- <td class="text-center">
                                        @if(!empty($stagiaire->rapports[1]))
                                            <div class="d-flex flex-column align-items-center">
                                                @if($stagiaire->rapports[1]->delayed)
                                                    <span class="badge bg-danger rounded-pill mb-1">Retard</span>
                                                @else
                                                    <span class="text-success fw-bold mb-1">Soumis</span>
                                                    <small class="text-muted">{{ $stagiaire->rapports[1]->created_at->format('d/m/Y H:i') }}</small>
                                                @endif
                                                <div class="btn-group btn-group-sm mt-1">
                                                    <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[1]->id])}}" class="btn btn-outline-primary">Voir</a>
                                                    <a href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}" class="btn btn-outline-secondary">Liste</a>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Non soumis</span>
                                        @endif
                                    </td> --}}

                                    @for ($i = 0; $i <= 2; $i++)
                                    <td>
                                        @if(!empty($stagiaire->jt_year_1[$i]))
                                        <span class="badge bg-success rounded-pill">Présent</span>
                                        <small class="text-muted d-block">{{ $stagiaire->jt_year_1[0]->created_at->format('d/m/Y') }}</small>
                                        @else
                                        <span class="badge bg-secondary rounded-pill">Absent</span>
                                        @endif 
                                    </td>
                                    @endfor

                                    <!-- Semestre 3 et 4   -->
                                    @for ($i = 2; $i <= 3; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                            <div class="d-flex flex-column align-items-center">
                                                @if($stagiaire->rapports[$i]->delayed)
                                                <span class="badge bg-danger rounded-pill mb-1">Retard</span>
                                                @else
                                                <span class="text-success fw-bold mb-1">Soumis</span>
                                                <small class="text-muted">{{ $stagiaire->rapports[0]->created_at->format('d/m/Y H:i') }}</small>
                                                @endif
                                                <div class="btn-group btn-group-sm mt-1">
                                                    <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[0]->id])}}" class="btn btn-outline-primary">Voir</a>
                                                    <a href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}" class="btn btn-outline-secondary">Liste</a>
                                                </div>
                                            </div>
                                            @else
                                            <span class="text-muted">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor

                                    @for ($i = 0; $i <= 2; $i++)
                                    <td>
                                        @if(!empty($stagiaire->jt_year_2[$i]))
                                        <span class="badge bg-success rounded-pill">Présent</span>
                                        <small class="text-muted d-block">{{ $stagiaire->jt_year_2[0]->created_at->format('d/m/Y') }}</small>
                                        @else
                                        <span class="badge bg-secondary rounded-pill">Absent</span>
                                        @endif 
                                    </td>
                                    @endfor

                                    @for ($i = 3; $i <= 4; $i++)
                                    <td class="text-center">
                                        @if(!empty($stagiaire->rapports[$i]))
                                        <div class="d-flex flex-column align-items-center">
                                            @if($stagiaire->rapports[$i]->delayed)
                                            <span class="badge bg-danger rounded-pill mb-1">Retard</span>
                                            @else
                                            <span class="text-success fw-bold mb-1">Soumis</span>
                                            <small class="text-muted">{{ $stagiaire->rapports[0]->created_at->format('d/m/Y H:i') }}</small>
                                            @endif
                                            <div class="btn-group btn-group-sm mt-1">
                                                <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[0]->id])}}" class="btn btn-outline-primary">Voir</a>
                                                <a href="{{ route('controleur.rapport_history', ['id' => $stagiaire->id]) }}" class="btn btn-outline-secondary">Liste</a>
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-muted">Non soumis</span>
                                        @endif
                                    </td>
                                @endfor
                                @for ($i = 0; $i <= 2; $i++)
                                <td>
                                    @if(!empty($stagiaire->jt_year_3[$i]))
                                    <span class="badge bg-success rounded-pill">Présent</span>
                                    <small class="text-muted d-block">{{ $stagiaire->jt_year_3[0]->created_at->format('d/m/Y') }}</small>
                                    @else
                                    <span class="badge bg-secondary rounded-pill">Absent</span>
                                    @endif 
                                </td>
                                @endfor
                                </tr>
    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Nouvelle section de résumé par année -->
     <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Résumé par Année</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Année 1 -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded-3 h-100">
                                <h5>Année 1</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Rapports soumis:</span>
                                    <strong>{{ count(array_filter([$stagiaire->rapports[0] ?? null, $stagiaire->rapports[1] ?? null])) }}/2</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>JT présents:</span>
                                    <strong>{{ count($stagiaire->jt_year_1 ?? []) }}/3</strong>
                                </div>
                                <button class="btn btn-sm btn-success w-100" 
                                        @if(count(array_filter([$stagiaire->rapports[0] ?? null, $stagiaire->rapports[1] ?? null])) < 2 || count($stagiaire->jt_year_1 ?? []) < 3) disabled @endif>
                                    Valider l'année
                                </button>
                            </div>
                        </div>

                        <!-- Année 2 -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded-3 h-100">
                                <h5>Année 2</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Rapports soumis:</span>
                                    <strong>{{ count(array_filter([$stagiaire->rapports[2] ?? null, $stagiaire->rapports[3] ?? null])) }}/2</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>JT présents:</span>
                                    <strong>{{ count($stagiaire->jt_year_2 ?? []) }}/3</strong>
                                </div>
                                <button class="btn btn-sm btn-success w-100" 
                                        @if(count(array_filter([$stagiaire->rapports[2] ?? null, $stagiaire->rapports[3] ?? null])) < 2 || count($stagiaire->jt_year_2 ?? []) < 3) disabled @endif>
                                    Valider l'année
                                </button>
                            </div>
                        </div>

                        <!-- Année 3 -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded-3 h-100">
                                <h5>Année 3</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Rapports soumis:</span>
                                    <strong>{{ count(array_filter([$stagiaire->rapports[4] ?? null, $stagiaire->rapports[5] ?? null])) }}/2</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>JT présents:</span>
                                    <strong>{{ count($stagiaire->jt_year_3 ?? []) }}/3</strong>
                                </div>
                                <button class="btn btn-sm btn-success w-100" 
                                        @if(count(array_filter([$stagiaire->rapports[4] ?? null, $stagiaire->rapports[5] ?? null])) < 2 || count($stagiaire->jt_year_3 ?? []) < 3) disabled @endif>
                                    Valider l'année
                                </button>
                            </div>
                        </div>
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
    .table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endsection

