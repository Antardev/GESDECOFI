@extends('welcome')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">{{ __('down_form.download_form') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">

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
                                    'country' => old('country', $country ?? ''),
                                    'matricule' => $matricule ?? '',
                                ];
                            @endphp

                            @if(isset($matricule))
                                <input type="text" class="form-control" id="matricule" name="matricule" value="{{ $fields['matricule'] }}" hidden>
                            @endif

                            <div class="mb-3 text-start">
                                <label for="firstname" class="form-label">{{ __('down_form.firstname') }}</label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ $fields['firstname'] }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="name" class="form-label">{{ __('down_form.name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $fields['name'] }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="country" class="form-label">{{ __('down_form.country') }}</label>
                                <select name="country" class="form-control @error('country') is-invalid @enderror" id="country" required>
                                    <option value="">{{ __('down_form.select_country') }}</option>
                                    @foreach (['benin' => 'Bénin', 'mali' => 'Mali', 'togo' => 'Togo', 'civ' => 'Côte d\'Ivoire', 'cameroon' => 'Cameroun', 'ghana' => 'Ghana', 'senegal' => 'Sénégal'] as $key => $countryName)
                                        <option value="{{ $key }}" {{ $fields['country'] == $key ? 'selected' : '' }}>{{ $countryName }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="email" class="form-label">{{ __('down_form.email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $fields['email'] }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="birth_date" class="form-label">{{ __('down_form.birth_date') }}</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ $fields['birth_date'] }}" max="{{ date('Y-m-d') }}" required>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="phone_number" class="form-label">{{ __('down_form.phone_number') }}</label>
                                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ $fields['phone_number'] }}" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('message.save') }}
                            </button>

                            <div class="documents-requis mt-5 text-start">
                                <h4 class="mb-4 text-center">
                                    <i class="align-middle me-2" data-feather="folder"></i>
                                    {{ __('down_form.required_documents') }}
                                </h4>

                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    {{ __('down_form.documents_info') }}
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="align-middle me-2" data-feather="file-text"></i>
                                        <div>
                                            <strong>{{ __('down_form.registration_form') }}</strong>
                                            <small class="d-block text-muted">({{ __('down_form.document_download_info') }})</small>
                                        </div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="align-middle me-2" data-feather="file-text"></i>
                                        <div>
                                            <strong>{{ __('down_form.certified_copy') }}</strong>
                                            <small class="d-block text-muted">({{ __('down_form.translation_info') }})</small>
                                        </div>
                                    </li>
                                </ul>

                                <div class="mt-4 p-3 bg-light rounded">
                                    <h5 class="mb-3">
                                        <i class="bi bi-send-check me-2"></i>{{ __('down_form.submission_procedure') }}
                                    </h5>
                                    <ol>
                                        <li class="mb-2">{{ __('down_form.gather_documents') }}</li>
                                        <li class="mb-2">{{ __('down_form.scan_documents') }}</li>
                                        <li class="mb-2">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#ajouterModal" title="{{ __('down_form.submit_folder') }}">
                                                {{ __('down_form.submit_full_folder') }}
                                            </a>
                                        </li>
                                    </ol>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4">
                                <i class="bi bi-info-circle me-2"></i>
                                {{ __('down_form.contact_info') }} 
                                <a href="{{ route('NousContacter') }}">{{ __('down_form.contact_us') }}</a> | Tél : 01 23 45 67 89
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