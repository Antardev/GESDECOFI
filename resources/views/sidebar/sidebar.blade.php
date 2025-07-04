		@if(auth()->check())
			<nav id="sidebar" class="sidebar js-sidebar">
					<div class="sidebar-content js-simplebar">
						<a class="sidebar-brand" href="index.html">
				<span class="align-middle">GestionDECOFI</span>
				</a>
						<ul class="sidebar-nav">


							<li class="sidebar-item dropdown">
								<!-- Menu principal Stagiaire -->
								<a class="sidebar-link dropdown-toggle " href="#" onclick="toggleDropdown(event)">
								  <i class="align-middle" data-feather="users"></i>
								  <span class="align-middle">Stagiaire</span>
								  <i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
								</a>

								<!-- Contenu du menu Stagiaire -->
								<ul class="dropdown-menu ps-3">
								  <!-- Sous-menu Ajouter -->
								  <li class="dropdown-submenu">
									<a class="sidebar-link dropdown-toggle" href="#">
									  <i class="align-middle" data-feather="plus"></i>
									  <span class="align-middle">Ajouter une activité</span>
									  <i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
									</a>

									<!-- Sous-contenu Ajouter -->
									<ul class="dropdown-menu ps-3">
									  <li class="sidebar-item">
										<a class="sidebar-link" href="{{route('Ajout_mission')}}">
										  <i class="align-middle" data-feather="file-plus"></i>
										  <span class="align-middle">Missions </span>
										</a>
									  </li>
									  <li class="sidebar-item">
										<a class="sidebar-link" href="{{route('Ajout_fiche')}}">
										  <i class="align-middle" data-feather="plus"></i>
										  <span class="align-middle">Journée technique</span>
										</a>
									  </li>
									  <li class="sidebar-item">
										<a class="sidebar-link" href="#">
										  <i class="align-middle" data-feather="file-text"></i>
										  <span class="align-middle">Rapport semestriel</span>
										</a>
									  </li>
									</ul>
								  </li>

								  <!-- Items simples -->
								  <li class="sidebar-item">
									<a class="sidebar-link" href="#">
									  <i class="align-middle" data-feather="eye"></i>
									  <span class="align-middle">Vues</span>
									</a>
								  </li>

								  <li class="sidebar-item">
									<a class="sidebar-link" href="{{route('Listes_missions')}}">
									  <i class="align-middle" data-feather="list"></i>
									  <span class="align-middle">Listes des missions</span>
									</a>
								  </li>

								</ul>
							  </li>
							  <li class="sidebar-item dropdown">
								<a class="sidebar-link dropdown-toggle " onclick="toggleDropdown(event)" href="#">
									<i class="align-middle" data-feather="user"></i> <span class="align-middle">Controleur Nationale</span>
									<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
								</a>
								<ul class="dropdown-menu ps-3 ">
								  <li class="sidebar-item">
									<a class="sidebar-link" href="#">
									  <i class="align-middle" data-feather="eye"></i>
									  <span class="align-middle">Vues</span>
									</a>

								  </li>

								  <li class="sidebar-item">
									<a class="sidebar-link" href="{{route('Listes_stagiaires')}}">
									  <i class="align-middle" data-feather="list"></i>
									  <span class="align-middle">Listes des stagiaires</span>
									</a>
								  </li>

								  <li class="sidebar-item">
									<a class="sidebar-link" href="{{route('controleur.Add_assistant')}}">
									  <i class="align-middle" data-feather="user-plus"></i>
									  <span class="align-middle">Ajouter un assistant</span>
									</a>
								  </li>

								</ul>
							  </li>
							<li class="sidebar-item dropdown">
								<a class="sidebar-link dropdown-toggle " onclick="toggleDropdown(event)" href="#">
									<i class="align-middle" data-feather="user"></i> <span class="align-middle">Controleur Régionale</span>
									<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
								</a>

								<ul class="dropdown-menu ps-3 ">
									<li class="sidebar-item dropdown">
										<a class="sidebar-link" href="#">
											<i class="align-middle" data-feather="list"></i>
											<span class="align-middle">Liste controleurs Nationaux</span>
										</a>
									</li>

									<li class="sidebar-item dropdown">
										<a class="sidebar-link" href="{{route('Listes_stagiaires')}}">
											<i class="align-middle" data-feather="list"></i>
											<span class="align-middle">Listes des stagiaires</span>
										</a>
									</li>
								</ul>
							</li>
							
							<li class="sidebar-item dropdown">
								<form action="{{route ('logout')}}" method="post">
									<a class="sidebar-link" href="">
									<i class="align-middle" data-feather="log-out"></i>
									<span class="align-middle">Se deconnecter</span>
								</a>
								</form>
								
							</li>

						</ul>

					</div>

			</nav>

		@endif
	<style>
		.sidebar-item.dropdown .dropdown-menu {
			display: none;
			position: static;
			float: none;
			/* padding: 0.5rem 0;
			margin: 0.5rem 0 0; */
			background-color: transparent;
			border: none;
		}
	
		.sidebar-item.dropdown .dropdown-menu.show {
			display: block;
		}

		.dropdown-toggle:after {
    border: none;
    border-width

: 0 2px 2px 0;
    display: inline-block;
    padding: 2px;
    transform: rotate(45deg);
}
	
		.sidebar-item.dropdown .dropdown-toggle .toggle-dropdown {
			transition: transform 0.3s ease;
		}
	
		.sidebar-item.dropdown .dropdown-toggle[aria-expanded="true"] .toggle-dropdown {
			transform: rotate(180deg);
		}
	
		.dropdown-submenu {
			position: relative;
		}
	
		.dropdown-submenu .dropdown-menu {
			left: 100%;
			top: 0;
			margin-top: 0;
			margin-left: 0.1rem;
		}
	</style>
	
	<script>
		function toggleDropdown(event) {
			event.preventDefault();
			const dropdownToggle = event.currentTarget;
			const dropdownMenu = dropdownToggle.nextElementSibling;
			const isExpanded = dropdownToggle.getAttribute('aria-expanded') === 'true';

			// Fermer tous les dropdowns ouverts
			document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
				if (openMenu !== dropdownMenu) {
					openMenu.classList.remove('show');
					openMenu.previousElementSibling.setAttribute('aria-expanded', 'false');
				}
			});

			// Basculer l'état actuel
			dropdownToggle.setAttribute('aria-expanded', !isExpanded);
			dropdownMenu.classList.toggle('show', !isExpanded);
		}

		// Gestion des sous-menus
		document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(toggle => {
			toggle.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				this.nextElementSibling.classList.toggle('show');
				this.setAttribute('aria-expanded', this.nextElementSibling.classList.contains('show'));
			});
		});
	</script>