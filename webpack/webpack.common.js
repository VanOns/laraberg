const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const path = require('path');

module.exports = {
    entry: './resources/ts/laraberg.ts',
    output: {
        filename: 'js/laraberg.js',
        path: path.resolve(__dirname, '../public'),
        library: {
            name: 'Laraberg',
            type: 'umd'
        }
    },
    module: {
        rules: [
            {
                test: /\.ts?$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.(s[ac]ss|css)$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ]
            }
        ]
    },
    resolve: {
        extensions: ['.ts', '.js'],
    },
    externals: {
        'react': 'React',
        'react-dom': 'ReactDOM'
    },
    optimization: {
        minimizer: [ `...`, new CssMinimizerPlugin() ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/laraberg.css',
        }),
    ]
};
