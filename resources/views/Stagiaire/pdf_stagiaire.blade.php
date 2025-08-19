@extends('welcome')
    @section('title')
        <title>Gestion DECOFI - PDF Stagiaire</title>
    @endsection
    @section('scripts_up')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    @endsection

    @section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h3 mb-0">Informations du Stagiaire</h1>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="text-muted"> <strong>Matricule</strong></h5>
                            <p class="lead" id="matricule">{{$matricule }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted"> <strong>Nom </strong></h5>
                            <p class="lead" id="name">{{ $name }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted"> <strong> Prénom</strong></h5>
                            <p class="lead" id="firstname">{{ $firstname }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted"> <strong> Email</strong></h5>
                            <p class="lead" id="email">{{ $email }}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="text-muted"> <strong>Nationalité </strong></h5>
                            <p class="lead" id="Nationalite">{{ $Nationalite }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="text-muted"> <strong> Téléphone</strong></h5>
                            <p class="lead" id="phone_number">{{ $phone_number }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted"> <strong> Date de naissance</strong></h5>
                            <p class="lead" id="birth_date">{{ $birth_date }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-muted"> <strong>Lieu de naissance </strong></h5>
                            <p class="lead" id="lieu">{{ $lieu}}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="text-muted"> <strong>Pays d'affiliation </strong></h5>
                            <p class="lead" id="country">{{ $country }}</p>
                        </div>
                        
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <button id="generate" class="btn btn-primary btn-lg">
                            <i class="" data-feather="printer"></i>Générer le PDF
                        </button>
                    </div>
                    <div>
                        <a href="{{ route('stagiaire.inscription') }}" class="btn btn-secondary btn-lg">
                            <i class="" data-feather="edit"></i>Completer mon dossier
                        </a>
                    </div>
                </div>
                {{-- <div class="text-center mt-4">
                   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterModal">
                    <i class="align-middle me-2" data-feather="upload"></i> completer mon dossier
                </button> 
                </div> --}}
                
                
                <div class="text-center mt-4" id="qrcode" style="display:;">
                    <!-- Le QR code apparaîtra ici -->
                </div>
            </div>
        </div>
    </div>
     <script>
        document.getElementById('generate').onclick = function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            // Configuration des couleurs
            const primaryColor = [0, 102, 204]; // Bleu DECOFI
            const secondaryColor = [241, 241, 241]; // Gris clair
            
            // En-tête avec logo et informations
            doc.setFillColor(...primaryColor);
            doc.rect(0, 0, 210, 30, 'F');
            
            // Logo
            doc.addImage('{{asset('assets/img/logo.jpg')}}', 'JPEG', 10, 5, 20, 20);
            
            // Titres
            doc.setTextColor(255, 255, 255);
            doc.setFont("helvetica", "bold");
            doc.setFontSize(16);
            doc.text("Gestion DECOFI", 80, 15);
            doc.setFontSize(12);
            doc.text("Fiche de préinscription", 80, 22);
            
            // Corps du document
            doc.setTextColor(0, 0, 0); // Noir
            
            // Rectangle d'information principale
            doc.setFillColor(...secondaryColor);
            doc.roundedRect(10, 40, 190, 30, 3, 3, 'F');
            doc.setFontSize(14);
            doc.text("Informations du Stagiaire", 15, 50);
            doc.setFontSize(10);
            doc.text(`Matricule: ${document.getElementById('matricule').textContent}`, 150, 50);
            
            // Ligne de séparation
            doc.setDrawColor(...primaryColor);
            doc.setLineWidth(0.5);
            doc.line(10, 55, 200, 55);
            
            // Informations personnelles
            const yStart = 65;
            let y = yStart;
            
            doc.setFont("helvetica", "bold");
            doc.setFontSize(12);
            doc.text("Informations Personnelles", 15, y);
            y += 10;
            
            doc.setFont("helvetica", "normal");
            doc.setFontSize(10);
            
            const infos = [
                { label: "Nom", value: document.getElementById('name').textContent },
                { label: "Prénom", value: document.getElementById('firstname').textContent },
                { label: "Date de naissance", value: document.getElementById('birth_date').textContent },
                { label: "Pays ", value: document.getElementById('lieu').textContent },
                { label: "Téléphone", value: document.getElementById('phone_number').textContent },
                { label: "Email", value: document.getElementById('email').textContent }
                // { label: "lieu de naissance", value: document.getElementById('lieu').textContent }
                // { label: "Nationalite", value: document.getElementById('email').textContent }
            ];
            
            // Affichage des informations sur deux colonnes
            infos.forEach((info, index) => {
                const column = index % 2 === 0 ? 15 : 110;
                const rowY = y + Math.floor(index/2) * 8;


                doc.setFont("helvetica", "bold");
                doc.text(`${info.label}:`, column, rowY);
                doc.setFont("helvetica", "normal");
                if(info.label === "Date de naissance") {
                     doc.text(info.value, column + 33, rowY);
                } else 
                if( info.label === "Téléphone") {
                    doc.text(info.value, column + 20, rowY);
                } else
                if(info.label === "Nom") {
                    doc.text(info.value, column + 11, rowY);
                } else
                {
                    doc.text(info.value, column + 25, rowY);
                }

            });
            
            y += Math.ceil(infos.length/2) * 8 + 10;
            
            // Génération du QR Code
            const qrData = `DECOFI Stagiaire|${document.getElementById('matricule').textContent}|${document.getElementById('name').textContent}|${document.getElementById('firstname').textContent}`;
            $('#qrcode').empty().qrcode({
                text: qrData,
                width: 100,
                height: 100
            });
            
            const qrCodeCanvas = document.getElementById('qrcode').getElementsByTagName('canvas')[0];
            if (qrCodeCanvas) {
                const qrCodeImage = qrCodeCanvas.toDataURL('image/png');
                
                // Ajout du QR Code
                doc.setFont("helvetica", "bold");
                doc.text("QR Code d'identification:", 15, y);
                doc.addImage(qrCodeImage, 'PNG', 15, y + 5, 40, 40);
                
                // Zone d'information du QR Code
                doc.setFontSize(8);
                doc.text("Ce QR Code contient les informations principales", 60, y + 10);
                doc.text("du stagiaire et peut être scanné pour un accès", 60, y + 15);
                doc.text("rapide aux données.", 60, y + 20);
            }

            y += 50;
            //espace après le QR Code
            y += 10;

// Ajout du message et de la liste des documents
            doc.setFont("helvetica", "normal");
            doc.setFontSize(10);
            doc.setTextColor(0, 0, 0); // Noir

            // Message d'introduction
            doc.text("Cher(e) Stagiaire,", 15, y);
            y += 7;
            doc.text("Merci de vous être enregistré sur notre plateforme.", 15, y);
            y += 7;
            doc.text("Pour finaliser votre inscription, vous devrez joindre, conformément au point 1.1 de la charte du stage professionnel du ", 15, y);
            doc.text("DECOFI, les documents suivants :", 15, y + 5);
            y += 10;

            // Liste des documents (avec puces)
            const documents = [
                "Formulaire de préinscription",
                "Décharge de la demande d'inscription en stage adressée au Président de l'Ordre",
                "Attestation d'acceptation en stage du Maître de Stage",
                "Engagement dûment signé du stagiaire et de son Maître de Stage",
                "Attestation de réussite du DESCOGEF",
                "Carte d'Identité Nationale ou du Passeport",
                "Certificat de résidence du lieu d'implantation du bureau de son Maître de Stage",
                "Contrat de travail signé par le Maître de Stage",
                "Extrait de casier judiciaire",
                "Carte CNSS",
                "Photo d'identité"
            ];

            // Affichage de la liste avec puces
            doc.setFontSize(9);
            documents.forEach((docItem, index) => {
                // Ajout de la puce et du texte
                doc.text(`• ${docItem}`, 20, y);
                y += 6;
                
                // Vérification si on dépasse la page
                if (y > 250) {
                    doc.addPage();
                    y = 20;
                }
            });

// Espace après la liste
y += 10;

// Message de conclusion
// doc.setFontSize(10);
// doc.text("Nous vous remercions pour votre coopération et vous souhaitons une excellente", 15, y);
// y += 6;
// doc.text("expérience de stage avec DECOFI.", 15, y);

            
            
            // Pied de page
            doc.setFont("helvetica", "italic");
            doc.setFontSize(8);
            doc.setTextColor(100, 100, 100);
            doc.text("Document généré automatiquement par le système Gestion DECOFI", 15, 280);
            doc.text(new Date().toLocaleDateString(), 180, 280, null, null, "right");
            
            // Bordure du document
            doc.setDrawColor(...primaryColor);
            doc.setLineWidth(0.5);
            doc.rect(5, 5, 200, 287);
            
            // Sauvegarde du PDF
            doc.save(`Fiche_Stagiaire_${document.getElementById('matricule').textContent}.pdf`);
        };
        
    </script>
@endsection



