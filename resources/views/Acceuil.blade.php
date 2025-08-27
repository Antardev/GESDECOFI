@extends('welcome')

@section('content')
    @if (auth()->check())
        <div id="chat-button" style="position: fixed; bottom: 30px; right: 30px; z-index: 1000;">
            <button class="btn btn-primary rounded-circle p-3" style="box-shadow: 0 4px 8px rgba(0,0,0,0.2);"
                onclick="openChat()">
                <i class="align-middle" data-feather="message-circle" style="font-size: 2rem;"></i>
            </button>
            @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
            @if ($unreadCount > 0)
                <span id="unread-count" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                    style="display: block;">{{ $unreadCount }}</span>
            @else
                <span id="unread-count" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                    style="display: none;"></span>
            @endif
            {{-- <span id="unread-count"
                class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">0</span> --}}
        </div>

        <!-- Fenêtre de chat -->
        <div id="chat-window"
            style="display: none; position: fixed; bottom: 100px; right: 30px; width: 350px; height: 450px; 
                                    background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 1000;">
            <div class="chat-header bg-primary text-white p-3 rounded-top"
                style="display: flex; justify-content: space-between; align-items: center;">
                <h6 class="mb-0">Chat en direct</h6>
                <button class="btn btn-sm btn-light" onclick="closeChat()">
                    <i class="align-middle" data-feather="x"></i>
                </button>
            </div>
            <div class="chat-body p-3" style="height: 300px; overflow-y: auto; background: #f8f9fa;">
                <button id="load-more" class="btn btn-link" onclick="loadMoreMessages()" style="display: none;">Voir messages
                    précédents</button>
                <div id="chat-messages" class="chat-messages"></div>
                <button id="load-previous" class="btn btn-link" onclick="loadPreviousMessages()" style="display: none;">Charger
                    plus de messages</button>
            </div>
            <div class="chat-footer p-3" style="border-top: 1px solid #eee;">
                <form id="chat-form" onsubmit="sendMessage(event)">
                    <div class="input-group">
                        <input type="text" id="message-input" class="form-control" placeholder="Tapez votre message..."
                            required>
                        <input type="text" id="receiver" class="form-control" value="1" hidden required>
                        <button class="btn btn-primary" type="submit">
                            <i class="align-middle" data-feather="send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

   <div class="hero-section" style="position: relative; text-align: center; height: calc(100vh - 60px); overflow: hidden;">
   
    <div id="heroCarousel" class="carousel slide h-100" data-bs-ride="carousel">
        <div class="carousel-inner h-100">
            <div class="carousel-item active h-100">
                <img src="{{ asset('assets/img/fd2.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Image 1">
            </div>
            <div class="carousel-item h-100">
                <img src="{{ asset('assets/img/fd3.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Image 2">
            </div>
            <div class="carousel-item h-100">
                <img src="{{ asset('assets/img/fd4.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Image 3">
            </div>
        </div>
    </div>
    {{-- <div class="hero-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: 1;"></div> --}}

    
    <!-- Image de fond -->
    {{-- <img src="{{ asset('assets/img/fd2.jpg') }}" alt="Bienvenue" 
         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"
         class="hero-image"> --}}
    
    <!-- Contenu du hero -->
    <div class="hero-content" 

         style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                color: white; padding: 2rem; max-width: 1200px; width: 98%; text-align: center;
                opacity: 0; transform: translate(-50%, -40%); transition: all 0.8s ease;">
        <h1 style="font-size: 2.5rem; margin-bottom: 1.5rem; font-weight: 700; color: white; text-shadow: 0 2px 4px black+; ">
            {{__('message.welcome_to_platform')}}
        </h1>
        <p style="font-size: 20px; margin-bottom: 2rem; color: white; text-shadow: 0 1px 3px black;">
            {{__('message.discover_services')}} <br> {{__('message.discover_diplom')}}
        </p>
        {{-- <p style="font-size: 20px;color: white; text-shadow: 0 1px 3px black;">{{__('message.discover_diplom')}} </p> --}}
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            @if (!auth()->user())
            <a href="#" 
               class="btn btn-primary btn-hero"
               style="padding: 0.8rem 2rem; font-size: 1.1rem; border-radius: 50px; 
                      background-color: primary; border: none; transition: all 0.3s ease;" onclick="showDecofiSection(event)">
                {{__('message.discover')}} 
            </a>
            @endif
            
            <a href="{{route('Liste_stagiaire_acceuil')}}" 
               class="btn btn-primary btn-hero"
               style="padding: 0.8rem 2rem; font-size: 1.1rem; border-radius: 50px; 
                      background-color: primary; border: none; transition: all 0.3s ease;">
                Liste des stagiaires
            </a>
        </div>
    </div>

    

    <!-- Indicateur de défilement -->
    {{-- <div class="scroll-indicator" 
         style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); 
                color: white; font-size: 1.5rem; animation: bounce 2s infinite;">
        <i class="fas fa-chevron-down"></i>
    </div> --}}

    <style>
        /* Animation de l'image au hover */
        .hero-section:hover .hero-image {
            transform: scale(1.05);
        }
        
        /* Animation du contenu */
        .hero-section .hero-content {
            animation: fadeInUp 1s ease forwards 0.3s;
        }
        
        /* Animation de bounce pour l'indicateur */
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0) translateX(-50%);}
            40% {transform: translateY(-20px) translateX(-50%);}
            60% {transform: translateY(-10px) translateX(-50%);}
        }
        
        /* Animation d'apparition */
        @keyframes fadeInUp {
            from {opacity: 0; transform: translate(-50%, -40%);}
            to {opacity: 1; transform: translate(-50%, -50%);}
        }
        
        /* Effet hover sur les boutons */
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .btn-outline-light.btn-hero:hover {
            background-color: rgba(255,255,255,0.1) !important;
        }


        /* Ajoutez ceci dans votre balise <style> */
        #decofi-section {
            transition: all 0.5s ease;
        }

        .decofi-content {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease 0.2s;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }


        /* Nouveaux styles pour la section DECOFI */
        .diploma-card {
            transition: all 0.3s;
            height: 100%;
        }
        .diploma-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .border-primary { border-left: 4px solid #3498db !important; }
        .border-success { border-left: 4px solid #2ecc71 !important; }
        .border-info { border-left: 4px solid #17a2b8 !important; }
        .details-section {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</div>

<!-- Ajoutez cette section après votre hero-section -->
<div id="decofi-section" style="display: none; padding: 80px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                {{-- <h2 class="mb-4" style="font-weight: 700; color: #2c3e50;">Découvrez DECOFI</h2> --}}
                <div class="decofi-content" style="transition: all 0.5s ease;">
                    <!-- Le contenu sera chargé dynamiquement ici -->
                </div>
            </div>
        </div>
    </div>
</div>

<div id="partners-section" style="padding: 80px 0; background-color: rgb(241, 233, 233)33)33)33)09);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5">
                <h2 style="font-weight: 700; color: #2c3e50;">Les écoles Agrées</h2>
                <p class="lead">Nous collaborons avec les meilleures institutions pour votre formation</p>
            </div>
        </div>
        
        <div class="row justify-content-center align-items-center">
            <!-- Partenaire 1 -->
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="https://www.univ-lome.tg/" target="_blank" class="d-block text-center">
                    <img src="{{ asset('assets/img/CCI.webp') }}" alt="CCI Côte d'Ivoire" 
                         class="img-fluid partner-logo" 
                         style="max-height: 80px; filter: grayscale(100%); transition: all 0.3s;">
                    <p class="mt-2 mb-0 small">CCI Côte d'Ivoire</p>
                </a>
            </div>
            
            <!-- Partenaire 2 -->
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="https://www.uvt.tn/" target="_blank" class="d-block text-center">
                    <img src="{{ asset('assets/img/CGECI.webp') }}" alt="CGECI" 
                         class="img-fluid partner-logo" 
                         style="max-height: 80px; filter: grayscale(100%); transition: all 0.3s;">
                    <p class="mt-2 mb-0 small">CGECI</p>
                </a>
            </div>
            
            <!-- Partenaire 3 -->
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="https://www.cesag.sn/" target="_blank" class="d-block text-center">
                    <img src="{{ asset('assets/img/CEPICI.webp') }}" alt="CEPICI" 
                         class="img-fluid partner-logo" 
                         style="max-height: 80px; filter: grayscale(100%); transition: all 0.3s;">
                    <p class="mt-2 mb-0 small">CEPICI</p>
                </a>
            </div>
            
            <!-- Partenaire 4 -->
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="" target="_blank" class="d-block text-center">
                    <img src="{{ asset('assets/img/BCEAO.webp') }}" alt="BCEAO" 
                         class="img-fluid partner-logo" 
                         style="max-height: 80px; filter: grayscale(100%); transition: all 0.3s;">
                    <p class="mt-2 mb-0 small">BCEAO</p>
                </a>
            </div>
            
            <!-- Partenaire 5 -->
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="https://www.esc-togo.com/" target="_blank" class="d-block text-center">
                    <img src="{{ asset('assets/img/partners/esct.png') }}" alt="IPME" 
                         class="img-fluid partner-logo" 
                         style="max-height: 80px; filter: grayscale(100%); transition: all 0.3s;">
                    <p class="mt-2 mb-0 small">IPME</p>
                </a>
            </div>
            
            <!-- Partenaire 6 -->
            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <a href="https://www.ifage.ch/" target="_blank" class="d-block text-center">
                    <img src="{{ asset('assets/img/BVRM.png')}}" alt="BRVM" 
                         class="img-fluid partner-logo" 
                         style="max-height: 80px; filter: grayscale(100%); transition: all 0.3s;">
                    <p class="mt-2 mb-0 small">BRVM</p>
                </a>
            </div>
        </div>
    </div>
</div>

   

<script>
    // Animation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        const heroSection = document.querySelector('.hero-section');
        const scrollIndicator = document.querySelector('.scroll-indicator');
        
        // Faire défiler vers la section suivante au clic
        scrollIndicator.addEventListener('click', function() {
            window.scrollBy({
                top: window.innerHeight - 60,
                behavior: 'smooth'
            });
        });
        
        // Effet parallax au scroll
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            heroSection.style.backgroundPositionY = scrollPosition * 0.5 + 'px';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
            const heroSection = document.querySelector('.hero-section');
            heroSection.style.backgroundPositionY = window.pageYOffset * 0.5 + 'px';
        });

        // Affichage de la section DECOFI
        function showDecofiSection(event) {
            event.preventDefault();
            
            const section = document.getElementById('decofi-section');
            const content = section.querySelector('.decofi-content');
            
            const decofiContent = `
                <h2 class="text-center mb-5" style="color: #2c3e50;">Les trois étapes du cursus</h2>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card diploma-card border-primary">
                            <div class="card-body">
                                <h4 class="card-title"> <strong>DECOGEF  </strong></h4>
                                <p class="card-text">Premier diplôme du cursus, accessible après le Baccalauréat.</p>
                                <button class="btn btn-sm btn-outline-primary" onclick="toggleDetails('decogef')">Voir détails</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card diploma-card border-success">
                            <div class="card-body">
                                <h4 class="card-title"> <strong>DESCOGEF </strong></h4>
                                <p class="card-text">Deuxième diplôme, formation de haut niveau en comptabilité.</p>
                                <button class="btn btn-sm btn-outline-success" onclick="toggleDetails('descogef')">Voir détails</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card diploma-card border-info">
                            <div class="card-body">
                                <h4 class="card-title"> <strong>DECOFI </strong></h4>
                                <p class="card-text">Diplôme final du cycle avec stage professionnel de 3 ans.</p>
                                <button class="btn btn-sm btn-outline-info" onclick="toggleDetails('decofi')">Voir détails</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Détails DECOGEF -->
                <div id="decogef-details" class="details-section">
                    <h3>DECOGEF</h3>
                    <p style="text-align: justify"> Nouvellement institué par le règlement N°03/2020/CM/UEMOA du 26 juin 2020, le DECOGEF est le premier diplôme du cursus de l’Expertise Comptable de l’UEMOA. Il est accessible après le Baccalauréat ou un diplôme équivalent et est organisé en Unités d’Enseignement sur une durée de six (06) semestres.
Les unités d’enseignement, définies et approuvées par la CREFECF, sont validées par une session d’examen organisée par le jury.
Les attestations d’obtention du diplôme du DECOGEF sont délivrées par le Président du jury.
Le diplôme délivré est revêtu de la signature du Président du Jury et du Président de la CREFECF.
</p>

                    
                     <h4 class="mt-4"> Le programme est organisé de la façon suivante : </h4>
                     <p style="text-align: justify">o	<strong>Formation théorique et Technique </strong>: La formation se déroule sur une durée de six (6) semestres et est organisée en unités d’enseignement (UE) qui se présentent comme suit : </p
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Unité d'Enseignement</th>
                                        <th>Crédits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>UE 1 : Droit des entreprises</td><td>28</td></tr>
                                    <tr><td>UE 2 : Droit fiscal</td><td>12</td></tr>
                                    <tr><td>UE 3 : Comptabilité et Audit</td><td>18</td></tr>
                                    <tr><td>UE 4 : Comptabilité approfondie </td> <td>22</td></tr>
                                    <tr><td>UE 5 : Finance </td><td>14</td></tr>
                                    <tr><td>UE 6 : Contrôle de gestion</td><td>15</td></tr>
                                    <tr><td>UE 7 : Pratiques professionnelles</td><td>9</td></tr>
                                    <tr><td>UE 8 : Outils mathématiques de gestion</td><td>12</td></tr>
                                    <tr><td>UE 9 : Management </td><td>7</td></tr>
                                    <tr><td>UE 10: Pratiques de recherche </td><td>3</td></tr>
                                    <tr><td>UE 11: Expression et langues vivantes </td><td>10</td></tr>
                                    <tr><td>UE 12: Système d’information </td><td>14</td></tr>
                                    <tr><td>UE 13: Economie </td><td>10</td></tr>
                                    <tr><td>UE 14:Synthèse </td><td>6</td></tr>
                                    
                                    <tr class="table-info"><td><strong>Total</strong></td><td><strong>180</strong></td></tr>
                                </tbody>
                            </table>

                            <h4 class="mt-4"></h4>
                            <p style="text-align: justify">o  <strong>Stage DECOGEF </strong>: Durée de 06 à 08 semaines minimum, accompli auprès d'un expert-comptable ou dans les services comptables d'une entreprise.</p>
                             <p style="text-align: justify"> A l’issue de la formation, l’apprenant est présenté à l’examen régional du DECOGEF organisé par la CREFECF dans les Etats membres de l’UEMOA. Le diplôme délivré est revêtu de la signature du Président du Jury et du Président de la CREFECF.</p>

                               
                        <h4 class="mt-4">Tarifs</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th></th>
                                        <th>DECOGEF 1</th>
                                        <th>DECOGEF 2</th>
                                        <th>DECOGEF 3</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Frais de Scolarité</td><td>1.000.000 FCFA</td><td>1.000.000 FCFA</td><td>1.000.000 FCFA</td></tr>
                                    <tr><td>Frais connexes</td><td>145.000 FCFA</td><td>145.000 FCFA</td><td>145.000 FCFA</td></tr>
                                    <tr><td>Droit d'examen regional</td><td>-</td><td>-</td><td>260 000 FCFA</td></tr>
                                    <tr><td>Frait de soutenace</td><td>-</td><td>-</td><td>90 000 FCFA</td></tr>
                                    <tr><td>Droit d'examen</td><td>-</td><td>-</td><td>260 000 FCFA</td></tr>

                                </tbody>
                            </table>
                        </div>
                        </div>

                        
                    </div>
                    </div>
        </div>

                </div>
                
                <!-- Détails DESCOGEF -->
                <div id="descogef-details" class="details-section">
                    <h3>DESCOGEF</h3>
                    <p style="text-align: justify">Le Diplôme d’Etudes Supérieures de Comptabilité et Gestion Financière (DESCOGEF) est le deuxième (2e) diplôme du cursus de l’Expertise Comptable de l’Union Economique et Monétaire Ouest-Africaine (UEMOA), obtenu à l’issue d’une formation de haut niveau en comptabilité et gestion financière de l’UEMOA. Ce programme de formation est conçu par les professeurs de rang magistral et les Experts-Comptables de l’UEMOA en collaboration avec des cabinets d’Expertise Comptable. Il était régi par le règlement N°03/2020/CM/UEMOA du 26 juin 2020.</p>
                    <p style="text-align: justify>Le programme du DESCOGEF est organisé en unités d’enseignement réparties sur quatre semestres. Les unités d’enseignement, définies et approuvées par la CREFECF, sont validées par une session d’examen organisée par le jury.</br> Les attestations d’obtention du diplôme du DESCOGEF sont délivrées par le Président du jury.
                        Le diplôme délivré est revêtu de la signature du Président du Jury et du Président de la CREFECF.
                    </p>
                        <h4 class="mt-4"> Le programme est organisé de la façon suivante : </h4>
                         <p style="text-align: justify>o	<strong>Formation théorique et Technique </strong>: les auditeurs suivent une formation de haut niveau en Comptabilité, Gestion Financière, Audit, Fiscalité, Droit, Informatique, Anglais, Communication et Leadership en quatre (04) semestres organisés en Unités d’Enseignement (UE) ainsi qu’il suit: </p
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Unité d'Enseignement</th>
                                        <th>Crédits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>UE 1 :Relations juridiques et fiscales</td><td>21</td></tr>
                                    <tr><td>UE 2 : Finance</td><td>28</td></tr>
                                    <tr><td>UE 3 : Management, Contrôle de Gestion	</td><td>20</td></tr>
                                    <tr><td>UE 4 : Comptabilité et Audit </td> <td>19</td></tr>
                                    <tr><td>UE 5 : Management des Systèmes d’Information </td><td>10</td></tr>
                                    <tr><td>UE 6 : Epreuve Orale d’économie (en français/anglais)</td><td>5</td></tr>
                                    <tr><td>UE 7 : PTechniques d’expression et langues vivantes	</td><td>2</td></tr>
                                    <tr><td>UE 8 : Pratiques de recherche</td><td>7</td></tr>
                                    <tr><td>UE 9:Synthèse </td><td>8</td></tr>
                                    
                                    <tr class="table-info"><td><strong>Total</strong></td><td><strong>120</strong></td></tr>
                                </tbody>
                            </table>

                              <p style="text-align: justify" >o  <strong> Le stage DESCOGEF </strong>: la durée du stage est de 14 à 16 semaines minimum et il doit être accompli auprès d’un expert-comptable, un commissaire aux comptes ou dans les services comptables et financiers d’une entreprise, d’une collectivité publique ou d’une association. A l’issue du stage, l’apprenant devra rédiger un mémoire d’environ 50 pages maximum précédées d’une partie de quelques pages pour la présentation de l’organisation.</p>
                            <p style="text-align: justify"> A l’issue de la formation, l’apprenant est présenté à l’examen régional du DESCOGEF organisé par la CREFECF dans les Etats membres de l’UEMOA. Le diplôme délivré est revêtu de la signature du Président du Jury et du Président de la CREFECF.</p>
                             <h4 class="mt-4">Tarifs</h4>
                         <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th></th>
                                        <th>DESCOGEF 1</th>
                                        <th>DESCOGEF 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Droit d'examen regional</td><td>-</td><td>400.000 FCFA</td></tr>
                                    <tr><td>Frais de Scolarité</td><td>2.000.000 FCFA</td><td>2.400.000 FCFA</td></tr>
                                </tbody>
                            </table>
                        </div>
                </div>
                      

                
                
                <!-- Détails DECOFI -->
                <div id="decofi-details" class="details-section">
                    <h3>DECOFI</h3>
                    <p style="text-align: justify">L’obtention du DESCOGEF ouvre la voix au Diplôme d'Expertise Comptable et Financière (DECOFI) qui est le diplôme final du cycle. Il est organisé en deux temps :</p>
                     
                   <p>  <strong>-Stage Professionnel: </strong> la durée du stage est de 3 ans et contient des obligations professionnelles à savoir :</p>
                     <div class="ps-5">

                        <ul class="list-unstyled">
                            <li class="mb-2"  style="text-align: justify" >
                                <span class="badge bg-primary me-2">✓</span>
                                Stage en cabinet ou société d'expertise comptable agréée
                            </li> 
                            <li class="mb-2"  style="text-align: justify">
                                <span class="badge bg-primary me-2">✓</span>
                                6 rapports semestriels à déposer
                            </li>
                            <li  style="text-align: justify">
                                <span class="badge bg-primary me-2">✓</span>
                                9 sessions de journées techniques obligatoires
                            </li>
                        </ul>
                    </div>

                     <p style="text-align:justify"> <strong>-L'examen final: </strong> A l’issue de la formation, l’apprenant est présenté à l’examen régional du DECOFI organisé par la CREFECF dans les Etats membres de l’UEMOA. Le diplôme délivré est revêtu de la signature du Président du Jury et du Président de la CREFECF. Cet examen qui permet d’évaluer ces compétences techniques et son éthique porte sur les unités d’enseignement suivant :</p>
                    
  <div class="ps-5">

                        <ul class="list-unstyled">
                            <li class="mb-2"  style="text-align: justify" >
                                <span class="badge bg-primary me-2">✓</span>
                                Audit Contractuel et contrôle légal
                            </li> 
                            <li class="mb-2"  style="text-align: justify">
                                <span class="badge bg-primary me-2"> ✓</span>
                               	Jury professionnel
                            </li>
                            <li  style="text-align: justify">
                                <span class="badge bg-primary me-2">✓</span>
                                	Anglais 
                            </li>
                            <li  style="text-align: justify">
                                <span class="badge bg-primary me-2">✓</span>
                                	Mémoire 
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button class="btn btn-secondary" onclick="hideDecofiSection()">Fermer</button>
                </div>
            `;
            
            section.style.display = 'block';
            content.innerHTML = decofiContent;
            
            window.scrollTo({
                top: section.offsetTop - 20,
                behavior: 'smooth'
            });
            
            setTimeout(() => {
                content.style.opacity = '1';
                content.style.transform = 'translateY(0)';
            }, 100);
        }

        function toggleDetails(diploma) {
            // Masquer tous les détails d'abord
            document.querySelectorAll('.details-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Afficher seulement la section demandée
            const detailsSection = document.getElementById(`${diploma}-details`);
            if (detailsSection) {
                detailsSection.style.display = 'block';
                detailsSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function hideDecofiSection() {
            const section = document.getElementById('decofi-section');
            section.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
    // Vérifie si le paramètre URL contient show=decofi
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('show') && urlParams.get('show') === 'decofi') {
        showDecofiSection(event);
    }
});
        
</script>

    @foreach (['not_found', 'access'] as $errorType)
        @if($errors->has($errorType))
            <div class="toast align-items-center text-white bg-danger bg-opacity-75 border-0 position-fixed top-50 start-50 translate-middle fade show"
                role="alert" style="z-index: 1000; backdrop-filter: blur(2px);">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $errors->first($errorType) }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    @endforeach

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
    <style>
        #chat-button:hover {
            transform: scale(1.1);
            transition: transform 0.3s;
        }

        .chat-body {
            scrollbar-width: thin;
            scrollbar-color: #007bff #f8f9fa;
        }

        .chat-body::-webkit-scrollbar {
            width: 8px;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 4px;
        }

        #chat-messages {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 15px;
        }

        .message {
            max-width: 70%;
            padding: 8px 12px;
            border-radius: 12px;
            position: relative;
        }

        .message.sent {
            align-self: flex-start;
            background: #007bff;
            color: white;
            border-bottom-left-radius: 0;
        }

        .message.received {
            align-self: flex-end;
            background: #f1f1f1;
            color: #333;
            border-bottom-right-radius: 0;
        }

        .sender-name {
            display: block;
            font-weight: bold;
            font-size: 0.8em;
            margin-bottom: 4px;
            color: #555;
        }

        .message-time {
            display: block;
            font-size: 0.7em;
            text-align: right;
            margin-top: 4px;
            opacity: 0.8;
        }

        .message-content {
            margin: 5px 0;
        }
    </style>

    <script>
        let currentPage = 0;

    //     function openChat() {
    //         fetch('/mark-notifications-as-read', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //     },
    //     body: JSON.stringify({
    //         user_id: {{ auth()->id() }}
    //     })
    // })
    // .then(response => response.json())
    // .then(data => {
    //     // 2. Masquer le badge après la requête réussie
    //     document.getElementById('unread-count').style.display = 'none';
    //     document.getElementById('unread-count').textContent = '0';
        
    //     // 3. Ouvrir le chat (votre fonction existante)
    //     // ... votre code existant pour ouvrir le chat ...
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    // });

    //         document.getElementById('chat-window').style.display = 'block';
    //         loadMessages();
    //     }
    function openChat() {
    // Marquer les notifications comme lues (sans attendre la réponse)
    fetch('/mark-notifications-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ user_id: {{ auth()->id() }} })
    })
    .then(() => {
        const badge = document.getElementById('unread-count');
        if (badge) {
            badge.style.display = 'none';
            badge.textContent = '0';
        }
    })
    .catch(console.error);

    // Ouvrir immédiatement le chat
    const chatWindow = document.getElementById('chat-window');
    if (chatWindow) {
        chatWindow.style.display = 'block';
    }
    loadMessages().catch(console.error);
}

        function closeChat() {
            document.getElementById('chat-window').style.display = 'none';
        }

        function loadMessages() {
            fetch(`http://192.168.100.146:8001/chat/messages?page=${currentPage}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau : ' + response.statusText);
                    }
                    return response.json();
                })
                .then(messages => {
                    const container = document.getElementById('chat-messages');
                    container.innerHTML = '';

                    messages.data.reverse().forEach(msg => {
                        const isSender = msg.sender_id === {{ auth()->id() }};
                        container.innerHTML += `
                            <div class="mb-2 ${isSender ? 'text-end' : ''}">
                                <div class="d-inline-block p-2 rounded ${isSender ? 'bg-primary text-white' : 'bg-light'}">
                                    ${msg.content}
                                </div>
                                <small class="d-block text-muted">${new Date(msg.created_at).toLocaleTimeString()}</small>
                            </div>
                        `;
                    });

                    // Afficher le bouton "Voir messages précédents" si plus de messages sont disponibles
                    document.getElementById('load-previous').style.display = messages.prev_page_url ? 'block' : 'none';
                    // Afficher le bouton "Charger plus de messages" si plus de messages récents sont disponibles
                    document.getElementById('load-more').style.display = messages.next_page_url ? 'block' : 'none';

                    container.scrollTop = container.scrollHeight;
                })
                .catch(error => console.error('Erreur lors du chargement des messages:', error));
        }

        function loadPreviousMessages() {
            if (currentPage > 1) {
                currentPage--;
                loadMessages();
            }
        }

        function loadMoreMessages() {
            currentPage++;
            loadMessages();
        }

        function sendMessage(e) {
            e.preventDefault();
            const input = document.getElementById('message-input');
            const input2 = document.getElementById('receiver');

            const message = input.value;
            const recipientId = input2.value;

            fetch('http://192.168.100.146:8001/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message, receiver_id: recipientId })
            })
                .then(() => {
                    input.value = '';
                    loadMessages(); // Recharger les messages
                });
        }

        // Pour les notifications en temps réel (si vous utilisez Laravel Echo)
        @auth
            window.Echo.private(`chat.{{ auth()->id() }}`)
                .listen('MessageSent', (e) => {
                    const unreadBadge = document.getElementById('unread-count');
                    unreadBadge.style.display = 'block';
                    unreadBadge.textContent = parseInt(unreadBadge.textContent || 0) + 1;

                    // Si le chat est ouvert, afficher le message
                    if (document.getElementById('chat-window').style.display === 'block') {
                        loadMessages();
                    }
                });
        @endauth
      
    </script>

@endsection