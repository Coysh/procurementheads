<?php
/**
 * The template for displaying Jobs Archive pages.
 *
 * This page template is used to display a list of available job positions.
 * Each post represents a unique job listing. It is intended to provide
 * visitors with a comprehensive list of careers at the company.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package procheads
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php astra_archive_header(); ?>

		<?php astra_pagination(); ?>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>


<style>
	.post-type-archive-jobs .site-content {
		background-color: #333f48 !important;
	}
	
</style>

