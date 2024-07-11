(function (jQuery) {
    "use strict";

    /*---------------------------------------------------------------------
    Page Loader
    -----------------------------------------------------------------------*/
    // jQuery("#load-page").delay(1000).fadeOut(0);
    jQuery("#load-page").show();
    window.addEventListener('load', function() {
        jQuery("#load-page").fadeOut(0);
    })
    
    jQuery(".alert-box").fadeIn(0).fadeOut(6000);

    $('.alert-box').bind("mouseenter", function(){
        $('.alert-box').stop(true).fadeIn(600); //$('#select'), not ('#select')
    });

    $('.alert-box').bind("mouseleave", function(){
        $('.alert-box').stop(true).fadeOut(6000); //$('#select'), not ('#select')
    });



})(jQuery);