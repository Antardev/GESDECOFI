<!DOCTYPE html>
<html>
<head>
    <title>Modification de date de stage</title>
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
        .date-change {
            color: #dc3545;
            font-weight: bold;
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
            <h1 class="h3 mb-0">Modification de votre date de stage</h1>
        </div>
        
        <div class="email-body">
            <p>Bonjour  {{ $name }} {{$firstname}},</p>
            <p>Nous vous informons que la date de début de votre stage a été modifiée :</p>
            
            <div class="info-card">
                <div class="info-item">
                    <span class="info-label">Nouvelle date de début :</span>
                    <span class="date-change">{{ \Carbon\Carbon::parse($new_date)->format('d/m/Y') }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Stagiaire :</span>
                    <span>{{ $name }}</span>
                </div>
                
                @if(isset($matricule))
                <div class="info-item">
                    <span class="info-label">Matricule :</span>
                    <span>{{ $matricule }}</span>
                </div>
                @endif
                
                <div class="info-item">
                    <span class="info-label">Date de modification :</span>
                    <span>{{ now()->format('d/m/Y à H:i') }}</span>
                </div>
            </div>
            
            <p>Cette modification a été enregistrée dans votre dossier. Veuillez noter cette nouvelle date et vous y conformer.</p>
            
            <p>Si vous pensez qu'il s'agit d'une erreur ou si vous avez des questions, veuillez contacter votre responsable de stage.</p>
            
            <p class="mt-4">Cordialement,<br>L'équipe des stages DECOFI</p>
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