<!DOCTYPE html>
<html>
<head>
    <title>Rappel - Informations Cabinet 2ème Année</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #0d6efd;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-body {
            padding: 30px;
        }
        .info-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        .action-btn {
            background-color: #0d6efd;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s;
            text-decoration: none;
            color: white !important;
            border-radius: 50px;
            display: inline-block;
        }
        .action-btn:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            color: white;
        }
        .email-footer {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 14px;
        }
        .logo {
            max-height: 50px;
            margin-bottom: 15px;
        }
        .urgent-badge {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .document-list {
            list-style-type: none;
            padding: 0;
        }
        .document-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .document-list li:last-child {
            border-bottom: none;
        }
        .document-list li::before {
            content: "•";
            color: #0d6efd;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="Logo" class="logo">
            <h1 class="h3 mb-2">Rappel - Informations Cabinet 2ème Année</h1>
            <span class="urgent-badge">Action Requise</span>
        </div>
        
        <div class="email-body">
            <p>Cher(e) <strong>{{ $stagiaire->firstname }} {{ $stagiaire->name }}</strong>,</p>
            
            <p>Nous vous contactons concernant votre stage en entreprise qui arrive à la fin de sa première année.</p>
            
            <div class="info-card">
                <div class="info-item">
                    <span class="info-label">Type de structure :</span>
                    <span>Entreprise</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Début 2ème semestre :</span>
                    <span>{{ $semesterStartDate->format('d/m/Y') }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Échéance :</span>
                    <span>Dans 1 mois</span>
                </div>
            </div>
            
            <p>Comme convenu, votre deuxième année de stage devra se dérouler dans un cabinet agréé.</p>
            
            <p><strong>Documents requis pour la 2ème année :</strong></p>
            
            <ul class="document-list">
                <li>Nom et coordonnées du cabinet d'accueil</li>
                <li>Nom du maître de stage agréé</li>
                <li>Contrat de stage signé pour la 2ème année</li>
                <li>Attestation d'acceptation du maître de stage</li>
                <li>Ordre d'affiliation du cabinet</li>
                <li>Numéro d'inscription du cabinet à l'ordre</li>
            </ul>
            
            <p>Veuillez vous connecter à votre espace stagiaire pour compléter ces informations au plus tard <strong>15 jours avant le début du 2ème semestre</strong>.</p>
            
            <div class="text-center">
                <a href="{{ route('stagiaire.profile') }}" class="action-btn">
                    Compléter mes informations
                </a>
            </div>
            
            <div class="alert alert-warning mt-4" role="alert">
                <strong>Important :</strong> Le non-respect de cette échéance pourrait entraîner un retard dans le traitement de votre dossier et impacter le bon déroulement de votre stage.
            </div>
            
            <p class="mt-3">Pour toute assistance, veuillez contacter le service des stages.</p>
            
            <p>Cordialement,<br>Le service des stages<br>Ordre des Experts-Comptables</p>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} Ordre des Experts-Comptables et Comptables Agréés. Tous droits réservés.</p>
            <p class="mb-0">
                <a href="{{ route('accueil') }}" style="color: #6c757d; text-decoration: none;">Accéder à la plateforme</a> | 
                <a href="mailto:stages@ordre-expertcomptable.com" style="color: #6c757d; text-decoration: none;">Contact</a>
            </p>
            <p class="mt-2 small">Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>