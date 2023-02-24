const path = require("path");
const webpack = require('webpack');

module.exports = {
  entry: [
    __dirname + "/css/_variables.scss",
    __dirname + "/js/entry.js",
  ],
  output: {
    path: path.resolve(__dirname),
    filename: "js/bundle.js",
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [],
      },

      {
        test: /\.scss$/,
        use: [
          {
            loader: "file-loader",
            options: { outputPath: "css/", name: "[name].css" },
            // options: { outputPath: "css/", name: "style.css" },
          },
          {
            loader: "postcss-loader",
            options: {
              // All postcss options is now under `postcssOptions`
              postcssOptions: {
                plugins: [require("autoprefixer")],
              },
              sourceMap: true,
            },
          },
          {
            loader: "sass-loader",
            options: { sourceMap: true },
          },
        ],
      },
      {
        test: /\.css$/i,
        use: ["style-loader", "css-loader"],
      },
      {
        test: /\.(?:|gif|png|jpg|svg)$/,
        type: "asset/inline",
      },
    ],
  },
  plugins: [

    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
      "window.jQuery": "jquery"
    }),


  ],
};
