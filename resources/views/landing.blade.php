@extends('welcome')

@section('content')

<div class="hero-section" style="position: relative; text-align: center; height: calc(100vh - 60px);  overflow: hidden;">
    <img src="{{ asset('assets/img/1.png') }}" alt="Bienvenue" style="width: 100%; height: 100%; max-height: 600px; object-fit: cover;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background-color: rgba(0, 0, 0, 0.7); padding: 30px; border-radius: 10px;">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color:blanchedalmond;">{{__('message.welcome_to_platform')}}</h1>
        <p style="font-size: 1.2rem; color: #bebcbc;">{{__('message.select_your_role')}} :</p>
        
        <div class="d-flex justify-content-center mt-4">
            <form action="{{ route('enter_like') }}" method="POST">
                @csrf
                <div>
                    <input type="radio" name="type" id="stagiaire" value="stagiaire">
                    <label for="stagiaire">{{__('message.Stagiaire')}}</label>
                    @if(!$cn_yet)
                    <input type="radio" name="type" id="controleur_national" value="controleur_national">
                    <label for="controleur_national">{{__('message.national_controller')}}</label>
                    @endif

                    @if(!$cr_yet)
                    <input type="radio" name="type" id="controleur_regional" value="controleur_regional">
                    <label for="controleur_regional">{{__('message.regional_controller')}}</label>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-2">{{__('message.enter')}}</button>
            </form>
        </div>
    </div>
</div>



@if(!empty($_GET['verified']) && $_GET['verified'] == 1)
<div class="toast-container position-fixed top-50 start-50 translate-middle p-3 border-0">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header #bebcbc">
            <strong class="me-auto">Succès</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" >
            <h1></h1>
            {{ __('message.email_verified_success') }}
        </div>
    </div>
</div>
@endif
@if(session('success'))
<div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Succès</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.querySelector('.toast');
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
</script>
@endsection