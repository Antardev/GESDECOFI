<!DOCTYPE html>
<html>
<head>
    <title>Notification d'inscription</title>
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
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="Logo" class="logo">
            <h1 class="h3 mb-0">Nouvelle inscription de stagiaire</h1>
        </div>
        
        <div class="email-body">
            <p>Bonjour,</p>
            <p>Un nouveau stagiaire vient de s'inscrire sur la plateforme :</p>
            
            <div class="info-card">
                <div class="info-item">
                    <span class="info-label">Nom complet :</span>
                    <span>{{ $name }} {{ $firstname }}</span>
                </div>
                
                @if(isset($email))
                <div class="info-item">
                    <span class="info-label">Email :</span>
                    <span>{{ $email }}</span>
                </div>
                @endif
                
                @if(isset($matricule))
                <div class="info-item">
                    <span class="info-label">Matricule :</span>
                    <span>{{ $matricule }}</span>
                </div>
                @endif
                
                @if(isset($phone))
                <div class="info-item">
                    <span class="info-label">Téléphone :</span>
                    <span>{{ $phone }}</span>
                </div>
                @endif
                
                <div class="info-item">
                    <span class="info-label">Date d'inscription :</span>
                    <span>{{ now()->format('d/m/Y à H:i') }}</span>
                </div>
            </div>
            
            <p>Veuillez traiter cette demande dans les plus brefs délais.</p>
            
            <div class="text-center">
                <a href="{{ route('CN.diligences_table') }}?a=sav" class="action-btn">
                    Voir la demande
                </a>
            </div>
            
            <p class="mt-4">Cordialement,<br>L'équipe DECOFI</p>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} DECOFI. Tous droits réservés.</p>
            <p class="mb-0">
                <a href="{{ route('accueil') }}" style="color: #6c757d; text-decoration: none;">Accéder à la plateforme</a>
            </p>
        </div>
    </div>
</body>
</html>