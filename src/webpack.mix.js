const mix = require('laravel-mix');

// const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');
// const CopyWebpackPlugin = require('copy-webpack-plugin');
// const ImageminPlugin = require('imagemin-webpack-plugin').default;
// const imageminMozjpeg = require('imagemin-mozjpeg');
//
// require('laravel-mix-svg-sprite');
// require('laravel-mix-webp');
// require('laravel-mix-polyfill');
// // require('laravel-mix-svg-sprite');
//
// mix.webpackConfig({
//     plugins: [
//         // Создаем svg-спрайт с иконками
//         new SVGSpritemapPlugin(
//             'resources/coreui-icons-2/svg/free/*.svg', // Путь относительно каталога с webpack.mix.js
//             {
//                 output: {
//                     filename: 'public/icons/admin/icons.svg', // Путь относительно каталога public/
//                     svg4everybody: false, // Отключаем плагин "SVG for Everybody"
//                     svg: {
//                         sizes: false // Удаляем инлайновые размеры svg
//                     },
//                     chunk: {
//                         keep: true, // Включаем, чтобы при сборке не было ошибок из-за отсутствия spritemap.js
//                     },
//                     svgo: {
//                         plugins : [
//                             {
//                                 'removeStyleElement': false // Удаляем из svg теги <style>
//                             },
//                             {
//                                 'removeAttrs': {
//                                     attrs: ["fill", "stroke"] // Удаляем часть атрибутов для управления стилями из CSS
//                                 }
//                             },
//                         ]
//                     },
//                 },
//                 sprite: {
//                     prefix: 'icon-', // Префикс для id иконок в спрайте, будет иметь вид 'icon-имя_файла_с_иконкой'
//                     generate: {
//                         title: false, // Не добавляем в спрайт теги <title>
//                     },
//                 },
//             }
//         ),
//         // Копируем картинки из каталога ресурсов в публичный каталог
//         new CopyWebpackPlugin({
//             patterns: [
//                 {
//                     from: 'resources/coreui-icons-2/svg', // Путь относительно каталога с webpack.mix.js
//                     to: 'public/icons/admin', // Путь относительно каталога public/,
//                     globOptions: {
//                         ignore: ["**/icons/**"], // Игнорируем каталог с иконками
//                     },
//                 },
//             ],
//         }),
//         // Оптимизируем качество изображений
//         new ImageminPlugin({
//             test: /\.(jpe?g|png|gif)$/i,
//             plugins: [
//                 imageminMozjpeg({
//                     quality: 80,
//                     progressive: true,
//                 }),
//             ],
//         }),
//     ],
// })
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
//
// mix.styles([
//     'resources/coreui5/css/style.css',
//     'resources/coreui5/css/examples.css',
//     'resources/coreui5/css/ads.css',
//     'resources/coreui5/css/vendors/simplebar.css',
//     'resources/coreui5/vendors/@coreui/chartjs/css/coreui-chartjs.css',
//     // Add more CSS files if needed
// ], 'public/css/app.css');
// mix.scripts([
//     'node_modules/bootstrap/dist/js/bootstrap.js',
//     // Додайте ваші власні скрипти, якщо потрібно
//     'resources/coreui5/js/config.js',
//     'resources/coreui5/js/color-modes.js',
// ], 'public/js/app.js');

// mix.copyDirectory('resources/admin-panel/dist/css', 'public/css');
// mix.copyDirectory('resources/admin-panel/dist/js', 'public/js');
// mix.copyDirectory('resources/admin-panel/dist/assets', 'public/assets');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui/icons/sprites', 'public/icons/sprites');
// mix.copyDirectory('resources/admin-panel/node_modules/simplebar', 'public/node_modules/simplebar');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui/coreui/js', 'public/node_modules/@coreui/coreui/js');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js', 'public/node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js');
// mix.copyDirectory('resources/admin-panel/node_modules/@coreui/utils/dist/umd', 'public/node_modules/@coreui/utils/dist/umd');
