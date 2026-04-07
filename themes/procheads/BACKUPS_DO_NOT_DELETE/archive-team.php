<?php
/**
 * The template for displaying member archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package procheads
 * @since procheads 1.0.0
 */

get_header(); ?>
	<div class="team">
		<header class="header">
			<div class="header--background">
				<div class="header__content">
					<div class="column">
						<h1 class="heading heading--larger"><?php the_field('team_title', 'option') ?></h1>
						<?php the_field('team_instructions', 'option') ?>
					</div>
				</div>
			</div>
		</header>
		<div role="main" class="team__main row small-up-1 medium-up-2" data-equalizer data-equalize-by-row="true" id="team__main">
			<div class="team__intro">
				<h2 class="heading heading--team"><?php the_field('intro_large','option'); ?><br><span><?php the_field('intro_small','option'); ?></span></h2>
				<p class="heading heading--team-stand"><?php the_field('intro_stand_first','option'); ?></p>
			</div>
			
			<?php $posts = get_field('display_members', 'option'); ?>
			
			<?php if ( $posts ) : ?>

				<?php /* Start the Loop */ ?>
				<?php foreach ( $posts as $post ) : setup_postdata($post); ?>
					<article id="member-<?php the_ID(); ?>" class="member column column-block">
						<div class="member--border">
							<div class="member__main" data-equalizer-watch>
								<?php get_template_part( 'template-parts/content', 'team' ); ?>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
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
