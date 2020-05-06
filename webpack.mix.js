let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copyDirectory('resources/assets/admin/images', 'public/admin/images');

// mix.js('resources/assets/admin/js/app.js', 'public/admin/js')
//     .js('resources/assets/admin/js/common.js', 'public/admin/js');
//     .js('resources/assets/admin/plugins/forms/selects/bootstrap_multiselect.js', 'public/admin/plugins/forms')
//     .js('resources/assets/admin/plugins/forms/selects/select2.min.js', 'public/admin/plugins/forms')
//     .js('resources/assets/admin/plugins/extensions/jquery_ui/interactions.min.js', 'public/admin/plugins/extentions/jquery-ui')
//     .js('resources/assets/admin/plugins/forms/tags/tagsinput.min.js', 'public/admin/plugins/forms/tags')
//     .js('resources/assets/admin/plugins/forms/tags/tokenfield.min.js', 'public/admin/plugins/forms/tags')
//     .js('resources/assets/admin/plugins/pickers/daterangepicker.js', 'public/admin/plugins/pickers/daterangepicker')
//     .js('resources/assets/admin/plugins/notifications/jgrowl.min.js', 'public/admin/plugins/notifications')
//     .js('resources/assets/admin/plugins/notifications/noty.min.js', 'public/admin/plugins/notifications')
//     .js('resources/assets/admin/plugins/notifications/sweet_alert.min.js', 'public/admin/plugins/notifications');


mix.sass('resources/assets/admin/sass/app.scss', 'public/admin/css')
    .sass('resources/assets/admin/sass/common/common.scss', 'public/admin/css/common')
    .sass('resources/assets/admin/sass/list/list.scss', 'public/admin/css/list')
    .sass('resources/assets/admin/sass/form/form.scss', 'public/admin/css/form');

mix.js('resources/assets/admin/js/app.js', 'public/admin/js')
    .js('resources/assets/admin/js/common.js', 'public/admin/js');

mix.copyDirectory('resources/assets/admin/js/main', 'public/admin/js/main');
mix.copyDirectory('resources/assets/admin/js/plugins', 'public/admin/js/plugins');

mix.copyDirectory('resources/assets/front', 'public');
mix.copyDirectory('resources/assets/admin/icons', 'public/icons');


mix.disableNotifications();