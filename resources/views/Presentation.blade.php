@extends('welcome')

@section('styles_up')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --accent-color: #e74c3c;
    }
    
    .hero-section {
        position: relative;
        color: white;
        padding: 8rem 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        overflow: hidden; /* Empêche le débordement */
    }

    .hero-bg-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .hero-bg-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        
    }

    .hero-overlay {
        position: absolute;
        top: 60px; /* Commence après la navbar */
        left: 0;
        width: 100%;
        height: calc(100% - 60px);
        background: linear-gradient(135deg, rgba(44, 62, 80, 0.85), rgba(52, 152, 219, 0.85));
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        margin-top: 60px; /* Compense la navbar */
    }

    /* Animation */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-section .container {
        animation: fadeInUp 1s ease forwards;
    }
    
    .feature-icon {
        font-size: 2.5rem;
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }
    
    .role-card {
        border-top: 4px solid var(--secondary-color);
        transition: transform 0.3s;
        height: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .role-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    .btn-decofi {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    
    .btn-decofi:hover {
        background-color: #c0392b;
        color: white;
    }
    
    .timeline {
        position: relative;
        padding-left: 50px;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--secondary-color);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding: 15px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -40px;
        top: 20px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--accent-color);
        border: 3px solid white;
    }
    
    .section-spacing {
        padding: 3rem 0;
    }
    
    .bg-decofi-primary {
        background-color: rgb(52 152 219);
    }
    
    .text-decofi-primary {
        color: var(--primary-color) !important;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="hero-bg-container">
        <img src="{{ asset('assets/img/1.png') }}" alt="Background" class="hero-bg-image">
    </div>
    
    <!-- Overlay coloré -->
   
    <div class="container">
        <h1 class="display-4 fw-bold mb-3" style="color: black; 
        text-shadow: 0 0 2px white, 
                     0 0 2px white, 
                     0 0 2px white, 
                     0 0 2px white;
        position: relative;
        display: inline-block;">
<i class="fas fa-user-graduate me-2"></i>Plateforme GestionDECOFI
</h1>
        <p class="lead mb-4">Gestion optimisée des stagiaires et suivi par les contrôleurs</p>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="card role-card">
                    <div class="card-body">
                        <i class="fas fa-user-graduate feature-icon"></i>
                        <h4>Stagiaires</h4>
                        <p>Gérez votre parcours et vos documents</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Espace étudiant</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card role-card">
                    <div class="card-body">
                        <i class="fas fa-user-tie feature-icon"></i>
                        <h4>Contrôleurs</h4>
                        <p>Suivez vos stagiaires efficacement</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Espace contrôleur</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card role-card">
                    <div class="card-body">
                        <i class="fas fa-university feature-icon"></i>
                        <h4>Administration</h4>
                        <p>Supervisez l'ensemble du processus</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Espace admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fonctionnalités -->
<section id="fonctionnalites" class="section-spacing bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Fonctionnalités clés</h2>
            <p class="lead">Une plateforme complète pour le suivi des stagiaires voulant obtenir le DECOFI</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-tasks text-primary"></i>
                            </div>
                            <h4 class="mb-0">Gestion des stages</h4>
                        </div>
                        <p>Suivi complet des stages avec calendrier, objectifs et évaluations</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-file-upload text-primary"></i>
                            </div>
                            <h4 class="mb-0">Dépôt des documents</h4>
                        </div>
                        <p>Plateforme sécurisée pour le dépôt des rapports et documents requis</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-comments text-primary"></i>
                            </div>
                            <h4 class="mb-0">Communication</h4>
                        </div>
                        <p>Messagerie intégrée entre stagiares et contrôleurs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-chart-line text-primary"></i>
                            </div>
                            <h4 class="mb-0">Suivi en temps réel</h4>
                        </div>
                        <p>Tableaux de bord pour le suivi de la progression</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-bell text-primary"></i>
                            </div>
                            <h4 class="mb-0">Notifications</h4>
                        </div>
                        <p>Alertes pour les échéances et les retours des contrôleurs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-certificate text-primary"></i>
                            </div>
                            <h4 class="mb-0">Validation DECOFI</h4>
                        </div>
                        <p>Processus digitalisé pour l'obtention de l'Attestation de Stage</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Processus -->
<section id="processus" class="section-spacing">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Comment ça marche ?</h2>
            <p class="lead">Le processus DECOFI pour les étudiants DESCOGEF</p>
        </div>
        <div class="timeline">
            <div class="timeline-item">
                <h4>1. Inscription</h4>
                <p>L'étudiant crée son compte et complète son profil</p>
            </div>
            <div class="timeline-item">
                <h4>2. Attribution</h4>
                <p>Un contrôleur est assigné à l'étudiant en fonction de son pays d'inscription</p>
            </div>
            <div class="timeline-item">
                <h4>3. Planification</h4>
                <p>L'étudiant et le contrôleur définissent le plan de stage</p>
            </div>
            <div class="timeline-item">
                <h4>4. Suivi</h4>
                <p>Le contrôleur suit les progrès via la plateforme</p>
            </div>
            <div class="timeline-item">
                <h4>5. Évaluation</h4>
                <p>Dépôt des rapports et évaluation finale</p>
            </div>
            <div class="timeline-item">
                <h4>6. Attestation</h4>
                <p>Obtention de l'attestation pour l'examen</p>
            </div>
        </div>
    </div>
</section>

<!-- Avantages -->
<section class="section-spacing bg-decofi-primary text-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Avantages de la plateforme</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="me-4">
                        <i class="fas fa-check-circle fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4>Pour les étudiants</h4>
                        <ul class="fa-ul">
                            <li><span class="fa-li"><i class="fas fa-check text-white"></i></span>Accès centralisé à toutes les ressources</li>
                            <li><span class="fa-li"><i class="fas fa-check text-white"></i></span>Suivi clair des exigences et échéances</li>
                            <li><span class="fa-li"><i class="fas fa-check text-white"></i></span>Communication directe avec les contrôleurs</li>
                            <li><span class="fa-li"><i class="fas fa-check text-white"></i></span>Transparence sur l'avancement du dossier</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <div class="me-4">
                        <i class="fas fa-check-circle fa-2x text-white"></i>
                    </div>
                    <div>
                        <h4>Pour les contrôleurs</h4>
                        <ul class="fa-ul">
                            <li><span class="fa-li"><i class="fas fa-check text-white"></i></span>Visualisation centralisée des stagiaires</li>
                            <li><span class="fa-li"><i class="fas fa-check text-white"></i></span>Outils de suivi et d'évaluation intégrés</li>
                            <li><span class="fa-li"><i class="fas fa-check text-white"></i></span>Alertes pour les documents à valider</li>
                            <li><span class="fa-li"><i class="fas fa-check text-white"></i></span>Historique complet des interactions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact -->


<!-- Footer -->
<footer class="py-4 bg-dark text-white">
    <div class="container text-center">
        <p class="mb-0">© {{ date('Y') }} Plateforme GestionDECOFI - Tous droits réservés</p>
    </div>
</footer>
@endsection

@push('scripts_down')
<script>
    // Scripts spécifiques à la page de présentation
    document.addEventListener('DOMContentLoaded', function() {
        // Animation pour les éléments de la timeline
        const timelineItems = document.querySelectorAll('.timeline-item');
        timelineItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            item.style.transition = `all 0.5s ease ${index * 0.2}s`;
            
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 100);
        });
        
        // Smooth scroll pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endpush