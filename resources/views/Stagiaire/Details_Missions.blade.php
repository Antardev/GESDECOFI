@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 text-center">Détails de la Mission</h3>
                </div>
                
                <div class="card-body">
                    <!-- Section Informations Principales -->
                    <div class="mb-4">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-info-circle me-2"></i>Informations Générales
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Nom de la mission</p>
                                    <p class="text-muted">{{ $mission->mission_name }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Date de début</p>
                                    <p class="text-muted">
                                        {{ \Carbon\Carbon::parse($mission->mission_begin_date)->isoFormat('LL') }}
                                    </p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Date de fin</p>
                                    <p class="text-muted">
                                        {{ \Carbon\Carbon::parse($mission->mission_end_date)->isoFormat('LL') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Catégorie</p>
                                    <p class="text-muted">{{ $mission->categorie->categorie_name }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Nombre total d'heures</p>
                                    <p class="text-muted">
                                        <span class="badge bg-primary rounded-pill px-3 py-2">
                                            {{ $mission->nb_hour }} heures
                                        </span>
                                    </p>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <p class="fw-bold mb-1">Description</p>
                            <p class="text-muted">{{ $mission->mission_description }}</p>
                        </div>
                    </div>
                    
                    <!-- Section Sous-catégories -->
                    <div class="mt-4">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-list-ul me-2"></i>Répartition des heures par sous-catégorie
                        </h4>
                        
                        @if($mission->sub_categories->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Sous-catégorie</th>
                                        <th width="120" class="text-end">Heures</th>
                                        <th width="120" class="text-end">% du total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mission->sub_categories as $index => $subcategory)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $subcategory->sub_categorie_name }}</td>
                                        <td class="text-end">{{ $subcategory->hour }} h</td>
                                        <td class="text-end">
                                            {{ round(($subcategory->hour / $mission->nb_hour) * 100, 1) }}%
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-active">
                                        <td colspan="2" class="fw-bold">Total</td>
                                        <td class="text-end fw-bold">{{ $mission->nb_hour }} h</td>
                                        <td class="text-end fw-bold">100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucune sous-catégorie associée à cette mission.
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="card-footer bg-light">
                    <a href="{{ route('stagiaire.list_mission') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection