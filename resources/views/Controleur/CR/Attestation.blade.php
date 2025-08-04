{{-- 
@extends('welcome')

@section('title')
    <title>Gestion DECOFI - Attestation</title>
@endsection

@section('scripts_up')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endsection

@section('content')

<div id="stagiaire-info" style="display: none;" 
     data-nom="{{ $stagiaire->name }}"
     data-prenom="{{ $stagiaire->firstname }}"
     data-formation="{{ $stagiaire->formation ?? 'Non spécifié' }}"
     data-date-debut="{{ Carbon\Carbon::parse($stagiaire->date_entree)->format('d/m/Y')}}"
     data-date-fin="{{ $stagiaire->date_fin ?? now()->format('Y-m-d') }}"
     data-responsable="{{ $stagiaire->nom_representant }}"
     data-fonction="Responsable du cabinet"
     data-entreprise="{{ $stagiaire->nom_cabinet }}"
     data-ville="{{ $stagiaire->lieu_cabinet }}"
     data-date-attestation="{{ now()->format('Y-m-d') }}">
</div>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-file-certificate me-2"></i>Attestation de stage</h4>
        </div>
        
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Les informations du stagiaire ont été pré-remplies. Vérifiez les données avant de générer l'attestation.
            </div>
            
            <form id="attestationForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nom du responsable</label>
                            <input type="text" class="form-control" id="responsable" value="{{ auth()->user()->fullname  }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Fonction</label>
                            <input type="text" class="form-control" id="fonction" value="Responsable du cabinet" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nom de l'entreprise</label>
                            <input type="text" class="form-control" id="entreprise" value="{{ $stagiaire->nom_cabinet }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nom du stagiaire</label>
                            <input type="text" class="form-control" id="nom" value="{{ $stagiaire->name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Prénom du stagiaire</label>
                            <input type="text" class="form-control" id="prenom" value="{{ $stagiaire->firstname }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Formation suivie</label>
                            <input type="text" class="form-control" id="formation" value="{{ $stagiaire->formation ?? 'Non spécifié' }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Date de début</label>
                            <input type="date" class="form-control" id="date_debut" value="{{  Carbon\Carbon::parse($stagiaire->stage_begin)->format('d/m/Y') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Date de fin</label>
                            <input type="date" class="form-control" id="date_fin" value="{{ $stagiaire->date_fin ?? now()->format('Y-m-d') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ville</label>
                            <input type="text" class="form-control" id="ville" value="{{ $stagiaire->lieu_cabinet }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Date de l'attestation</label>
                            <input type="date" class="form-control" id="date_attestation" value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Mission principale</label>
                    <textarea class="form-control" id="mission" rows="4" required>Participation aux activités du cabinet, réalisation des tâches confiées par le maître de stage, et application des connaissances acquises durant la formation.</textarea>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary" onclick="genererPDF()">
                        <i class="fas fa-file-pdf me-2"></i>Générer l'attestation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template caché pour l'attestation -->
<div id="attestation" class="attestation" style="display: none;">
    <div class="header">
        <h2>ATTESTATION DE STAGE</h2>
    </div>
    <p>Je soussigné(e), <strong><span id="res"></span></strong>, <strong><span id="fct"></span></strong>, de l'entreprise <strong><span id="ent"></span></strong>, atteste que :</p>
    
    <p><strong>Nom et Prénom du stagiaire :</strong> <span id="stag_nom"></span> <span id="stag_prenom"></span></p>
    <p><strong>Formation suivie :</strong> <span id="form"></span></p>
    <p><strong>Période de stage :</strong> Du <span id="dd"></span> au <span id="df"></span></p>
    <p><strong>Mission principale :</strong> <span id="miss"></span></p>
    
    <p>Durant cette période, le(la) stagiaire a fait preuve de sérieux, d'assiduité et de professionnalisme.</p>
    <p>Cette attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.</p>
    
    <div class="footer">
        <p>Fait à <strong><span id="vil"></span></strong>, le <strong><span id="dat"></span></strong></p>
        <p>Signature et cachet de l'entreprise</p>
        <p><strong>Code unique :</strong> <span id="code"></span></p>
    </div>
</div>

<style>
    .attestation {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        padding: 2cm;
        background: white;
        border: 1px solid #ddd;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .attestation .header {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .attestation .header h2 {
        font-size: 24px;
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
    }
    
    .attestation p {
        margin-bottom: 15px;
    }
    
    .attestation .footer {
        margin-top: 50px;
        text-align: right;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les données du stagiaire depuis l'élément caché
        const stagiaireData = document.getElementById('stagiaire-info').dataset;
        
        // Pré-remplir les champs si vide
        if (!document.getElementById('responsable').value) {
            document.getElementById('responsable').value = stagiaireData.responsable;
        }
        
        if (!document.getElementById('entreprise').value) {
            document.getElementById('entreprise').value = stagiaireData.entreprise;
        }
        
        // etc. pour les autres champs...
    });

    function genererPDF() {
        // Validation du formulaire
        const form = document.getElementById('attestationForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Récupérer les valeurs
        const responsable = document.getElementById("responsable").value;
        const fonction = document.getElementById("fonction").value;
        const entreprise = document.getElementById("entreprise").value;
        const nom = document.getElementById("nom").value;
        const prenom = document.getElementById("prenom").value;
        const formation = document.getElementById("formation").value;
        const date_debut = document.getElementById("date_debut").value;
        const date_fin = document.getElementById("date_fin").value;
        const mission = document.getElementById("mission").value;
        const ville = document.getElementById("ville").value;
        const date_attestation = document.getElementById("date_attestation").value;

        // Formater les dates en français
        const formatDate = (dateString) => {
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('fr-FR', options);
        };

        // Générer le code unique
        const code = "STG-" + 
            nom.substring(0, 3).toUpperCase() + 
            prenom.substring(0, 3).toUpperCase() + 
            "-" + new Date().getFullYear();

        // Remplir l'attestation
        document.getElementById("res").textContent = responsable;
        document.getElementById("fct").textContent = fonction;
        document.getElementById("ent").textContent = entreprise;
        document.getElementById("stag_nom").textContent = nom;
        document.getElementById("stag_prenom").textContent = prenom;
        document.getElementById("form").textContent = formation;
        document.getElementById("dd").textContent = formatDate(date_debut);
        document.getElementById("df").textContent = formatDate(date_fin);
        document.getElementById("miss").textContent = mission;
        document.getElementById("vil").textContent = ville;
        document.getElementById("dat").textContent = formatDate(date_attestation);
        document.getElementById("code").textContent = code;

        // Afficher l'attestation (pour capture HTML2Canvas)
        document.getElementById("attestation").style.display = "block";

        // Générer le PDF
        const { jsPDF } = window.jspdf;
        html2canvas(document.getElementById("attestation")).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
            pdf.save("Attestation_Stage_" + nom + "_" + prenom + ".pdf");
            
            // Masquer à nouveau l'attestation
            document.getElementById("attestation").style.display = "none";
        });
    }
</script>
@endsection --}}

@extends('welcome')

@section('title')
    <title>Gestion DECOFI - Attestation</title>
@endsection

@section('scripts_up')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endsection

@section('content')

<div id="stagiaire-data" style="display: none;"
     data-responsable="{{ auth()->user()->fullname }}"
     data-fonction="Controleur Régional"
     data-entreprise="{{ $stagiaire->nom_cabinet }}"
     data-nom="{{ $stagiaire->name }}"
     data-prenom="{{ $stagiaire->firstname }}"
     data-birthday="{{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }}"
     data-nom1="{{ $stagiaire->name }}"
     data-prenom1="{{ $stagiaire->firstname }}"
     data-date-debut="{{ Carbon\Carbon::parse($stagiaire->stage_begin)->format('d/m/Y') }}"
     data-date-fin="{{ $stagiaire->date_fin ?? now()->format('Y-m-d') }}"
     data-ville="{{ $stagiaire->lieu_cabinet }}"
     data-date-attestation="{{ now()->format('Y-m-d') }}"
     data-mission="Participation aux activités du cabinet, réalisation des tâches confiées par le maître de stage, et application des connaissances acquises durant la formation.">
</div>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-file-certificate me-2"></i>Attestation de stage</h4>
        </div>
        
        <div class="card-body text-center">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Vous êtes sur le point de générer une attestation pour 
                <strong>{{ $stagiaire->firstname }} {{ $stagiaire->name }}</strong>
            </div>
            
            <div class="mb-4">
                <h5>Informations du stagiaire</h5>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-start">
                        <p><strong>Nom complet:</strong> {{ $stagiaire->firstname }} {{ $stagiaire->name }}</p>
                        <p><strong>Date de naissance:</strong>{{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }}</p>
                        <p><strong>Période de stage:</strong> Du {{ Carbon\Carbon::parse($stagiaire->stage_begin)->format('d/m/Y') }} au {{ $stagiaire->date_fin ? Carbon\Carbon::parse($stagiaire->date_fin)->format('d/m/Y') : now()->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6 text-start">
                        <p><strong>Entreprise:</strong> {{ $stagiaire->nom_cabinet }}</p>
                        <p><strong>Lieu:</strong> {{ $stagiaire->lieu_cabinet }}</p>
                        <p><strong>Responsable:</strong> {{ auth()->user()->fullname }}</p>
                    </div>
                </div>
            </div>
            
            <button type="button" class="btn btn-primary btn-lg" onclick="genererPDF()">
                <i class="fas fa-file-pdf me-2"></i>Générer l'attestation
            </button>
        </div>
    </div>
</div>

<!-- Template d'attestation -->
<div id="attestation" class="attestation" style="display: none;">
    <!-- Nouvel en-tête à gauche -->
    <div class="letterhead">
        <div class="cppc-header">
            <p class="cppc-title">Conseil Permanent de la <br>Profession Comptable (CPPC)</p>
                 
            <div class="separator"></div>
            <p class="controller-title">Le Contrôleur Régional des stages</p>
        </div>
    </div>
    <div class="header text-center">
        <h2>ATTESTATION DE VALIDATION DE STAGE</h2>
        <p class="document-number">N° 01-2024-CNS/OEC CI-CRS/DECOFI</p>
    </div>
    
    <div class="content">
        <p>
            Je soussigné, <strong><span id="res"></span></strong>, <strong><span id="fct"></span></strong> du stage
            atteste que :
        </p>
        
        <p>
            <strong><span id="stag_nom"></span> <span id="stag_prenom"></span></strong>, 
            né le <strong><span id="Birth"></span></strong> a été inscrit au registre des Experts Comptables et Financiers Stagiaires</strong> 
            et a effectué un stage professionnel <strong>conformément aux conditions définies par la charte 
            du stage professionnel du Diplôme d'Expertise Comptable et Financière (DECOFI) de l'UEMOA 
            du 19 mai 2022.</strong>
        </p>
        
        <p>
            Monsieur <strong><span id="stag_nom1"></span> <span id="stag_prenom1"></span></strong> est par conséquent 
            autorisé à se présenter à l'examen final du DECOFI.
        </p>
        
        <p>
            En foi de quoi, la présente attestation <strong>prévue par l'article ART 12 du règlement 
            03/2020/CM/UEMOA</strong> lui est délivrée pour servir et valoir ce que de droit.
        </p>
        
        <p>
            Cette attestation est valable pour une durée de six (6) ans à compter de la date de signature.
        </p>
        
        <div class="footer text-right mt-5">
            <p>Fait à <strong><span id="vil"></span></strong>, le <strong><span id="dat"></span></strong></p>
            <div class="signature">
                <p>Le Contrôleur Régional</p>
                <p class="signature-line">_________________________</p>
                <p><strong><span id="res"></span></strong></p>
            </div>
        </div>
    </div>
</div>

<style>
    .attestation {
        font-family: "Times New Roman", serif;
        line-height: 1.5;
        padding: 2.5cm;
        background: white;
        max-width: 21cm;
        margin: 0 auto;
        font-size: 12pt;
        text-align: left; /* Changé de justify à left */
    }
    
    .attestation .header {
        margin-bottom: 30px;
    }
    
    .attestation .header h2 {
        font-size: 14pt;
        text-transform: uppercase;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .document-number {
        font-size: 11pt;
        font-weight: bold;
        margin-bottom: 20px;
    }
    
    .content p {
        margin-bottom: 15px;
        text-indent: 0; /* Suppression de l'indentation */
        text-align: left; /* Alignement à gauche */
    }
    
    .footer {
        margin-top: 50px;
    }
    
    .signature {
        margin-top: 50px;
    }
    
    .signature-line {
        margin: 20px 0;
        width: 200px;
        border-top: 1px solid #000;
    }
     /* Styles pour le nouvel en-tête */
     .letterhead {
        margin-bottom: 1.5cm;
    }

    .cppc-header {
        text-align: left;
        margin-bottom: 1cm;
    }

    .cppc-title {
        font-weight: bold;
        margin-bottom: 0.2cm;
        font-size: 12pt;
    }

    .separator {
        border-top: 1px solid #000;
        width: 6cm;
        margin: 0.2cm 0;
    }

    .controller-title {
        font-style: italic;
        font-size: 11pt;
    }

    
</style>

<script>
    function genererPDF() {
        // Récupérer les données depuis l'élément caché
        const data = document.getElementById('stagiaire-data').dataset;
        
        // Formater la date en français
        const formatDate = (dateString) => {
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('fr-FR', options);
        };

        // Remplir l'attestation
        document.getElementById("res").textContent = data.responsable;
        document.getElementById("fct").textContent = data.fonction;
        document.getElementById("stag_nom").textContent = data.nom;
        document.getElementById("stag_nom1").textContent = data.nom1;
        document.getElementById("stag_prenom").textContent = data.prenom;
        document.getElementById("stag_prenom1").textContent = data.prenom1;
        document.getElementById("Birth").textContent = formatDate(data.birthday); ;
        document.getElementById("stag_nom").textContent = data.nom;
        document.getElementById("stag_prenom").textContent = data.prenom;
        document.getElementById("vil").textContent = data.ville;
        document.getElementById("dat").textContent = formatDate(data.dateAttestation);

        // Générer le PDF
        const { jsPDF } = window.jspdf;
        document.getElementById("attestation").style.display = "block";
        
        html2canvas(document.getElementById("attestation"), {
            scale: 2,
            logging: false,
            useCORS: true
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            pdf.addImage(imgData, 'PNG', 0, 0, 210, 0);
            pdf.save(`Attestation_DECOFI_${data.nom}_${data.prenom}.pdf`);
            
            document.getElementById("attestation").style.display = "none";
        });
    }
</script>
@endsection