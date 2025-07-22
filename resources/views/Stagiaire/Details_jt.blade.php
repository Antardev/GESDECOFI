@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="background-color: #f0f8ff;">
                <div class="card-header" style="background-color: #007bff; color: white;">
                    <h3 class="mb-0 text-center">Détails de la JT</h3>
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
                                    <p class="fw-bold mb-1">Nom </p>
                                    <p class="text-muted">
                                        @if (preg_match('/^JT(\d+)$/', $jt->jt_name, $matches))
                                            Section {{ $matches[1] }}
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Date début</p>
                                    <p class="text-muted">
                                        {{ \Carbon\Carbon::parse($jt->start_date)->isoFormat('LL') }}
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Date fin</p>
                                    <p class="text-muted">
                                        {{ \Carbon\Carbon::parse($jt->end_date)->isoFormat('LL') }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Lieu</p>
                                    <p class="text-muted">
                                        {{ $jt->jt_location }}
                                    </p>
                                </div>


                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Ordre</p>
                                    <p class="text-muted">
                                        {{ $jt->affiliation_order }}
                                    </p>
                                </div>

                            </div>

                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Description</p>
                                    <p class="text-muted">{{ $jt->jt_description }}</p>
                                </div>

                        </div>

                    <!-- Section Sous-catégories -->
                    <div class="mt-4">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-list-ul me-2"></i>Répartition des heures par Domaines et sous-domaines
                        </h4>
                        
                        @if($jt->sub_domains->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Sous-domaine</th>
                                        <th width="120" class="text-end">Heures</th>
                                        <th width="120" class="text-end">% du total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jt->sub_domains as $index => $jt_subdomain)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jt_subdomain->sub_domain_name }}</td>
                                        <td class="text-end">{{ $jt_subdomain->nb_hour }} h</td>
                                        <td class="text-end">
                                            @if($jt->nb_hour)
                                                @if($jt_subdomain->nb_hour == 0)
                                                0
                                                @else
                                                {{ round(($jt_subdomain->nb_hour / $jt->domain->nb_hour) * 100, 1) }}%
                                                @endif
                                            @else
                                            0
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-active">
                                        <td colspan="2" class="fw-bold">Total</td>
                                        <td class="text-end fw-bold">{{ $jt->domain->nb_hour }} h</td>
                                        <td class="text-end fw-bold">100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucun sous-domaine associée à cette journée technique.
                        </div>
                        @endif
                    </div>
                    {{-- Section module --}}
                    <div class="mt-4">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-cubes me-2"></i>Modules de la JT
                        </h4>
                        
                        @if($jt->modules->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Nom du module</th>
                                        <th width="120" class="text-end">Heures</th>
                                        <th width="120" class="text-end">% du total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalHours = $jt->modules->sum('nb_hour'); @endphp
                                    @foreach($jt->modules as $index => $module)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $module->name }}</td>
                                        <td class="text-end">{{ $module->nb_hour }} h</td>
                                        <td class="text-end">
                                            @if($totalHours > 0)
                                                {{ round(($module->nb_hour / $totalHours) * 100, 1) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-active">
                                        <td colspan="2" class="fw-bold">Total</td>
                                        <td class="text-end fw-bold">{{ $totalHours }} h</td>
                                        <td class="text-end fw-bold">100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucun module associé à cette journée technique.
                        </div>
                        @endif
                    </div>
                    </div>
                    
                    <div class="card-footer" style="background-color: #e9ecef;">
                        <a href="{{ route('stagiaire.list_jt') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                        </a>

                        @if($jt->rapport_path)
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#pdfModal">
                            <i class="fas fa-file-pdf me-1"></i> Consulter le rapport
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour afficher le PDF -->
@if($jt->rapport_path)
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="pdfModalLabel">Rapport de Journée technique: {{ $jt->jt_name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="{{ asset('storage/' . $jt->rapport_path) }}#toolbar=0&view=FitH" 
                        style="width: 100%; height: 100%; border: none;"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ asset('storage/' . $jt->rapport_path) }}" 
                   class="btn btn-success" 
                   download="Rapport_{{ $jt->jt_name }}.pdf">
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
@endsection