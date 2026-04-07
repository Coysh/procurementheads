<?php
/**
 * The sidebar containing the main widget area
 *
 * @package procheads
 * @since procheads 1.0.0
 */

?>
<aside class="sidebar">
    <div class="sidebar__wrapper">
        <div class="sidebar__item sidebar__item-blogs">

            <div class="sidebar__item-wrapper">
                <h5 class="heading heading--sidebar"><?php echo __('LATEST BLOG POSTS', 'procheads'); ?></h5>
				<?php
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => 4,
				);
				$blog_query = new WP_Query( $args );
				// The Loop
				if ( $blog_query->have_posts() ) {
					echo '<ul class="blog-list">';
					while ( $blog_query->have_posts() ) {
						$blog_query->the_post();

						$wrapper = '<li><a href="%s" class="listing listing--blog">%s</a></li>';
						$contents = '<div class="listing__content"><h6>%s</h6><p class="heading heading--byline"><span class="fulldate">%s</span> by <span class="author">%s</span></p></div>';
						$output = '';
						$title = (get_field('override_title')) ? get_field('override_title') : get_the_title();
						$output .= sprintf($contents, $title, get_the_date('F j, Y'), get_the_author());
						printf($wrapper, get_the_permalink(), $output);
					}
					echo '</ul>';

					/* Restore original Post Data */
					wp_reset_postdata();
				}
				?>
            </div>
        </div>

        <div class="sidebar__button-wrapper">
			<?php echo procheads_top_bar_r_buttons(); ?>
        </div>

        <?php if ( !get_field('sb_hide_feature', 'options') ) : ?>
            <div class="sidebar__item sidebar__item-blogs sidebar__item-center">
                <div class="sidebar__item-wrapper ">
                    <h5 class="heading heading--sidebar"><?php the_field('sb_title', 'option'); ?></h5>
                    <div class="sidebar__item-content">
                        <?php the_field('sb_content', 'option'); ?>
                    </div>
                    <?php
                    if ( get_field('sb_add_link', 'option' ) ) :
	                    $button_template = '<a href="%s" class="button">%s</a>';
	                    $link_picker = get_field('sb_link_picker','option');
	                    $buttonLink = get_the_permalink($link_picker[0]);
	                    echo sprintf($button_template, $buttonLink, get_field('sb_link_title','option'));
                    endif;
                    ?>
                </div>
            </div>
        <?php endif; ?>


    </div>
</aside>
