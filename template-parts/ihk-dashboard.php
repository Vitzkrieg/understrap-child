<?php
/**
 * My Account page
 * 
 * @package IHK\Templates
 * @version 0.1.0
 */

$dashpage = get_query_var('ihkdash') ?: 'ihk-dashboard';
?>
<div class="ihk-dashboard d-flex flex-wrap">
	<div class="ihk-dashboard-sidebar col-lg-3 col-md-4 col-12 <?php echo $dashpage; ?>">
		<?php
			/**
			 * Dashboard navigation.
			 *
			 * @since 0.1.0
			 */
			do_action( 'ihk_dashboard_family' );

			/**
			 * Dashboard content.
			 *
			 * @since 0.1.0
			 */
			do_action( 'ihk_dashboard_sidebar' );
		?>
	</div>
	<div class="ihk-dashboard-content <?php echo $dashpage; ?> col-lg-9 col-md-8 col-12">
		<?php
			/**
			 * Dashboard navigation.
			 *
			 * @since 0.1.0
			 */
			// do_action( 'ihk_dashboard_navigation' );

			/**
			 * Dashboard content.
			 *
			 * @since 0.1.0
			 */
			do_action( 'ihk_dashboard_content' );
		?>
	</div>
</div>