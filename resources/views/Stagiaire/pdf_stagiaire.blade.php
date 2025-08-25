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
            const darkColor = [0, 0, 0]; // Noir
            const whiteColor = [255, 255, 255]; // Blanc

            
            // === EN-TÊTE STYLISÉ ===
            doc.setFillColor(...primaryColor);
            doc.rect(0, 0, 210, 30, 'F');
            
            // Logo
            doc.addImage('{{asset('assets/img/logo.jpg')}}', 'JPEG', 15, 5, 20, 20);
            
            // Titres
            doc.setTextColor(255, 255, 255);
            doc.setFont("helvetica", "bold");
            doc.setFontSize(16);
            doc.text("CONTRÔLE DE STAGE DECOFI", 105, 15, { align: "center" });
            doc.setFontSize(12);
            doc.text("FICHE DE PRÉINSCRIPTION", 105, 22, { align: "center" });
            
            // === INFORMATIONS PRINCIPALES ===
            doc.setTextColor(...darkColor);
            
            // Carte d'information
            doc.setFillColor(255, 255, 255);
            doc.setDrawColor(200, 200, 200);
            doc.roundedRect(10, 35, 190, 20, 3, 3, 'FD');
            
            doc.setFont("helvetica", "bold");
            doc.setFontSize(14);
            doc.setTextColor(...primaryColor);
            doc.text("INFORMATIONS STAGIAIRE", 105, 45, { align: "center" });
            
            doc.setFontSize(12);
            doc.setTextColor(...darkColor);
            doc.text(`Matricule: ${document.getElementById('matricule').textContent}`, 105, 52, { align: "center" });
            
            // === INFORMATIONS PERSONNELLES ===
            let y = 60;
            
            // Titre section
            doc.setFillColor(...primaryColor);
            doc.roundedRect(10, y, 190, 8, 2, 2, 'F');
            
            doc.setTextColor(...darkColor);
            doc.setFont("helvetica", "bold");
            doc.setFontSize(12);
            doc.text("COORDONNÉES", 15, y + 5.5);
            
            y += 12;
            
            // Informations personnelles
            doc.setTextColor(...darkColor);
            doc.setFont("helvetica", "normal");
            doc.setFontSize(11);
            
            const infos = [
                { label: "Nom", value: document.getElementById('name').textContent },
                { label: "Prénom", value: document.getElementById('firstname').textContent },
                { label: "Date de naissance", value: document.getElementById('birth_date').textContent },
                { label: "Pays", value: document.getElementById('lieu').textContent },
                { label: "Téléphone", value: document.getElementById('phone_number').textContent },
                { label: "Email", value: document.getElementById('email').textContent }
            ];
            
            // Affichage sur 2 colonnes
            infos.forEach((info, index) => {
                const column = index % 2 === 0 ? 15 : 110;
                const rowY = y + Math.floor(index/2) * 9;
        
                doc.setFont("helvetica", "bold");
                doc.text(`${info.label}:`, column, rowY);
                
                doc.setFont("helvetica", "normal");
                // Ajustement de la valeur pour éviter le débordement
                let displayValue = info.value;
                if (doc.getTextWidth(info.value) > (index % 2 === 0 ? 40 : 35)) {
                    displayValue = info.value.substring(0, 25) + (info.value.length > 25 ? '...' : '');
                }
                
                if(info.label === "Nom") {
                    doc.text(displayValue, column + 12, rowY);
                } else if(info.label === "Prénom") {
                    doc.text(displayValue, column + 18, rowY);
                } else if(info.label === "Date de naissance") {
                    doc.text(displayValue, column + 40, rowY);
                } else if(info.label === "Pays") {
                    doc.text(displayValue, column + 13, rowY);
                } else if(info.label === "Téléphone") {
                    doc.text(displayValue, column + 23, rowY);
                } else {
                    doc.text(displayValue, column + 15, rowY);
                }
            });
            
            y += Math.ceil(infos.length/2) * 9 + 10;
            
            // === SECTION DOCUMENTS REQUIS ===
            doc.setFillColor(...primaryColor);
            doc.roundedRect(10, y, 190, 8, 2, 2, 'F');
            
            doc.setTextColor(255, 255, 255);
            doc.setFont("helvetica", "bold");
            doc.setFontSize(12);
            doc.text("DOCUMENTS REQUIS POUR L'INSCRIPTION", 15, y + 5.5);
            
            y += 12;
            
            // Message
            doc.setTextColor(...darkColor);
            doc.setFont("helvetica", "normal");
            doc.setFontSize(11);
            doc.text("Veuillez fournir les documents suivants pour finaliser votre inscription :", 15, y);
            y += 7;
            
            // Liste des documents
            const documents = [
                "Formulaire de préinscription",
                "Décharge de la demande d'inscription en stage",
                "Attestation d'acceptation du Maître de Stage",
                "Engagement dûment signé du stagiaire et de son Maître de Stage",
                "Attestation de réussite du DESCOGEF",
                "Carte d'Identité Nationale ou Passeport en cours de validité",
                "Certificat de résidence du lieu d'implantation du bureau",
                "Contrat de travail signé par le Maître de Stage",
                "Extrait de casier judiciaire (datant de moins de 3 mois)",
                "Carte CNSS ou attestation de sécurité sociale",
                "Photo d'identité récente (format passeport)"
            ];
            
            doc.setFontSize(10);
            
            // Première colonne
            documents.slice(0, 6).forEach((docItem, index) => {
                doc.setFillColor(...primaryColor);
                doc.circle(15, y + 3 + (index * 6), 1.5, 'F');
                doc.setTextColor(...darkColor);
                
                // Gestion du texte long
                if (doc.getTextWidth(docItem) > 85) {
                    const parts = doc.splitTextToSize(docItem, 85);
                    doc.text(parts, 20, y + 3 + (index * 6));
                    y += (parts.length - 1) * 4;
                } else {
                    doc.text(docItem, 20, y + 3 + (index * 6));
                }
            });
            
            // Deuxième colonne
            let secondColumnY = y;
            documents.slice(6).forEach((docItem, index) => {
                doc.setFillColor(...primaryColor);
                doc.circle(110, secondColumnY + 3 + (index * 6), 1.5, 'F');
                doc.setTextColor(...darkColor);
                
                // Gestion du texte long
                if (doc.getTextWidth(docItem) > 85) {
                    const parts = doc.splitTextToSize(docItem, 85);
                    doc.text(parts, 115, secondColumnY + 3 + (index * 6));
                    secondColumnY += (parts.length - 1) * 4;
                } else {
                    doc.text(docItem, 115, secondColumnY + 3 + (index * 6));
                }
            });
            
            // Ajuster la position Y en fonction de la colonne la plus longue
            y = Math.max(y + (6 * 6), secondColumnY + (5 * 6)) + 10;
            
            // === QR CODE EN BAS À DROITE ===
            const qrData = `DECOFI|${document.getElementById('matricule').textContent}|${document.getElementById('name').textContent}|${document.getElementById('firstname').textContent}`;
            $('#qrcode').empty().qrcode({
                text: qrData,
                width: 80,
                height: 80,
                background: "#ffffff",
                foreground: "#0066cc"
            });
            
            const qrCodeCanvas = document.getElementById('qrcode').getElementsByTagName('canvas')[0];
            if (qrCodeCanvas) {
                const qrCodeImage = qrCodeCanvas.toDataURL('image/png');
                
                // Positionner le QR Code en bas à droite
                const qrSize = 35;
                const qrX = 160;
                const qrY = 230;
                
                // Cadre autour du QR Code
                doc.setDrawColor(...primaryColor);
                doc.setLineWidth(0.5);
                doc.roundedRect(qrX, qrY, qrSize + 5, qrSize + 5, 2, 2, 'S');
                
                // QR Code
                doc.addImage(qrCodeImage, 'PNG', qrX + 2.5, qrY + 2.5, qrSize, qrSize);
                
                // Texte sous le QR Code
                doc.setFont("helvetica", "bold");
                doc.setFontSize(8);
                doc.setTextColor(...darkColor);
                doc.text("IDENTIFIANT", qrX + 10, qrY + qrSize + 10);
                
                doc.setFont("helvetica", "normal");
                doc.setFontSize(7);
                doc.text("Scan pour vérification", qrX + 3, qrY + qrSize + 15);
            }
            
            // === PIED DE PAGE ===
            doc.setDrawColor(150, 150, 150);
            doc.setLineWidth(0.3);
            doc.line(10, 270, 200, 270);
            
            doc.setFont("helvetica", "italic");
            doc.setFontSize(9);
            doc.setTextColor(...darkColor);
            doc.text("Document généré par Gestion DECOFI - " + new Date().toLocaleDateString('fr-FR'), 15, 278);
            
            doc.setFont("helvetica", "normal");
            doc.text(`Référence: ${document.getElementById('matricule').textContent}`, 180, 278, { align: "right" });
            
            // === BORDURE FINALE ===
            doc.setDrawColor(...primaryColor);
            doc.setLineWidth(0.5);
            doc.rect(5, 5, 200, 280);
            
            // Sauvegarde du PDF
            const fileName = `Fiche_Stagiaire_${document.getElementById('matricule').textContent}.pdf`;
            doc.save(fileName);
        };
        </script>
@endsection



