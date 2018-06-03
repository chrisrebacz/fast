const elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');

const plugin = {

}

const theme = [
   './node_modules/bootstrap-sass/assets/javascripts/bootstrap.js', 
   './node_modules/clipboard/dist/clipboard.js',
   './web/app/themes/youknow-theme/resources/libs/bootstrap-growl/bootstrap-growl.js',
   './web/app/themes/youknow-theme/resources/libs/malihu-custom-scrollbar-plugin/jQuery.mCustomScrollbar.js',
   './web/app/themes/youknow-theme/resources/libs/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
   './web/app/themes/youknow-theme/resources/libs/footable/js/footable.js',
   './web/app/themes/youknow-theme/resources/libs/footable/js/footable.filter.js',
   './web/app/themes/youknow-theme/resources/libs/footable/js/footable.grid.js',
   './web/app/themes/youknow-theme/resources/libs/footable/js/footable.paginate.js',
   './web/app/themes/youknow-theme/resources/libs/footable/js/footable.sort.js',
   './web/app/themes/youknow-theme/resources/libs/footable/js/footable.striping.js',
   './web/app/themes/youknow-theme/resources/scripts/functions.js'
];

elixir((mix) => {
    mix.sass('./web/app/themes/youknow-theme/resources/styles/youknow.scss', './web/app/themes/youknow-theme/assets/css');
    mix.sass('./web/app/themes/youknow-theme/resources/styles/editor-style.scss', './web/app/themes/youknow-theme/assets/css');
    mix.scripts(theme, './web/app/themes/youknow-theme/assets/js/youknow.js');
});
