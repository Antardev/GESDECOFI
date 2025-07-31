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
                    @foreach($categories as $category)
                        <button type="button" class="btn btn-outline-secondary filter-btn" data-category="{{ $category->id }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="booksGrid">
        @forelse($books as $book)
        <div class="col-md-4 mb-4 book-card" 
             data-categories="{{ $book->categories->pluck('id')->implode(',') }}" 
             data-title="{{ strtolower($book->title) }}"
             data-subtitle="{{ strtolower($book->subtitle ?? '') }}">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-img-top" style="height: 200px; overflow: hidden; background: #f5f5f5;">
                    <canvas id="cover-{{ $book->id }}" 
                            data-pdf-url="{{ Storage::url($book->livre) }}"
                            style="width: 100%; height: 100%;"></canvas>
                </div>
                <div class="card-body text-center">
                    <!-- Affichage des catégories -->
                    <div class="mb-2">
                        @forelse($book->categories as $category)
                            <span class="badge bg-{{ $category->color ?? 'secondary' }} me-1">
                                {{ $category->name }}
                            </span>
                        @empty
                            <span class="badge bg-secondary">Autres</span>
                        @endforelse
                    </div>
                    
                    <h3>{{ $book->title }}</h3>
                    <h5 class="text-muted mb-4">{{ $book->subtitle ?? '' }}</h5>
                    
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-primary px-4" 
                                onclick="openFullscreenBook('{{ Storage::url($book->livre) }}', '{{ $book->title }}')">
                                <i class="bi bi-book me-2"></i>Lire
                        </button>
                        {{-- <a href="{{ Storage::url($book->livre) }}" class="btn btn-success px-4" download>
                            <i class="fas fa-download me-2"></i>Télécharger
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                Aucun livre disponible pour le moment.
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Visionneuse plein écran -->
<div id="fullscreenViewer" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-white" style="z-index: 1050;">
    <div class="position-absolute top-0 end-0 p-3">
        <button class="btn btn-danger btn-lg" onclick="closeFullscreenBook()">
            <i class="bi bi-x-lg"></i></i>
        </button>
    </div>
    <div class="container h-100 d-flex flex-column">
        <div class="py-3">
            <h2 id="viewerTitle" class="text-center"></h2>
        </div>
        <div class="flex-grow-1">
            <iframe id="fullscreenBookFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script>
// Fonction pour ouvrir la visionneuse
function openFullscreenBook(pdfUrl, title) {
    const viewer = document.getElementById('fullscreenViewer');
    viewer.classList.remove('d-none');
    viewer.classList.add('d-block');
    document.getElementById('mainContainer').classList.add('d-none');
    document.getElementById('fullscreenBookFrame').src = pdfUrl;
    document.getElementById('viewerTitle').textContent = title;
    document.body.style.overflow = 'hidden';
}

// Fonction pour fermer la visionneuse
function closeFullscreenBook() {
    document.getElementById('fullscreenViewer').classList.remove('d-block');
    document.getElementById('fullscreenViewer').classList.add('d-none');
    document.getElementById('mainContainer').classList.remove('d-none');
    document.getElementById('fullscreenBookFrame').src = '';
    document.body.style.overflow = 'auto';
}

// Fonction de recherche et filtres améliorée
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchInput').addEventListener('input', filterBooks);
    
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterBooks();
        });
    });
});

function filterBooks() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const activeCategory = document.querySelector('.filter-btn.active').dataset.category;
    
    document.querySelectorAll('.book-card').forEach(book => {
        const title = book.dataset.title;
        const subtitle = book.dataset.subtitle;
        const bookCategories = book.dataset.categories.split(',');
        
        // Vérification de la recherche
        const matchesSearch = title.includes(searchTerm) || subtitle.includes(searchTerm);
        
        // Vérification de la catégorie
        const matchesCategory = activeCategory === 'all' || bookCategories.includes(activeCategory);
        
        // Appliquer le filtre
        book.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
    });
}

// Fermer avec la touche Escape
document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape') closeFullscreenBook();
});

pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="cover-"]').forEach(canvas => {
        const pdfUrl = canvas.dataset.pdfUrl;

        pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
            return pdf.getPage(1);
        }).then(page => {
            const viewport = page.getViewport({ scale: 0.5 });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const context = canvas.getContext('2d');
            return page.render({
                canvasContext: context,
                viewport: viewport
            }).promise; // Ensure the rendering promise is returned
        }).catch(error => {
            console.error('Error rendering PDF:', error);
        });
    });
});
</script>

<style>
.card {
    transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

#fullscreenViewer {
    background-color: white;
}

@media (max-width: 768px) {
    .w-50 {
        width: 100% !important;
    }
    .btn-group .btn {
        margin: 2px;
        font-size: 0.8rem;
    }
}
</style>
@endsection