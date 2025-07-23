		<nav class="navbar navbar-expand navbar-light navbar-bg">
			@if(auth()->check())
			<a class="sidebar-toggle js-sidebar-toggle">
          		<i class="hamburger align-self-center"></i>
        	</a>
			@endif
			<a class="">
        		GestionDECOFI
        	</a>
			<div class="navbar-collapse collapse">
				<ul class="navbar-nav navbar-align">
					<li class="nav-item">
						<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="{{route('home')}}">
							<i class="align-middle" data-feather="home"></i>
						</a>
						<a class="nav-link d-none d-sm-inline-block" href="{{ route('welcome') }}">
							{{__('message.Home')}}
						</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="{{route('NousContacter')}}">
							<i class="align-middle" data-feather="trello"></i>
						</a>
                        <a class="nav-link d-none d-sm-inline-block" href="{{route('NousContacter')}}">
                            {{__('message.contact_us')}}
                        </a>
					</li>
					@if(auth()->check())
					<li class="nav-item">
						{{-- <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
							<div class="position-relative">
								<i class="align-middle" data-feather="bell"></i>
								
							</div>
						</a> --}}
						<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
							<div class="position-relative">
								<i class="align-middle" data-feather="bell"></i>
								
								@if(auth()->user() && (Str::contains(auth()->user()->validated_type, 'CN') || Str::contains(auth()->user()->validated_type, 'assistant_controller')))
								@php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
							    @if ($unreadCount > 0)
									<span class="indicator bg-danger">{{ $unreadCount }}</span>
								@else
									<span class="indicator bg-secondary" style="display: none;">0</span>
								@endif
							@endif
							</div>
					
						</a>
						
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
							<div class="dropdown-menu-header">
								<div class="d-flex justify-content-between align-items-center">
									<h6 class="dropdown-header mb-0">Notifications </h6>
									<div>
										<a href="#" class="text-muted small">Marquer tout comme lu</a>
										<span class="mx-1">•</span>
										<a href="#" class="text-muted small">Paramètres</a>
									</div>
								</div>
							</div>
							
							<div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
								@forelse (Auth::user()->unreadNotifications as $notification)
									<a href="{{ $notification->data['url'] }}" class="list-group-item list-group-item-action border-bottom">
										<div class="d-flex align-items-start">
											<div class="flex-shrink-0 me-3">
												<div class="bg-primary bg-opacity-10 p-2 rounded">
													<i class="bi bi-bell text-primary"></i>
												</div>
											</div>
											<div class="flex-grow-1">
												<div class="d-flex justify-content-between">
													<h6 class="mb-1">{{ $notification->data['title'] }}</h6>
													<small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
												</div>
												<p class="mb-0 small">{{ $notification->data['message'] }}</p>
											</div>
										</div>
									</a>
								@empty
									<div class="list-group-item text-center">Aucune notification</div>
								@endforelse
							</div>
							
							<div class="dropdown-menu-footer">
								<a href="#" class="text-center d-block py-2 small">Voir toutes les notifications</a>
							</div>
						</div>
						
						<style>
							.indicator {
								position: absolute;
								top: -5px;
								right: -5px;
								width: 18px;
								height: 18px;
								border-radius: 50%;
								color: white;
								font-size: 10px;
								display: flex;
								align-items: center;
								justify-content: center;
								font-weight: bold;
							}
							
							.dropdown-menu-header {
								padding: 0.75rem 1rem;
								border-bottom: 1px solid #dee2e6;
							}
							
							.dropdown-menu-footer {
								border-top: 1px solid #dee2e6;
							}
							
							.list-group-item {
								padding: 0.75rem 1rem;
								transition: background-color 0.2s;
							}
							
							.list-group-item:hover {
								background-color: #f8f9fa;
							}
						</style>

						<script>
						document.addEventListener('DOMContentLoaded', function() {
							// Gestion du clic sur les notifications
							// document.querySelectorAll('.list-group-item').forEach(item => {
							// 	item.addEventListener('click', function(e) {
							// 		e.preventDefault();
							// 		// Mettre à jour le compteur de notifications
							// 		const indicator = document.querySelector('.indicator');
							// 		let count = parseInt(indicator.textContent);
							// 		if (count > 0) {
							// 			indicator.textContent = count - 1;
							// 			if (count - 1 === 0) {
							// 				indicator.style.display = 'none';
							// 			}
							// 		}
									
							// 		// Marquer comme lu visuellement
							// 		this.style.opacity = '0.6';
							// 	});
							// });

							// Gestion du "Marquer tout comme lu"
							document.querySelector('.dropdown-menu-header a:first-child').addEventListener('click', function(e) {
								e.preventDefault();
								document.querySelector('.indicator').style.display = 'none';
								document.querySelectorAll('.list-group-item').forEach(item => {
									item.style.opacity = '0.6';
								});
							});

							function sendMessage() {
    // Logique d'envoi de message ici

    // Après l'envoi réussi, mettez à jour le compteur
    const indicator = document.querySelector('.indicator');
    let count = parseInt(indicator.textContent) || 0;
    indicator.textContent = count + 1;
    indicator.style.display = 'block'; // Assurez-vous que le badge est visible
}
						});
						</script>
					</li>
					@endif
					
                    @if(auth()->check())
                        <li class="nav-link md-none display-lg">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
					<li class="nav-item dropdown">
						<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
            				<i class="align-middle" data-feather="user"></i>
          				</a>
						<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">	
							<span class="text-dark">{{ auth()->user()->fullname }}</span>
          				</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a class="dropdown-item" href="{{route('Profile')}}"><i class="align-middle me-1" data-feather="user"></i> {{__('message.profile')}}</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item bg-primary text-white" href="#"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__('message.logout')}}</a>
						</div>
					</li>
                    @else
                        <li class="nav-item mx-2  md-none display-lg">
                            <a class="btn btn-primary" href="{{ route('login') }}">
                                {{__('message.login')}}
                            </a>
                        </li>
                        <li class="nav-item  md-none display-lg">
                            <a class="nav-btn btn btn-primary" href="{{ route('register') }}">
                                {{__('message.register')}}
                            </a>
                        </li>
                    @endif
				</ul>
			</div>
			
		</nav>