/* Collapse-Magic */

(function($) {

    if ($('.claps-toggle-text').length > 0) {
        //apply the tags and icons to create the toggle
        $(".claps-toggle-text").each(function() {
            //Set some default values in case any data is missing in the transferred div tags
            var expand_title = (typeof $(this).data('title') !== 'undefined')?
                $(this).data('title'): "Expand To Read More";
            var collapse_title = (typeof $(this).data('swaptitle') !== 'undefined')?
                $(this).data('swaptitle'): "Collapse To Read Less";
            var expand_icon = (typeof $(this).data('icon') !== 'undefined')?
                $(this).data('icon'): "&#9660;";
            var collapse_icon = (typeof $(this).data('swapicon') !== 'undefined')?
                $(this).data('swapicon'): "&#9650;";
            var collapse_ht = (typeof $(this).data('ht') !== 'undefined')?
                $(this).data('ht'): "100px";
            var collapse_hf = (typeof $(this).data('hf') !== 'undefined')?
                $(this).data('hf'): "20px";
            var toggle_above = (typeof $(this).data('above') !== 'undefined')?
                $(this).data('above'): 1;
            if (toggle_above==1){
                $(this).prepend('<div class= "claps-text-expand-button"><span class= "claps-text-collapse-button">' +
                    '<span class= "claps-text-toggle-icon">' + expand_icon + '</span> ' + expand_title + '</span></div>');
            } else {
                $(this).append('<div class= "claps-text-expand-button"><span class= "claps-text-collapse-button">' +
                    '<span class= "claps-text-toggle-icon">' + expand_icon + '</span> ' + expand_title + '</span></div>');
            }
            $('.claps-toggle-text .claps-text-toggle-collapsed').css('height', collapse_ht);
            $(this).find(".claps-text-collapse-button").on("click", function() {
                $(this).parent().siblings(".claps-text-inner").toggleClass("claps-text-toggle-expanded");
                $(this).parent().siblings(".claps-text-inner").toggleClass("claps-text-toggle-collapsed");
                if ($(this).parent().siblings("div.claps-text-inner").hasClass("claps-text-toggle-expanded")) {
                    $(this).html("<span class= 'claps-text-toggle-icon'>" + collapse_icon + "</span> " + collapse_title);
                    $('.claps-toggle-text .claps-text-toggle-expanded').css('height', 'auto');
                    // console.log('EXPANDED');
                } else {
                    $(this).html("<span class= 'claps-text-toggle-icon'>" + expand_icon + "</span> " + expand_title);
                    $('.claps-toggle-text .claps-text-toggle-collapsed').css('height', collapse_ht);
                    // console.log('COLLAPSED');
                    if (toggle_above!=1){
                        $('html, body').animate({
                            scrollTop: $(this).closest('.claps-toggle-text').offset().top - 150
                        }, 800); // Adjust the duration as needed
                    }
                }
            });
            $('.claps-toggle-text .claps-text-toggle-collapsed:after').css('height', collapse_hf);
        });
    }

})(jQuery);
