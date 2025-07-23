@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-diagram-3 me-2"></i>Liste des Domaines
                    </h5>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{route('show_input_domaine')}}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Ajouter un Domaine
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Nombre de sous-domaines</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($domains as $domain)
                                <tr>
                                    <td>{{ $domain->name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">
                                            {{ $domain->subdomains->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                           
                
                                            <button class="btn btn-outline-primary view-subdomains" 
                                                    data-domain-id="{{ $domain->id }}">
                                                <i class="bi bi-eye"></i> Voir
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Ligne des sous-domaines (cachée par défaut) -->
                                <tr id="subdomains-{{ $domain->id }}" class="subdomains-row" style="display: none;">
                                    <td colspan="3">
                                        <div class="p-3 bg-light rounded">
                                            <h6 class="fw-bold mb-3">Sous-domaines :</h6>
                                            @if($domain->subdomains->count() > 0)
                                                <ul class="list-group">
                                                    @foreach($domain->subdomains as $subdomain)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $subdomain->name }}
                                                        <div class="btn-group">
                                                            <button class="btn btn-sm btn-outline-warning me-1 edit-subdomain"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editSubdomainModal"
                                                                    data-id="{{ $subdomain->id }}"
                                                                    data-name="{{ $subdomain->name }}"
                                                                    >
                                                                <i class="bi bi-pencil"></i> Modifier
                                                            </button>
                                                            
                                                            <form action="{{ $subdomain->active ? '/subdomains/deactivate/'.$subdomain->id : '/subdomains/activate/'.$subdomain->id }}" 
                                                                  method="POST" 
                                                                  class="d-inline toggle-activation-form">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="btn btn-sm {{ $subdomain->active ? 'btn-outline-danger' : 'btn-outline-success' }} toggle-activation"
                                                                        data-id="{{ $subdomain->id }}" data-active ="{{$subdomain->active ?true:false}}">
                                                                    <i class="bi {{ $subdomain->active ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                                                                    {{ $subdomain->active ? 'Désactiver' : 'Activer' }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="alert alert-info mb-0">
                                                    Aucun sous-domaine disponible
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'édition Sous-domaine -->
<div class="modal fade" id="editSubdomainModal" tabindex="-1" aria-labelledby="editSubdomainModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubdomainModalLabel">Modifier le sous-domaine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSubdomainForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subdomainName" class="form-label">Nom du sous-domaine</label>
                        <input type="text" class="form-control" id="subdomainName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .subdomains-row td {
        border-top: none;
        padding-top: 0;
        padding-bottom: 0;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'affichage des sous-domaines
    function getCsrfToken(form) {
        const tokenInput = form.querySelector('input[name="_token"]');
        return tokenInput ? tokenInput.value : '';
    }

    document.querySelectorAll('.view-subdomains').forEach(button => {
        button.addEventListener('click', function() {
            const domainId = this.getAttribute('data-domain-id');
            const subdomainRow = document.getElementById(`subdomains-${domainId}`);
            
            // Masquer toutes les autres lignes de sous-domaines
            document.querySelectorAll('.subdomains-row').forEach(row => {
                if (row.id !== `subdomains-${domainId}`) {
                    row.style.display = 'none';
                }
            });
            
            // Basculer l'affichage de la ligne courante
            subdomainRow.style.display = subdomainRow.style.display === 'none' ? 'table-row' : 'none';
            
            // Changer l'icône du bouton
            const icon = this.querySelector('i');
            if (subdomainRow.style.display === 'none') {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
                this.innerHTML = '<i class="bi bi-eye"></i> Voir';
            } else {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
                this.innerHTML = '<i class="bi bi-eye-slash"></i> Masquer';
            }
        });
    });

     // Modal d'édition Sous-domaine
     const editSubdomainModal = document.getElementById('editSubdomainModal');
    if (editSubdomainModal) {
        editSubdomainModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const subdomainId = button.getAttribute('data-id');
            const subdomainName = button.getAttribute('data-name');
            
            const form = document.getElementById('editSubdomainForm');
            form.action = `/subdomains/${subdomainId}`;
            document.getElementById('subdomainName').value = subdomainName;
        });
    }

    document.querySelectorAll('.toggle-activation').forEach(button => {
    button.addEventListener('click', async function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const elementId = this.getAttribute('data-id');
        const isActive = this.getAttribute('data-active') === 'true';
        const elementType = form.action.includes('subcategories') ? 'subcategory' : 
                          form.action.includes('subdomains') ? 'subdomain' : 'domain';

        const confirmation = await Swal.fire({
            title: `Voulez-vous vraiment ${isActive ? 'désactiver' : 'activer'} cet élément ?`,
            text: `${isActive ? 'La désactivation' : 'L\'activation'} affectera la visibilité de cet élément.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Oui, ${isActive ? 'désactiver' : 'activer'}`,
            cancelButtonText: 'Annuler'
        });

        if (confirmation.isConfirmed) {
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(form)
                    },
                    body: JSON.stringify({ 
                        _method: 'POST' 
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Mise à jour de l'état
                    const newActiveState = !isActive;
                    
                    // Mise à jour du bouton
                    this.setAttribute('data-active', newActiveState);
                    this.innerHTML = `<i class="bi ${newActiveState ? 'bi-slash-circle' : 'bi-check-circle'}"></i> ${newActiveState ? 'Désactiver' : 'Activer'}`;
                    this.className = `btn btn-sm ${newActiveState ? 'btn-outline-danger' : 'btn-outline-success'} toggle-activation`;
                    
                    // Mise à jour du formulaire
                    form.action = newActiveState 
                        ? form.action.replace('/activate', '/deactivate')
                        : form.action.replace('/deactivate', '/activate');
                    
                    // Notification
                    Swal.fire({
                        title: 'Succès!',
                        text: `Élément ${newActiveState ? 'activé' : 'désactivé'} avec succès.`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            } catch (error) {
                console.log('Error:', error);
                Swal.fire({
                    title: 'Erreur!',
                    text: 'Une erreur est survenue lors de la mise à jour.',
                    icon: 'error'
                });
            }
        }
    });
});
});
</script>
@endsection