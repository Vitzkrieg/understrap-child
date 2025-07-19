<?php

global $ihk_dash_nav_items;
$ihk_dash_nav_items = array(
    'ihk-dashboard'     => __( 'Home', 'ihk' ),
    'ihk-products'      => __( 'My Products', 'ihk' ),
    'ihk-events'        => __( 'My Events', 'ihk' ),
    'ihk-library'       => __( 'My Library', 'ihk' ),
    'ihk-articles'      => __( 'My Articles', 'ihk' ),
    'my-account'        => __( 'My Account', 'ihk' ),
);

global $ihk_dash_nav_icons;
$ihk_dash_nav_icons = array(
	'ihk-dashboard'		=> 'la la-home',
	'ihk-products' 		=> 'la la-tag',
	'ihk-events' 		=> 'la la-calendar',
	'ihk-library' 		=> 'la la-book',
	'ihk-articles' 		=> 'la la-file-alt',
	'my-account' 		=> 'la la-user',
);

function ihk_get_dashboard_nav_items() {
    global $ihk_dash_nav_items;
    
    return $ihk_dash_nav_items;
}

function ihk_dashboard_get_nav_url( $slug ) {

    if ( $slug == "ihk-dashboard" ) {
        return $slug;
    }

    $split = explode('ihk-', $slug);

    if ( isset($split[1]) ) {
        return "ihk-dashboard/" . $slug;
    }

    return $split[0];
}

function ihk_get_dash_page() {
	return get_query_var('ihkdash') ?: "ihk-dashboard";
}

function is_ihk_dashboard_page() {
	global $wp;
	static $is_dashboard;

	if (!isset($is_dashboard)) {
		$is_dashboard = str_contains($wp->request, "ihk-dashboard")
			|| str_contains($wp->request, "my-account")
			|| str_contains($wp->request, "bulletins/")
		;
	}

	return $is_dashboard;
}

add_shortcode( 'ihk-dashboard', 'ihk_member_dashboard' );
function ihk_member_dashboard($atts, $content = null) {
	include(locate_template( './template-parts/ihk-dashboard.php' ));
}


add_action( 'ihk_dashboard_navigation', 'ihk_dashboard_navigation_show' );
function ihk_dashboard_navigation_show() {
	global $ihk_dash_nav_icons;

	$dash_nav_items = ihk_get_dashboard_nav_items();
	$dashpage = ihk_get_dash_page();

	$site_url = get_site_url();

    ob_start();
	?>

	<nav id="ihk-dashboard-navigation">
		<ul>
			<?php foreach( $dash_nav_items as $slug => $name ) :
				$url = $site_url . '/' . ihk_dashboard_get_nav_url( $slug );
				$active = ($dashpage == $slug) ? 'ihk-dashboard-nav-link--active' : '';
			?>
				<li data-slug="<?php echo $dashpage . ':' . $slug; ?>" class="ihk-dashboard-nav-link ihk-dashboard-nav-link--<?php echo esc_attr( $slug ); ?>">
					<a class="<?php echo esc_attr( $active ); ?>" href="<?php echo esc_url( $url ); ?>">
						<i class="<?php echo $ihk_dash_nav_icons[$slug]; ?>"></i>
						<span><?php echo esc_html( $name ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>

	<?php
    $content = ob_get_clean();
    echo wp_kses_post( html_entity_decode( $content ) );
}

add_action( 'wp_nav_menu_objects', 'ihk_dashboard_nav_menu_objects', 10, 2 );
function ihk_dashboard_nav_menu_objects( $items, $args ) {
	if ( ! is_ihk_dashboard_page() || $args->theme_location !== 'primary' ) {
		return $items;
	}

	$dashpage = ihk_get_dash_page();
	$site_url = get_site_url();

	foreach ( $items as $item ) {
		if ( in_array( $item->title, array_keys( ihk_get_dashboard_nav_items() ) ) ) {
			$item->url = $site_url . '/' . ihk_dashboard_get_nav_url( $item->title );
			if ( $dashpage == $item->title ) {
				$item->classes[] = 'ihk-dashboard-nav-link--active';
			}
		}
	}

	return $items;
}


add_action( 'ihk_dashboard_family', 'ihk_dashboard_family_show' );
function ihk_dashboard_family_show() {
    ob_start();
	?>
	<div id="ihk-dashboard-family">
		<div class="family-icon">
			<?php
			// TODO: get user / family icon
			$img = get_site_icon_url( 100 );
			?>
			<img src="<?php echo $img; ?>" alt="" />
		</div>
	</div>
	<?php
    $content = ob_get_clean();
    echo wp_kses_post( html_entity_decode( $content ) );
}


add_action('init', 'ihk_dashboard_rewrite_rules');
function ihk_dashboard_rewrite_rules() {
	add_rewrite_rule(
		'ihk-dashboard/([^/]*)/?$',
		'index.php?pagename=ihk-dashboard&ihkdash=$matches[1]',
		'top'
	);
}


add_filter('query_vars', 'ihk_add_query_vars');
function ihk_add_query_vars( $vars ) {
	$vars[] = 'ihkdash';
	return $vars;
}

add_action('ihk_dashboard_content', 'ihk_dashboard_content_page');
function ihk_dashboard_content_page() {
	$dashpage = ihk_get_dash_page();

	$split = explode('ihk-', $dashpage);
	$page = $split[1] ?? $split[0];

	do_action('ihk_dashboard_content_' . $page);
}



function ihk_get_post_like_labels() {
	return array(
		'loved' => esc_html__('My Favorites', 'ihk'),
		'completed' => esc_html__('My read', 'ihk'),
		'listed' => esc_html__('My list', 'ihk'),
		'already-loved' => esc_html__('Add to Favorites', 'ihk'),
		'already-completed' => esc_html__('Add to read', 'ihk'),
		'already-listed' => esc_html__('Add to list', 'ihk'),
		'updating' => esc_html__('Updating', 'ihk'),
	);
}

add_filter('understrap_nav_col_classes', 'ihk_dashboard_nav_col_classes');

function ihk_dashboard_nav_col_classes($classes) {
	if (!is_ihk_dashboard_page()) {
		return $classes;
	}
	$classes[] = 'd-none';
	return $classes;
}

add_filter('inharmony_header_widget_class', 'ihk_dashboard_header_widget_class');
function ihk_dashboard_header_widget_class($classes) {
	if (is_ihk_dashboard_page()) {
		return ['widget-col', 'col-12'];
	}
	return $classes;
}