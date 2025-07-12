jQuery(document).ready(function() {
    jQuery("body").on('click', '.item-vote a', function() {
        const $link = jQuery(this);
        const post_id = $link.data("post_id");
        const type = $link.data("type");
        const $icon = $link.find('span.qtip i');
        const $label = $link.find('span.label');
        
        $link.addClass('disabled'); // Disable the link to prevent multiple clicks
        $label.text(ihk_like_post.updating); // Update label to updating state

        jQuery.ajax({
            type: "post",
            url: ihk_like_post.url,
            data: {
                action: "post-like",
                post_id: post_id,
                type: type,
            },
            success: function(a) {
                if (a.indexOf('already') == -1) {
                    $link.addClass(type);
                    $icon.removeClass('fa-regular').addClass('fa-solid');
                    $label.text(ihk_like_post[a]);
                } else {
                    // If the user clicks again to unlike
                    $link.removeClass(type);
                    $icon.removeClass('fa-solid').addClass('fa-regular');
                    $label.text(ihk_like_post[a]);
                }
            },
            error: function(e) {
                console.error('Error processing the like action.', e.message);
            },
            complete: function() {
                $link.removeClass('disabled'); // Re-enable the link after the request completes
            }
        });
        return false;
    });
});