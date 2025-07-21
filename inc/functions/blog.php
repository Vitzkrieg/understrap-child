<?php

if ( ! function_exists( 'inharmony_hide_posted_on' ) ) {
	/**
	 * Hides the posted on markup in `understrap_posted_on()`.
	 *
	 * @param string $posted_on Posted on HTML markup.
	 * @return string Maybe filtered posted on HTML markup.
	 */
	function inharmony_hide_posted_on( $posted_on ) {
		return '';
	}
}
add_filter( 'understrap_posted_on', 'inharmony_hide_posted_on' );

if ( ! function_exists( 'inharmony_hide_posted_by' ) ) {
	/**
	 * Hides the posted on markup in `understrap_posted_by()`.
	 *
	 * @param string $byline Posted by HTML markup.
	 * @return string Maybe filtered posted by HTML markup.
	 */
	function inharmony_hide_posted_by( $byline ) {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
            $meta = '';
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'understrap' ) );
			if ( $categories_list && understrap_categorized_blog() ) {
				/* translators: %s: Categories of current post */
				$meta .= sprintf( '<span class="cat-links">' . esc_html__( '%s', 'understrap' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'understrap' ) );
			if ( $tags_list ) {
				/* translators: %s: Tags of current post */
				$meta .= sprintf( '<span class="tags-links">' . esc_html__( '%s', 'understrap' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

            if ($meta != '') {
                $meta = '<br />' . $meta;
            }

            $byline .= $meta;
		}
		return $byline;
	}
}
add_filter( 'understrap_posted_by', 'inharmony_hide_posted_by' );

if ( ! function_exists( 'understrap_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function understrap_entry_footer() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'understrap' ), esc_html__( '1 Comment', 'understrap' ), esc_html__( '% Comments', 'understrap' ) );
			echo '</span>';
		}
		understrap_edit_post_link();
	}
}

if ( ! function_exists( 'inharmony_read_time' ) ) {
	/**
	 * Prints HTML with meta information for post read time.
     * TODO: create settings for rate,prefix,suffix, where to display
	 * TODO: check that this works in query loop
	 */
	function inharmony_read_time() {
		global $post;
        $read = is_page_template('blogpage.php') . ' ';
        $rate = 300;
        $prefix = "Read time: ";
        $suffix_singular = " minute";
        $suffix_plural = " minutes";

		if ( is_single() || 'post' === get_post_type($post) ) {
            $words = wp_strip_all_tags(get_the_content());
            $count = str_word_count($words);
            $time = round($count / $rate);
            if ($time < 1) {
                $time = 1;
            }
            $suffix = ($time == 1) ? $suffix_singular : $suffix_plural;
			$read .= sprintf( '<span class="read-time">' . esc_html__( '%s %d %s', 'understrap' ) . '</span>', $prefix, $time, $suffix ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
        
        echo $read;
	}
}



if ( ! function_exists( 'inharmony_custom_excerpt_length' ) ) {
	/**
	 * Filter the_excerpt length to 20 words.
	 * WP default: 55
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	function inharmony_custom_excerpt_length( $length ) {
		if ( is_page_template( 'page-templates/blogpage.php' ) ) {
			return 55;
		} else if ( is_front_page() && is_home() ) {
			return 80;
		}

		return $length;
	}

}
add_filter( 'excerpt_length', 'inharmony_custom_excerpt_length', 999 );

/**
 * Adds a custom read more link to all excerpts, manually or automatically generated
 *
 * @param string $post_excerpt Posts's excerpt.
 *
 * @return string
 */
function understrap_all_excerpts_get_more_link( $post_excerpt ) {
	global $template;
	if ( ! is_admin() ) {
		if ( basename($template) == 'blogpage.php' ) {
			$post_excerpt = $post_excerpt . ' [...]';
		} else if ( !is_product() ){
			$more_styles = array(
				'btn',
				'btn-' . get_theme_mod( 'inharmony_color_blog_buttons_bg', 'primary'),
				'text-' . get_theme_mod( 'inharmony_color_blog_buttons_text', 'light'),
				'understrap-read-more-link',
			);

			$post_excerpt = $post_excerpt . ' [...]<p><a class="' . join(' ', $more_styles). '" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __(
				'Read More...',
				'inharmony'
			) . '<span class="screen-reader-text"> from ' . get_the_title( get_the_ID() ) . '</span></a></p>';
		}
	}
	return $post_excerpt;
}


/**
 * AJAX load more posts
 */
function inharmony_loadmore_ajax_handler(){
	check_ajax_referer('load_more_posts', 'security');
	$skip_first = ( isset($_POST['skip_first']) && !$_POST['skip_first'] ) ? false : get_theme_mod( 'inharmony_post_list_skip_first', true );
	$count = ($skip_first) ? 1 : 0;
	$ids = array();

	$display_count = isset($_POST['posts_per_page']) ? $_POST['posts_per_page'] :  get_theme_mod( 'inharmony_post_list_count', 6 );
	$page = $_POST['page'] + 1;
	$offset = ( $page - 1 ) * $display_count + $count;
 
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $page; // we need next page to be loaded
	$args['post_status'] = 'publish';
	$args['posts_per_page'] = $display_count; // Displays the latest # posts
	$args['post_type'] = 'post'; // Pulls posts from 'post' post type only
	$args['ignore_sticky_posts'] = true; // Ignores the sticky posts
	$args['post__not_in'] = $ids; // ignore the first post
	$args['order'] = 'DESC';
	$args['offset'] = $offset;

	$disp_atts = [];
	$disp_atts['post_element'] = isset($_POST['post_element']) ? $_POST['post_element'] : 'article';
	$disp_atts['post_class'] =  isset($_POST['post_class']) ? $_POST['post_class'] : '';
	$disp_atta['title_style'] = 'entry-title';
 
	// it is always better to use WP_Query but not here
	query_posts( $args );
 
	if( have_posts() ) :
		while( have_posts() ): the_post();
 
			get_template_part( 'loop-templates/content', 'blogposts', $disp_atts );
 
		endwhile;
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
add_action('wp_ajax_loadmore', 'inharmony_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'inharmony_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}


/**
 * Default post image
 * 
 * I don't recall why this was going to be used
 */
//function to call first uploaded image in functions file
function inharmony_get_post_image_default( $html, $post_id, $post_thumbnail_id, $size, $attr ) {

	if ($html != '') {
		return $html;
	}

	$files = get_children('post_parent='.get_the_ID().'&post_type=attachment
	&post_mime_type=image&order=desc');
	if($files) :
		$keys = array_reverse(array_keys($files));
		$j=0;
		$num = $keys[$j];
		$image=wp_get_attachment_image($num, $size, true);
		$imagepieces = explode('"', $image);
		$imagepath = $imagepieces[1];
		$main=wp_get_attachment_url($num);
		$the_title=get_the_title();
		$html =  "<img src='$main' alt='$the_title' class='frame' />";
	else :
		$the_title=get_the_title();
		$html = "<img src='" . get_stylesheet_directory_uri() . "/imgs/default-post-image.jpg' alt='". $the_title . "' />";
	endif;

	return $html;
}
//add_filter( 'post_thumbnail_html', 'inharmony_get_post_image_default', 10, 5 );



if ( ! function_exists( 'understrap_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function understrap_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="container navigation post-navigation mt-5 mb-5">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'understrap' ); ?></h2>
			<div class="d-flex nav-links justify-content-between">
				<?php
				if ( get_previous_post_link() ) {
					previous_post_link( '<span class="nav-previous">%link</span>', _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'understrap' ) );
				}
				if ( get_next_post_link() ) {
					next_post_link( '<span class="nav-next">%link</span>', _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'understrap' ) );
				}
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}


function inharmony_pre_get_posts( $query ) {

	if (is_front_page() && is_home()) {
		$query->posts_per_page = get_theme_mod( 'inharmony_post_list_count', 6 );
	}

	return $query;
}
add_action( 'pre_get_posts', 'inharmony_pre_get_posts' );