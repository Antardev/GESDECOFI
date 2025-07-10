@extends('welcome')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus align-middle"></i>
                        Mes Informations
                    </h5>
                    <span class="badge bg-{{ $stagiaire->validated ? 'success' : 'warning' }}">
                        {{ $stagiaire->validated ? 'Validé' : 'En attente' }}
                    </span>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Colonne gauche - Avatar et infos personnelles -->
                        <div class="col-md-4">
                            <!-- Photo/Initiales -->
                            <div class="position-relative mx-auto" style="width: 100px; height: 100px;">
                                @if($stagiaire->picture_path)
                                    <!-- Image cliquable qui ouvre le modal -->
                                    <img src="{{ asset('storage/' . $stagiaire->picture_path) }}" 
                                         class="rounded-circle w-100 h-100 object-fit-cover border border-3 border-white shadow-sm"
                                         alt="Photo de {{ $stagiaire->firstname }} {{ $stagiaire->name }}"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#imageModal{{ $stagiaire->id }}">
                                @else
                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center w-100 h-100 fs-2 fw-bold shadow-sm"
                                         style="background: linear-gradient(135deg, #17a2b8 0%, #5bc0de 100%);">
                                        {{ substr($stagiaire->firstname, 0, 1) }}{{ substr($stagiaire->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Modal pour afficher l'image en grand -->
                            @if($stagiaire->picture_path)
                            <div class="modal fade" id="imageModal{{ $stagiaire->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">
                                                Photo de {{ $stagiaire->firstname }} {{ $stagiaire->name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/' . $stagiaire->picture_path) }}" 
                                                 class="img-fluid"
                                                 alt="Photo de {{ $stagiaire->firstname }} {{ $stagiaire->name }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <h4 class="mt-3 text-center">{{ $stagiaire->firstname }} {{ $stagiaire->name }}</h4>
                            <p class="text-muted mb-2 text-center">Matricule: {{ $stagiaire->matricule }}</p>
                            
                            <!-- Informations personnelles -->
                            <div class="mt-4">
                                <h6 class="border-bottom pb-2">Informations personnelles</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-envelope text-primary me-2"></i> 
                                        {{ $stagiaire->email }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-phone-alt text-primary me-2"></i> 
                                        {{ $stagiaire->phone ?? 'Non renseigné' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        {{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }} ({{ Carbon\Carbon::parse($stagiaire->birthdate)->age }} ans)
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-id-card text-primary me-2"></i>
                                        CNSS: {{ $stagiaire->numero_cnss ?? 'Non renseigné' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i> 
                                        {{ $stagiaire->country ?? 'Non spécifié' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-clock text-primary me-2"></i> 
                                        Inscrit le {{ $stagiaire->created_at->format('d/m/Y H:i') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-user-check text-primary me-2"></i> 
                                        Statut : 
                                        <span class="badge bg-{{ $stagiaire->validated ? 'success' : 'warning' }}">
                                            {{ $stagiaire->validated ? 'Validé' : 'En attente' }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Colonne droite - Informations professionnelles -->
                        <div class="col-md-8">
                            <!-- Informations sur le cabinet -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2">
                                    <i class="fas fa-building me-2"></i>Informations sur le cabinet
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Nom du cabinet:</strong> {{ $stagiaire->nom_cabinet }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Email:</strong> {{ $stagiaire->email_cabinet }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Téléphone:</strong> {{ $stagiaire->tel_cabinet }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Lieu:</strong> {{ $stagiaire->lieu_cabinet }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>N° inscription:</strong> {{ $stagiaire->numero_inscription_cabinet }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Date de debut de stagiaire:</strong> {{ Carbon\Carbon::parse($stagiaire->date_entree)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <p><strong>Représentant:</strong> {{ $stagiaire->nom_representant }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Informations sur le maître de stage -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2">
                                    <i class="fas fa-user-tie me-2"></i>Maître de stage
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Nom:</strong> {{ $stagiaire->nom_maitre }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Prénom:</strong> {{ $stagiaire->prenom_maitre }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Téléphone:</strong> {{ $stagiaire->tel_maitre }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>N° inscription:</strong> {{ $stagiaire->numero_inscription_maitre }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Diplôme et documents -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2">
                                    <i class="fas fa-file-alt me-2"></i>Documents
                                </h6>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-primary w-100" onclick="loadPDF('{{ asset('storage/' . $stagiaire->file_path) }}')">
                                            <i class="fas fa-file-pdf me-2"></i>Fiche
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-primary w-100" onclick="loadPDF('{{ asset('storage/' . $stagiaire->diplome_path) }}')">
                                            <i class="fas fa-graduation-cap me-2"></i>Diplôme
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-primary w-100" onclick="loadPDF('{{ asset('storage/' . $stagiaire->contrat_path) }}')">
                                            <i class="fas fa-file-contract me-2"></i>Contrat
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <p><strong>Date d'obtention du diplôme:</strong> {{ Carbon\Carbon::parse($stagiaire->date_obtention)->format('d/m/Y') }}</p>
                                </div>
                                
                                <!-- Iframe pour afficher le PDF -->
                                <div class="mt-3 border rounded p-2">
                                    <iframe id="pdfViewer" src="" style="width: 100%; height: 500px; border: none;"></iframe>
                                </div>
                            </div>
                            
                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-between border-top pt-3">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Retour
                                </a>
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace();
    });
    
    function loadPDF(pdfUrl) {
        document.getElementById('pdfViewer').src = pdfUrl;
        // Faire défiler jusqu'au visualiseur PDF
        document.getElementById('pdfViewer').scrollIntoView({ behavior: 'smooth' });
    }
</script>