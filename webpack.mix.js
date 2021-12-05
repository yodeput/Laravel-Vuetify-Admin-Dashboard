const mix = require('laravel-mix')
const path = require('path')
require('vuetifyjs-mix-extension')

const webpack = {
    resolve: {
        alias: {
            '@resources': path.resolve(__dirname, 'resources/'),
            '@assets': path.resolve(__dirname, 'resources/assets/'),
            '@': path.resolve(__dirname, 'resources/js/src/'),
            'apexcharts': path.resolve(__dirname, 'node_modules/apexcharts-clevision'),
        },
    },
    module: {
        rules: [
            {
                test: /(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/,
                use: [
                    {
                        loader: "file-loader",
                        options: {
                            name: 'assets/images/[path][name].[ext]',
                            context: 'resources/src/assets/images'
                        }
                    }
                ],

            }
        ]
    },
}

mix.webpackConfig(webpack)

mix.js('resources/js/app.js', 'public/js')
    .vuetify('vuetify-loader', './resources/sass/styles/variables.scss').options({
    processCssUrls: false
    })
    .vue()
    .copyDirectory('resources/js/src/assets/images', 'public/assets/images')

mix.webpackConfig({
    output: {
        chunkFilename: 'js/chunks/[name].[chunkhash].js',
    },
})
