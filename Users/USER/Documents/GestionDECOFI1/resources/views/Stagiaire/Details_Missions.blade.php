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
                                            {{ $mission->nb_hour > 0 ? round(($subcategory->hour / $mission->nb_hour) * 100, 1) : 0 }}%
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
                    {{-- @dd($mission) --}}

                    @if($mission->rapport_path)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pdfModal">
                        <i class="fas fa-file-pdf me-1"></i> Consulter le rapport
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal pour afficher le PDF -->
@if($mission->rapport_path)
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="pdfModalLabel">Rapport de mission: {{ $mission->mission_name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="{{ asset('storage/' . $mission->rapport_path) }}#toolbar=0&view=FitH" 
                        style="width: 100%; height: 100%; border: none;"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ asset('storage/' . $mission->rapport_path) }}" 
                   class="btn btn-success" 
                   download="Rapport_{{ $mission->mission_name }}.pdf">
                    <i class="fas fa-download me-1"></i> Télécharger
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Fermer
                </button>
            </div>
        </div>
    </div>
</div>
@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection