/* Collapse-Magic */

(function($) {

    if ($('.claps-toggle-text').length > 0) {
        //apply the tags and icons to create the toggle

        $('.claps-toggle-text').each(function() {
            //Set some default values in case any data is missing in the transferred div tags

            var $block = $(this);
            var expand_title = $block.data('title') ?? "Expand To Read More";
            var collapse_title = $block.data('swaptitle') ?? "Collapse To Read Less";
            var expand_icon = $block.data('icon') ?? "&#9660;";
            var collapse_icon = $block.data('swapicon') ?? "&#9650;";
            var toggle_above = $block.data('above') ?? 1;

            //Define the --collapse-hf property for the CSS
            //$(this).css('--collapse-hf', collapse_hf);

            var toggle_html = `<div class="claps-text-expand-button">
                <span class="claps-text-collapse-button">
                    <span class="claps-text-toggle-icon">${expand_icon}</span> ${expand_title}
                </span>
            </div>`;

            if (toggle_above === 1) {
                $block.prepend(toggle_html);
            } else {
                $block.append(toggle_html);
            }

            $block.find(".claps-text-collapse-button").on("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $btn = $(this);
                var $block = $btn.closest('.claps-toggle-text');
                var $inner = $block.children('.claps-text-inner').first();
                $inner.toggleClass("claps-text-toggle-expanded claps-text-toggle-collapsed");
                if ($inner.hasClass("claps-text-toggle-expanded")) {
                    $btn.html(`<span class='claps-text-toggle-icon'>${collapse_icon}</span> ${collapse_title}`);
                } else {
                    $btn.html(`<span class='claps-text-toggle-icon'>${expand_icon}</span> ${expand_title}`);

                    if (toggle_above !== 1) {
                        $('html, body').animate({
                            scrollTop: $block.offset().top - 150
                        }, 800);
                    }
                }
            });

        });

    }

})(jQuery);
