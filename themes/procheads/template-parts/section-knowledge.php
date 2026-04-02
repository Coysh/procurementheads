<section class="section section--knowledge section--dark" data-equalizer data-equalize-on="large">
    <?php
    $title = get_sub_field('ik_section_title');
    if ( $title ) : ?>
    <header>
        <h2 class="heading heading--blog"><?php echo $title ?></h2>
    </header>
    <?php endif; ?>
	<div class="section__wrapper">
        <?php
        $image = get_sub_field('ik_side_image');
        $background_image = ' ';

        if( !empty($image) ):

        // vars
        $image_url = $image['sizes'][ 'medium'];

        $background_image = sprintf(' style="background-image:url(%s)" ',$image_url);

        endif;
        ?>
        <div class="section__column section__column--image"<?php echo $background_image ?>data-equalizer-watch>
            <?php if ( get_sub_field('side_image_page_link')) : ?>
                <a href="<?php the_sub_field('side_image_page_link') ?>" class="section__column--image-link"></a>
            <?php endif; ?>
        </div>
		<div class="section__column section__column--news" data-equalizer-watch>
			<h3 class="heading heading--knowledge"><?php the_sub_field('ik_blog_title') ?></h3>
			<?php
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
			);
			$blog_query = new WP_Query( $args );
			// The Loop
			if ( $blog_query->have_posts() ) {
			    echo '<ul class="list list--news">';
				while ( $blog_query->have_posts() ) {
					$blog_query->the_post();

					$wrapper = '<li class="list__item"><a href="%s">%s</a></li>';
					$contents = '%s <span>%s</span>';
					$title = get_the_title();
					$output = sprintf($contents, $title, __( 'Read more', 'procheads' ));
					printf($wrapper, get_the_permalink(), $output);
				}
				echo '</ul>';

				/* Restore original Post Data */
				wp_reset_postdata();
			}
			?>
		</div>
	</div>
</section>