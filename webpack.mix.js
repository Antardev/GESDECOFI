const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles('node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'public/css/datatables.css')
   .scripts('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/js/datatables.js')
   .scripts('node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js', 'public/js/datatables.bootstrap.js')
   .version();
