// const siteUrl = 'https://mzhk.com.ua';
const siteUrl = "https://volynmuseum.com";
// const siteUrl = 'https://vkm.oss-studio.com';

var $ = require("jquery");
window.jQuery = $;

import {
  GoTo,
  strlen,
  bodyFixPosition,
  bodyUnfixPosition,
  DoYou,
  escapeHtml,
} from "./module-base.js";

import "owl.carousel/dist/assets/owl.carousel.css";
import "owl.carousel/dist/assets/owl.theme.default.min.css";
import "owl.carousel";

import "jquery.cookie";

import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";

// import variables from '../css/_variables.scss';

$(document)
  .ready(function () {
    function upClass() {
      let bgColor, textColor;
      let newTheme = $.cookie("theme");
      let newSize = $.cookie("size");

      let bgColor_ = $.cookie("bgColor");
      let textColor_ = $.cookie("textColor");

      if (newSize) {
        $("body").attr("data-size", $.cookie("size"));
      }

      if (newTheme) {
        $("body").attr("data-theme", $.cookie("theme"));

        switch (newTheme) {
          case "-light":
            bgColor = "#fff";
            textColor = "#000";
            break;
          case "-dark":
            bgColor = "#000";
            textColor = "#fff";
            break;
          case "-yellow":
            bgColor = "#ffc400";
            textColor = "#000";
            break;
          case "-sepia":
            bgColor = "#f0d3a8";
            textColor = "#000";
            break;
          case "-inv":
            bgColor = "#fff";
            textColor = "#000";
            break;
        }
        $("body").removeAttr("style").css({
          "--bg-color": bgColor,
          "--text-color": textColor,
        });
      }

      if (bgColor_ || textColor_) {
        newTheme = "";
        $("body").removeAttr("style").css({
          "--bg-color": bgColor_,
          "--text-color": textColor_,
        });

        if (bgColor_) {
          $(".js-bgColor").val(bgColor_).css("background-color", bgColor_);
        }
        if (textColor_) {
          $(".js-textColor")
            .val(textColor_)
            .css("background-color", textColor_);
        }
      }

      $("body").attr("class", newTheme + " " + newSize);
    }

    upClass();

    $(".panelVision input").change(function (e) {
      $.cookie("theme", "");

      if ($(this).hasClass("js-bgColor")) {
        let newColor = $(this).val();
        $.cookie("bgColor", newColor, { expires: 7, path: "/" });
      }
      if ($(this).hasClass("js-textColor")) {
        let newColor = $(this).val();
        $.cookie("textColor", newColor, { expires: 7, path: "/" });
      }

      upClass();
    });

    $(".panelVision a").click(function (e) {
      e.preventDefault();
      let newTheme = $(this).data("theme");
      let newSize = $(this).data("size");
      if (newTheme != "" && newTheme !== undefined) {
        $.cookie("theme", newTheme, { expires: 7, path: "/" });
        $.cookie("bgColor", "");
        $.cookie("textColor", "");
      }
      if (newSize != "" && newSize !== undefined) {
        $.cookie("size", newSize, { expires: 7, path: "/" });
      }
      upClass();
    });

    //======== panel show reset close
    $("a.-vision").click(function (e) {
      e.preventDefault();
      $(".panelVision").toggleClass("show");
      $("header .container form").removeClass("show");
    });
    $(".panelVision a.-reset").click(function (event) {
      event.preventDefault();
      $.cookie("size", "");
      $.cookie("theme", "");
      $.cookie("bgColor", "");
      $.cookie("textColor", "");
      $("body").removeAttr("style");

      $(".js-bgColor").attr("value", "#fff").css("background-color", "#fff");
      $(".js-textColor").attr("value", "#000").css("background-color", "#000");

      // upClass();
      // $(".panelVision").toggleClass("show");
      location.reload();
    });
    $(".panelVision a.-close").click(function (event) {
      event.preventDefault();
      $(".panelVision").toggleClass("show");
    });

    $(".info-text img").removeAttr("width").removeAttr("height");
    $(".info-text .btn.btn-default").remove();

    $(".pageHome__about .-item:first").addClass("act");
    $(".pageHome__about .-item .nav a").click(function (event) {
      event.preventDefault();
      if ($(this).hasClass("js-prev")) {
        $(".pageHome__about .-item").toggleClass("act");
      }
      if ($(this).hasClass("js-next")) {
        $(".pageHome__about .-item").toggleClass("act");
      }
    });

    // if (window.location.pathname == '/') {
    //   $('header.euroholding .container nav > a:first-child,
    // footer.euroholding .container nav > a:first-child').addClass('-act');
    // }

    $(".owl-partners").owlCarousel({
      autoPlay: 4000,
      stopOnHover: true,
      navigation: true,
      nav: false,
      paginationSpeed: 4000,
      goToFirstSpeed: 4000,
      singleItem: true,
      autoHeight: true,
      transitionStyle: "fade",
      items: 5,
      loop: false,
      autoplay: false,
      autoplayTimeout: 6000,
      autoplayHoverPause: false,
      responsive: {
        0: {
          items: 1,
        },
        400: {
          items: 2,
        },
        700: {
          items: 3,
        },
        1000: {
          items: 4,
        },
        1200: {
          items: 5,
        },
      },
      // navText: ["<i class='-prev'><</i>", "<i class='-next'>></i>"],
    });

    $(".info-text img").removeAttr("style");

    $("img.js-lazy:lt(4)").each(function () {
      if ($(this).isInViewport() === true) {
        $(this).attr("src", $(this).data("src")).removeAttr("data-src");
      }
    });

    if ($("body").width() <= 768) {
      $("a.-bars").click(function (e) {
        e.preventDefault();
        $("header .container nav").addClass("show");
        bodyFixPosition();
      });
      $("a.-close").click(function (e) {
        e.preventDefault();
        $("header .container nav").removeClass("show");
        bodyUnfixPosition();
      });

      $("a.-search").click(function (e) {
        e.preventDefault();
        $("header .container form").toggleClass("show");
      });
    }

    $(".el-gotop").click(function () {
      $("body,html").animate(
        {
          scrollTop: 0,
        },
        400
      );
      return false;
    });
  })
  .on("scroll", function () {
    let scrollPos = $(document).scrollTop();

    $("img.js-lazy").each(function () {
      if ($(this).isInViewport() === true) {
        $(this).attr("src", $(this).data("src")).removeAttr("data-src");
      }
    });

    $(".js-stop").click(function (e) {
      e.preventDefault();
    });

    // if ($(document).width() > 900) {
    //   if ($('div').hasClass('o-grass1')) {
    //     doParalax($(".o-grass1"), -2);
    //   }
    //   if ($('div').hasClass('o-grass2')) {
    //     doParalax($(".o-grass2"), 2);
    //   }
    // }

    if (scrollPos > 90) {
      $(".el-gotop").removeClass("hidden");
    } else {
      $(".el-gotop").addClass("hidden");
    }
  });

$(window).on("load", function () {
  $("#preloader").delay(200).fadeOut("60");
});

// import 'normalize.css';

// require('../fonts/font.scss');
require("../css/style.scss");

$.fn.isInViewport = function () {
  var elementTop = $(this).offset().top;
  var elementBottom = elementTop + $(this).outerHeight();

  var viewportTop = $(window).scrollTop();
  var viewportBottom = viewportTop + $(window).height();

  return elementBottom > viewportTop && elementTop < viewportBottom;

  //        return true;
};
