@extends('welcome')

@section('content')
<main class="d-flex w-100">
    <div class="container d-flex flex-column ">
        <div class="row">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">{{ __('sign_c.register_as') }} {{ $type === 'CN' ? __('sign_c.national_controller') : __('sign_c.regional_controller') }}</h1>
                        <p class="lead">{{ __('sign_c.fill_form') }}</p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form method="POST" action="{{ route('controleur.store') }}">
                                    @csrf
                                    {{-- @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif --}}
                                    @if($errors->has('general'))
                                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                            <i class="align-middle me-2" data-feather="key"></i>
                                            {{ $errors->first('general') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <input type="text" name="type" value="{{ $type }}" hidden>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-label">{{ __('sign_c.name') }}</label>
                                            <input class="form-control form-control-lg" type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('sign_c.enter_name') }}" />
                                            @if($errors->has('name'))
                                                <span class="text-danger text-small">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                        <div class="col">
                                            <label class="form-label">{{ __('sign_c.firstname') }}</label>
                                            <input class="form-control form-control-lg" type="text" name="firstname" value="{{ old('firstname') }}" placeholder="{{ __('sign_c.enter_firstname') }}" />
                                            @if($errors->has('firstname'))
                                                <span class="text-danger text-small">{{ $errors->first('firstname') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-label">{{ __('sign_c.birth_date') }}</label>
                                            <input class="form-control form-control-lg" type="date" name="date" value="{{ old('date') }}" max="{{ date('Y-m-d') }}" placeholder="{{ __('sign_c.enter_birth_date') }}" />
                                            @if($errors->has('date'))
                                                <span class="text-danger text-small">{{ $errors->first('date') }}</span>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <label class="form-label">{{ __('sign_c.country') }}</label>
                                            <select class="form-control form-control-lg" name="country">
                                                <option value="">{{ __('sign_c.select_country') }}</option>
                                                @foreach (__('message.countries') as $code => $name)
                                                    <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('country'))
                                                <span class="text-danger text-small">{{ $errors->first('country') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-label">{{ __('sign_c.email') }}</label>
                                            <input class="form-control form-control-lg" type="email" name="email" value="{{ auth()->user()->email }}" placeholder="{{ __('sign_c.enter_email') }}" />
                                            @if($errors->has('email'))
                                                <span class="text-danger text-small">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <label class="form-label">{{ __('sign_c.phone') }}</label>
                                            <div class="input-group">
                                                <select class="form-select form-control-lg" name="phone_code" style="max-width: 85px; padding: 0.5rem;">
                                                    @foreach(__('message.countries_phone') as $code => $country)
                                                        <option value="{{ $country['phone_code'] }}" 
                                                                data-country="{{ $code }}"
                                                                data-flag="{{ $country['flag'] }}"
                                                                {{ old('phone_code', '+33') == $country['phone_code'] ? 'selected' : '' }}>
                                                            {{ $country['flag'] }} {{ $country['phone_code'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input class="form-control form-control-lg" type="tel" name="phone" value="{{ old('phone') }}" placeholder="{{ __('sign_c.enter_phone') }}" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('sign_c.affiliation_order') }}</label>
                                        <input class="form-control form-control-lg" type="text" name="affiliation" value="{{ old('affiliation') }}" placeholder="{{ __('sign_c.enter_affiliation') }}" />
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-label">{{ __('sign_c.which_country') }}</label>
                                            <div class="input-group">
                                                <select class="form-select form-control-lg" name="country_contr" style="max-width: 85px; padding: 0.5rem;">
                                                    @foreach(__('message.countries_phone') as $code => $country)
                                                        <option value="{{ $country['code'] }}" 
                                                                data-country="{{ $code }}"
                                                                data-flag="{{ $country['flag'] }}"
                                                                {{ old('phone_code', '+33') == $country['phone_code'] ? 'selected' : '' }}>
                                                            {{ $country['flag'] }} {{ $country['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @if($errors->has('country_contr'))
                                                <span class="text-danger text-small">{{ $errors->first('country_contr') }}</span>
                                            @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary">{{ __('sign_c.register') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-3">
                        <a href="\login">{{ __('sign_c.login_as') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (feather) {
            feather.replace();
        }
    });
</script>
@endsection