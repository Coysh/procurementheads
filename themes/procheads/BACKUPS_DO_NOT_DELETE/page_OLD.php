<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package procheads
 * @since procheads 1.0.0
 */

get_header(); ?>

    <article id="page-<?php the_ID(); ?>" role="main" class="page">
        <header class="header">
            <div class="header--background">
                <div class="header__content">
                    <div class="column">
                        <h1 class="heading heading--larger"><?php the_title(); ?></h1>
						<?php the_field('stand_first') ?>
                    </div>
                </div>
            </div>
        </header>
		<?php do_action( 'procheads_before_content' ); ?>
		<?php while ( have_posts() ) : the_post(); ?>
            <?php if( have_rows('blocks') ): ?>
                <?php
				function procheads_block_content($block_idx = 1){
				    $output = "";
				    if ( get_sub_field('block_title_'.$block_idx) ) {
					    $output .= sprintf('<h2 class="heading heading--blog">%s</h2>', get_sub_field('block_title_'.$block_idx) );
                    }
				    $output .= get_sub_field('block_content_'.$block_idx);
				    return $output;
				}
                ?>
                <div class="blocks">

					<?php while ( have_rows('blocks') ) : the_row(); ?>
                    <div class="row">
                        <?php
                        $block_type = get_sub_field('block_columns');
                        $block_add_rule = ( get_sub_field('block_rule') ) ? ' block--rule':'';

                        switch ( $block_type ) {
                            case 'single':
                                printf('<div class="block block--single%s">', $block_add_rule);
                                echo '<div class="block__wrapper">';
	                            echo procheads_block_content(1);
	                            echo '</div>';
	                            echo '</div>';
                                break;
                            case 'double':
	                            printf('<div class="block block--double%s">', $block_add_rule);
	                            echo '<div class="block__wrapper block__wrapper--left">';
	                            echo procheads_block_content(1);
	                            echo '</div>';
	                            echo '<div class="block__wrapper block__wrapper--right">';
	                            echo procheads_block_content(2);
	                            echo '</div>';
	                            echo '</div>';
	                            break;
                            case 'image':
                                $image_side = get_sub_field('block_image_side');
                                $block_left_class = $block_right_class = ' block__wrapper--image';
                                $block_left_css = $block_right_css = '';
	                            $block_left_column = $block_right_column = '';
                                $block_image = get_sub_field('block_image');
                                $block_image_html = sprintf('<img src="%s" alt="%s" class="block__image"/>', esc_url($block_image['sizes']['large']), esc_html($block_image['alt']));
                                if ( $image_side === 'left' ) {
                                    $block_right_class = '';
	                                $block_left_column = $block_image_html;
                                    $block_right_column = procheads_block_content(1);
                                } else {
	                                $block_left_class = '';
	                                $block_left_column = procheads_block_content(1);
	                                $block_right_column = $block_image_html;
                                }
	                            printf('<div class="block block--double%s">', $block_add_rule);
	                            printf('<div class="block__wrapper block__wrapper--left%s">', $block_left_class);
	                            echo $block_left_column;
	                            echo '</div>';
                                printf('<div class="block__wrapper block__wrapper--right%s">', $block_right_class);
	                            echo $block_right_column;
	                            echo '</div>';
	                            echo '</div>';
	                            break;
                        }
                        ?>
                    </div>
					<?php endwhile; ?>
                </div>
            <?php endif; ?>
		<?php endwhile;?>
		<?php do_action( 'procheads_after_content' ); ?>
	    <?php get_template_part('template-parts/section','layouts'); ?>
    </article>

<?php get_footer();
