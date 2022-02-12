const mix = require('laravel-mix');

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

// mix.override(webpackConfig => {
//     // console.log(webpackConfig.module.rules);    // Valid dump rules
//     webpackConfig.module.rules.forEach(rule => {
//         console.log('--> current rules test:');
//         console.log(rule.test);
//         console.log('--> current rules use:');
//         if(Array.isArray(rule.use)){
//             rule.use.forEach(ruleItem => {
//                 console.log('current ruleItem Loader:');
//                 console.log(ruleItem.loader);

//                 console.log('current ruleItem Option:');
//                 console.log(ruleItem.options);
//             });
//         } else{
//             console.log('--> current rule:')
//             console.log(rule);
//         }    
        
//     });
// });

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

mix.disableNotifications();
