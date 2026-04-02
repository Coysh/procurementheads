<?php
// If a featured image is set, insert into layout and use Interchange
// to select the optimal image size per named media query.
if ( has_post_thumbnail( $post->ID ) ) : ?>
	<header id="featured-hero" role="banner" data-interchange="[<?php echo the_post_thumbnail_url('thumbnail'); ?>, small], [<?php echo the_post_thumbnail_url('medium'); ?>, medium], [<?php echo the_post_thumbnail_url('large'); ?>, large]">
	</header>
<?php endif;
