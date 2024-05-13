let mix = require('laravel-mix');
require('laravel-mix-svg-sprite');

// mix.copyDirectory('node_modules/@coreui', 'public/node_modules/@coreui');
// mix.copyDirectory('node_modules/@coreui/icons/sprites', 'public/icons/sprites');
// mix.copyDirectory('node_modules/@coreui/icons', 'public/icons');
// mix.copyDirectory('node_modules/simplebar', 'public/node_modules/simplebar');
// mix.copyDirectory('resources/admin-panel/dist/js', 'public/js');
// mix.copyDirectory('resources/admin-panel/dist/css', 'public/css');
// mix.copyDirectory('resources/admin-panel/src/assets', 'public/assets');
// mix.copyDirectory('resources/admin-panel/dist/icons', 'public/icons');
// mix.copyDirectory('resources/admin-panel/dist/assets', 'public/assets');
// mix.copyDirectory('node_modules/@coreui', 'public/node_modules/@coreui');
// mix.copyDirectory('resources/admin-panel/dist/base', 'public/base');
// mix.copyDirectory('resources/admin-panel/dist/buttons', 'public/buttons');
// mix.copyDirectory('resources/admin-panel/dist/forms', 'public/forms');
// mix.copyDirectory('node_modules/chart.js', 'public/node_modules/chart.js');
//
//
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui', 'public/node_modules/@coreui');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui', 'public/node_modules/@coreui');

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css', [
//         //
//     ]);

mix.styles([
    'resources/coreui5/css/style.css',
    'resources/coreui5/css/examples.css',
    'resources/coreui5/css/ads.css',
    'resources/coreui5/css/vendors/simplebar.css',
    'resources/coreui5/vendors/@coreui/chartjs/css/coreui-chartjs.css',
    // Add more CSS files if needed
], 'public/css/app.css');
mix.scripts([
    'node_modules/bootstrap/dist/js/bootstrap.js',
    // Додайте ваші власні скрипти, якщо потрібно
    'resources/coreui5/js/config.js',
    'resources/coreui5/js/color-modes.js',
], 'public/js/app.js');

// mix.copyDirectory('resources/admin-panel/dist/css', 'public/css');
// mix.copyDirectory('resources/admin-panel/dist/js', 'public/js');
// mix.copyDirectory('resources/admin-panel/dist/assets', 'public/assets');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui/icons/sprites', 'public/icons/sprites');
// mix.copyDirectory('resources/admin-panel/node_modules/simplebar', 'public/node_modules/simplebar');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui/coreui/js', 'public/node_modules/@coreui/coreui/js');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js', 'public/node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui/utils/dist/umd', 'public/node_modules/@coreui/utils/dist/umd');
