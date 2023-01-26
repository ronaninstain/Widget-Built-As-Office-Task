(function ($) {
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/pe-latest-posts-sliders.default",
      function (scope, $) {
        var $HeroSlider = $(scope).find(".owl-bundle");
        if ($HeroSlider.length > 0) {
          $HeroSlider.owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            dots: false,
            nav: true,
            navText: [
              "<i class='fa fa-chevron-left'></i>",
              "<i class='fa fa-chevron-right'></i>",
            ],

            responsive: {
              0: {
                items: 1,
                nav: true,
              },
              400: {
                items: 2,
                nav: true,
              },
              1000: {
                items: 3,
                nav: true,
              },
            },
          });
        }
      }
    );
  });
})(jQuery);

(function ($) {
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/ali_course_slider.default",
      function (scope, $) {
        var $HeroSlider = $(scope).find(".owl-ali");
        if ($HeroSlider.length > 0) {
          $HeroSlider.owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            dots: false,
            nav: true,
            navText: [
              "<i class='fa fa-chevron-left'></i>",
              "<i class='fa fa-chevron-right'></i>",
            ],

            responsive: {
              0: {
                items: 1,
                nav: true,
              },
              400: {
                items: 2,
                nav: true,
              },
              1000: {
                items: 4,
                nav: true,
              },
            },
          });
        }
      }
    );
  });
})(jQuery);
