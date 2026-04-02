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