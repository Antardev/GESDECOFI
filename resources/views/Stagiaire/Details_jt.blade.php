@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
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
                                    <p class="fw-bold mb-1">Date </p>
                                    <p class="text-muted">
                                        {{ \Carbon\Carbon::parse($jt->jt_date)->isoFormat('LL') }}
                                    </p>
                                </div>
                                
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <p class="fw-bold mb-1">Ordre</p>
                                    <p class="text-muted">
                                        {{ $jt->affiliation_order }}
                                    </p>
                                </div>
                                

                                
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <p class="fw-bold mb-1">Description</p>
                            <p class="text-muted">{{ $jt->jt_description }}</p>
                        </div>
                    </div>
                    
                <div class="card-footer bg-light">
                    <a href="{{ route('stagiaire.list_jt') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                    </a>
                    {{-- @dd($mission) --}}

                    @if($jt->rapport_path)
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
@if($jt->rapport_path)
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="pdfModalLabel">Rapport de mission: {{ $jt->jt_name }}</h5>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection