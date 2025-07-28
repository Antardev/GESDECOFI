@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Message de succès global --}}
            @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="align-middle me-2" data-feather="check-circle"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- message spécifique --}}
            @if(session('profile_updated'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="align-middle me-2" data-feather="user-check"></i>
                {{ _('Profile_updated') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

             @if(session('password_updated'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="align-middle me-2" data-feather="key"></i>
                    {{ session('password_updated') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Navigation par onglets -->
                    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="infos-tab" data-bs-toggle="tab" data-bs-target="#infos" type="button">
                                <i class="align-middle me-1" data-feather="user"></i> Informations
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button">
                                <i class="align-middle me-1" data-feather="lock"></i> {{__('message.Password')}}
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="profileTabsContent">
                        <!-- Onglet Informations -->
                        <div class="tab-pane fade show active" id="infos" role="tabpanel">
                            <h4 class="text-center mb-4">{{ auth()->user()->fullname }}</h4>
                            
                            <form action="{{route('user-profile-information.update')}}" method="POST">
                                @csrf
                               @method('PUT')
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{__('message.fullname')}}</label>
                                        <input type="text" class="form-control" name="fullname" 
                                            value="{{ old('fullname', auth()->user()->fullname) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">{{__('message.email')}}</label>
                                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" >
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{__('message.language')}}</label>
                                        <select class="form-control" name="lang" required>
                                            <option value="en" {{ old('language', auth()->user()->lang) == 'en' ? 'selected' : '' }}>{{__('message.english')}}</option>
                                            <option value="fr" {{ old('language', auth()->user()->lang) == 'fr' ? 'selected' : '' }}>{{__('message.french')}}</option>
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="align-middle me-1" data-feather="save"></i> {{__('message.save_changes')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Onglet Mot de passe -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <h4 class="mb-4"><i class="align-middle me-1" data-feather="lock"></i> {{__('message.change_password')}}</h4>
                            
                            <form action="{{route('user-password.update')}}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">{{__('message.current_password')}}</label>
                                        <input type="password" class="form-control" name="current_password" required>
										@if($errors->has('current_password'))
                                            <span class="text-danger text-small">
                                                {{ $errors->first('current_password') }}
                                            </span>
										@endif
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">{{__('message.new_password')}}</label>
                                        <input type="password" class="form-control" name="password" required>
                                        <div class="form-text">{{__('message.minimal_8_caracteres')}}</div>
										@if($errors->has('password'))
                                            <span class="text-danger text-small">
                                                {{ $errors->first('password') }}
                                            </span>
										@endif
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">{{__('message.new_password_confirmation')}}</label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                    
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="align-middle me-1" data-feather="key"></i> {{__('message.save_changes')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Initialisation des icônes Feather -->
<script>
    document.addEventListener('DOMContentLoaded', function() {


        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

         feather.replace();
        
        // Active l'onglet sauvegardé dans localStorage
        const activeTab = localStorage.getItem('activeProfileTab');
        if (activeTab) {
            const tabTrigger = new bootstrap.Tab(document.querySelector(activeTab));
            tabTrigger.show();
        }

        // Sauvegarde l'onglet actif
        document.querySelectorAll('#profileTabs button').forEach(tabEl => {
            tabEl.addEventListener('click', function() {
                localStorage.setItem('activeProfileTab', this.dataset.bsTarget);
            });
        });
    });
</script>


<style>
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #495057;
        padding: 0.75rem 1.5rem;
    }
    .nav-tabs .nav-link.active {
        border-bottom-color: #0d6efd;
        color: #0d6efd;
        background-color: transparent;
    }
    .nav-tabs .nav-link:hover {
        border-bottom-color: #dee2e6;
    }
    .alert {
        transition: opacity 0.5s ease-out;
    }
</style>
@endsection