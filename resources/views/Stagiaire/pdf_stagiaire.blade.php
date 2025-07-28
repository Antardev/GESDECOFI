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
                            <h5 class="text-muted">Matricule</h5>
                            <p class="lead" id="matricule">{{$matricule }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted">Nom</h5>
                            <p class="lead" id="name">{{ $name }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted">Prénom</h5>
                            <p class="lead" id="firstname">{{ $firstname }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted">Email</h5>
                            <p class="lead" id="email">{{ $email }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="text-muted">Téléphone</h5>
                            <p class="lead" id="phone_number">{{ $phone_number }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted">Date de naissance</h5>
                            <p class="lead" id="birth_date">{{ $birth_date }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted">Pays</h5>
                            <p class="lead" id="country">{{ $country }}</p>
                        </div>
                        {{-- <div class="mb-3">
                            <h5 class="text-muted">Ordre d'affiliation à l'ordre</h5>
                            <p class="lead" id="country">{{ $affiliation_order}}</p>
                        </div> --}}
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
                { label: "Nom", value: document.getElementById('firstname').textContent },
                { label: "Prénom", value: document.getElementById('name').textContent },
                { label: "Date de naissance", value: document.getElementById('birth_date').textContent },
                { label: "Pays", value: document.getElementById('country').textContent },
                { label: "Téléphone", value: document.getElementById('phone_number').textContent },
                { label: "Email", value: document.getElementById('email').textContent }
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

{{-- <script>
        document.getElementById('generate').onclick = function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFillColor(0, 102, 204);
            doc.rect(10, 10, 190, 30, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont("helvetica", "bold");
            
            doc.addImage('{{asset('assets/img/logo.jpg')}}', 'PNG', 10, 5, 30, 30); 
            
            // Ajouter l'en-tête
            doc.setFontSize(18);
            doc.text("GestionDECOFI", 90, 20);

            // Ajouter le titre
            doc.setFontSize(14);
            doc.text("Le DECOFI", 100, 30);

            // Mettre la couleur du texte en noir
            doc.setTextColor(0, 0, 0); // Noir

            // Récupérer les données
            const matricule = document.getElementById('matricule').textContent;
            const name = document.getElementById('name').textContent;
            const firstname = document.getElementById('firstname').textContent;
            const email = document.getElementById('email').textContent;
            const phone_number = document.getElementById('phone_number').textContent;
            const birth_date = document.getElementById('birth_date').textContent;
            const country = document.getElementById('country').textContent;

            // Vérifier que les informations sont valides
            if (!name || !matricule || !firstname || !email || !phone_number || !birth_date || !country) {
                alert('Veuillez vérifier que toutes les informations sont remplies.');
                return;
            }

            const qrData = `Nom: ${firstname}, Prénom: ${name}, Email: ${email}, Téléphone: ${phone_number}`;
            $('#qrcode').empty().qrcode(qrData); 

            const qrCodeCanvas = document.getElementById('qrcode').getElementsByTagName('canvas')[0];
            if (qrCodeCanvas) {
                const qrCodeImage = qrCodeCanvas.toDataURL('image/png'); 

                // Ajouter des informations au PDF
                doc.setFontSize(14); 
                doc.text(`Fiche de préinscription du stagiaire`, 75, 55);

                doc.setFontSize(10); 
                doc.text(`Matricule : ${matricule}`, 10, 50+20);
                doc.line(10, 55+20, 110, 55+20);
                doc.text(`Nom : ${firstname}`, 10, 60+20);
                doc.line(10, 65+20, 110, 65+20);
                doc.text(`Prenom : ${name}`, 10, 70+20);
                doc.line(10, 75+20, 110, 75+20);
                doc.text(`Date de naissance : ${birth_date}`, 10, 80+20);
                doc.line(10, 85+20, 110, 85+20);
                doc.text(`Telephone : ${phone_number}`, 10, 90+20);
                doc.line(10, 95+20, 110, 95+20);
                doc.text(`Email : ${email}`, 10, 100+20);
                doc.line(10, 105+20, 110, 105+20);
                doc.text(`Pays : ${country}`, 10, 110+20);
                doc.line(10, 115+20, 110, 115+20);
                doc.addImage(qrCodeImage, 'PNG', 150, 70+20, 40, 40); 

                // doc.text("NB : ");
                doc.setFont("helvetica", "italic");
                doc.setFontSize(10);
                doc.text("Veuillez remplir cette fiche et l'accompagner des documents listés sur le site, puis vous rendre à l'ordre pour la déposer.", 10, 230);

                doc.setDrawColor(0);
                doc.rect(5, 5, 200, 280); 

  
                doc.save('stagiaire.pdf');
            } else {
                alert('Erreur lors de la génération du code QR. Veuillez réessayer.');
            }
        };
    </script> --}}
   

