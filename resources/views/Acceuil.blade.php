@extends('welcome')
@section('content')
		<div class="hero-section" style="position position: relative; text-align: center; height: calc(100vh - 60px); overflow: hidden;">
			<!-- Image de fond -->
			<img src="{{ asset('assets/img/1.png') }}" alt="Bienvenue" style="width: 100%; height: 100%; max-height: 600px; object-fit: cover;">	
			<!-- Texte superposé -->
			<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background-color: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;display: block !important; visibility: visible !important; height: auto !important;">
				<h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: white;">{{__('message.welcome_to_platform')}}</h1>
				<p style="font-size: 1.2rem; color: grey">{{__('message.discover_services')}}</p>
				<button class="btn btn-primary" style="margin-top: 20px;"> <a href="{{ route('register') }}" style="color: white; text-decoration: none;">{{__('message.discover')}}</a></button>
			</div>
		</div>
		@foreach (['not_found', 'access'] as $errorType)
			@if($errors->has($errorType))
				<div class="toast align-items-center text-white bg-danger bg-opacity-75 border-0 position-fixed top-50 start-50 translate-middle fade show"
					role="alert" style="z-index: 1000; backdrop-filter: blur(2px);">
					<div class="d-flex">
						<div class="toast-body">
							{{ $errors->first($errorType) }}
						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
							aria-label="Close"></button>
					</div>
				</div>
			@endif
		@endforeach

		<script>
			// Auto-hide après 5 secondes
			setTimeout(() => {
				const toasts = document.querySelectorAll('.toast');
				toasts.forEach(toast => toast.classList.remove('show'));
			}, 5000);
		</script>


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
@endsection