<?php
if( $post_style == 'style_4' ){
    $masonry = 'masonry';
} else {
    $masonry = 'fitRows';
}

wp_enqueue_script('isotope');
wp_enqueue_script('infinite-scroll');
wp_enqueue_script('imagesloaded');
$script = "(function($) {
    \"use strict\";
    var win = $(window);
    win.load(function(){
        var isoOptionsBlog = {
            itemSelector: '.post',
            layoutMode: '".$masonry."',
            masonry: {
                columnWidth: '.post-size'
            },
            percentPosition:true,
        };
        var gridBlog2 = $('#latest-posts .blog-posts');
        gridBlog2.isotope(isoOptionsBlog);       
        win.resize(function(){
            gridBlog2.isotope('layout');
        });
        gridBlog2.infinitescroll({
            navSelector  : '#pagination',    // selector for the paged navigation 
            nextSelector : '#pagination a.next',  // selector for the NEXT link (to page 2)
            itemSelector : '.post',     // selector for all items you'll retrieve
            loading: {
                finishedMsg: 'No more items to load.',
                msgText: '<i class=\"fa fa-spinner fa-spin fa-2x\"></i>'
              },
            animate      : false,
            errorCallback: function(){
                $('a.loadmore').removeClass('active').hide();
                $('a.loadmore').addClass('hide');
            },
            appendCallback: true
            },  // call Isotope as a callback
            function( newElements ) {
                var newElems = $( newElements ); 
                newElems.imagesLoaded(function(){
                    gridBlog2.isotope( 'appended', newElems );
                    gridBlog2.isotope('layout');
                    $('a.loadmore').removeClass('active');
                });
            }
        );
        $('a.loadmore').click(function () {
            $(this).addClass('active');
            gridBlog2.infinitescroll('retrieve');
            return false;
        });
        setTimeout(function(){ $('.page-loading').fadeOut('fast', function (){});}, 100);
    });
    $(window).load(function(){ $(window).unbind('.infscr'); });
})(jQuery)";
wp_add_inline_script('isotope', $script);