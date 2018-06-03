var elixir = require('laravel-elixir');

var scripts = [
    './node_modules/bootstrap-sass/assets/javascripts/bootstrap.js', 
    './node_modules/clipboard/dist/clipboard.js',
    './resources/libs/bootstrap-growl/bootstrap-growl.js',
    './resources/libs/malihu-custom-scrollbar-plugin/jQuery.mCustomScrollbar.js',
    './resources/libs/footable/js/footable.js',
    './resources/libs/footable/js/footable.filter.js',
    './resources/libs/footable/js/footable.grid.js',
    './resources/libs/footable/js/footable.paginate.js',
    './resources/libs/footable/js/footable.sort.js',
    './resources/libs/footable/js/footable.striping.js',
    './resources/scripts/functions.js'
];


elixir((mix) => {
    mix.sass('./resources/styles/youknow.scss', './assets/css/youknow.css');
    mix.scripts(scripts, './assets/js/youknow.js');
});
