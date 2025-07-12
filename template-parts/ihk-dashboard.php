<?php
/**
 * My Account page
 * 
 * @package IHK\Templates
 * @version 0.1.0
 */

$dashpage = get_query_var('ihkdash') ?: 'ihk-dashboard';
?>
<div class="ihk-dashboard">
	<div class="ihk-dashboard-sidebar span3">
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
	<div class="ihk-dashboard-content <?php echo $dashpage; ?> span9">
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