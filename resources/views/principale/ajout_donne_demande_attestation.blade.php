{{-- @extends('base')
@section('title', 'collecte de donnees')
@section('content')<br><br><br><br>

    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center mt-3">
        <div class="col-lg-10 col-md-12 col-12">
            <div class="card shadow-lg border-0 rounded-4">

                @if(session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <script>
                        Swal.fire({
                        icon: 'error',
                        title: 'Erreur de validation',
                        html: {!! implode('<br>', $errors->all()) !!},
                        confirmButtonText: 'OK'
                        });
                    </script>
                @endif

                <!-- HEADER -->
                <div class="card-header bg-success text-white text-center rounded-top-4">
                    <h4 class="fw-bold my-2">FORMULAIRE DE DEMANDE D'ATTESTATION DE FIN DE STAGE N°  </h4>
                </div>

                <div class="card-body p-4">
                    <div class="p-3 mb-4 bg-light rounded-3 border">
                        <p class="mb-0" style="font-size: 0.9rem; line-height: 1.5;">
                            Ce formulaire est destiné à la collecte de vos informations personnelles dans l'unique but du traitement de votre demande d'attestation de fin de stage au titre de l'année 2025. Il demeure ouvert jusqu'au 31 octobre 2025 à 17 heures au plus tard.
                            <br>
                            <b>Le Secrétariat du Contrôleur National de Stage du BENIN.</b>
                        </p>
                    </div>
                    <!-- Indicateur d'étapes -->
                    <div class="d-flex justify-content-center mb-4" id="steps-indicator">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle step-circle bg-danger text-white d-flex justify-content-center align-items-center"
                                style="width:40px; height:40px;">1</div>
                            <span class="ms-2 fw-bold text-danger">Informations Du Stagiaire</span>
                        </div>
                        <div class="d-flex align-items-center ms-4">
                            <div class="rounded-circle step-circle bg-secondary text-white d-flex justify-content-center align-items-center"
                                style="width:40px; height:40px;">2</div>
                            <span class="ms-2 text-secondary">Informations sur le Stage</span>
                        </div>
                        <div class="d-flex align-items-center ms-4">
                            <div class="rounded-circle step-circle bg-secondary text-white d-flex justify-content-center align-items-center"
                                style="width:40px; height:40px;">3</div>
                            <span class="ms-2 text-secondary">Obligations de Stage</span>
                        </div>

                        <div class="d-flex align-items-center ms-4">
                            <div class="rounded-circle step-circle bg-secondary text-white d-flex justify-content-center align-items-center"
                                style="width:40px; height:40px;">4</div>
                            <span class="ms-2 text-secondary">Récapitulatif</span>
                        </div>
                    </div>

                    <!-- Formulaire -->
                    <form method="POST" action="{{route('stage_store_collecte_donnees')}}" id="multi-step-form" enctype="multipart/form-data">
                        @csrf

                        <h4 class="fw-bold my-2" style="display: none">FORMULAIRE DE DEMANDE D'ATTESTATION DE FIN DE STAGE
                            N° <input type="text" name="numerodemande" id="numerodemande" value="25001" class="bg-success text-light" style="border: none" readonly>
                        </h4>

                        <!-- ================== ÉTAPE 1 ================== -->
                        <div class="form-step active">
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="civilite" id="civiliteM" value="M" required>
                                    <label class="form-check-label fw-bold" for="civiliteM">M</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="civilite" id="civiliteMme" value="Mme">
                                    <label class="form-check-label fw-bold" for="civiliteMme">Mme</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="civilite" id="civiliteMlle" value="Mlle">
                                    <label class="form-check-label fw-bold" for="civiliteMlle">Mlle</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="matriculestagiaire" class="form-label"><strong>N° Matricule </strong></label>
                                    <input type="text" name="matriculestagiaire" id="matriculestagiaire" value="{{ old('matriculestagiaire') }}" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-4">
                                    <label for="nomstagiaire" class="form-label"><strong>Nom </strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="nomstagiaire" id="nomstagiaire" value="{{ old('nomstagiaire') }}" class="form-control form-control-sm text-uppercase" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="prenomstagiaire" class="form-label"><strong>Prénom </strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="prenomstagiaire" id="prenomstagiaire" value="{{ old('prenomstagiaire') }}" class="form-control form-control-sm text-capitalize" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="lieunaissance" class="form-label"><strong>Lieu de Naissance </strong><span class="text-danger"> *</span></label>
                                    <input type="text" name="lieunaissance" id="lieunaissance" value="{{ old('lieunaissance') }}" class="form-control form-control-sm text-capitalize" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="nationalite" class="form-label"><strong>Nationalité </strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="nationalite" id="nationalite" value="{{ old('nationalite') }}" class="form-control form-control-sm text-capitalize" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="adresse" class="form-label"><strong>Adresse </strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}" class="form-control form-control-sm text-capitalize" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="datenaissance" class="form-label"><strong>Date Naissance </strong><span class="text-danger"> *</span></label>
                                    <input type="date" name="datenaissance" id="datenaissance" max="{{ date('Y-m-d') }}" value="{{ old('datenaissance') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="phonecontact" class="form-label"><strong>Télephone </strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="phonecontact" id="phonecontact" value="{{ old('phonecontact') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label"><strong>Email </strong> <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-danger next-step">Suivant</button>
                            </div>
                        </div>

                        <!-- ================== ÉTAPE 2 ================== -->
                        <div class="form-step d-none">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="datedebutstage" class="form-label"><strong>Date Debut Stage </strong><span class="text-danger"> *</span></label>
                                    <input type="date" name="datedebutstage" id="datedebutstage" max="{{ date('Y-m-d') }}" value="{{ old('datedebutstage') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="datefinstage" class="form-label"><strong>Date Fin Stage </strong> <span class="text-danger">*</span></label>
                                    <input type="date" name="datefinstage" id="datefinstage" max="{{ date('Y-m-d') }}" value="{{ old('datefinstage') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-4" style="display: none">
                                    <label for="nomcontrolleurstage" class="form-label"><strong>Nom Contrôleur Stage</strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="nomcontrolleurstage" id="nomcontrolleurstage" value="{{ old('nomcontrolleurstage') }}" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-4">
                                    <label for="prenomcontrolleurstage" class="form-label"><strong>Nom & Prénom Contrôleur Stage</strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="prenomcontrolleurstage" id="prenomcontrolleurstage" value="{{ old('prenomcontrolleurstage') }}" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <h5 class="text-danger mb-3 text-center text-decoration-underline">Maître de Stage</h5>
                                <div class="col-md-6" style="display: none">
                                    <label for="nomaitrestage" class="form-label"><strong>Nom </strong><span class="text-danger"> *</span></label>
                                    <input type="text" name="nomaitrestage" id="nomaitrestage" value="{{ old('nomaitrestage') }}" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-6">
                                    <label for="prenomaitrestage" class="form-label"><strong>Nom & Prénom </strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="prenomaitrestage" id="prenomaitrestage" value="{{ old('prenomaitrestage') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="orderaffimaitstage" class="form-label"><strong>Ordre D'Affiliation </strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="orderaffimaitstage" id="orderaffimaitstage" value="{{ old('orderaffimaitstage') }}" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="numeroaffimaitstage" class="form-label"><strong>N° D'Affiliation </strong><span class="text-danger"> *</span></label>
                                    <input type="text" name="numeroaffimaitstage" id="numeroaffimaitstage" value="{{ old('numeroaffimaitstage') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="dateaffimaitstage" class="form-label"><strong>Date D'Affiliation </strong> <span class="text-danger">*</span></label>
                                    <input type="date" name="dateaffimaitstage" id="dateaffimaitstage" max="{{ date('Y-m-d') }}" value="{{ old('dateaffimaitstage') }}" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <h6 class="text-danger mb-3 text-center text-decoration-underline">Structure d'accueil du stage</h6>
                                <div class="col-md-3">
                                    <label for="raisonsociastructure" class="form-label"><strong>Raison sociale :</strong><span class="text-danger"> *</span></label>
                                    <input type="text" name="raisonsociastructure" id="raisonsociastructure" value="{{ old('raisonsociastructure') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="ordreaffilistructure" class="form-label"><strong>Ordre d'Affiliation :</strong> <span class="text-danger">*</span></label>
                                    <input type="text" name="ordreaffilistructure" id="ordreaffilistructure" value="{{ old('ordreaffilistructure') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="numeroaffilistructure" class="form-label"><strong> N° d'Affiliation :</strong><span class="text-danger"> *</span></label>
                                    <input type="text" name="numeroaffilistructure" id="numeroaffilistructure" value="{{ old('numeroaffilistructure') }}" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="dateaffilistructure" class="form-label"><strong>Date d'Affiliation : </strong> <span class="text-danger">*</span></label>
                                    <input type="date" name="dateaffilistructure" id="dateaffilistructure" max="{{ date('Y-m-d') }}" value="{{ old('dateaffilistructure') }}" class="form-control form-control-sm" required>
                                </div>
                            </div>

                            <div class="text-center mx-5">
                                <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                                <button type="button" class="btn btn-danger next-step">Suivant</button>
                            </div>
                        </div>

                        <!-- ================== ÉTAPE 3 ================== -->
                        <div class="form-step d-none">
                            <p class="text-center fw-lighter">Veuillez cocher les éléments à fournir. À chaque coche, le champ d’upload apparaît. (PDF/JPG/PNG)</p>

                            <!-- 3.1 CONDITIONS D'ENTREE EN STAGE -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-decoration-underline">3.1 - CONDITIONS D'ENTREE EN STAGE</label>
                                <div class="row gy-2">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input doc-check" type="checkbox" id="chk_decharge" name="conditions[]" value="decharge" data-target="#up_decharge">
                                            <label class="form-check-label" for="chk_decharge">Décharge / Acceptation de l'Ordre</label>
                                        </div>
                                        <div id="up_decharge" class="d-none mt-2">
                                            <input type="file" name="file_decharge" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Décharge / Acceptation">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input doc-check" type="checkbox" id="chk_convenstage" name="conditions[]" value="convenstage" data-target="#up_convenstage">
                                            <label class="form-check-label" for="chk_convenstage">Convention de stage</label>
                                        </div>
                                        <div id="up_convenstage" class="d-none mt-2">
                                            <input type="file" name="file_convenstage" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Convention de stage">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input doc-check" type="checkbox" id="chk_convencnss" name="conditions[]" value="convencnss" data-target="#up_convencnss">
                                            <label class="form-check-label" for="chk_convencnss">Carte CNSS</label>
                                        </div>
                                        <div id="up_convencnss" class="d-none mt-2">
                                            <input type="file" name="file_convencnss" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Convention CNSS">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-decoration-underline">3.2 - RAPPORTS DE STAGE</label>
                                <div class="row gy-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center align-middle">
                                        <thead>
                                            <tr>
                                            <th></th>
                                            <th colspan="2">Année 1</th>
                                            <th colspan="2">Année 2</th>
                                            <th colspan="2">Année 3</th>
                                            </tr>
                                            <tr>
                                            <th></th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td><strong>Semestre 1</strong></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            </tr>
                                            <tr>
                                            <td><strong>Semestre 2</strong></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-decoration-underline">3.3 - Journées techniques de stage</label>
                                <div class="row gy-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center align-middle">
                                        <thead>
                                            <tr>
                                            <th></th>
                                            <th colspan="2">Année 1</th>
                                            <th colspan="2">Année 2</th>
                                            <th colspan="2">Année 3</th>
                                            </tr>
                                            <tr>
                                            <th></th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td><strong>Session 1</strong></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            </tr>
                                            <tr>
                                            <td><strong>Session 2</strong></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            </tr>
                                            <tr>
                                            <td><strong>Session 3</strong></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            <td><input type="date" name="" class="form-control"></td>
                                            <td><input type="file" name="" class="form-control"></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                            <!-- Galerie de prévisualisation -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Aperçu des fichiers sélectionnés</label>
                                <div id="previewZone" class="row g-3"></div>
                                <small class="text-muted">Les images s’affichent en miniature. Pour les PDF, une icône avec le nom du fichier est affichée.</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                                <button type="button" class="btn btn-danger next-step">Suivant</button>
                            </div>
                        </div>

                        <!-- ================== ÉTAPE 4 (Récapitulatif) ================== -->
                        <div class="form-step d-none">
                            <p class="mb-2">Vous pouvez corriger les informations (Etape 1 & Etape 2) avant de soumettre. Les fichiers (Etape 3) apparaissent en bas.</p>
                            <div id="recap-fields" class="row g-3"></div>
                            <hr class="my-4">
                            <h6 class="mb-2">Fichiers sélectionnés</h6>
                            <div id="recapFiles" class="row g-3"></div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                                <button type="submit" class="btn btn-success">Soumettre</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <br><br><br>

    <!-- jQuery -->
    <script>
        $(function(){
            let currentStep = 0;
            const $steps = $(".form-step");
            const $circles = $(".step-circle");

            function showStep(index){
                $steps.addClass("d-none").removeClass("active");
                $steps.eq(index).removeClass("d-none").addClass("active");

                // Progression cumulée : tous les cercles de 0..index deviennent rouges
                $circles.removeClass("bg-danger").addClass("bg-secondary");
                for(let i=0; i<=Math.min(index,3); i++){
                    $circles.eq(i).removeClass("bg-secondary").addClass("bg-danger");
                }
            }

            function validateRequiredInputs($scope){
                let valid = true;

                // radios : au moins 1 choisi par name
                $scope.find("input[type=radio][required]").each(function(){
                    const name = $(this).attr('name');
                    if ($scope.find(input[name="${name}"]:checked).length === 0) {
                        valid = false;
                    }
                });

                // autres champs requis
                $scope.find("input[required]:not([type=radio])").each(function(){
                    if(!$(this).val()){
                        valid = false;
                        $(this).addClass("is-invalid");
                    }else{
                        $(this).removeClass("is-invalid");
                    }
                });

                return valid;
            }

            function validateStep(index){
                // Step 1 & 2 : tous les champs requis remplis
                if(index === 0 || index === 1){
                    return validateRequiredInputs($steps.eq(index));
                }
                // Step 3 : chaque checkbox cochée doit avoir un fichier choisi
                if(index === 2){
                    let ok = true;
                    // conditions
                    $(".doc-check, .rap-check, .jt-check").each(function(){
                        const checked = $(this).is(":checked");
                        const target = $(this).data("target");
                        if(checked){
                            const $file = $(target).find('input[type="file"]');
                            if($file.length && !$file.val()){
                                ok = false;
                                $file.addClass("is-invalid");
                            }else{
                                $file.removeClass("is-invalid");
                            }
                        }
                    });
                    return ok;
                }
                return true;
            }

            function buildRecap(){
                // Désactiver les inputs originaux Step1&2 pour éviter doublons lors de la soumission
                const $s12 = $steps.eq(0).add($steps.eq(1));
                $s12.find("input, select, textarea").prop("disabled", true);

                // Construire inputs modifiables en col-md-3
                const fields = [];
                $s12.find("input, select, textarea").each(function(){
                    const $el = $(this);
                    const type = ($el.attr("type") || "").toLowerCase();
                    const name = $el.attr("name");
                    if(!name || name === '_token') return;

                    let label = $el.closest('.col-md-3, .col-md-4, .col-md-6, .col-md-12').find("label.form-label,strong,label").first().text().trim();
                    if(!label){ label = name; }

                    // Valeur lisible pour radios
                    let value = $el.val();
                    if(type === 'radio'){
                        if(!$([name="${name}"]:checked).length) return;
                        value = $([name="${name}"]:checked).val();
                        // éviter dupliquer plusieurs radios du même name
                        if(fields.some(f => f.name === name)) return;
                    }

                    // prendre uniquement le champ "courant" (pas les radios non cochés)
                    if(type === 'radio' && !$el.is(':checked')) return;

                    fields.push({name, label, value, type});
                });

                $("#recap-fields").empty();
                fields.forEach(f=>{
                    $("#recap-fields").append(`
                        <div class="col-12 col-md-3">
                            <label class="form-label"><b>${f.label}</b></label>
                            <input type="text" class="form-control form-control-sm recap-input" data-name="${f.name}" name="${f.name}" value="${$('<div/>').text(f.value).html()}">
                        </div>
                    `);
                });

                // Afficher récap des fichiers (miniatures 4 par ligne)
                $("#recapFiles").empty();
                rebuildPreviewGallery("#recapFiles");
            }

            function syncRecapBackToSteps(){
                // Copier valeurs modifiées du récap vers les champs originaux correspondants
                $(".recap-input").each(function(){
                    const name = $(this).data("name");
                    const val = $(this).val();
                    // radios vs inputs
                    const $targets = $([name="${name}"]).not($(this));
                    if($targets.is('[type=radio]')){
                        // si on a modifié la civilité par ex., cocher la bonne
                        $targets.prop('checked', false)
                                .filter([value="${val}"]).prop('checked', true);
                    }else{
                        $targets.val(val);
                    }
                });
                // Réactiver les inputs originaux
                $steps.eq(0).add($steps.eq(1)).find("input, select, textarea").prop("disabled", false);
            }

            function toggleUploadByCheckbox($chk){
                const target = $chk.data("target");
                if($chk.is(":checked")){
                    $(target).removeClass("d-none");
                }else{
                    // clear file + hide
                    $(target).find('input[type="file"]').val("").removeClass("is-invalid");
                    $(target).addClass("d-none");
                    rebuildPreviewGallery(); // refresh gallery after uncheck
                }
            }

            function previewCardHtml(src, isPdf, label, filename){
                if(isPdf){
                    return `
                    <div class="col-6 col-md-3">
                    <div class="border rounded-3 p-2 h-100 d-flex flex-column align-items-center">
                        <div style="font-size:48px;line-height:1">📄</div>
                        <div class="small text-center mt-2">${label}</div>
                        <div class="small text-muted text-center">${filename}</div>
                    </div>
                    </div>`;
                }else{
                    return `
                    <div class="col-6 col-md-3">
                    <div class="border rounded-3 p-2 h-100 d-flex flex-column align-items-center">
                        <img src="${src}" class="img-fluid rounded" style="max-height:120px;object-fit:contain;">
                        <div class="small text-center mt-2">${label}</div>
                        <div class="small text-muted text-center">${filename}</div>
                    </div>
                    </div>`;
                }
            }

            function rebuildPreviewGallery(targetSelector){
                const $container = $(targetSelector || "#previewZone");
                $container.empty();

                // parcourir tous les inputs fichier visibles ou non (on affiche tout ce qui est sélectionné)
                $(".file-input").each(function(){
                    const files = this.files;
                    if(!files || !files.length) return;
                    const label = $(this).data("label") || $(this).attr("name");
                    const file = files[0];
                    const name = file.name.toLowerCase();
                    const isPdf = name.endsWith(".pdf");

                    if(isPdf){
                        $container.append(previewCardHtml("", true, label, file.name));
                    }else{
                        const reader = new FileReader();
                        reader.onload = (e)=>{
                            $container.append(previewCardHtml(e.target.result, false, label, file.name));
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            $(".next-step").on("click", function(){
                if(!validateStep(currentStep)){
                    alert("Veuillez compléter correctement cette étape (tous les champs requis et/ou fichiers cochés).");
                    return;
                }
                currentStep++;
                if(currentStep >= $steps.length) currentStep = $steps.length - 1;

                // si on entre dans le récap, construire le récap + fichiers
                if(currentStep === 3){
                    buildRecap();
                }
                showStep(currentStep);
            });

            $(".prev-step").on("click", function(){
                if(currentStep === 3){
                    // on quitte le récap, synchroniser les valeurs
                    syncRecapBackToSteps();
                }
                currentStep--;
                if(currentStep < 0) currentStep = 0;
                showStep(currentStep);
            });

            // Coche → afficher/masquer upload
            $(document).on("change", ".doc-check, .rap-check, .jt-check", function(){
                toggleUploadByCheckbox($(this));
                rebuildPreviewGallery();
            });

            // Upload → reconstruire miniatures
            $(document).on("change", ".file-input", function(){
                rebuildPreviewGallery();
            });

            // Init
            showStep(currentStep);
        });
    </script>

@endsection
--}}

@extends('welcome')
@section('scripts_up')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/multi_step_form.js') }}"></script>
    <style>
        .step-circle {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
@endsection

@section('title', 'collecte de donnees')
@section('content')<br><br><br><br>
<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center mt-3">
    <div class="col-lg-10 col-md-12 col-12">
        <div class="card shadow-lg border-0 rounded-4">

            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <script>
                    Swal && Swal.fire({
                        icon: 'error',
                        title: 'Erreur de validation',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            <!-- HEADER -->
            <div class="card-header bg-success text-white text-center rounded-top-4">
                 <h4 class="fw-bold my-2">FORMULAIRE DE DEMANDE D'ATTESTATION DE FIN DE STAGE N° {{$n}}</h4>
            </div>

            <div class="card-body p-4">
                <div class="p-3 mb-4 bg-light rounded-3 border">
                    <p class="mb-0" style="font-size: 0.9rem; line-height: 1.5;">
                        Ce formulaire est destiné à la collecte de vos informations personnelles dans l'unique but du traitement de votre demande d'attestation de fin de stage au titre de l'année 2025. Il demeure ouvert jusqu'au 31 octobre 2025 à 17 heures au plus tard.
                        <br>
                        <b>Le Secrétariat du Contrôleur National de Stage du BENIN.</b>
                    </p>
                </div>

                <!-- Indicateur d'étapes -->
                <div class="d-flex justify-content-center mb-4" id="steps-indicator">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle step-circle bg-danger text-white d-flex justify-content-center align-items-center"
                             style="width:40px; height:40px;">1</div>
                        <span class="ms-2 fw-bold text-danger">Informations Du Stagiaire</span>
                    </div>
                    <div class="d-flex align-items-center ms-4">
                        <div class="rounded-circle step-circle bg-secondary text-white d-flex justify-content-center align-items-center"
                             style="width:40px; height:40px;">2</div>
                        <span class="ms-2 text-secondary">Informations sur le Stage</span>
                    </div>
                    <div class="d-flex align-items-center ms-4">
                        <div class="rounded-circle step-circle bg-secondary text-white d-flex justify-content-center align-items-center"
                             style="width:40px; height:40px;">3</div>
                        <span class="ms-2 text-secondary">Obligations de Stage</span>
                    </div>
                    <div class="d-flex align-items-center ms-4">
                        <div class="rounded-circle step-circle bg-secondary text-white d-flex justify-content-center align-items-center"
                             style="width:40px; height:40px;">4</div>
                        <span class="ms-2 text-secondary">Récapitulatif</span>
                    </div>
                </div>

                <!-- Formulaire -->
                <form method="POST" action="{{ route('stage_store_collecte_donnees') }}" id="multi-step-form" enctype="multipart/form-data">
                    @csrf

                    <h4 class="fw-bold my-2" style="display: none">FORMULAIRE DE DEMANDE D'ATTESTATION DE FIN DE STAGE
                            N° <input type="text" name="numerodemande" id="numerodemande" value="{{$n}}" class="bg-success text-light" style="border: none" readonly>
                    </h4>
                    <!-- ================== ÉTAPE 1 ================== -->
                    <div class="form-step active">
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="civilite" id="civiliteM" value="M" required>
                                <label class="form-check-label fw-bold" for="civiliteM">M</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="civilite" id="civiliteMme" value="Mme" required>
                                <label class="form-check-label fw-bold" for="civiliteMme">Mme</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="civilite" id="civiliteMlle" value="Mlle" required>
                                <label class="form-check-label fw-bold" for="civiliteMlle">Mlle</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="matriculestagiaire" class="form-label"><strong>N° Matricule</strong></label>
                                <input type="text" name="matriculestagiaire" id="matriculestagiaire" value="{{ old('matriculestagiaire') }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4">
                                <label for="nomstagiaire" class="form-label"><strong>Nom</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="nomstagiaire" id="nomstagiaire" value="{{ old('nomstagiaire') }}" class="form-control form-control-sm text-uppercase" required>
                            </div>
                            <div class="col-md-4">
                                <label for="prenomstagiaire" class="form-label"><strong>Prénom</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="prenomstagiaire" id="prenomstagiaire" value="{{ old('prenomstagiaire') }}" class="form-control form-control-sm text-capitalize" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="lieunaissance" class="form-label"><strong>Lieu de Naissance</strong><span class="text-danger"> *</span></label>
                                <input type="text" name="lieunaissance" id="lieunaissance" value="{{ old('lieunaissance') }}" class="form-control form-control-sm text-capitalize" required>
                            </div>
                            <div class="col-md-4">
                                <label for="nationalite" class="form-label"><strong>Nationalité</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="nationalite" id="nationalite" value="{{ old('nationalite') }}" class="form-control form-control-sm text-capitalize" required>
                            </div>
                            <div class="col-md-4">
                                <label for="adresse" class="form-label"><strong>Adresse</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}" class="form-control form-control-sm text-capitalize" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="datenaissance" class="form-label"><strong>Date Naissance</strong><span class="text-danger"> *</span></label>
                                <input type="date" name="datenaissance" id="datenaissance" max="{{ date('Y-m-d') }}" value="{{ old('datenaissance') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-4">
                                <label for="phonecontact" class="form-label"><strong>Télephone</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="phonecontact" id="phonecontact" value="{{ old('phonecontact') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label"><strong>Email</strong> <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-danger next-step">Suivant</button>
                        </div>
                    </div>

                    <!-- ================== ÉTAPE 2 ================== -->
                    <div class="form-step d-none">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="datedebutstage" class="form-label"><strong>Date Debut Stage</strong><span class="text-danger"> *</span></label>
                                <input type="date" name="datedebutstage" id="datedebutstage" max="{{ date('Y-m-d') }}" value="{{ old('datedebutstage') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-4">
                                <label for="datefinstage" class="form-label"><strong>Date Fin Stage</strong> <span class="text-danger">*</span></label>
                                <input type="date" name="datefinstage" id="datefinstage" max="{{ date('Y-m-d') }}" value="{{ old('datefinstage') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-4" style="display:none">
                                <label for="nomcontrolleurstage" class="form-label"><strong>Nom Contrôleur Stage</strong></label>
                                <input type="text" name="nomcontrolleurstage" id="nomcontrolleurstage" value="{{ old('nomcontrolleurstage') }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4">
                                <label for="prenomcontrolleurstage" class="form-label"><strong>Nom & Prénom Contrôleur Stage</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="prenomcontrolleurstage" id="prenomcontrolleurstage" value="{{ old('prenomcontrolleurstage') }}" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <h5 class="text-danger mb-3 text-center text-decoration-underline">Maître de Stage</h5>
                            <div class="col-md-6" style="display:none">
                                <label for="nomaitrestage" class="form-label"><strong>Nom</strong></label>
                                <input type="text" name="nomaitrestage" id="nomaitrestage" value="{{ old('nomaitrestage') }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6">
                                <label for="prenomaitrestage" class="form-label"><strong>Nom & Prénom</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="prenomaitrestage" id="prenomaitrestage" value="{{ old('prenomaitrestage') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label for="orderaffimaitstage" class="form-label"><strong>Ordre D'Affiliation</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="orderaffimaitstage" id="orderaffimaitstage" value="{{ old('orderaffimaitstage') }}" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="numeroaffimaitstage" class="form-label"><strong>N° D'Affiliation</strong><span class="text-danger"> *</span></label>
                                <input type="text" name="numeroaffimaitstage" id="numeroaffimaitstage" value="{{ old('numeroaffimaitstage') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label for="dateaffimaitstage" class="form-label"><strong>Date D'Affiliation</strong> <span class="text-danger">*</span></label>
                                <input type="date" name="dateaffimaitstage" id="dateaffimaitstage" max="{{ date('Y-m-d') }}" value="{{ old('dateaffimaitstage') }}" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <h6 class="text-danger mb-3 text-center text-decoration-underline">Structure d'accueil du stage</h6>
                            <div class="col-md-3">
                                <label for="raisonsociastructure" class="form-label"><strong>Raison sociale</strong><span class="text-danger"> *</span></label>
                                <input type="text" name="raisonsociastructure" id="raisonsociastructure" value="{{ old('raisonsociastructure') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-3">
                                <label for="ordreaffilistructure" class="form-label"><strong>Ordre d'Affiliation</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="ordreaffilistructure" id="ordreaffilistructure" value="{{ old('ordreaffilistructure') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-3">
                                <label for="numeroaffilistructure" class="form-label"><strong>N° d'Affiliation</strong><span class="text-danger"> *</span></label>
                                <input type="text" name="numeroaffilistructure" id="numeroaffilistructure" value="{{ old('numeroaffilistructure') }}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-3">
                                <label for="dateaffilistructure" class="form-label"><strong>Date d'Affiliation</strong> <span class="text-danger">*</span></label>
                                <input type="date" name="dateaffilistructure" id="dateaffilistructure" max="{{ date('Y-m-d') }}" value="{{ old('dateaffilistructure') }}" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="text-center mx-5">
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="button" class="btn btn-danger next-step">Suivant</button>
                        </div>
                    </div>

                    <!-- ================== ÉTAPE 3 ================== -->
                    <div class="form-step d-none">
                        <p class="text-center fw-lighter">Veuillez fournir les éléments demandés. (PDF/JPG/PNG). Tous les champs (dates et rapports) des sections 3.2 et 3.3 sont <b>obligatoires</b>.</p>

                        <!-- 3.1 CONDITIONS D'ENTREE EN STAGE (facultatif si non coché) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-decoration-underline">3.1 - CONDITIONS D'ENTRÉE EN STAGE</label>
                            <div class="row gy-2">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input doc-check" type="checkbox" id="chk_decharge" name="conditions[]" value="decharge" data-target="#up_decharge">
                                        <label class="form-check-label" for="chk_decharge">Décharge / Acceptation de l'Ordre</label>
                                    </div>
                                    <div id="up_decharge" class="d-none mt-2">
                                        <input type="file" name="file_decharge" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Décharge / Acceptation">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input doc-check" type="checkbox" id="chk_convenstage" name="conditions[]" value="convenstage" data-target="#up_convenstage">
                                        <label class="form-check-label" for="chk_convenstage">Convention de stage</label>
                                    </div>
                                    <div id="up_convenstage" class="d-none mt-2">
                                        <input type="file" name="file_convenstage" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Convention de stage">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input doc-check" type="checkbox" id="chk_convencnss" name="conditions[]" value="convencnss" data-target="#up_convencnss">
                                        <label class="form-check-label" for="chk_convencnss">Carte CNSS</label>
                                    </div>
                                    <div id="up_convencnss" class="d-none mt-2">
                                        <input type="file" name="file_convencnss" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Carte CNSS">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3.2 RAPPORTS DE STAGE (tous requis) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-decoration-underline">3.2 - RAPPORTS DE STAGE</label>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="2">Année 1</th>
                                            <th colspan="2">Année 2</th>
                                            <th colspan="2">Année 3</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Joindre rapport</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Semestre 1</strong></td>
                                            <td><input type="date" name="rapport_a1_s1_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            
                                            <td><input type="file" name="rapport_a1_s1_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Rapport Année 1 - Semestre 1" required></td>

                                            <td><input type="date" name="rapport_a2_s1_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="file" name="rapport_a2_s1_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Rapport Année 2 - Semestre 1" required></td>
                                            <td><input type="date" name="rapport_a3_s1_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="file" name="rapport_a3_s1_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Rapport Année 3 - Semestre 1" required></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Semestre 2</strong></td>
                                            <td><input type="date" name="rapport_a1_s2_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="file" name="rapport_a1_s2_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Rapport Année 1 - Semestre 2" required></td>
                                            <td><input type="date" name="rapport_a2_s2_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="file" name="rapport_a2_s2_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Rapport Année 2 - Semestre 2" required></td>
                                            <td><input type="date" name="rapport_a3_s2_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="file" name="rapport_a3_s2_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="Rapport Année 3 - Semestre 2" required></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 3.3 JOURNÉES TECHNIQUES (toutes requises) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-decoration-underline">3.3 - Journées techniques de stage</label>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="3">Année 1</th>
                                            <th colspan="3">Année 2</th>
                                            <th colspan="3">Année 3</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Lieu</th>
                                            <th>Joindre rapport</th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Lieu</th>
                                            <th>Joindre rapport</th>
                                            <th>Date de dépôt à l'Ordre</th>
                                            <th>Lieu</th>
                                            <th>Joindre rapport</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Session 1</strong></td>
                                            <td><input type="date" name="jt_a1_s1_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>

                                            <td><input type="text" name="jt_a1_s1_lieu" class="form-control" placeholder="JT lieu" style="width: 100px;" required></td>

                                            <td><input type="file" name="jt_a1_s1_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 1 - Session 1" required></td>

                                            <td><input type="date" name="jt_a2_s1_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>

                                            <td><input type="text" name="jt_a2_s1_lieu" class="form-control" data-label="JT lieu" style="width: 100px;" required></td>

                                            <td><input type="file" name="jt_a2_s1_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 2 - Session 1" required></td>
                                            <td><input type="date" name="jt_a3_s1_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>

                                            <td><input type="text" name="jt_a3_s1_lieu" class="form-control" data-label="JT lieu" style="width: 100px;" required></td>

                                            <td><input type="file" name="jt_a3_s1_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 3 - Session 1" required></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Session 2</strong></td>
                                            <td><input type="date" name="jt_a1_s2_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>

                                            <td><input type="text" name="jt_a1_s2_lieu" class="form-control" data-label="JT lieu" style="width: 100px;" required></td>

                                            <td><input type="file" name="jt_a1_s2_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 1 - Session 2" required></td>
                                            <td><input type="date" name="jt_a2_s2_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>

                                            <td><input type="text" name="jt_a2_s2_lieu" class="form-control" data-label="JT lieu" style="width: 100px;" required></td>

                                            <td><input type="file" name="jt_a2_s2_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 2 - Session 2" required></td>
                                            <td><input type="date" name="jt_a3_s2_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="text" name="jt_a3_s2_lieu" class="form-control" data-label="JT lieu" style="width: 100px;" required></td>

                                            <td><input type="file" name="jt_a3_s2_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 3 - Session 2" required></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Session 3</strong></td>
                                            <td><input type="date" name="jt_a1_s3_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="text" name="jt_a1_s3_lieu" class="form-control" data-label="JT lieu" style="width: 100px;" required></td>
                                            <td><input type="file" name="jt_a1_s3_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 1 - Session 3" required></td>
                                            <td><input type="date" name="jt_a2_s3_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="text" name="jt_a2_s3_lieu" class="form-control" data-label="JT lieu" required></td>
                                            <td><input type="file" name="jt_a2_s3_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 2 - Session 3" required></td>
                                            <td><input type="date" name="jt_a3_s3_date" class="form-control" max="{{ date('Y-m-d') }}" required></td>
                                            <td><input type="text" name="jt_a3_s3_lieu" class="form-control" data-label="JT lieu" required></td>
                                            <td><input type="file" name="jt_a3_s3_file" class="form-control file-input" accept=".pdf,.jpg,.jpeg,.png" data-label="JT Année 3 - Session 3" required></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Galerie de prévisualisation -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Aperçu des fichiers sélectionnés</label>
                            <div id="previewZone" class="row g-3"></div>
                            <small class="text-muted">Les images s’affichent en miniature. Pour les PDF, une icône avec le nom du fichier est affichée.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="button" class="btn btn-danger next-step">Suivant</button>
                        </div>
                    </div>

                    <!-- ================== ÉTAPE 4 (Récapitulatif) ================== -->
                    <div class="form-step d-none">
                        <p class="mb-2">Vous pouvez corriger les informations avant de soumettre. Les fichiers apparaissent en bas (modification via l’étape 3).</p>

                        <h6 class="text-danger">Informations (ÉTAPES 1 & 2) — modifiables</h6>
                        <div id="recap-fields" class="row g-3"></div>

                        <hr class="my-3">

                        <h6 class="text-danger">Obligations (ÉTAPE 3) — dates et cases modifiables</h6>
                        <div id="recap-step3" class="row g-3"></div>

                        <hr class="my-3">

                        <h6 class="mb-2">Fichiers sélectionnés (ÉTAPE 3)</h6>
                        <div id="recapFiles" class="row g-3"></div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="goto-step3">Modifier les fichiers (retour Étape 3)</button>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="submit" class="btn btn-success">Soumettre</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<br><br><br>

    <script>
        $(function(){
            let currentStep = 0;
            const $steps   = $(".form-step");
            const $circles = $(".step-circle");

            function showStep(index){
                $steps.addClass("d-none").removeClass("active");
                $steps.eq(index).removeClass("d-none").addClass("active");
                $circles.removeClass("bg-danger").addClass("bg-secondary");
                for(let i=0;i<=Math.min(index,3);i++){
                    $circles.eq(i).removeClass("bg-secondary").addClass("bg-danger");
                }
            }

            // ------------ VALIDATIONS ------------
            function validateRequiredInputs($scope){
                let valid = true;

                // Radios (par groupe de name) : au moins une option cochée si required
                const radioNames = new Set();
                $scope.find('input[type="radio"][required]').each(function(){ radioNames.add($(this).attr('name')); });
                radioNames.forEach(function(n){
                    if($scope.find(`input[type="radio"][name="${n}"]:checked`).length === 0){
                        valid = false;
                        // on marque visuellement tout le groupe
                        $scope.find(`input[type="radio"][name="${n}"]`).addClass("is-invalid");
                    }else{
                        $scope.find(`input[type="radio"][name="${n}"]`).removeClass("is-invalid");
                    }
                });

                // Autres champs requis (text/date/email/etc.)
                $scope.find('input[required]:not([type="radio"]):not([type="file"])').each(function(){
                    if(!$(this).val()){
                        $(this).addClass("is-invalid");
                        valid = false;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                // Fichiers requis (Étape 3)
                $scope.find('input[type="file"][required]').each(function(){
                    if(!(this.files && this.files.length)){
                        $(this).addClass("is-invalid");
                        valid = false;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                return valid;
            }

            function validateStep(index){
                // Étape 1 & 2 : champs requis
                if(index === 0 || index === 1){
                    return validateRequiredInputs($steps.eq(index));
                }
                // Étape 3 : toutes les dates & fichiers requis doivent être remplis
                if(index === 2){
                    return validateRequiredInputs($steps.eq(2));
                }
                return true;
            }

            // ------------ RÉCAP ------------
            function buildRecap(){
                // Désactiver les inputs originaux des étapes 1 & 2 (évite doublons à la soumission)
                const $s12 = $steps.eq(0).add($steps.eq(1));
                $s12.find("input, select, textarea").prop("disabled", true);

                // 1/2 — construire des champs modifiables (avec le même "name")
                const fields = [];
                $s12.find("input, select, textarea").each(function(){
                    const $el = $(this);
                    const type = ($el.attr("type") || "").toLowerCase();
                    const name = $el.attr("name");
                    if(!name || name === '_token') return;

                    // label heuristique
                    let label = $el.closest('.col-md-3, .col-md-4, .col-md-6, .col-md-12, .mb-3, .row')
                                .find("label[for='"+$el.attr("id")+"'], label.form-label, strong").first().text().trim();
                    if(!label){ label = name; }

                    // radios : ne garder que la valeur cochée
                    if(type === 'radio'){
                        if(!$(`input[type="radio"][name="${name}"]:checked`).length) return;
                        if(fields.some(f => f.name === name)) return; // une seule ligne par groupe
                        const value = $(`input[type="radio"][name="${name}"]:checked`).val();
                        fields.push({name, label, value, inputType: 'text'});
                        return;
                    }

                    // éviter de reprendre les fichiers
                    if(type === 'file') return;

                    fields.push({name, label, value: $el.val(), inputType: (type || 'text')});
                });

                $("#recap-fields").empty();
                fields.forEach(f=>{
                    $("#recap-fields").append(`
                        <div class="col-12 col-md-3">
                            <label class="form-label"><b>${f.label}</b></label>
                            <input type="${f.inputType}" class="form-control form-control-sm recap-input"
                                data-name="${f.name}" name="${f.name}" value="${$('<div/>').text(f.value ?? '').html()}">
                        </div>
                    `);
                });

                // Étape 3 — miroirs (sans name) pour dates/checkbox (les fichiers sont listés à part)
                $("#recap-step3").empty();

                // 3.a — dates (rapports & journées techniques)
                $steps.eq(2).find('input[type="date"]').each(function(){
                    const $el = $(this);
                    const name = $el.attr('name');
                    let label = name;
                    // label plus propre
                    const cellLabel = $el.closest('td').prevAll('td:first').text().trim(); // "Semestre 1"/"Session 1"
                    const header = $el.closest('table').find('thead tr:eq(1) th').eq($el.closest('td')[0].cellIndex).text().trim(); // "Date..."
                    const yearHdr = $el.closest('table').find('thead tr:eq(0) th').eq($el.closest('td')[0].cellIndex).text().trim();
                    if(cellLabel) label = `${cellLabel} — ${yearHdr || ''} ${header ? ' / '+header : ''}`;

                    $("#recap-step3").append(`
                        <div class="col-12 col-md-3">
                            <label class="form-label"><b>${label}</b></label>
                            <input type="date" class="form-control form-control-sm recap-mirror" data-name="${name}" value="${$el.val()}">
                        </div>
                    `);
                });

                // 3.b — checkboxes (conditions d'entrée)
                $steps.eq(2).find('input[type="checkbox"]').each(function(){
                    const $el = $(this);
                    const name = $el.attr('name');
                    const label = $el.closest('.form-check').find('label').text().trim() || name;
                    const checked = $el.is(':checked') ? 'checked' : '';
                    $("#recap-step3").append(`
                        <div class="col-12 col-md-3 d-flex align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input recap-mirror-check" data-name="${$el.attr('id')}" ${checked} id="rec_${$el.attr('id')}">
                                <label class="form-check-label" for="rec_${$el.attr('id')}">${label}</label>
                            </div>
                        </div>
                    `);
                });

                // Miroirs -> original (dates/checkbox)
                $(document).off('input.recapMirror change.recapMirror');
                $(document).on('input.recapMirror change.recapMirror', '.recap-mirror', function(){
                    const n = $(this).data('name');
                    $(`input[name="${n}"]`).val($(this).val());
                });
                $(document).on('change.recapMirror', '.recap-mirror-check', function(){
                    const origId = $(this).data('name');
                    const $orig = $('#'+origId);
                    $orig.prop('checked', $(this).is(':checked')).trigger('change');
                });

                // FICHIERS
                $("#recapFiles").empty();
                rebuildPreviewGallery("#recapFiles");
            }

            function syncRecapBackToSteps(){
                // Copier valeurs modifiées (1 & 2) vers les champs originaux
                $(".recap-input").each(function(){
                    const name = $(this).data("name");
                    const val  = $(this).val();
                    const $targets = $(`input[name="${name}"], select[name="${name}"], textarea[name="${name}"]`).not($(this));
                    if($targets.is('[type=radio]')){
                        $targets.prop('checked', false)
                                .filter(`[value="${val}"]`).prop('checked', true);
                    }else{
                        $targets.val(val);
                    }
                });
                // Réactiver inputs originaux 1 & 2
                $steps.eq(0).add($steps.eq(1)).find("input, select, textarea").prop("disabled", false);
            }

            // ------------ PREVIEWS ------------
            function previewCardHtml(src, isPdf, label, filename){
                if(isPdf){
                    return `
                    <div class="col-6 col-md-3">
                    <div class="border rounded-3 p-2 h-100 d-flex flex-column align-items-center">
                        <div style="font-size:48px;line-height:1">📄</div>
                        <div class="small text-center mt-2">${label}</div>
                        <div class="small text-muted text-center">${filename}</div>
                    </div>
                    </div>`;
                }else{
                    return `
                    <div class="col-6 col-md-3">
                    <div class="border rounded-3 p-2 h-100 d-flex flex-column align-items-center">
                        <img src="${src}" class="img-fluid rounded" style="max-height:120px;object-fit:contain;">
                        <div class="small text-center mt-2">${label}</div>
                        <div class="small text-muted text-center">${filename}</div>
                    </div>
                    </div>`;
                }
            }

            function rebuildPreviewGallery(targetSelector){
                const $container = $(targetSelector || "#previewZone");
                $container.empty();

                $(".file-input").each(function(){
                    const files = this.files;
                    if(!files || !files.length) return;
                    const label = $(this).data("label") || $(this).attr("name");
                    const file  = files[0];
                    const name  = (file.name || '').toLowerCase();
                    const isPdf = name.endsWith(".pdf");

                    if(isPdf){
                        $container.append(previewCardHtml("", true, label, file.name));
                    }else{
                        const reader = new FileReader();
                        reader.onload = (e)=> $container.append(previewCardHtml(e.target.result, false, label, file.name));
                        reader.readAsDataURL(file);
                    }
                });
            }

            // ------------ NAVIGATION ------------
            $(".next-step").on("click", function(){
                if(!validateStep(currentStep)){
                    alert("Veuillez compléter correctement cette étape (tous les champs requis).");
                    return;
                }
                currentStep++;
                if(currentStep >= $steps.length) currentStep = $steps.length - 1;

                if(currentStep === 3){ buildRecap(); }
                showStep(currentStep);
            });

            $(".prev-step").on("click", function(){
                if(currentStep === 3){ syncRecapBackToSteps(); }
                currentStep--;
                if(currentStep < 0) currentStep = 0;
                showStep(currentStep);
            });

            $("#goto-step3").on("click", function(){
                if(currentStep === 3){ syncRecapBackToSteps(); }
                currentStep = 2;
                showStep(currentStep);
            });

            // Coche → afficher/masquer upload (3.1)
            $(document).on("change", ".doc-check", function(){
                const target = $(this).data("target");
                if($(this).is(":checked")){
                    $(target).removeClass("d-none");
                }else{
                    $(target).find('input[type="file"]').val("").removeClass("is-invalid");
                    $(target).addClass("d-none");
                }
                rebuildPreviewGallery();
            });

            // Upload → reconstruire miniatures
            $(document).on("change", ".file-input", function(){
                rebuildPreviewGallery();
            });

            // Init
            showStep(currentStep);
        });
    </script>
@endsection

