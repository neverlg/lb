var webpack = require('webpack');
var path = require("path");
var ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    //插件项
    plugins: [
        new webpack.optimize.CommonsChunkPlugin('common'),//提取多个入口文件的公共脚本部分，然后生成一个 common.js 来方便多页面之间进行复用
        new webpack.ProvidePlugin({
            // Promise:'es6-promise',
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: {warnings: false}
        }),
    ],
    //页面入口文件配置
    entry: {
        'master/discover' : "src/master/discover.vue",
    },
    //入口文件输出配置
    output: {
        path: path.join(__dirname, "assets/dist"),
        publicPath: '/dist/',
        filename: '[name].js',
    },
    module: {
        //加载器配置
        loaders: [
            // { test: /\.css$/, loader: 'style-loader!css-loader' },
            { test: /\.css$/, loader: ExtractTextPlugin.extract({ fallback: 'style-loader', use: 'css-loader' }) },
            { test: /\.js$/, loader: 'jsx-loader?harmony' },
            // { test: /\.(png|jpg)$/, loader: 'url-loader?limit=8192&name=images/[name].[hash:8].[ext]'},
            { test: /\.(png|jpg)$/, loader: 'url-loader?limit=8192&name=images/[name].[ext]'},
            { test: /\.vue/, loader: 'vue-loader' },
        ]
    },
    resolve: {
        alias: {
            /* 公用路径 */
            assets: path.resolve(__dirname, "assets"),
            src: path.resolve(__dirname, "assets/js"),
            components: path.resolve(__dirname, "assets/js/components"),

            /* 组件类库 */
            areas : path.resolve(__dirname, "static/areas.js"),
            'area-selector' : "components/area-selector.vue",

        }
    },
    externals: {

    }
};