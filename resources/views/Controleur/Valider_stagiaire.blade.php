@extends('welcome')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus align-middle"></i>
                        Détails du stagiaire
                    </h5>
                    <span class="badge bg-{{ $stagiaire->validated ? 'success' : 'warning' }}">
                        {{ $stagiaire->validated ? 'Validé' : 'En attente' }}
                    </span>
                </div>

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
                            @if($stagiaire->is_validated())
                            <p class="text-muted mb-2 text-center">
                                        <a class="btn btn-sm btn-success" href="{{Route('controleur.stagiaire_recap', ['id' => $stagiaire->id])}}">
                                           <i class="fas fa-clipboard-list"></i>
                                            Voir le Recapitulatif
                                        </a>
                                        <br>
                                        @if($stagiaire->disabled)
                                        <form action="{{Route('controleur.stagiaires.enable', ['id' => $stagiaire->id])}}" class="d-flex" method="POST">
                                            @csrf
                                            <button type="submit" class="mx-auto btn btn-sm btn-success mt-2" href="">
                                           <i class="fas fa-clipboard-list"></i>
                                                Activer ce compte
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{Route('controleur.stagiaires.disable', ['id' => $stagiaire->id])}}" class="d-flex" method="POST">
                                            @csrf
                                            <button type="submit" class="mx-auto btn btn-sm btn-danger mt-2" href="">
                                            <i class="fas fa-clipboard-list"></i>
                                                Désactiver ce compte
                                            </button>
                                        </form>
                                        @endif
                            </p>
                            @endif
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
                                       Né le  {{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }} ({{ Carbon\Carbon::parse($stagiaire->birthdate)->age }} ans)
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-id-card text-primary me-2"></i>
                                        CNSS: {{ $stagiaire->numero_cnss ?? 'Non renseigné' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i> 
                                      Pays de naissance: {{ $stagiaire->lieu ?? 'Non spécifié' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i> 
                                      Pays d'affiliation: {{ $stagiaire->country ?? 'Non spécifié' }}
                                    </li>
                                      <li class="mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i> 
                                         Nationalite: {{ $stagiaire->Nationalite ?? 'Non spécifié' }}
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
                            <!-- Informations sur le cabinet/ l'entreprise -->
                            <div class="mb-4">
                                @if($stagiaire->structure_type == 'cabinet')
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
                                        <p><strong>N° ONECCA:</strong> {{ $stagiaire->numero_inscription_cabinet }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Affiliation </strong> {{ $stagiaire->affiliation_cabinet }}</p>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <p><strong>Responsable du Cabinet:</strong> {{ $stagiaire->nom_representant }}</p>
                                    </div>
                                </div>
                                    @else
                                    <h6 class="border-bottom pb-2">
                                        <i class="fas fa-building me-2"></i>Informations sur l'entreprise
                                    </h6>
                                    <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Nom de l'entreprise:</strong> {{ $stagiaire->nom_entreprise }}</p>  
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Type de l'entreprise:</strong> {{ $stagiaire->type_entreprise }}</p>  
                                    </div>
                                    
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Email:</strong> {{ $stagiaire->email_firm }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Téléphone:</strong> {{ $stagiaire->tel_firm }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Adresse:</strong> {{ $stagiaire->Adresse_firm }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Poste occupé:</strong> {{ $stagiaire->Poste_firm }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Nom du commissaire aux comptes:</strong> {{ $stagiaire->nom_commissaire }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Nom du representant:</strong> {{ $stagiaire->Representant_firm }}</p>
                                    </div>
                                </div>
                                    @endif 
                                    <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Date de début de stage :</strong> {{ Carbon\Carbon::parse($stagiaire->stage_begin)->format('d/m/Y') }}</p>
                                    </div>
                                    @if (!$stagiaire->validated)
                                        
                                   <div class="col-md-6 mb-2">
                                        <button class="btn btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#changerdateModal"
                                        data-id="{{ $stagiaire->id }}"
                                        data-date="{{ $stagiaire->stage_begin ? $stagiaire->stage_begin : '' }}">
                                    Changer la date
                                </button>   
                                    </div>
                                    @endif
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
                                        <p><strong>E-mail :</strong> {{ $stagiaire->email_maitre }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>N° ONECCA:</strong> {{ $stagiaire->numero_inscription_maitre }}</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <p><strong>Affiliation:</strong> {{ $stagiaire->affiliation_maitre }}</p>
                                    </div>
                                    

                                </div>
                            </div>

                            <!-- Diplôme et documents -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2">
                                    <i class="fas fa-file-alt me-2"></i>Documents
                                </h6>
                                <div class="row g-2 mb-3">
                                    <!-- Styles CSS intégrés pour uniformiser la taille -->
                                    <style>
                                        .btn-document {
                                            font-size: 10px !important;
                                            padding: 4px 6px;
                                            white-space: nowrap;
                                            overflow: hidden;
                                            text-overflow: ellipsis;
                                            max-width: 100%;
                                            height: 32px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        }
                                        .btn-document i {
                                            margin-right: 3px;
                                            font-size: 11px;
                                        }
                                    </style>
                                
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->file_path) }}')"
                                                data-bs-toggle="tooltip" title="Fiche de préinscription">
                                            <i class="fas fa-file-pdf"></i>Fiche
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->diplome_path) }}')"
                                                data-bs-toggle="tooltip" title="Attestation de réussite">
                                            <i class="fas fa-graduation-cap"></i>Diplôme
                                        </button>
                                    </div>
                                    
                                    @if($stagiaire->structure_type == 'cabinet')
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->contrat_path) }}')"
                                                data-bs-toggle="tooltip" title="Contrat de travail">
                                            <i class="fas fa-file-contract"></i>Contrat
                                        </button>
                                    </div>
                                    @else
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->contrat_firm) }}')"
                                                data-bs-toggle="tooltip" title="Contrat de travail">
                                            <i class="fas fa-file-contract"></i>Contrat
                                        </button>
                                    </div>
                                
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->fiche_paie) }}')"
                                                data-bs-toggle="tooltip" title="Fiche de paie de l'entreprise">
                                            <i class="fas fa-file-invoice-dollar"></i>Fiche Paie
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->engagement_firm) }}')"
                                                data-bs-toggle="tooltip" title="Engagement de la structure à faciliter le stage">
                                            <i class="fas fa-handshake"></i>Eng. Structure
                                        </button>
                                    </div>
                                
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->engagement_enter_cabinet) }}')"
                                                data-bs-toggle="tooltip" title="Engagement à continuer en cabinet">
                                            <i class="fas fa-building"></i>Eng. Cabinet
                                        </button>
                                    </div>
                                    @endif
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->id_card) }}')"
                                                data-bs-toggle="tooltip" title="Carte d'identité ou passeport">
                                            <i class="fas fa-id-card"></i>Carte ID
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->casier) }}')"
                                                data-bs-toggle="tooltip" title="Extrait de casier judiciaire">
                                            <i class="fas fa-gavel"></i>Casier
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->residence_master) }}')"
                                                data-bs-toggle="tooltip" title="Certificat de résidence du maître de stage">
                                            <i class="fas fa-home"></i>Res. Maître
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->accept_certificat) }}')"
                                                data-bs-toggle="tooltip" title="Attestation d'acceptation du maître de stage">
                                            <i class="fas fa-check-circle"></i>Acceptation
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->engagement) }}')"
                                                data-bs-toggle="tooltip" title="Engagement du stagiaire et du maître de stage">
                                            <i class="fas fa-signature"></i>Engagement
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->decharge) }}')"
                                                data-bs-toggle="tooltip" title="Décharge de demande d'inscription">
                                            <i class="fas fa-file-alt"></i>Décharge
                                        </button>
                                    </div>
                                    
                                    <div class="col-md-2 col-4 mb-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 btn-document" 
                                                onclick="loadPDF('{{ asset('storage/' . $stagiaire->cnss_card) }}')"
                                                data-bs-toggle="tooltip" title="Carte CNSS ou attestation de sécurité sociale">
                                            <i class="fas fa-address-card"></i>CNSS
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
                                @if(!$stagiaire->stage_begin )
                                    <div class="text-center">
                                        <span id="appear" style="display: none;">
                                            {{ __('message.The_intern_has_not_yet_submitted') }}
                                        </span>
                                        <br>
                                        <span class="btn btn-secondary" onclick="document.getElementById('appear').style.display = 'inline';">
                                            {{ __('sign_stage.send') }}
                                        </span>
                                    </div>
                                @else
                                    @if(!$stagiaire->validated)
                                    <form method="POST" action="{{route('controller.validate_stagiaire')}}">
                                        @csrf
                                        <input type="text" name="stagiaire_id" value="{{$stagiaire->id}}" hidden>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-circle me-1"></i> Valider
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



<div class="modal fade" id="changerdateModal" tabindex="-1" aria-labelledby="changeDateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="changeDateModalLabel">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Modifier la date de stage
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changeDateForm" method="get">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="stage_begin" class="form-label fw-bold">Nouvelle date de début</label>
                        <input type="date" 
                               class="form-control" 
                               id="stage_begin" 
                               name="stage_begin" 
                               required
                               >
                        <small class="text-muted">Format: JJ/MM/AAAA</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Succès</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@section('styles_up')
<style>
    .btn-small{
        font-size: 5px;
    }
</style>
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

    document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'ouverture du modal
    const dateModal = document.getElementById('changerdateModal');
    if (dateModal) {
        dateModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const stagiaireId = button.getAttribute('data-id');
            const currentDate = button.getAttribute('data-date');
            
            const form = document.getElementById('changeDateForm');
            form.action = `/stagiaires/${stagiaireId}/update-date`;
            document.getElementById('stage_begin').value = currentDate;
        });
    }

    // Gestion de la soumission du formulaire
    const dateForm = document.getElementById('changeDateForm');
    if (dateForm) {
        dateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Afficher indicateur de chargement
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Enregistrement...
            `;

            fetch(this.action, {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                    
                },
                body: new FormData(this)
            })
            
            .then(response => {
                
    window.location.reload();
})
            .catch(error => {
                console.error('Error:', error);
                alert(error.message);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

</script>