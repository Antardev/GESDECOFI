@extends('welcome')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <h1 class="text-center">{{ __('sign_stage.submit_my_form') }}</h1>

                <form action="{{ route('stagiaire.edit') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="matricule" class="form-label">{{ __('sign_stage.your_matricule') }}</label>
                        <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule" name="matricule" value="{{ old('matricule') }}" required maxlength="14" onblur="fetchData()">
                        @error('matricule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="user-info" style="display: {{ $errors->any() ? 'block' : 'none' }};">
                        <h5> <strong>{{ __('sign_stage.user_info') }}
                            </strong>
                         </h5>
                        <div class=" row mb-3">
                            <div class="col-md-6"><div class="input-group">
                                <span class="input-group-text">Prénom</span>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname"
                                    value="{{ old('firstname') }}" readonly>
                            </div>
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror</div>

                            <div class="col-md-6"><div class="input-group">
                                <span class="input-group-text">{{ __('sign_stage.name') }}</span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                    value="{{ old('name') }}" readonly>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror</div>
                        </div>


                        <div class=" row mb-3">

                           <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">{{ __('sign_stage.birth_date') }}</span>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" 
                                        name="birth_date" value="{{ old('birth_date') }}" max="{{ date('Y-m-d') }}" readonly>
                                </div>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">{{ __('sign_stage.country_of_affiliation') }}</span>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" 
                                        name="country" value="{{ old('country') }}" readonly>
                                </div>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class=" row mb-3">

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">Nationalite</span>
                                    <input type="text" class="form-control @error('Nationalite') is-invalid @enderror" id="Nationalite" 
                                        name="Nationalite" value="{{ old('Nationalite') }}" readonly>
                                </div>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="col-md-6">
                                 <div class="input-group">
                                <span class="input-group-text">Lieu de naissance</span>
                                <input type="text" class="form-control @error('lieu') is-invalid @enderror" id="lieu" 
                                    name="lieu" value="{{ old('lieu') }}"  readonly>
                                </div>
                                @error('lieu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class=" row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">Email</span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                        value="{{ old('email') }}" readonly>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">{{ __('sign_stage.phone') }}</span>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" 
                                        name="phone" value="{{ old('phone') }}" readonly>
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>



                        <div class="mb-3">
                            {{-- <label for="affiliation_order" class="form-label">{{ __('sign_stage.order_of_affiliation') }}</label> --}}
                            <div class="input-group">
                                <span class="input-group-text">{{ __('sign_stage.order_of_affiliation') }}</span>
                                <input type="text" class="form-control @error('affiliation_order') is-invalid @enderror" id="affiliation_order" 
                                    name="affiliation_order" value="{{ old('affiliation_order') }}" readonly>
                            </div>
                            @error('affiliation_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            {{-- <label for="phone" class="form-label">{{ __('sign_stage.phone') }}</label> --}}

                        </div>
                        <div class="mb-3">
                            {{-- <label for="numero_cnss">Numero CNSS <span class="text-small text-danger">*</span></label> --}}
                            <div class="input-group">
                                <span class="input-group-text">Numéro Sociale</span>
                                <input type="number" class="form-control @error('numero_cnss') is-invalid @enderror" id="numero_cnss" name="numero_cnss" value="{{ old('numero_cnss') }}" placeholder="Veillez renseignez votre numero sociale">
                            </div>
                            @error('numero_cnss')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cnss_card" class="form-label"><strong>Carte Sociale<span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                {{-- <span class="input-group-text"><strong></strong>Carte CNSS </span> --}}
                                <input class="form-control @error('cnss_card') is-invalid @enderror" type="file" id="cnss_card" name="cnss_card" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx" required>
                            </div>
                            @error('cnss_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="picture" class="form-label"><strong>Ma photo <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                {{-- <span class="input-group-text">Ma photo </span> --}}
                                <input type="file" class="form-control @error('picture') is-invalid @enderror" id="picture" name="picture">
                            </div>
                            @error('picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_card" class="form-label"><strong>Carte D'identité ou Passeport <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                {{-- <span class="input-group-text">Carte D'identité ou Passeport</span> --}}
                                <input class="form-control @error('id_card') is-invalid @enderror" type="file" id="id_card" name="id_card" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx" required>
                            </div>
                            @error('id_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fiche" class="form-label"><strong>Formulaire de Préinscription <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                {{-- <span class="input-group-text">Formulaire de Préinscription</span> --}}
                                <input class="form-control @error('fiche') is-invalid @enderror" type="file" id="fiche" name="fiche" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx" required>
                            </div>
                            @error('fiche')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="diplome" class="form-label"><strong>Attestation de réussite du DESCOGEF <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                {{-- <span class="input-group-text">Attestation de réussite du DESCOGEF</span> --}}
                                <input class="form-control @error('diplome') is-invalid @enderror" type="file" id="diplome" name="diplome" accept=".pdf,.doc,.docx" required>
                            </div>
                            @error('diplome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            {{-- <label for="date_obtention" class="form-label">{{ __('sign_stage.date_obtention') }} <span class="text-small text-danger">*</span></label> --}}
                            <div class="input-group">
                                <span class="input-group-text">Date d'obtention</span>
                                <input type="date" class="form-control @error('date_obtention') is-invalid @enderror" id="date_obtention" name="date_obtention" value="{{ old('date_obtention') }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                            @error('date_obtention')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="decharge" class="form-label"><strong> Décharge de la demande d’inscription en stage adressée au Président de l’Ordre <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                <input class="form-control @error('decharge') is-invalid @enderror" type="file" id="decharge" name="decharge" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx" required>
                            </div>
                            @error('decharge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="casier" class="form-label"><strong>Extrait de Casier judiciaire <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                <input class="form-control @error('casier') is-invalid @enderror" type="file" id="casier" name="casier" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx" required>
                            </div>
                            @error('casier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="residence_master" class="form-label"><strong>Certificat de résidence du lieu d’implantation du bureau de son Maître de Stage <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                <input class="form-control @error('residence_master') is-invalid @enderror" type="file" id="residence_master" name="residence_master" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx" required>
                            </div>
                            @error('residence_master')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="engagement" class="form-label"><strong>Engagement dûment signé du stagiaire et de son Maître de Stage <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                <input class="form-control @error('engagement') is-invalid @enderror" type="file" id="engagement" name="engagement" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx" required>
                            </div>
                            @error('engagement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="accept_certificat" class="form-label"><strong>Attestation d’acceptation en stage du Maître de Stage <span class="text-small text-danger">*</span></strong></label>
                            <div class="input-group">
                                <input class="form-control @error('accept_certificat') is-invalid @enderror" type="file" id="accept_certificat" name="accept_certificat" accept=".pdf,.doc,.docx" required>
                            </div>
                            @error('accept_certificat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5><strong>{{ __('sign_stage.cab_info') }}</strong></h5>

                        <div class="ms-3">
                            <div class="mb-3">
                                {{-- <label for="nom_cabinet" class="form-label">{{ __('sign_stage.nom_cabinet') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Nom du Cabinet</span>
                                    <input type="text" class="form-control @error('nom_cabinet') is-invalid @enderror" id="nom_cabinet" name="nom_cabinet" value="{{ old('nom_cabinet') }}" required>
                                </div>
                                @error('nom_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="debut_stage" class="form-label">{{ __('sign_stage.debut_stage') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Date de début de stage</span>
                                    <input type="date" name="debut_stage" class="form-control @error('debut_stage') is-invalid @enderror" id="debut_stage" value="{{ old('debut_stage') }}" max="{{ date('Y-m-d') }}" required>
                                </div>
                                @error('debut_stage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="nom_representant" class="form-label">{{ __('sign_stage.nom_representant') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Nom complet du Représentant</span>
                                    <input type="text" class="form-control @error('nom_representant') is-invalid @enderror" id="nom_representant" name="nom_representant" value="{{ old('nom_representant') }}" required>
                                </div>
                                @error('nom_representant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="email_cabinet" class="form-label">{{ __('sign_stage.email_cabinet') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">{{__('sign_stage.email_cabinet')}}</span>
                                    <input type="text" class="form-control @error('email_cabinet') is-invalid @enderror" id="email_cabinet" name="email_cabinet" value="{{ old('email_cabinet') }}" required>
                                </div>
                                @error('email_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="tel_cabinet" class="form-label">{{ __('sign_stage.tel_cabinet') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Téléphone</span>
                                    <input type="text" class="form-control @error('tel_cabinet') is-invalid @enderror" id="tel_cabinet" name="tel_cabinet" value="{{ old('tel_cabinet') }}" required>
                                </div>
                                @error('tel_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="lieu_cabinet" class="form-label">{{ __('sign_stage.lieu_cabinet') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Lieu</span>
                                    <input type="text" class="form-control @error('lieu_cabinet') is-invalid @enderror" id="lieu_cabinet" name="lieu_cabinet" value="{{ old('lieu_cabinet') }}" required>
                                </div>
                                @error('lieu_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contrat" class="form-label"><strong>Contrat de travail <span class="text-small text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <input type="file" class="form-control @error('contrat') is-invalid @enderror" name="contrat" accept=".pdf,.doc,.img">
                                </div>
                                @error('contrat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="numero_inscription_cabinet" class="form-label">{{ __('sign_stage.Numero_inscription_cabinet') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Numéro d'inscription</span>
                                    <input type="text" class="form-control @error('numero_inscription_cabinet') is-invalid @enderror" id="numero_inscription_cabinet" name="numero_inscription_cabinet" value="{{ old('numero_inscription_cabinet') }}" required>
                                </div>
                                @error('numero_inscription_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        <div class="mb-3">
                            {{-- <label for="affiliation_order" class="form-label">{{ __('sign_stage.order_of_affiliation') }}</label> --}}
                            <div class="input-group">
                                <span class="input-group-text">Ordre d'Affiliation du cabinet</span>
                                <select class="form-control form-control-lg" name="affiliation_cabinet">
                                    <option value="">{{ __('sign_c.select_affiliation') }}</option>
                                    <option value="OECCA Bénin" {{ old('affiliation_cabinet') == 'OECCA Bénin' ? 'selected' : '' }}>OECCA Bénin</option>
                                    <option value="OEC Côte d'Ivoire" {{ old('affiliation_cabinet') == "OEC Côte d'Ivoire" ? 'selected' : '' }}>OEC Côte
                                        d'Ivoire</option>
                                    <option value="ONECCA Burkina" {{ old('affiliation_cabinet') == 'ONECCA Burkina' ? 'selected' : '' }}>ONECCA Burkina
                                    </option>
                                    <option value="OECCA Guinée B" {{ old('affiliation_cabinet') == 'OECCA Guinée B' ? 'selected' : '' }}>OECCA Guinée B
                                    </option>
                                    <option value="ONECCA Niger" {{ old('affiliation_cabinet') == 'ONECCA Niger' ? 'selected' : '' }}>ONECCA Niger
                                    </option>
                                    <option value="ONECCA Mali" {{ old('affiliation_cabinet') == 'ONECCA Mali' ? 'selected' : '' }}>ONECCA Mali</option>
                                    <option value="ONECCA Sénégal" {{ old('affiliation_cabinet') == 'ONECCA Sénégal' ? 'selected' : '' }}>ONECCA Sénégal
                                    </option>
                                    <option value="ONECCA Togo" {{ old('affiliation_cabinet') == 'ONECCA Togo' ? 'selected' : '' }}>ONECCA Togo</option>
                                </select>
                            </div>
                            @error('affiliation_cabinet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                        <h5><strong>{{ __('sign_stage.master_info') }}</strong></h5>
                        <div class="ms-3">
                            <div class="mb-3">
                                {{-- <label for="nom_maitre" class="form-label">{{ __('sign_stage.nom_maitre') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Nom du Maître</span>
                                    <input type="text" class="form-control @error('nom_maitre') is-invalid @enderror" id="nom_maitre" name="nom_maitre" value="{{ old('nom_maitre') }}" required>
                                </div>
                                @error('nom_maitre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="prenom_maitre" class="form-label"><strong>{{ __('sign_stage.prenom_maitre') }} <span class="text-small text-danger">*</span></strong></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Prénom du Maître</span>
                                    <input type="text" class="form-control @error('prenom_maitre') is-invalid @enderror" id="prenom_maitre" name="prenom_maitre" value="{{ old('prenom_maitre') }}" required>
                                </div>
                                @error('prenom_maitre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="email_maitre" class="form-label">{{ __('sign_stage.email_maitre') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Email du Maître</span>
                                    <input type="text" class="form-control @error('email_maitre') is-invalid @enderror" id="email_maitre" name="email_maitre" value="{{ old('email_maitre') }}" required>
                                </div>
                                @error('email_maitre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="tel_maitre" class="form-label">{{ __('sign_stage.tel_maitre') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Téléphone</span>
                                    <input type="number" class="form-control @error('tel_maitre') is-invalid @enderror" id="tel_maitre" name="tel_maitre" value="{{ old('tel_maitre') }}" required>
                                </div>
                                @error('tel_maitre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="numero_inscription_maitre" class="form-label">{{ __('sign_stage.Numéro_Inscription_maitre') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Numéro d'Affiliation</span>
                                    <input type="text" class="form-control @error('numero_inscription_maitre') is-invalid @enderror" id="numero_inscription_maitre" name="numero_inscription_maitre" value="{{ old('numero_inscription_maitre') }}" required>
                                </div>
                                @error('numero_inscription_maitre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="debut_stage" class="form-label">{{ __('sign_stage.debut_stage') }} <span class="text-small text-danger">*</span></label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Date d'insciption à l'odre </span>
                                    <input type="date" name="date_maitre_ordre" class="form-control @error('date_maitre_ordre') is-invalid @enderror" id="date_maitre_ordre" value="{{ old('date_maitre_ordre') }}" max="{{ date('Y-m-d') }}" required>
                                </div>
                                @error('date_maitre_ordre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="mb-3">
                                <label for="contrat" class="form-label"><strong>Attestation de première affiliation à l'ordre <span class="text-small text-danger">*</span></strong></label>
                                <div class="input-group">
                                    <input type="file" class="form-control @error('attestation_maitre') is-invalid @enderror" name="attestation_maitre" accept=".pdf,.doc,.img">
                                </div>
                                @error('attestation_maitre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                {{-- <label for="affiliation_order" class="form-label">{{ __('sign_stage.order_of_affiliation') }}</label> --}}
                                <div class="input-group">
                                    <span class="input-group-text">Ordre d'Affiliation du Maitre de stage</span>
                                    <select class="form-control form-control-lg" name="affiliation_maitre">
                                        <option value="">{{ __('sign_c.select_affiliation') }}</option>
                                        <option value="OECCA Bénin" {{ old('affiliation_maitre') == 'OECCA Bénin' ? 'selected' : '' }}>OECCA Bénin</option>
                                        <option value="OEC Côte d'Ivoire" {{ old('affiliation_maitre') == "OEC Côte d'Ivoire" ? 'selected' : '' }}>OEC Côte
                                            d'Ivoire</option>
                                        <option value="ONECCA Burkina" {{ old('affiliation_maitre') == 'ONECCA Burkina' ? 'selected' : '' }}>ONECCA Burkina
                                        </option>
                                        <option value="OECCA Guinée B" {{ old('affiliation_maitre') == 'OECCA Guinée B' ? 'selected' : '' }}>OECCA Guinée B
                                        </option>
                                        <option value="ONECCA Niger" {{ old('affiliation_maitre') == 'ONECCA Niger' ? 'selected' : '' }}>ONECCA Niger
                                        </option>
                                        <option value="ONECCA Mali" {{ old('affiliation_maitre') == 'ONECCA Mali' ? 'selected' : '' }}>ONECCA Mali</option>
                                        <option value="ONECCA Sénégal" {{ old('affiliation_maitre') == 'ONECCA Sénégal' ? 'selected' : '' }}>ONECCA Sénégal
                                        </option>
                                        <option value="ONECCA Togo" {{ old('affiliation_maitre') == 'ONECCA Togo' ? 'selected' : '' }}>ONECCA Togo</option>
                                    </select>
                                </div>
                                @error('affiliation_cabinet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        </div>

                    </div>

                    @if(!$stage)
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">{{ __('sign_stage.send') }}</button>
                    </div>
                    @else
                    <div class="text-center">
                        <span id="appear" style="display: none;">
                            {{ __('sign_stage.You_have_already_submitted_a_form') }}
                        </span>
                        <br>
                        <span class="btn btn-secondary" onclick="document.getElementById('appear').style.display = 'inline';">
                            {{ __('sign_stage.send') }}
                        </span>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts_down')
<script>
    function fetchData() {
        const matricule = document.getElementById('matricule').value;
        if (matricule.length === 8) {
            fetch(`/api/stagiaire/get/${matricule}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (!data.message) {
                        document.getElementById('firstname').value = data.firstname;
                        document.getElementById('name').value = data.name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('birth_date').value = data.birthdate;
                        document.getElementById('country').value = data.country;
                        document.getElementById('affiliation_order').value = data.affiliation_order;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('lieu').value = data.lieu || ''; // Fallback si `lieu` n'existe pas
                        document.getElementById('Nationalite').value = data.Nationalite || data.nationalite || ''; // Gestion de la casse
                        document.getElementById('user-info').style.display = 'block';

                    } else {
                        alert('Ce Matricule n\'est pas le votre.');
                    }
                })
                .catch(error => console.error('Erreur:', error));
        } else {
            document.getElementById('user-info').style.display = 'none';
        }
    }
</script>
@endsection