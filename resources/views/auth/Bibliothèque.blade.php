@extends('welcome')

@section('content')
<div class="container py-5" id="mainContainer">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center mb-4">Bibliothèque</h1>
            <div class="d-flex justify-content-center">
                <div class="w-50">
                    <input type="text" class="form-control" placeholder="Rechercher un livre..." id="searchInput">
                </div>
            </div>
            
            <!-- Filtres par catégorie -->
            <div class="text-center mt-3">
                <div class="btn-group" role="group" aria-label="Filtres catégories">
                    <button type="button" class="btn btn-outline-secondary filter-btn active" data-category="all">Tous</button>
                    <button type="button" class="btn btn-outline-secondary filter-btn" data-category="technique">Technique</button>
                    <button type="button" class="btn btn-outline-secondary filter-btn" data-category="juridique">Juridique</button>
                    <button type="button" class="btn btn-outline-secondary filter-btn" data-category="gestion">Gestion</button>
                    <button type="button" class="btn btn-outline-secondary filter-btn" data-category="autres">Autres</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="booksGrid">
        <!-- Livre 1 -->
        <div class="col-md-4 mb-4 book-card" data-category="juridique">
            <div class="card h-100 border-0">
                <div class="card-body text-center">
                    <span class="badge bg-info mb-2">Juridique</span>
                    <h3>Titre du Livre</h3>
                    <h5 class="text-muted mb-4">Sous-titre du livre</h5>
                    <button class="btn btn-primary px-4" 
                            onclick="openFullscreenBook('{{ asset('storage/contrats/bsTfWTDrXw1t0YXt2sfwbPiu5Po0u1G3IGqWle7O.pdf') }}', 'Titre du Livre')">
                        <i class="fas fa-book-open me-2"></i>Lire
                    </button>
                </div>
            </div>
        </div>

        <!-- Livre 2 -->
        <div class="col-md-4 mb-4 book-card" data-category="technique">
            <div class="card h-100 border-0">
                <div class="card-body text-center">
                    <span class="badge bg-success mb-2">Technique</span>
                    <h3>Guide Pratique</h3>
                    <h5 class="text-muted mb-4">Édition 2023</h5>
                    <button class="btn btn-primary px-4" 
                            onclick="openFullscreenBook('/chemin/vers/livre2.pdf', 'Guide Pratique')">
                        <i class="fas fa-book-open me-2"></i>Lire
                    </button>
                </div>
            </div>
        </div>

        <!-- Livre 3 -->
        <div class="col-md-4 mb-4 book-card" data-category="gestion">
            <div class="card h-100 border-0">
                <div class="card-body text-center">
                    <span class="badge bg-warning text-dark mb-2">Gestion</span>
                    <h3>Apprendre Laravel</h3>
                    <h5 class="text-muted mb-4">Pour débutants</h5>
                    <button class="btn btn-primary px-4" 
                            onclick="openFullscreenBook('/chemin/vers/livre3.pdf', 'Apprendre Laravel')">
                        <i class="fas fa-book-open me-2"></i>Lire
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Livre 4 -->
        <div class="col-md-4 mb-4 book-card" data-category="autres">
            <div class="card h-100 border-0">
                <div class="card-body text-center">
                    <span class="badge bg-secondary mb-2">Autres</span>
                    <h3>Livre sans catégorie</h3>
                    <h5 class="text-muted mb-4">Exemple supplémentaire</h5>
                    <button class="btn btn-primary px-4" 
                            onclick="openFullscreenBook('/chemin/vers/livre4.pdf', 'Livre sans catégorie')">
                        <i class="fas fa-book-open me-2"></i>Lire
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Visionneuse plein écran -->
<div id="fullscreenViewer" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-white" style="z-index: 1050;">
    <div class="position-absolute top-0 end-0 p-3">
        <button class="btn btn-danger btn-lg" onclick="closeFullscreenBook()">
            <i class="fas fa-times"></i> Fermer
        </button>
    </div>
    <div class="container h-100 d-flex flex-column">
        <div class="py-3">
            <h2 id="viewerTitle" class="text-center"></h2>
        </div>
        <div class="flex-grow-1">
            <iframe id="fullscreenBookFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
        <div class="py-3 text-center">
            <a id="fullscreenDownloadBtn" href="#" class="btn btn-primary btn-lg" download>
                <i class="fas fa-download me-2"></i>Télécharger le livre
            </a>
        </div>
    </div>
</div>

<script>
function openFullscreenBook(pdfUrl, title) {
    // Afficher la visionneuse
    const viewer = document.getElementById('fullscreenViewer');
    viewer.classList.remove('d-none');
    viewer.classList.add('d-block');
    
    // Masquer le contenu principal
    document.getElementById('mainContainer').classList.add('d-none');
    
    // Charger le PDF
    document.getElementById('fullscreenBookFrame').src = pdfUrl;
    document.getElementById('viewerTitle').textContent = title;
    document.getElementById('fullscreenDownloadBtn').href = pdfUrl;
    
    // Empêcher le défilement de la page
    document.body.style.overflow = 'hidden';
}

function closeFullscreenBook() {
    // Cacher la visionneuse
    document.getElementById('fullscreenViewer').classList.remove('d-block');
    document.getElementById('fullscreenViewer').classList.add('d-none');
    
    // Afficher le contenu principal
    document.getElementById('mainContainer').classList.remove('d-none');
    
    // Vider la frame
    document.getElementById('fullscreenBookFrame').src = '';
    
    // Rétablir le défilement
    document.body.style.overflow = 'auto';
}

// Fonction de recherche
document.getElementById('searchInput').addEventListener('input', function(e) {
    filterBooks();
});

// Gestion des filtres par catégorie
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Retirer la classe active de tous les boutons
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        // Ajouter la classe active au bouton cliqué
        this.classList.add('active');
        
        filterBooks();
    });
});

function filterBooks() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const activeCategory = document.querySelector('.filter-btn.active').dataset.category;
    
    document.querySelectorAll('.book-card').forEach(book => {
        const title = book.querySelector('h3').textContent.toLowerCase();
        const subtitle = book.querySelector('h5').textContent.toLowerCase();
        const bookCategory = book.dataset.category;
        
        const matchesSearch = title.includes(searchTerm) || subtitle.includes(searchTerm);
        const matchesCategory = activeCategory === 'all' || bookCategory === activeCategory;
        
        if(matchesSearch && matchesCategory) {
            book.style.display = 'block';
        } else {
            book.style.display = 'none';
        }
    });
}

// Fermer avec la touche Escape
document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape') {
        closeFullscreenBook();
    }
});
</script>

<style>
.card {
    transition: transform 0.3s;
}
.card:hover {
    transform: translateY(-5px);
}

#fullscreenViewer {
    background-color: white;
    transition: opacity 0.3s;
}

.badge {
    font-size: 0.8rem;
    padding: 0.35em 0.65em;
}

@media (max-width: 768px) {
    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    
    .btn-group {
        flex-wrap: wrap;
    }
    
    .btn-group .btn {
        margin-bottom: 5px;
    }
}
</style>
@endsection