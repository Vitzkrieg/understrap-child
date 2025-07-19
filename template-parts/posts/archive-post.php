<?php

/**
 * The template for displaying all IHK Taxonomy page content.
 *
 * @package Malina-IHK
 */

$out = '';

$out .= '<div id="latest-posts">';
$out .= '<h2>' . $section_title . '</h2>';
$out .= '<div id="blog-posts-page" class="row-fluid blog-posts">';

global $post;

foreach ($posts_array as $cat_post) {
    setup_postdata($cat_post);
    $post = $cat_post;

    $classes = join(' ', get_post_class($post->ID));
    $classes .= ' post';

    if(!$ignore_sticky_posts && is_sticky() && strrpos($classes, 'sticky')){
        $out .= '<article class="'.$text_align.' span12 '.$classes.'">';
            $out .= '<div class="post-block-title">';
                if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
                $out .= '<header class="title">';
                $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
                $out .= '</header>';
            $out .= '</div>';
            $out .= '<div class="post-img-block">';
            $out .= malina_get_post_format_content(false, 'large');
            if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
            $out .= '</div>';	
            $out .= '<div class="post-content">';
                if( malina_post_has_more_link( get_the_ID() ) ){
                    $out .= malina_get_the_content();
                } else {
                    $out .= get_the_excerpt();
                }
                $out .= '</div>';
                $out .= '<div class="post-meta'.$bottom_lines.'">';
                    $out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><span>'.esc_html__('Read more', 'inharmony').'</span><i class="la la-long-arrow-right"></i></a></div>';
                    if(function_exists('MalinaSharebox')){
                        $out .= MalinaSharebox( get_the_ID() );
                    }
                $out .= '</div>';
        $out .= '</article>';
    } elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && $post_style == 'style_1' ){
        $classes = str_replace('sticky ', '', $classes);
        $out .= '<article class="post-featured post-size span12 '.$classes.'">';
            $out .= '<div class="post-content-container">';
                $out .= '<div class="post-img-side">';
                if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
                $out .= malina_get_post_format_content(false, 'post-thumbnail');
                $out .= '</div>';
                $out .= '<div class="post-content-side">';
                    if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
                    $out .= '<header class="title">';
                    $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h3>';
                    $out .= '</header>';
                $out .= '<div class="post-content">';
                $out .= '</div>';
                $out .= '</div>';
            $out .= '</div>';
        $out .= '</article>';
    } elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && ($post_style == 'style_2' || $post_style == 'style_3' || $post_style == 'style_5' ) ){
        $classes = str_replace('sticky ', '', $classes);
        $out .= '<article class="post-featured post-featured-style2 span12 '.$classes.'">';
            $out .= '<div class="post-content-container '.$text_align.'">';						
            $out .= '<div class="post-content">';
                $out .= '<div class="post-img-block">';
                if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
                $out .= malina_get_post_format_content(false, 'large');
                $out .= '</div>';
                $out .= '<div class="post-title-block">';
                    if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
                    $out .= '<header class="title">';
                    $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
                    $out .= '</header>';
                $out .= '</div>';
            $out .= '</div>';
            $out .= '</div>';
        $out .= '</article>';
    } elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && $post_style == 'style_4'){
        $classes = str_replace('sticky ', '', $classes);
        $out .= '<article class="post-featured-style4 post-size '.$columns.' '.$classes.'">';
            $out .= '<div class="post-content-container '.$text_align.'">';						
                $out .= '<div class="post-content">';
                    $out .= '<div class="post-img-block">';
                        $out .= '<div class="meta-over-img">';
                        $out .= '<header class="title">';
                        if( $display_categories == 'true' ){
                            $out .= '<div class="meta-categories">'.get_the_category_list(' ').'</div>';
                        }
                        $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
                        $out .= '<div class="meta-date"><time datetime="'.get_the_date(DATE_W3C).'">'.get_the_time(get_option('date_format')).'</time></div>';
                        $out .= '</header>';
                        $out .= '</div>';
                        if( has_post_thumbnail() ) {
                            $out .= '<figure class="post-img"><a href="'.get_the_permalink().'" rel="bookmark">'.get_the_post_thumbnail($post->ID, 'malina-masonry', array('fetchpriority' => 'high', 'loading' => 'eager')).'</a></figure>';
                        }
                    $out .= '</div>';

                $out .= '</div>';
            $out .= '</div>';
        $out .= '</article>';
    } elseif( $post_style == 'style_2' || $post_style == 'style_3' ){
        $classes = str_replace('sticky ', '', $classes);
        if($post_style == 'style_3' ){
            static $i = 0;
            $i++;
            if($i % 2 == 0){
                $post_pos = 'even';
            } else {
                $post_pos = 'odd';
            }
        } else {
            $post_pos = '';
        }
        $out .= '<article class="post-size style_2 '.$post_pos.' span12 '.$classes.'">';
            $out .= '<div class="post-content-container '.$text_align.'">';
                $out .= '<div class="post-img-side">';
                    if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
                    $out .= malina_get_post_format_content(false, $thumbsize);
                $out .= '</div>';
                $out .= '<div class="post-content-side">';
                    if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
                    $out .= '<header class="title">';
                    $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
                    $out .= '</header>';
                $out .= '<div class="post-content">';
                $out .= '</div>';
                $out .= '</div>';
            $out .= '</div>';
        $out .= '</article>';
    } elseif( $post_style == 'style_5' ) {
    $classes = str_replace('sticky ', '', $classes);
    $out .= '<article class="span12 post-size style_5 '.$classes.'">';
        $out .= '<div class="post-content-container">';
            $out .= '<div class="post-img-side">';
                if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
                $out .= malina_get_post_format_content(false, $thumbsize);
            $out .= '</div>';
            $out .= '<div class="post-content-side">';
                if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
                $out .= '<header class="title">';
                $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
                $out .= '</header>';
            $out .= '<div class="post-content">';
            $out .= '</div>';
            $out .= '</div>';
        $out .= '</div>';
    $out .= '</article>';
    } elseif( $post_style == 'style_5_2' ) {
        $classes = str_replace('sticky ', '', $classes);
        $out .= '<article class="span12 post-size style_5 style_5_2 '.$classes.'">';
            $out .= '<div class="post-content-container '.$text_align.'">';
                $out .= '<div class="post-img-side">';
                $out .= malina_get_post_format_content(false, $thumbsize);
                $out .= '</div>';
                $out .= '<div class="post-content-side">';
                    if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
                    $out .= '<header class="title">';
                    $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
                    $out .= '</header>';
                $out .= '<div class="post-content">';
                $out .= '</div>';
                $out .= '</div>';
            $out .= '</div>';
        $out .= '</article>';
    } elseif($post_style == 'style_6') {
        $classes = str_replace('sticky ', '', $classes);
        $out .= '<article class="post-size '.$columns.' '.$post_style.' '.$classes.'">';
            $out .= '<div class="post-content-container '.$text_align.'">';
                $out .= '<div class="post-img-block">';
                if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d', get_the_ID() ).'</span><span class="month">'.get_the_time('M', get_the_ID() ).'</span></div>';
                $out .= malina_get_post_format_content(false, $thumbsize);
                $out .= '</div>';
                $out .= '<div class="post-content-block">';
                    $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
                    $out .= '<header class="title">';
                    $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
                    $out .= '</header>';
                if( function_exists('MalinaSharebox') ){
                    $out .= '<div class="meta-sharebox"><i class="la la-share-alt"></i>';
                        $out .= MalinaSharebox(get_the_ID(), false);
                    $out .= '</div>';
                }
                $out .= '</div>';
            $out .= '</div>';
        $out .= '</article>';
    } else {
        $classes = str_replace('sticky ', '', $classes);
        $out .= '<article class="post-size '.$columns.' '.$post_style.' '.$classes.'">';
            $out .= '<div class="post-content-container '.$text_align.'">';
                $out .= '<div class="post-img-block">';
                    if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
                    $out .= malina_get_post_format_content(false, $thumbsize);
                $out .= '</div>';
                $out .= '<div class="post-content-block">';
                if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
                    $out .= '<header class="title">';
                    $out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'inharmony').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
                    $out .= '</header>';
                    
                $out .= '<div class="post-content">';
                $out .= '</div>';
                $out .= '</div>';
            $out .= '</div>';
        $out .= '</article>';
    }

} // foreach ($cat_posts['post'] as $cat_post)
$out .= '</div>';
if( $pagination == 'true' && get_next_posts_link() ) {
    $out .= '<div id="pagination" class="hide">'.get_next_posts_link().'</div>';
    $out .= '<div class="loadmore-container"><a href="#" class="loadmore button"><span>'.esc_html__('Load More', 'inharmony').'</span></a></div>';
} else {
    if(malina_custom_pagination() != '') {
        $out .= '<div id="pagination">'.malina_custom_pagination().'</div>';
    }
}
$out .= '</div>';
echo ''.$out;

$out = '';