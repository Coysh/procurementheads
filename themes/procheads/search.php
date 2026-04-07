<?php
/**
 * The template for displaying search results pages.
 *
 * @package procheads
 * @since procheads 1.0.0
 */

get_header(); ?>

    <div class="blog no-banner">

        <header class="header">
            <div class="header--background">
                <div class="row column medium-10 large-8">
                    <h1 class=""><?php _e( 'Search Results for', 'procheads' ); ?> "<?php echo get_search_query(); ?>"</h1>
                </div>
            </div>
            <div id="blog-search" class="header__filters">
                <div class="row">
	                <?php get_search_form(); ?>
                </div>
            </div>
        </header>
        <div id="blog" role="main" class="blog__main row small-up-1 medium-up-3 large-up-4">
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php endwhile; ?>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; // End have_posts() check. ?>
        </div>
        <div class="row">
			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php
			if ( function_exists( 'procheads_pagination' ) ) :
				procheads_pagination();
			elseif ( is_paged() ) :
				?>
                <nav id="post-nav">
                    <div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'procheads' ) ); ?></div>
                    <div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'procheads' ) ); ?></div>
                </nav>
			<?php endif; ?>
        </div>

    </div>

<?php get_footer();


