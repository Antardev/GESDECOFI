@if(auth()->check())
	<nav id="sidebar" class="sidebar js-sidebar">
		<div class="sidebar-content js-simplebar">
			<a class="sidebar-brand" href="">
				<span class="align-middle">GestionDECOFI</span>
			</a>
			<ul class="sidebar-nav">

				{{-- La sidebar des stagiaires --}}
				@if (auth()->user() && Str::contains(auth()->user()->validated_type, 'stagiaire'))
					<li class="sidebar-header">Stagiaire</li>

					@php
						$now = now();
						$user = auth()->user();
						$stagiaire = App\Models\Stagiaire::where('user_id', $user->id)->first();

						// Fonction pour vérifier si une année est active
						function isYearActive($begin, $end, $now)
						{
							return $begin && $end && $now->between(
								Carbon\Carbon::parse($begin),
								Carbon\Carbon::parse($end)
							);
						}
					@endphp
					<li class="sidebar-item">
								<a class="sidebar-link" href="{{route('calendarshow')}}">
									<i class="align-middle" data-feather="calendar"></i>
									<span class="align-middle">Tableau de bord </span>
								</a>
							</li>
					{{-- Première année --}}
					<li
						class="sidebar-item dropdown @if(!isYearActive($stagiaire->first_year_begin, $stagiaire->first_year_end, $now)) disabled @endif">
						<a class="sidebar-link dropdown-toggle @if(!isYearActive($stagiaire->first_year_begin, $stagiaire->first_year_end, $now)) disabled-link @endif"
							href="#" @if(isYearActive($stagiaire->first_year_begin, $stagiaire->first_year_end, $now))
							onclick="toggleDropdown(event)" @endif>
							<i class="align-middle" data-feather="calendar"></i>
							<span class="align-middle">Première année</span>
							@if(!isYearActive($stagiaire->first_year_begin, $stagiaire->first_year_end, $now))
								<small class="text-danger"> Non disponible</small>
							@endif
							<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
						</a>

						@if(isYearActive($stagiaire->first_year_begin, $stagiaire->first_year_end, $now))
								<ul class="dropdown-menu ps-3">
									<!-- Sous-menu Ajouter -->
									<li class="dropdown-submenu">
										<a class="sidebar-link dropdown-toggle" href="#">
											<i class="align-middle" data-feather="plus"></i>
											<span class="align-middle">Ajouter une activité</span>
											<i class="sidebar-collapse-icon align-middle toggle-dropdown"
												data-feather="chevron-down"></i>
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

										</ul>
									</li>
									<!-- Sous-menu listes -->
									<li class="dropdown-submenu">
										<a class="sidebar-link dropdown-toggle" href="#">
											<i class="align-middle" data-feather="list"></i>
											<span class="align-middle">Mes listes</span>
											<i class="sidebar-collapse-icon align-middle toggle-dropdown"
												data-feather="chevron-down"></i>
										</a>

										<!-- Sous-contenu list -->
										<ul class="dropdown-menu ps-3">
											<li class="sidebar-item">
												<a class="sidebar-link" href="{{route('stagiaire.list_mission')}}">
													<i class="align-middle" data-feather="file-plus"></i>
													<span class="align-middle">Missions </span>
												</a>
											</li>
											<li class="sidebar-item">
												<a class="sidebar-link" href="{{route('stagiaire.list_jt')}}">
													<i class="align-middle" data-feather="plus"></i>
													<span class="align-middle">Journée technique</span>
												</a>
											</li>

										</ul>
									</li>
									<!-- Rapport semestriel-->
									<li class="dropdown-submenu">
										<a class="sidebar-link dropdown-toggle" href="#" aria-expanded="false">
											<i class="align-middle" data-feather="file-text"></i>
											<span class="align-middle">Rapport semestriel</span>
											<i class="sidebar-collapse-icon align-middle toggle-dropdown"
												data-feather="chevron-down"></i>
										</a>
										<!-- Sous-contenu list -->
										<ul class="dropdown-menu ps-3">
											<li class="sidebar-item">
												<a class="sidebar-link" href="{{ route('stagiaire.ajout_rapport') }}">
													<i class="align-middle" data-feather="file-plus"></i>
													<span class="align-middle">Ajouter</span>
												</a>
											</li>
											<li class="sidebar-item">
												<a class="sidebar-link" href="{{ route('stagiaire.rapport_history') }}">
													<i class="align-middle" data-feather="list"></i>
													<span class="align-middle">Historique</span>
												</a>
											</li>
										</ul>
									</li>

									{{-- Tableau --}}

									<li class="dropdown-submenu">
										<a class="sidebar-link dropdown-toggle" href="#" aria-expanded="false">
											<i class="align-middle" data-feather="layout"></i>
											<span class="align-middle">Tableau</span>
											<i class="sidebar-collapse-icon align-middle toggle-dropdown"
												data-feather="chevron-down"></i>
										</a>
										<!-- Sous-contenu list -->
										<ul class="dropdown-menu ps-3">
											<li class="sidebar-item">
												<a class="sidebar-link" href="{{route('Tableau1')}}">
													<i class="align-middle" data-feather="layout"></i>
													<span class="align-middle">1</span>
												</a>
											</li>
											<li class="sidebar-item">
												<a class="sidebar-link" href="{{route('Tableau2')}}">
													<i class="align-middle" data-feather="layout"></i>
													<span class="align-middle">2</span>
												</a>
											</li>
											<li class="sidebar-item">
												<a class="sidebar-link" href="{{route('Tableau3')}}">
													<i class="align-middle" data-feather="layout"></i>
													<span class="align-middle">2r</span>
												</a>
											</li>
											<li class="sidebar-item">
												<a class="sidebar-link" href="{{route('Tableau4')}}">
													<i class="align-middle" data-feather="layout"></i>
													<span class="align-middle">3</span>
												</a>
											</li>
										</ul>
									</li>

								</ul>

							</li>
							<!-- Calendrier annuel-->
							
						@endif

					{{-- Deuxième année --}}
					<li
						class="sidebar-item dropdown @if(!isYearActive($stagiaire->second_year_begin, $stagiaire->second_year_end, $now)) disabled @endif">
						<a class="sidebar-link dropdown-toggle @if(!isYearActive($stagiaire->second_year_begin, $stagiaire->second_year_end, $now)) disabled-link @endif"
							href="#" @if(isYearActive($stagiaire->second_year_begin, $stagiaire->second_year_end, $now))
							onclick="toggleDropdown(event)" @endif>
							<i class="align-middle" data-feather="calendar"></i>
							<span class="align-middle">Deuxième année</span>
							@if(!isYearActive($stagiaire->second_year_begin, $stagiaire->second_year_end, $now))
								<small class="text-danger"> Non disponible</small>
							@endif
							<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
						</a>

						@if(isYearActive($stagiaire->second_year_begin, $stagiaire->second_year_end, $now))
							<ul class="dropdown-menu ps-3">
								<!-- Sous-menu Ajouter -->
								<li class="dropdown-submenu">
									<a class="sidebar-link dropdown-toggle" href="#">
										<i class="align-middle" data-feather="plus"></i>
										<span class="align-middle">Ajouter une activité</span>
										<i class="sidebar-collapse-icon align-middle toggle-dropdown"
											data-feather="chevron-down"></i>
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

									</ul>
								</li>
								<!-- Sous-menu listes -->
								<li class="dropdown-submenu">
									<a class="sidebar-link dropdown-toggle" href="#">
										<i class="align-middle" data-feather="list"></i>
										<span class="align-middle">Mes listes</span>
										<i class="sidebar-collapse-icon align-middle toggle-dropdown"
											data-feather="chevron-down"></i>
									</a>

									<!-- Sous-contenu list -->
									<ul class="dropdown-menu ps-3">
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{route('stagiaire.list_mission')}}">
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

									</ul>
								</li>
								<!-- Rapport semestriel-->
								<li class="dropdown-submenu">
									<a class="sidebar-link dropdown-toggle" href="#" aria-expanded="false">
										<i class="align-middle" data-feather="file-text"></i>
										<span class="align-middle">Rapport semestriel</span>
										<i class="sidebar-collapse-icon align-middle toggle-dropdown"
											data-feather="chevron-down"></i>
									</a>
									<!-- Sous-contenu list -->
									<ul class="dropdown-menu ps-3">
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{ route('stagiaire.ajout_rapport') }}">
												<i class="align-middle" data-feather="file-plus"></i>
												<span class="align-middle">Ajouter</span>
											</a>
										</li>
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{ route('stagiaire.rapport_history') }}">
												<i class="align-middle" data-feather="list"></i>
												<span class="align-middle">Historique</span>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						@endif
					</li>

					{{-- Troisième année --}}
					<li
						class="sidebar-item dropdown @if(!isYearActive($stagiaire->third_year_begin, $stagiaire->third_year_end, $now)) disabled @endif">
						<a class="sidebar-link dropdown-toggle @if(!isYearActive($stagiaire->third_year_begin, $stagiaire->third_year_end, $now)) disabled-link @endif"
							href="#" @if(isYearActive($stagiaire->third_year_begin, $stagiaire->third_year_end, $now))
							onclick="toggleDropdown(event)" @endif>
							<i class="align-middle" data-feather="calendar"></i>
							<span class="align-middle">Troisième année</span>
							@if(!isYearActive($stagiaire->third_year_begin, $stagiaire->third_year_end, $now))
								<small class="text-danger"> Non disponible</small>
							@endif
							<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
						</a>

						@if(isYearActive($stagiaire->third_year_begin, $stagiaire->third_year_end, $now))
							<ul class="dropdown-menu ps-3">
								<!-- Sous-menu Ajouter -->
								<li class="dropdown-submenu">
									<a class="sidebar-link dropdown-toggle" href="#">
										<i class="align-middle" data-feather="plus"></i>
										<span class="align-middle">Ajouter une activité</span>
										<i class="sidebar-collapse-icon align-middle toggle-dropdown"
											data-feather="chevron-down"></i>
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

									</ul>
								</li>
								<!-- Sous-menu listes -->
								<li class="dropdown-submenu">
									<a class="sidebar-link dropdown-toggle" href="#">
										<i class="align-middle" data-feather="list"></i>
										<span class="align-middle">Mes listes</span>
										<i class="sidebar-collapse-icon align-middle toggle-dropdown"
											data-feather="chevron-down"></i>
									</a>

									<!-- Sous-contenu list -->
									<ul class="dropdown-menu ps-3">
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{route('stagiaire.list_mission')}}">
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

									</ul>
								</li>
								<!-- Rapport semestriel-->
								<li class="dropdown-submenu">
									<a class="sidebar-link dropdown-toggle" href="#" aria-expanded="false">
										<i class="align-middle" data-feather="file-text"></i>
										<span class="align-middle">Rapport semestriel</span>
										<i class="sidebar-collapse-icon align-middle toggle-dropdown"
											data-feather="chevron-down"></i>
									</a>
									<!-- Sous-contenu list -->
									<ul class="dropdown-menu ps-3">
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{ route('stagiaire.ajout_rapport') }}">
												<i class="align-middle" data-feather="file-plus"></i>
												<span class="align-middle">Ajouter</span>
											</a>
										</li>
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{ route('stagiaire.rapport_history') }}">
												<i class="align-middle" data-feather="list"></i>
												<span class="align-middle">Historique</span>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						@endif
					</li>
				@endif


				{{-- La sidebar des controleurs Nationaux --}}
				@if (auth()->user() && (Str::contains(auth()->user()->validated_type, 'CN') || Str::contains(auth()->user()->validated_type, 'assistant_controller')))
					<li class="sidebar-item dropdown">
						<a class="sidebar-link dropdown-toggle " onclick="toggleDropdown(event)" href="#">
							<i class="align-middle" data-feather="user"></i> <span class="align-middle">Controleur
								Nationale</span>
							<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
						</a>
						<ul class="dropdown-menu ps-3 ">
							{{-- <li class="sidebar-item">
								<a class="sidebar-link" href="#">
									<i class="align-middle" data-feather="eye"></i>
									<span class="align-middle">Vues</span>
								</a> --}}

							</li>

							<li class="sidebar-item">
								<a class="sidebar-link" href="{{route('controller.liste_stagiaires')}}">
									<i class="align-middle" data-feather="list"></i>
									<span class="align-middle">Listes des stagiaires</span>
								</a>
							</li>

							<li class="sidebar-item">
								<a class="sidebar-link" href="{{route('controleur.stagiaires_recap')}}">
									<i class="align-middle" data-feather="list"></i>
									<span class="align-middle">Recapitulatif nationale</span>
								</a>
							</li>

							
							@if (auth()->user() && !(Str::contains(auth()->user()->validated_type, 'assistant_controller')))
								<li class="sidebar-item">
									<a class="sidebar-link" href="{{route('controleur.Add_assistant')}}">
										<i class="align-middle" data-feather="user-plus"></i>
										<span class="align-middle">Ajouter un assistant</span>
									
									</a>
								</li>
								<li class="sidebar-item">
									<a class="sidebar-link" href="{{route('receivemessages')}}">
										<i class="align-middle" data-feather="message-circle"></i>
										<span class="align-middle">Messagerie</span>
										
										@if(auth()->check())
											@php $unreadCount = auth()->user()->unreadNotifications->count();
											@endphp
											@if ($unreadCount > 0)
											<span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
											@else
											<span class="badge bg-danger rounded-pill" style="display: none;">0</span>
											@endif
										@endif
									</a>
								</li>
								<li class="sidebar-item">
									<a class="sidebar-link" href="">
										<i class="align-middle" data-feather="loader"></i>
										<span class="align-middle">Diligences</span>
										<span class="badge bg-danger rounded-pill">1</span>
									</a>
								</li>
							@endif
						</ul>
					</li>
				@endif


				@if (auth()->user() && Str::contains(auth()->user()->validated_type, 'CR'))
					<li class="sidebar-item dropdown">
						<a class="sidebar-link dropdown-toggle " onclick="toggleDropdown(event)" href="#">
							<i class="align-middle" data-feather="user"></i> <span class="align-middle">Controleur
								Régionale</span>
							<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
						</a>

						<ul class="dropdown-menu ps-3 ">
							<li class="dropdown-submenu">
								<a class="sidebar-link dropdown-toggle" href="#">
									<i class="align-middle" data-feather="plus"></i>
									<span class="align-middle">Ajouter</span>
									<i class="sidebar-collapse-icon align-middle toggle-dropdown"
										data-feather="chevron-down"></i>
								</a>

								<!-- Sous-contenu Ajouter -->
								<ul class="dropdown-menu ps-3">

									<li class="sidebar-item">
										<a class="sidebar-link" href="{{route('ajout_categorie')}}">
											<i class="align-middle" data-feather="layout"></i>
											<span class="align-middle">Categorie</span>
										</a>
									</li>
									<li class="sidebar-item">
										<a class="sidebar-link" href="{{route('show_input_domaine')}}">
											<i class="align-middle" data-feather="layout"></i>
											<span class="align-middle">Domaine</span>
										</a>
									</li>
									<li class="sidebar-item">
										<a class="sidebar-link" href="{{route('show_input_sous_domaine')}}">
											<i class="align-middle" data-feather="layout"></i>
											<span class="align-middle">Sous-domaine</span>
										</a>
									</li>
									<li class="sidebar-item">
										<a class="sidebar-link" href="{{route('ajout_sous_categorie')}}">
											<i class="align-middle" data-feather="layout"></i>
											<span class="align-middle">Sous-categorie</span>
										</a>
									</li>
									
								</ul>

								<li class="dropdown-submenu">
									<a class="sidebar-link dropdown-toggle" href="#">
										<i class="align-middle" data-feather="list"></i>
										<span class="align-middle">Listes</span>
										<i class="sidebar-collapse-icon align-middle toggle-dropdown"
											data-feather="chevron-down"></i>
									</a>
	
									<!-- Sous-contenu Ajouter -->
									<ul class="dropdown-menu ps-3">
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{route('list_controleur_national')}}">
												<i class="align-middle" data-feather="point"></i>
												<span class="align-middle">Controleurs nationaux</span>
											</a>
										</li>
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{route('Listes_stagiairesCR')}}">
												<i class="align-middle" data-feather="layout"></i>
												<span class="align-middle">Stagiaires</span>
											</a>
										</li>
										<li class="sidebar-item">
											<a class="sidebar-link" href="">
												<i class="align-middle" data-feather="layout"></i>
												<span class="align-middle">Domaines</span>
											</a>
										</li>
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{route('Liste_sous domaines')}}">
												<i class="align-middle" data-feather="layout"></i>
												<span class="align-middle">Sous-domaines</span>
											</a>
										</li>
										<li class="sidebar-item">
											<a class="sidebar-link" href="{{route('liste_categories')}}">
												<i class="align-middle" data-feather="layout"></i>
												<span class="align-middle">Categories</span>
											</a>
										</li>
									</ul>
								</li>
							</li>
							
						</ul>
					</li>
				@endif

				@if (auth()->user() && Str::contains(auth()->user()->validated_type, 'admin'))
					<li class="sidebar-item dropdown">
						<a class="sidebar-link dropdown-toggle " onclick="toggleDropdown(event)" href="#">
							<i class="align-middle" data-feather="user"></i> <span class="align-middle">Admin</span>
							<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
						</a>

						<ul class="dropdown-menu ps-3 ">
							<li class="sidebar-item dropdown">
								<a class="sidebar-link" href="{{route('admin.list_controleur')}}">
									<i class="align-middle" data-feather="list"></i>
									<span class="align-middle">Liste des controleurs </span>
								</a>
							</li>

							<li class="sidebar-item dropdown">
								<a class="sidebar-link" href="{{route('Listes_stagiairesCR')}}">
									<i class="align-middle" data-feather="list"></i>
									<span class="align-middle">Listes des stagiaires</span>
								</a>
							</li>
						</ul>
					</li>
				@endif

				@if (auth()->user() && Str::contains(auth()->user()->validated_type, 'stagiaire'))
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{route('stagiaire.details')}}">
							<i class="align-middle" data-feather="user"></i>
							<span class="align-middle">Mes informations</span>
						</a>
					</li>
				@endif

				

				@if (auth()->user() && Str::contains(auth()->user()->validated_type, 'superadmin'))
				<li class="sidebar-item dropdown">
					<a class="sidebar-link dropdown-toggle " onclick="toggleDropdown(event)" href="#">
						<i class="align-middle" data-feather="user"></i> <span class="align-middle">SuperAdmin</span>
						<i class="sidebar-collapse-icon align-middle toggle-dropdown" data-feather="chevron-down"></i>
					</a>

					<ul class="dropdown-menu ps-3 ">
						<li class="sidebar-item dropdown">
							<a class="sidebar-link" href="{{route('superadmin.list_controleur')}}">
								<i class="align-middle" data-feather="list"></i>
								<span class="align-middle">Liste des controleurs </span>
							</a>
						</li>

						<li class="sidebar-item dropdown">
							<a class="sidebar-link" href="{{route('superadmin.liste_stagiaires')}}">
								<i class="align-middle" data-feather="list"></i>
								<span class="align-middle">Listes des stagiaires</span>
							</a>
						</li>

						<li class="sidebar-item dropdown">
							<a class="sidebar-link" href="{{route('superadmin.stagiaires_recap')}}">
								<i class="align-middle" data-feather="list"></i>
								<span class="align-middle">Recapitulatif </span>
							</a>
						</li>
					</ul>
				</li>
				@endif
				<li class="sidebar-item dropdown">
					<form action="{{route('logout')}}" method="post">
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
		border-width: 0 2px 2px 0;
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

	.sidebar-item.disabled {
		opacity: 0.6;
		pointer-events: none;
	}

	.disabled-link {
		color: #7d6c78 !important;
		cursor: not-allowed;
	}

	.disabled-link:hover {
		background-color: transparent !important;
	}
</style>

<script>
	function toggleDropdown(event) {
		event.preventDefault();
		const dropdownToggle = event.currentTarget;
		const dropdownMenu = dropdownToggle.nextElementSibling;
		const isExpanded = dropdownToggle.getAttribute('aria-expanded') === 'true';

		// Fermer les dropdowns ouverts
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



	