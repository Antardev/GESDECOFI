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