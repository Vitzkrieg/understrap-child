/**
 * Load more posts
 */

jQuery(function ($) {

    function loadMorePosts() {
        const str_loading = loadmore_params.str_loading || "Loading...",
        str_load_more = loadmore_params.str_load_more || "More Posts",
        container_id = loadmore_params.container_id || "ih-latest-posts__list";
        
        $('#load-older-posts a button')
        .text(str_load_more)
        .on('click', function (e) {
            e.preventDefault();
            var button = $(this),
                data = {
                    'action': 'loadmore',
                    'query': loadmore_params.posts, // that's how we get params from wp_localize_script() function
                    'page': loadmore_params.current_page,
                    'skip_ids': loadmore_params.skip_ids,
                    'posts_per_page': loadmore_params.posts_per_page,
                    'security': loadmore_params.security
                };
    
            $.ajax({ // you can also use $.post here
                url: loadmore_params.ajaxurl, // AJAX handler
                data: data,
                type: 'POST',
                beforeSend: function (xhr) {
                    button.text(str_loading); // change the button text, you can also add a preloader image
                },
                success: function (data) {
                    // exit if no data returned
                    if (!data.length) {
                        button.remove();
                        return;
                    }

                    const articles = $('#' + container_id).append(data).find('article');
    
                    loadmore_params.current_page++;

                    const curr = loadmore_params.current_page;
                    const max = parseInt(loadmore_params.max_page);
                    const count = parseInt(loadmore_params.page_count);

                    if (curr < max) {
                        button.text(str_load_more);
                    } else {
                        button.remove();
                    }

                    const scroll_index = (curr - 1) * count + 1;
                    const post = articles[scroll_index];

                    if (post) {
                        post.scrollIntoView({behavior: "smooth", block: "center"});
                    }
    
                    // you can also fire the "post-load" event here if you use a plugin that requires it
                    $(document.body).trigger('post-load');
                },
                error: function() {
                    button.remove();
                }
            });
        });
    }
    if (typeof loadmore_params !== 'undefined') loadMorePosts();
});