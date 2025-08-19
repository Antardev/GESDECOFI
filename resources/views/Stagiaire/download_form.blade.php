@extends('welcome')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">{{ __('down_form.download_form') }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif --}}
                @error('email')
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <span>{{ $message }}</span>
                        </ul>
                    </div>
                @enderror

                @if(isset($matricule))
                    <form action="{{ route('stagiaire.update') }}" method="POST">
                @else
                        <form action="{{ route('stagiaire.create') }}" method="POST">
                    @endif
                        @csrf

                        <div class="modal-header bg-primary text-white">
                            <h3 class="modal-title font-bold py-2">
                                <i class="align-middle me-2 py-2" data-feather="file-text"></i>
                                {{ __('down_form.registration_procedure') }}
                            </h3>
                            <i class="align-middle me-2 py-2 text-white" data-feather="alert-circle"></i>
                        </div>

                        <div class="modal-body">
                            <div class="card shadow-sm">
                                <div class="card-body text-center p-4">
                                    <h2 class="mb-4">{{ __('down_form.signup_and_download') }}</h2>
                                    <p class="text-muted mb-4">
                                        {{ __('down_form.fill_form') }}
                                    </p>

                                    <hr class="my-4">

                                    @php
                                        $defaultEmail = auth()->user()->email ?? '';
                                        $fields = [
                                            'firstname' => old('firstname', $firstname ?? ''),
                                            'name' => old('name', $name ?? ''),
                                            'email' => old('email', $defaultEmail),
                                            'phone_number' => old('phone_number', $phone_number ?? ''),
                                            'birth_date' => old('birth_date', $birth_date ?? ''),
                                            'lieu' => old('lieu', $lieu ?? ''),
                                            'Nationalite' => old('Nationalite', $Nationalite ?? ''),
                                            'country' => old('country', $country ?? ''),
                                            'matricule' => $matricule ?? '',
                                        ];
                                    @endphp

                                    @if(isset($matricule))
                                        <input type="text" class="form-control" id="matricule" name="matricule"
                                            value="{{ $fields['matricule'] }}" hidden>
                                    @endif


                                    <div class="mb-3 text-start">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label"> <strong>
                                                        {{ __('down_form.name') }}</strong></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    id="name" name="name" value="{{ $fields['name'] }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="firstname" class="form-label"> <strong>
                                                        {{ __('down_form.firstname') }}</strong></label>
                                                <input type="text"
                                                    class="form-control @error('firstname') is-invalid @enderror"
                                                    id="firstname" name="firstname" value="{{ $fields['firstname'] }}"
                                                    required>
                                                @error('firstname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="mb-3 text-start">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="country" class="form-label"> <strong>
                                                        {{ __('down_form.country_of_affiliation') }}</strong></label>
                                                <select name="country"
                                                    class="form-control @error('country') is-invalid @enderror" id="country"
                                                    required>
                                                    <option value="">{{ __('down_form.select_country') }}</option>
                                                    @foreach(__('message.countries_phone') as $code => $country)
                                                        {{-- @foreach (['Benin' => 'Bénin', 'Mali' => 'Mali', 'Togo' => 'Togo',
                                                        'Burkina Faso' => 'Burkina Faso', 'Senegal' => 'Sénégal', 'Niger' =>
                                                        'Niger', 'Ivory Coast' => 'Côte d\'ivoire'] as $key => $countryName)
                                                        <option value="{{ $key }}" {{ $fields['country']==$key ? 'selected' : ''
                                                            }}>{{ $countryName }}</option>--}}

                                                        <option value="{{ $country['code'] }}" {{ $fields['country'] == $country['code'] ? 'selected' : '' }}>
                                                            {{ $country['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                @error('country')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">
                                                    <strong>{{ __('down_form.email') }}</strong></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ $fields['email'] }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="mb-3 text-start">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="birth_date" class="form-label"> <strong>
                                                        {{ __('down_form.birth_date') }} </strong></label>
                                                <input type="date"
                                                    class="form-control @error('birth_date') is-invalid @enderror"
                                                    id="birth_date" name="birth_date" value="{{ $fields['birth_date'] }}"
                                                    max="{{ date('Y-m-d') }}" required>
                                                @error('birth_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="col-md-6">
                                                <label for="lieu" class="form-label"><strong>Lieu de
                                                        naissance</strong></label>
                                                <select class="form-control @error('lieu') is-invalid @enderror" id="lieu"
                                                    name="lieu" required>
                                                    <option value="">-- {{ __('Sélectionnez un pays') }} --</option>
                                                    @foreach(trans('countries') as $country)
                                                        <option value="{{ $country }}" {{ old('lieu', $fields['lieu']) == $country ? 'selected' : '' }}>
                                                            {{ $country }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('lieu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                        <div class="mb-3 text-start">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Nationalite" class="form-label"> <strong>
                                                            Nationalité</strong></label>
                                                    <input type="text"
                                                        class="form-control @error('Nationalite') is-invalid @enderror"
                                                        id="Nationalite" name="Nationalite"
                                                        value="{{ $fields['Nationalite'] }}" required>
                                                    @error('Nationalite')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="phone_number" class="form-label"> <strong>
                                                            {{ __('down_form.phone_number') }} </strong></label>
                                                    <input type="tel"
                                                        class="form-control @error('phone_number') is-invalid @enderror"
                                                        id="phone_number" name="phone_number"
                                                        value="{{ $fields['phone_number'] }}" required>
                                                    @error('phone_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>

                                        </div>

                                        <div class="text-center">
                                              <button type="submit" class="btn btn-primary btn-lg">
                                            {{ __('message.save') }}
                                        </button>
                                        </div>
                                      

                                        <div class="documents-requis mt-5 text-start">
                                            <h4 class="mb-4 text-center">
                                                <i class="align-middle me-2" data-feather="folder"></i>
                                                {{ __('down_form.required_documents') }}
                                            </h4>

                                            <div class="alert alert-warning">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                {{ __('down_form.documents_info') }}
                                            </div>

                                            <div class="mt-4 p-3 bg-light rounded">
                                                <h5 class="mb-3">
                                                    <i class="bi bi-files me-2"></i>{{ __('Documents à joindre') }}
                                                </h5>
                                                <ol>
                                                    <li class="mb-2">Formulaire de préinscription</li>
                                                    <li class="mb-2">Décharge de la demande d'inscription en stage adressée
                                                        au Président de l'Ordre</li>
                                                    <li class="mb-2">Attestation d'acceptation en stage du Maître de Stage
                                                    </li>
                                                    <li class="mb-2">Engagement durement signé du stagiaire et de son Maître
                                                        de Stage</li>
                                                    <li class="mb-2">Attestation de réussite du DESCOGEF</li>
                                                    <li class="mb-2">Carte d'Identité Nationale ou Passeport</li>
                                                    <li class="mb-2">Certificat de résidence du lieu d'implantation du
                                                        bureau de son Maître de Stage</li>
                                                    <li class="mb-2">Contrat de travail signé par le Maître de Stage</li>
                                                    <li class="mb-2">Extrait de casier judiciaire</li>
                                                    <li class="mb-2">Carte CNSS</li>
                                                    <li class="mb-2">Photo d'identité</li>
                                                </ol>
                                            </div>

                                            <div class="mt-4 p-3 bg-light rounded">
                                                <h5 class="mb-3">
                                                    <i
                                                        class="bi bi-send-check me-2"></i>{{ __('down_form.submission_procedure') }}
                                                </h5>
                                                <ol>
                                                    <li class="mb-2">{{ __('down_form.gather_documents') }}</li>
                                                    <li class="mb-2">{{ __('down_form.scan_documents') }}</li>
                                                    <li class="mb-2">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#ajouterModal"
                                                            title="{{ __('down_form.submit_folder') }}">
                                                            {{ __('down_form.submit_full_folder') }}
                                                        </a>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>

                                        <div class="alert alert-info mt-4">
                                            <i class="bi bi-info-circle me-2"></i>
                                            {{ __('down_form.contact_info') }}
                                            <a href="{{ route('NousContacter') }}">{{ __('down_form.contact_us') }}</a> |
                                            Tél : 01 23 45 67 89
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection