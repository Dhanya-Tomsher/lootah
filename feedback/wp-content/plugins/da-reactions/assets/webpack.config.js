const path = require('path');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
var CopyWebpackPlugin = require('copy-webpack-plugin');


module.exports = {
    entry: {
        admin: './src/script/admin.es6',
        'admin.premium': './src/script/admin.premium.es6',
        'admin.menu': './src/script/admin.menu.es6',
        public: './src/script/public.es6',
        gutenberg: './src/script/gutenberg.block.js',
        css: [
            './src/style/admin.scss',
            './src/style/public.scss'
        ]
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'dist')
    },
    mode: 'production',
    // mode: 'development',
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].css',
                        }
                    },
                    {
                        loader: 'extract-loader'
                    },
                    {
                        loader: 'css-loader?-url'
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: () => [require('autoprefixer')]
                        }
                    },
                    {
                        loader: 'sass-loader'
                    }
                ]
            }
        ]
    },
    stats: {
        colors: true
    },
    devtool: 'source-map',
    performance: {
        maxEntrypointSize: 512000,
        maxAssetSize: 512000
    },
    plugins: [
        new FixStyleOnlyEntriesPlugin(),
        new CopyWebpackPlugin([
            {from:'src/image',to:''}
        ]),
    ],
};
