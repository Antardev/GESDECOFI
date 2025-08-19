{{-- @extends('welcome')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Mot du Secrétaire Général</h2>
                </div>
                <div class="card-body">
                    <p>
                        Bienvenue sur la plateforme de gestion DECOFI. En tant que Secrétaire Général, je suis ravi de vous présenter cette initiative qui vise à faciliter la gestion des stages et des examens pour les étudiants du Diplôme d'Expertise Comptable et Financière (DECOFI).
                    </p>
                    <p>
                        Notre objectif est de fournir un environnement numérique efficace et convivial pour les étudiants, les enseignants et les administrateurs. Grâce à cette plateforme, nous espérons améliorer la communication, la transparence et l'efficacité dans la gestion des processus académiques.
                    </p>
                    <p>
                        Nous sommes convaincus que cette plateforme contribuera à renforcer la qualité de l'enseignement et à soutenir nos étudiants dans leur parcours académique.
                    </p>
                    <p>
                        Merci de votre engagement envers l'excellence académique et professionnelle.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@extends('welcome')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-secondary text-white">
                    <h2 class="mb-0">Mot du Secrétaire Permanent</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{ asset('assets/img/Bachir.jpeg') }}" 
                                     alt="Photo du Secrétaire Général" 
                                     class="img-fluid rounded-circle mb-3" 
                                     style="width: 200px; height: 200px; object-fit: cover;">
                                <h4 class="font-weight-bold">Bachir WADE</h4>
                                <p class="text-muted">Secrétaire Permanent du DECOFI ( Diplôme d'Expertise Comptable et Financière)</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="message-content">
                                <p class="lead">
                                    Chers stagiaires, contrôleurs et collaborateurs,
                                </p>
                                <p>
                                    Je suis honoré de vous accueillir sur la plateforme de gestion DECOFI. Cette initiative innovante représente une étape importante dans notre engagement commun pour l'excellence académique et professionnelle.
                                </p>
                                <p>
                                    En tant que Secrétaire Général, j'ai à cœur de faciliter votre parcours au sein du Diplôme d'Expertise Comptable et Financière. Cette plateforme a été conçue pour vous offrir un environnement numérique performant, simplifiant la gestion des stages et des examens.
                                </p>
                                <p>
                                    Notre ambition est triple :
                                </p>
                                <ul>
                                    <li>Améliorer la communication entre tous les acteurs de DECOFI</li>
                                    <li>Garantir une transparence totale dans les processus académiques</li>
                                    <li>Optimiser l'efficacité administrative pour vous permettre de vous concentrer sur l'essentiel</li>
                                </ul>
                                <p>
                                    Je mesure pleinement la confiance que vous placez en notre institution et m'engage personnellement à ce que cet outil réponde au mieux à vos attentes.
                                </p>
                                <p class="font-italic">
                                    Ensemble, construisons l'expertise comptable et financière de demain.
                                </p>
                                <p class="text-right font-weight-bold">
                                    <strong>Bachir WADE</strong>
                                    <br>
                                     Le Secrétaire Permanent de la CREFECF
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="py-4 bg-dark text-white">
        <div class="container text-center">
            <p class="mb-0">© {{ date('Y') }} Plateforme GestionDECOFI - Tous droits réservés</p>
        </div>
    </footer>
    <style>
        .message-content {
            line-height: 1.8;
            text-align: justify;
        }
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .card-header {
            padding: 1.5rem;
            font-size: 1.5rem;
        }
    </style>
@endsection