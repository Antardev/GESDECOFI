@extends('welcome')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <h1 class="text-center">{{ __('sign_stage.submit_my_form') }}</h1>

            <form action="{{ route('stagiaire.edit') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                @method('PUT')

                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <div class="mb-3">
                    <label for="matricule" class="form-label">{{ __('sign_stage.your_matricule') }}</label>
                    <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule" name="matricule" value="{{ old('matricule') }}" required maxlength="14" onblur="fetchData()">
                    @error('matricule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="user-info" style="display: {{ $errors->any() ? 'block' : 'none' }};">
                    <h5>{{ __('sign_stage.user_info') }}</h5>

                    <div class="mb-3">
                        <label for="firstname" class="form-label">{{ __('sign_stage.firstname') }}</label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname') }}" readonly>
                        @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('sign_stage.name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" readonly>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('sign_stage.email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" readonly>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="birth_date" class="form-label">{{ __('sign_stage.birth_date') }}</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" max="{{ date('Y-m-d') }}" readonly>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">{{ __('sign_stage.country_of_affiliation') }}</label>
                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" readonly>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('sign_stage.phone') }}</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" readonly>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="numero_cnss">Numero CNSS</label>
                        <input type="number" class="form-control @error('numero_cnss') is-invalid @enderror" id="numero_cnss" name="numero_cnss" value="{{ old('numero_cnss') }}">
                        @error('numero_cnss')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="picture" class="form-label">Ma photo</label>
                        <input type="file" class="form-control @error('picture') is-invalid @enderror" id="picture" name="picture">
                        @error('picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fiche" class="form-label">{{ __('sign_stage.select_completed_form') }}</label>
                        <input class="form-control @error('fiche') is-invalid @enderror" type="file" id="fiche" name="fiche" accept=".pdf,.doc,.docx" required>
                        @error('fiche')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="diplome" class="form-label">{{ __('sign_stage.diplome') }}</label>
                        <input class="form-control @error('diplome') is-invalid @enderror" type="file" id="diplome" name="diplome" accept=".pdf,.doc,.docx" required>
                        @error('diplome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_obtention" class="form-label">{{ __('sign_stage.date_obtention') }}</label>
                        <input type="date" class="form-control @error('date_obtention') is-invalid @enderror" id="date_obtention" name="date_obtention" value="{{ old('date_obtention') }}" required>
                        @error('date_obtention')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5>{{ __('sign_stage.cab_info') }}</h5>

                    <div class="mb-3">
                        <label for="nom_cabinet" class="form-label">{{ __('sign_stage.nom_cabinet') }}</label>
                        <input type="text" class="form-control @error('nom_cabinet') is-invalid @enderror" id="nom_cabinet" name="nom_cabinet" value="{{ old('nom_cabinet') }}" required>
                        @error('nom_cabinet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="debut_stage" class="form-label">{{ __('sign_stage.debut_stage') }}</label>
                        <input type="date" name="debut_stage" class="form-control @error('debut_stage') is-invalid @enderror" id="nom_cabinet" name="nom_cabinet" value="{{ old('nom_cabinet') }}" required>
                        @error('debut_stage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nom_representant" class="form-label">{{ __('sign_stage.nom_cabinet') }}</label>
                        <input type="text" class="form-control @error('nom_representant') is-invalid @enderror" id="nom_representant" name="nom_representant" value="{{ old('nom_representant') }}" required>
                        @error('nom_representant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email_cabinet" class="form-label">{{ __('sign_stage.email_cabinet') }}</label>
                        <input type="text" class="form-control @error('email_cabinet') is-invalid @enderror" id="email_cabinet" name="email_cabinet" value="{{ old('email_cabinet') }}" required>
                        @error('email_cabinet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tel_cabinet" class="form-label">{{ __('sign_stage.tel_cabinet') }}</label>
                        <input type="text" class="form-control @error('tel_cabinet') is-invalid @enderror" id="tel_cabinet" name="tel_cabinet" value="{{ old('tel_cabinet') }}" required>
                        @error('tel_cabinet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lieu_cabinet" class="form-label">{{ __('sign_stage.lieu_cabinet') }}</label>
                        <input type="text" class="form-control @error('lieu_cabinet') is-invalid @enderror" id="lieu_cabinet" name="lieu_cabinet" value="{{ old('lieu_cabinet') }}" required>
                        @error('lieu_cabinet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contrat" class="form-label">Contrat de travail</label>
                        <input type="file" class="form-control @error('contrat') is-invalid @enderror" name="contrat" accept=".pdf,.doc,.img">
                        @error('contrat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="numero_inscription_cabinet" class="form-label">{{ __('sign_stage.Numero_inscription_cabinet') }}</label>
                        <input type="text" class="form-control @error('numero_inscription_cabinet') is-invalid @enderror" id="numero_inscription_cabinet" name="numero_inscription_cabinet" value="{{ old('numero_inscription_cabinet') }}" required>
                        @error('numero_inscription_cabinet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label for="date_entree" class="form-label">{{ __('sign_stage.date_entree') }}</label>
                        <input type="date" class="form-control @error('date_entree') is-invalid @enderror" id="date_entree" name="date_entree" value="{{ old('date_entree') }}" required>
                        @error('date_entree')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <h5>{{ __('sign_stage.master_info') }}</h5>

                    <div class="mb-3">
                        <label for="nom_maitre" class="form-label">{{ __('sign_stage.nom_maitre') }}</label>
                        <input type="text" class="form-control @error('nom_maitre') is-invalid @enderror" id="nom_maitre" name="nom_maitre" value="{{ old('nom_maitre') }}" required>
                        @error('nom_maitre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prenom_maitre" class="form-label">{{ __('sign_stage.prenom_maitre') }}</label>
                        <input type="text" class="form-control @error('prenom_maitre') is-invalid @enderror" id="prenom_maitre" name="prenom_maitre" value="{{ old('prenom_maitre') }}" required>
                        @error('prenom_maitre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tel_maitre" class="form-label">{{ __('sign_stage.tel_maitre') }}</label>
                        <input type="number" class="form-control @error('tel_maitre') is-invalid @enderror" id="tel_maitre" name="tel_maitre" value="{{ old('tel_maitre') }}" required>
                        @error('tel_maitre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="numero_inscription_maitre" class="form-label">{{ __('sign_stage.Numéro_Inscription_maitre') }}</label>
                        <input type="text" class="form-control @error('numero_inscription_maitre') is-invalid @enderror" id="numero_inscription_maitre" name="numero_inscription_maitre" value="{{ old('numero_inscription_maitre') }}" required>
                        @error('numero_inscription_maitre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ __('sign_stage.send') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts_down')
<script>
    function fetchData() {
        const matricule = document.getElementById('matricule').value;
        if (matricule.length === 14) {
            fetch(`http://192.168.100.146:8001/stagiaire/get/${matricule}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('firstname').value = data.firstname;
                        document.getElementById('name').value = data.name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('birth_date').value = data.birthdate;
                        document.getElementById('country').value = data.country;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('user-info').style.display = 'block';
                    } else {
                        alert('Matricule non trouvé.');
                    }
                })
                .catch(error => console.error('Erreur:', error));
        } else {
            document.getElementById('user-info').style.display = 'none';
        }
    }
</script>
@endsection