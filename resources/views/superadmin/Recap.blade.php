
@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 rounded-4 shadow-lg">
                <div class="card-header bg-white text-black rounded-top-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Récapitulatif des Stagiaires du : {{ !empty($_GET['country'])?$_GET['country']: 'site' }}</h3>
                        <span class="badge bg-light text-primary fs-6">Aujourd'hui :  {{ now()->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
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
                                    <!-- Informations -->
                                    <th class="text-center bg-light">Nom</th>
                                    <th class="text-center bg-light">Prénom</th>
                                    <th class="text-center bg-light">Début Stage</th>
                                    
                                    <!-- Semestre 1-2 -->
                                    <th class="text-center bg-light">Rapport Semestre 1</th>
                                    <th class="text-center bg-light">Rapport Semestre 2</th>
                                    
                                    <!-- JT Année 1 -->
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    
                                    <!-- Semestre 3-4 -->
                                    <th class="text-center bg-light">Rapport Semestre 3</th>
                                    <th class="text-center bg-light">Rapport Semestre 4</th>
                                    
                                    <!-- JT Année 2 -->
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                    
                                    <!-- Semestre 5-6 -->
                                    <th class="text-center bg-light">Rapport Semestre 5</th>
                                    <th class="text-center bg-light">Rapport Semestre 6</th>
                                    
                                    <!-- JT Année 3 -->
                                    <th class="text-center bg-light">JT1</th>
                                    <th class="text-center bg-light">JT2</th>
                                    <th class="text-center bg-light">JT3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stagiaires as $stagiaire)
                                <tr>
                                    <!-- Informations -->
                                    <td class="fw-bold">{{ $stagiaire->firstname }}</td>
                                    <td>{{ $stagiaire->name }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($stagiaire->stage_begin)->format('d/m/Y') }}</td>
                                    
                                    <!-- Semestre 1-2 -->
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
                                                        <a href="{{route('superadmin.exam_rapport', ['id'=>$stagiaire->rapports[$i]->id])}}" class="btn btn-outline-primary">Voir</a>
                                                        <a href="{{ route('superadmin.rapport_history', ['id' => $stagiaire->id]) }}" class="btn btn-outline-secondary">Liste</a>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    
                                    <!-- JT Année 1 -->
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_1[$i]))
                                                <span class="badge bg-success rounded-pill">Présent</span>
                                                <small class="text-muted d-block">{{ $stagiaire->jt_year_1[$i]->created_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="badge bg-secondary rounded-pill">Non soumis</span>
                                            @endif 
                                        </td>
                                    @endfor
                                    
                                    <!-- Semestre 3-4 -->
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
                                                        <a href="{{route('superadmin.exam_rapport', ['id'=>$stagiaire->rapports[$i]->id])}}" class="btn btn-outline-primary">Voir</a>
                                                        <a href="{{ route('superadmin.rapport_history', ['id' => $stagiaire->id]) }}" class="btn btn-outline-secondary">Liste</a>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    
                                    <!-- JT Année 2 -->
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_2[$i]))
                                                <span class="badge bg-success rounded-pill">Présent</span>
                                                <small class="text-muted d-block">{{ $stagiaire->jt_year_2[$i]->created_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="badge bg-secondary rounded-pill">Non soumis</span>
                                            @endif 
                                        </td>
                                    @endfor
                                    
                                    <!-- Semestre 5-6 -->
                                    @for ($i = 4; $i <= 5; $i++)
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
                                                        <a href="{{route('superadmin.exam_rapport', ['id'=>$stagiaire->rapports[$i]->id])}}" class="btn btn-outline-primary">Voir</a>
                                                        <a href="{{ route('superadmin.rapport_history', ['id' => $stagiaire->id]) }}" class="btn btn-outline-secondary">Liste</a>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Non soumis</span>
                                            @endif
                                        </td>
                                    @endfor
                                    
                                    <!-- JT Année 3 -->
                                    @for ($i = 0; $i <= 2; $i++)
                                        <td class="text-center">
                                            @if(!empty($stagiaire->jt_year_3[$i]))
                                                <span class="badge bg-success rounded-pill">Présent</span>
                                                <small class="text-muted d-block">{{ $stagiaire->jt_year_3[$i]->created_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="badge bg-secondary rounded-pill">Non soumis</span>
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
    .bg-warning {
        background-color: #fff3cd !important;
    }
</style>
@endsection