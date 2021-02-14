jQuery(document).ready(function ($) {
  $(window).on("load", function() {
    $('.equalized-group').each(function(){
      let heighest = 0;
      $(this).find('.equalized-item').each(function(){
        heighest = ($(this).height() > heighest) ? $(this).height() : heighest;
      });
      $('.equalized-item').height(heighest)
      heighest = 0;
    });
  });
});
