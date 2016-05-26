(function($) {
  $(function() {
    $("a[rel=tooltip]").mouseenter(function() {
      var that = $(this);
      that.tooltip('show');
      setTimeout(function() {
        that.tooltip('hide');
      }, 2000);
    });

    $("a[rel=tooltip]").mouseleave(function() {
      $(this).tooltip('hide');
    })
  });
})(jQuery)