    {{-- @extends('welcome')
@section('title')
    <title>Gestion DECOFI - Attestation</title>
@endsection
@section('scripts_up')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endsection
@section('content')

<div class="info-container">
    <div class="info-group">
        <label>Nom du responsable :</label>
        <div class="info-value">Jean Dupont</div>
    </div>
    <div class="info-group">
        <label>Fonction :</label>
        <div class="info-value">Directeur des Ressources Humaines</div>
    </div>
    <div class="info-group">
        <label>Nom de l'entreprise :</label>
        <div class="info-value">DECOFI Technologies</div>
    </div>
    <div class="info-group">
        <label>Nom du stagiaire :</label>
        <div class="info-value">Martin</div>
    </div>
    <div class="info-group">
        <label>Prénom du stagiaire :</label>
        <div class="info-value">Sophie</div>
    </div>
    <div class="info-group">
        <label>Formation suivie :</label>
        <div class="info-value">Développement Web Full Stack</div>
    </div>
    <div class="info-group">
        <label>Date de début :</label>
        <div class="info-value">2024-01-15</div>
    </div>
    <div class="info-group">
        <label>Date de fin :</label>
        <div class="info-value">2024-06-15</div>
    </div>
    <div class="info-group">
        <label>Mission principale :</label>
        <div class="info-value">Développement d'une application web de gestion des stocks avec Laravel et Vue.js, participation aux réunions d'équipe et rédaction de la documentation technique.</div>
    </div>
    <div class="info-group">
        <label>Ville :</label>
        <div class="info-value">Paris</div>
    </div>
    <div class="info-group">
        <label>Date de l'attestation :</label>
        <div class="info-value">2024-06-20</div>
    </div>
</div>

<button onclick="genererPDF()">Télécharger l'Attestation (PDF)</button>

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
    .info-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
    }
    
    .info-group {
        margin-bottom: 15px;
        padding: 10px;
        background: white;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .info-group label {
        font-weight: bold;
        color: #555;
        margin-bottom: 5px;
        display: block;
    }
    
    .info-value {
        padding: 8px;
        background: #f0f0f0;
        border-radius: 4px;
    }
    
    button {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    
    button:hover {
        background: #45a049;
    }
    
    .attestation {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        padding: 2cm;
        background: white;
        border: 1px solid #ddd;
        max-width: 800px;
        margin: 20px auto;
    }
    
    .attestation .header {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .attestation .footer {
        margin-top: 50px;
        text-align: right;
    }
</style>

<script>
    function genererPDF() {
        // Récupérer les valeurs des div au lieu des inputs
        const responsable = document.querySelector(".info-group:nth-child(1) .info-value").textContent;
        const fonction = document.querySelector(".info-group:nth-child(2) .info-value").textContent;
        const entreprise = document.querySelector(".info-group:nth-child(3) .info-value").textContent;
        const nom = document.querySelector(".info-group:nth-child(4) .info-value").textContent;
        const prenom = document.querySelector(".info-group:nth-child(5) .info-value").textContent;
        const formation = document.querySelector(".info-group:nth-child(6) .info-value").textContent;
        const date_debut = document.querySelector(".info-group:nth-child(7) .info-value").textContent;
        const date_fin = document.querySelector(".info-group:nth-child(8) .info-value").textContent;
        const mission = document.querySelector(".info-group:nth-child(9) .info-value").textContent;
        const ville = document.querySelector(".info-group:nth-child(10) .info-value").textContent;
        const date_attestation = document.querySelector(".info-group:nth-child(11) .info-value").textContent;

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
        document.getElementById("dd").textContent = date_debut;
        document.getElementById("df").textContent = date_fin;
        document.getElementById("miss").textContent = mission;
        document.getElementById("vil").textContent = ville;
        document.getElementById("dat").textContent = date_attestation;
        document.getElementById("code").textContent = code;

        // Afficher l'attestation pour la capture
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
@endsection