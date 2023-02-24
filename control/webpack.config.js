'use strict';

const webpack = require('webpack');
const path = require('path');
const publicPath = './';

const TerserJSPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');


module.exports = {

    optimization: {
        minimize: true,
        minimizer: [new TerserJSPlugin({
            cache: true, parallel: false, terserOptions: { output: {comments: false} }
        }), new OptimizeCSSAssetsPlugin({safe: true, discardComments: { removeAll: true } })],
    },


    context: __dirname,
    target: 'web',
    // mode: 'development',
    mode: 'production',
    entry: publicPath + 'js/entry',

    output: {
        path: path.resolve(__dirname, publicPath + 'js'),
        filename: 'bundle.js',
        publicPath: path.build,
    },

    watch: true,
    watchOptions: {
        aggregateTimeout: 100
    },


    module: {
        rules: [
            {
                test: /\.less$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "less-loader"
                ]
            },
            {
                test: /\.css$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            publicPath: '../css/',
                        }
                    },
                    "css-loader"
                ],

            },
            {
                test: /\.(png|svg|jpg|gif)$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '../img/[name].[ext]',
                        limit: 10000
                    }
                }]
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '../fonts/[name].[ext]',
                            limit: 10000
                        }
                    }
                ]
            }
        ]
    },




    plugins: [

        new MiniCssExtractPlugin({
            filename: "../css/style.css",
        }),

        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery"
        }),
    ],
};