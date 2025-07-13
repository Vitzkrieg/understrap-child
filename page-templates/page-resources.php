<?php
/*
Template Name: Page: Resources
Template Post Type: page
Description: This template is used to display a page with resources.
Package: InHarmonyKids

@package InHarmonyKids
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$link_base = get_permalink();
$fields = ihk_get_resources_fields();
$fieldKeys = array_keys($fields);

// store the selected values in an array
$selections = array();

// Get the selected values from the form
$query = explode('&', $_SERVER['QUERY_STRING']);
$single_tax = null;

foreach ($query as $param) {
	$param = explode('=', $param);
	// check if the param is valid
	if ( count($param) != 2 ) {
		continue;
	}

	// split if url param was name[#]=value
	$name = explode('%5B', $param[0])[0];
	$value = $param[1];
	// check if the param is valid
	if ( !in_array($name, $fieldKeys) ) {
		continue;
	}

	// initialize the selections array if it doesn't exist
	if (!isset($selections[$name])) {
		$selections[$name] = array();
	}

	$selections[$name][] = esc_html(sanitize_text_field($value));

	// check if the param is a single tax
	if ($single_tax !== false) {
		if (is_string($single_tax)) {
			$single_tax = false;
		} else {
			$single_tax = $name . ':' . $value;
		}
	}
}

// Enqueue the scripts and styles
wp_enqueue_script( 'owl-carousel' );
wp_enqueue_style( 'owl-carousel' );

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="page-wrapper">

    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

            <aside class="col-md-2 widget-area" id="left-sidebar">

			    <?php get_template_part( 'sidebar-templates/sidebar', 'resources', array(
                    'link_base' => $link_base,
                    'fields' => $fields,
                    'fieldKeys' => $fieldKeys,
                    'selections' => $selections,
                    'single_tax' => $single_tax,
                ) );
                ?>

            </aside><!-- #resources-sidebar -->

			<div class="col-md-10 content-area" id="primary">

                <main class="site-main" id="main">

                    <?php
                    while ( have_posts() ) {
                        the_post();
                        get_template_part( 'loop-templates/content', 'resources' );
                    }
                    ?>

                </main>

                <?php
                // Do the right sidebar check and close div#primary.
                get_template_part( 'global-templates/right-sidebar-check' );
                ?>
			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
