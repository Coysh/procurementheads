<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package procheads
 * @since procheads 1.0.0
 */

get_header(); ?>

<?php
$post_object = get_field('choose_404_page','options');

if ( $post_object ) : ?>
	<?php
	$post = $post_object;
	setup_postdata( $post );
	?>
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
	</article>
	<?php wp_reset_postdata(); ?>
<?php else : ?>
<div id="single" role="main" class="single no-banner">
    <div class="row">
        <article <?php post_class('single__article large-centered') ?> id="post-<?php the_ID(); ?>">
            <header>
                <h1 class="entry-title"><?php _e( 'File Not Found', 'procheads' ); ?></h1>
            </header>
            <div class="entry-content">
                <div class="error">
                    <p class="bottom"><?php _e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'procheads' ); ?></p>
                </div>
                <p><?php _e( 'Please try the following:', 'procheads' ); ?></p>
                <ul>
                    <li><?php _e( 'Check your spelling', 'procheads' ); ?></li>
                    <li><?php printf( __( 'Return to the <a href="%s">home page</a>', 'procheads' ), home_url() ); ?></li>
                    <li><?php _e( 'Click the <a href="javascript:history.back()">Back</a> button', 'procheads' ); ?></li>
                </ul>
            </div>
        </article>
    </div>
</div>

<?php endif; ?>

<?php get_footer();
