(function ($) {
    $(window).on("elementor/frontend/init", function () {
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/PE Searchs.default",
        function (scope, $) {
          var $HeroPop = $(scope).find(".search");
          $HeroPop.click(function(){
            $(".search-section").toggleClass("open");
          });
        }
      );
    });
  });
  