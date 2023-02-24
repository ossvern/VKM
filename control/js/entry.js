// const siteUrl = 'http://localhost/medical-technopark.com.ua/amn';
const siteUrl = 'https://control.tourism.volyn.ua';

var $ = require("jquery");
window.jQuery = $;

// require('ckeditor4');


$(document).ready(function () {
    CKEDITOR.replaceClass = 'ckeditor';
    // CKEDITOR.replace( 'infoRu' );
    // CKEDITOR.replace( 'infoUk' );
});
$(window).on("resize", function () {

});
$(window).on("scroll", function () {

});


import 'normalize.css';

require('../fonts/font.css');
require('../css/style.less');





function strlen(string)
{
    return string.length;
}

function GoTo(vol) {
    location = vol
}

function DoYou(vol) {
    var ok = confirm("Ви точно Бажаєте видалити?")
    if (ok)
        location = vol
}



//https://www.iconfinder.com/iconsets/office-222


// npm i --save-dev webpack webpack-cli mini-css-extract-plugin script-loader file-loader less css-loader less-loader jquery html-webpack-plugin terser-webpack-plugin optimize-css-assets-webpack-plugin normalize.css

// ckeditor4