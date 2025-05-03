(function ($) {
  $.fn.startLoading = function () {
    return this.each(function () {
      $(this).attr("disabled", true).addClass("disabled");

      $spinner = $(this).find(".spinner-border");
      $spinner.removeClass("d-none");
    });
  };

  $.fn.stopLoading = function () {
    return this.each(function () {
      $(this).removeAttr("disabled").removeClass("disabled");

      $spinner = $(this).find(".spinner-border");
      $spinner.addClass("d-none");
    });
  };
})(jQuery);
