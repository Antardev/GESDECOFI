
@extends('welcome')

@section('content')
<div class="container py-5">
    

    <div class="row justify-content-center">
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('access_denied'))
            <div class="alert alert-danger mt-3">
                {{ session('access_denied') }}
            </div>
        @endif

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
                                    @php
                                        $to = 3;
                                        if($stagiaire->jt_year_1->count() > 3)
                                        {
                                            $to = $stagiaire->jt_year_1->count();
                                        }
                                    @endphp
                                    <th colspan="{{$to}}" class="text-center bg-warning text-dark">Journée technique 1 année</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 3</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 4</th>
                                    @php
                                        $to = 3;
                                        if($stagiaire->jt_year_2->count() > 3)
                                        {
                                            $to = $stagiaire->jt_year_2->count();
                                        }
                                    @endphp
                                    <th colspan="{{$to}}" class="text-center bg-warning text-dark">Journée technique 2 année</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 5</th>
                                    <th colspan="1" class="text-center bg-info text-white">Semestre 6</th>
                                    @php
                                        $to = 3;
                                        if($stagiaire->jt_year_3->count() > 3)
                                        {
                                            $to = $stagiaire->jt_year_3->count();
                                        }
                                    @endphp
                                    <th colspan="{{$to}}" class="text-center bg-warning text-dark">Journée technique 3 année</th>

                                </tr>
                                <tr>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    @if($stagiaire->jt_year_1->count() > 3)
                                        @for ($i = 3; $i < ($stagiaire->jt_year_1->count()); $i++)
                                            <th>
                                                {{'JT'.$i+1}}
                                            </th>
                                        @endfor
                                    @endif
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    @if($stagiaire->jt_year_2->count() > 3)
                                        @for ($i = 3; $i < ($stagiaire->jt_year_2->count()); $i++)
                                            <th>
                                                {{'JT'.$i+1}}
                                            </th>
                                        @endfor
                                    @endif
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                    <th class="text-center bg-light">Dépôt Rapport</th>
                                     <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    @if($stagiaire->jt_year_3->count() > 3)
                                        @for ($i = 3; $i < ($stagiaire->jt_year_3->count()); $i++)
                                            <th>
                                                {{'JT'.$i+1}}
                                            </th>
                                        @endfor
                                    @endif
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
                                                    <small class="text-muted">{{ $stagiaire->rapports[$i]->created_at->format('d/m/Y H:i') }}</small>
                                                    @endif
                                                    <div class="btn-group btn-group-sm mt-1">
                                                        <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[$i]->id])}}" class="btn btn-outline-primary">Voir</a>
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
                                            @if(!empty($stagiaire->jt_year_1[$i]))
                                            <span class="badge bg-success rounded-pill">Présent</span>
                                            <small class="text-muted d-block">{{ $stagiaire->jt_year_1[$i]->created_at->format('d/m/Y') }}</small>
                                            @else
                                            <span class="badge bg-secondary rounded-pill">Absent</span>
                                            @endif 
                                        </td>
                                    @endfor

                                    @if($stagiaire->jt_year_1->count() > 3)
                                        @for ($i = 3; $i < ($stagiaire->jt_year_1->count()); $i++)
                                            <td>
                                                @if(!empty($stagiaire->jt_year_1[$i]))
                                                <span class="badge bg-success rounded-pill">Présent</span>
                                                <small class="text-muted d-block">{{ $stagiaire->jt_year_1[$i]->created_at->format('d/m/Y') }}</small>
                                                @else
                                                <span class="badge bg-secondary rounded-pill">Absent</span>
                                                @endif 
                                            </td>
                                        @endfor
                                    @endif

                                    <!-- Semestre 3 et 4   -->
                                    @for ($i = 2; $i <= 3; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                            <div class="d-flex flex-column align-items-center">
                                                @if($stagiaire->rapports[$i]->delayed)
                                                <span class="badge bg-danger rounded-pill mb-1">Retard</span>
                                                @else
                                                <span class="text-success fw-bold mb-1">Soumis</span>
                                                <small class="text-muted">{{ $stagiaire->rapports[$i]->created_at->format('d/m/Y H:i') }}</small>
                                                @endif
                                                <div class="btn-group btn-group-sm mt-1">
                                                    <a href="{{route('controleur.exam_rapport', ['id'=>$stagiaire->rapports[$i]->id])}}" class="btn btn-outline-primary">Voir</a>
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
                                            <small class="text-muted d-block">{{ $stagiaire->jt_year_2[$i]->created_at->format('d/m/Y') }}</small>
                                            @else
                                            <span class="badge bg-secondary rounded-pill">Absent</span>
                                            @endif 
                                        </td>
                                    @endfor
                                    @if($stagiaire->jt_year_2->count() > 3)
                                        @for ($i = 3; $i < ($stagiaire->jt_year_2->count()); $i++)
                                            <td>
                                                @if(!empty($stagiaire->jt_year_2[$i]))
                                                <span class="badge bg-success rounded-pill">Présent</span>
                                                <small class="text-muted d-block">{{ $stagiaire->jt_year_2[$i]->created_at->format('d/m/Y') }}</small>
                                                @else
                                                <span class="badge bg-secondary rounded-pill">Absent</span>
                                                @endif 
                                            </td>
                                        @endfor
                                    @endif


                                    @for ($i = 3; $i <= 4; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->rapports[$i]))
                                            <div class="d-flex flex-column align-items-center">
                                                @if($stagiaire->rapports[$i]->delayed)
                                                <span class="badge bg-danger rounded-pill mb-1">Retard</span>
                                                @else
                                                <span class="text-success fw-bold mb-1">Soumis</span>
                                                <small class="text-muted">{{ $stagiaire->rapports[$i]->created_at->format('d/m/Y H:i') }}</small>
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
                                            <small class="text-muted d-block">{{ $stagiaire->jt_year_3[$i]->created_at->format('d/m/Y') }}</small>
                                            @else
                                            <span class="badge bg-secondary rounded-pill">Absent</span>
                                            @endif 
                                        </td>
                                    @endfor
                                    @if($stagiaire->jt_year_3->count() > 3)
                                        @for ($i = 3; $i < ($stagiaire->jt_year_3->count()); $i++)
                                            <td>
                                                @if(!empty($stagiaire->jt_year_3[$i]))
                                                <span class="badge bg-success rounded-pill">Présent</span>
                                                <small class="text-muted d-block">{{ $stagiaire->jt_year_3[$i]->created_at->format('d/m/Y') }}</small>
                                                @else
                                                <span class="badge bg-secondary rounded-pill">Absent</span>
                                                @endif 
                                            </td>
                                        @endfor
                                    @endif
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
                    <hr>
                    @php
                        $totalJt = get_st_total_jt_number($stagiaire->id);
                        $configJtNumber = get_general_config()->jt_number;
                        $threshold = $configJtNumber * 3;

                        $result = ($totalJt > $threshold) ? ($totalJt - $threshold) : 0;
                    @endphp

                    
                <div class="alert alert-warning" role="alert">
                    <h5 class="fw-bold">Nombre de JT Supplémentaire :</h5>
                    <span class="bg-danger text-white p-2 rounded">{{ $result }}</span>
                </div>

                <div class="my-3">

                    <p class="text-muted">
                        <strong>Note :</strong> Le choix de valider l'année vous appartient une fois que le nombre de JT et de rapports validés, défini par défaut, est atteint. Vous pouvez choisir de ne pas tenir compte des JT supplémentaires.
                    </p>
                </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Année 1 -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded-3 h-100">
                                <h5>Année 1</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Rapports soumis:</span>
                                    <strong>{{ $stagiaire->rapports_year1->count() }}/2</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>JT présents:</span>
                                    <strong>{{ count($stagiaire->jt_year_1 ?? []) }}/3</strong>
                                </div>

                                @if($stagiaire->isYearValidate(1))
                                    <button class="btn btn-sm btn-success w-100" 
                                            disabled>
                                        Année déjà validée
                                    </button>
                                @else

                                    <form method="POST" id="formY1" action="{{route('controleur.stagiaires.validateYear')}}">
                                        @csrf
                                        <input type="text" name="stagiaire_id" value="{{$stagiaire->id}}" hidden>

                                        <input type="text" name="year" value="1" hidden>
                                    </form>
                                    @if(auth()->user() && (Str::contains(auth()->user()->validated_type, 'CN') || Str::contains(auth()->user()->validated_type, 'assistant_controller')))
                                    <button type="submit" form="formY1" class="btn btn-sm btn-success w-100" 
                                            @if($stagiaire->rapports_year1->count() < 2 || count($stagiaire->jt_year_1 ?? []) < 3) disabled @endif>
                                        Valider l'année
                                    </button>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Année 2 -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded-3 h-100">
                                <h5>Année 2</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Rapports soumis:</span>
                                    <strong>{{ $stagiaire->rapports_year2->count() }}/2</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>JT présents:</span>
                                    <strong>{{ count($stagiaire->jt_year_2 ?? []) }}/3</strong>
                                </div>

                                @if($stagiaire->isYearValidate(2))
                                <button class="btn btn-sm btn-success w-100" 
                                        disabled>
                                    Année déjà validée
                                </button>
                                @else
                                
                                <form method="POST" id="formY2" action="{{route('controleur.stagiaires.validateYear')}}">
                                    @csrf

                                    <input type="text" name="stagiaire_id" value="{{$stagiaire->id}}" hidden>

                                    <input type="text" name="year" value="2" hidden>
                                </form>

                                @if(auth()->user() && (Str::contains(auth()->user()->validated_type, 'CN') || Str::contains(auth()->user()->validated_type, 'assistant_controller')))
                                <button type="submit" form="formY3" class="btn btn-sm btn-success w-100" 
                                        @if($stagiaire->rapports_year3->count() < 2 || count($stagiaire->jt_year_3 ?? []) < 3) disabled @endif>
                                    Valider l'année
                                </button>
                                @endif
                                @endif
                            </div>
                        </div>

                        <!-- Année 3 -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded-3 h-100">
                                <h5>Année 3</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Rapports soumis:</span>
                                    <strong>{{ $stagiaire->rapports_year3->count() }}/2</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>JT présents:</span>
                                    <strong>{{ count($stagiaire->jt_year_3 ?? []) }}/3</strong>
                                </div>
                                @if($stagiaire->isYearValidate(3))
                                    <button class="btn btn-sm btn-success w-100" 
                                            disabled>
                                        Année déjà validée
                                    </button>
                                @else

                                    @if(auth()->user() && (Str::contains(auth()->user()->validated_type, 'CN') || Str::contains(auth()->user()->validated_type, 'assistant_controller')))
                                    <form method="POST" id="formY3" action="{{route('controleur.stagiaires.validateYear')}}">
                                        @csrf

                                        <input type="text" name="stagiaire_id" value="{{$stagiaire->id}}" hidden>

                                        <input type="text" name="year" value="3" hidden>
                                    </form>

                                    <button type="submit" form="formY3" class="btn btn-sm btn-success w-100" 
                                            @if($stagiaire->rapports_year3->count() < 2 || count($stagiaire->jt_year_3 ?? []) < 3) disabled @endif>
                                        Valider l'année
                                    </button>
                                    @endif
                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if(auth()->user() && (Str::contains(auth()->user()->validated_type, 'CN') || Str::contains(auth()->user()->validated_type, 'assistant_controller')))
                <div class="card-footer d-flex">
                    @if($stagiaire->hasEndStage())
                        <button form="formS" type="submit" class="btn btn-lg btn-primary mx-auto" disabled>Déjà fin du stage</button>
                    @else
                    <form method="POST" id="formS" action="{{route('controleur.stagiaires.validateStage')}}">
                        @csrf

                        <input type="text" name="stagiaire_id" value="{{$stagiaire->id}}" hidden>
                    </form>
                    @endif
                    <button form="formS" type="submit" class="btn btn-lg btn-primary mx-auto" @if(!$stagiaire->allYearValidate()) disabled @endif>Valider la fin du stage</button>
                </div>
                @endif
                @if(auth()->user() && Str::contains(auth()->user()->validated_type, 'CR'))
                <div class="Card-footer d-flex">
                    <a href="{{route('Show_attestation', ['id' => $stagiaire->id])}}" class="btn btn-lg btn-primary mx-auto" > Generer une attestation </a>
                </div> 
                @endif
             
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

