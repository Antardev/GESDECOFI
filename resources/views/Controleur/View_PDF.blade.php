<!DOCTYPE html>
<html lang="fr">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard to manage DECOFI Stage">
	<meta name="author" content="GestionDECOFI">
	<meta name="keywords" content="Student, dashboard, Management, DECOFI, accountant, ui kit, web">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    </head>
<body>
    
<div>
    <canvas id="pdf-canvas"></canvas>
    <div>
        <button id="prev" class="btn btn-primary">Précédent</button>
        <button id="next" class="btn btn-primary">Suivant</button>
    </div>
</div>

<script>
    const url = '{{ asset('storage/' . $pdf) }}';
    let pdfDoc = null;
    let pageNum = 1;

    pdfjsLib.getDocument(url).promise.then(pdf => {
        pdfDoc = pdf;
        renderPage(pageNum);
    });

    function renderPage(num) {
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale: 1 });
            const canvas = document.getElementById('pdf-canvas');
            const context = canvas.getContext('2d');

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: context,
                viewport: viewport,
            };
            page.render(renderContext);
        });
    }

    document.getElementById('next').addEventListener('click', () => {
        if (pdfDoc && pageNum < pdfDoc.numPages) {
            pageNum++;
            renderPage(pageNum);
        }
    });

    document.getElementById('prev').addEventListener('click', () => {
        if (pdfDoc && pageNum > 1) {
            pageNum--;
            renderPage(pageNum);
        }
    });
</script>
</body>
</html>