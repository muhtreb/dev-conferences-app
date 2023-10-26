const Encore = require('@symfony/webpack-encore');
const path = require('path');
const webpack = require('webpack');

Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.ts')
    .splitEntryChunks()
    .copyFiles(
        {
            from: './assets/favicon',
        }
    )
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .enableSassLoader()
    .enableTypeScriptLoader()
    .enablePostCssLoader()
    .enableVueLoader(() => {
    }, {
        version: 3,
        runtimeCompilerBuild: true
    })
    .addPlugin(
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false
        })
    )
    .addAliases(
        {
            '@': path.resolve(__dirname, 'assets'),
            'vue$': 'vue/dist/vue.esm-bundler.js'
        }
    )
;

module.exports = Encore.getWebpackConfig();
