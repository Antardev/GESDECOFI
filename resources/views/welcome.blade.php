<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard to manage DECOFI Stage">
	<meta name="author" content="GestionDECOFI">
	<meta name="keywords" content="Student, dashboard, Management, DECOFI, accountant, ui kit, web">
  	
	@yield('scripts_up')
	
	<script src="https://unpkg.com/feather-icons"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title>Gestion DECOFI</title>

	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/assets/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">


    </head>
    <body class="antialiased">
	<div class="wrapper">
		@if(auth()->check())
        	@include('sidebar.sidebar')
		@endif
        <div class="main">

			@include('navbar.nav')
	
        	@yield('content') 
		</div>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				feather.replace();
			});

			
		</script>
		<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('assets/js/assets/app.js')}}"></script>
		<script src="{{asset('assets/js/assets/Dynamic.js')}}"></script>
		@yield('scripts_down')
	</div>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			if (feather) {
				feather.replace();
			}
		});
	</script>
    </body>
</html>
