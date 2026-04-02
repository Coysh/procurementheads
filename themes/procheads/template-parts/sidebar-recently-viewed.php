<?php
$post_type = get_post_type();
$singular = is_singular( "jobs" );

if ( $singular ) {
	if ( isset( $_COOKIE[ 'procheads_jobs_viewed' ] ) ) {
		$visited_jobs = procheads_get_last_viewed_cookie_array( 'procheads_jobs_viewed' );
		if ( is_array($visited_jobs)) $visited_jobs = array_slice($visited_jobs, 0, 3);
		$args = array(
			'post__in' => $visited_jobs,
			'post_type' => 'jobs',
			'posts_per_page' => 3,
			'orderby' => 'post__in'
		);
		$visited_query = new WP_Query( $args );

		if ( $visited_query->have_posts() ) : ?>
			<div class="sidebar__item sidebar__item-jobs">
				<div class="sidebar__item-wrapper">
					<h5>Recently Viewed Positions</h5>
					<?php /* Start the Loop */ ?>
					<?php while ( $visited_query->have_posts() ) : $visited_query->the_post(); ?>
						<article id="job-<?php the_ID(); ?>" class="job">
							<div class="job--border">
								<div class="job__main">
									<?php get_template_part( 'template-parts/content', 'jobs' ); ?>
								</div>
								<footer class="job__footer">
									<a href="<?php echo get_the_permalink() ?>" class="button">VIEW DETAILS</a>
								</footer>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; // End have_posts() check.

	}
}
