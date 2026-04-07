<?php
/**
 * The template for displaying page set for the Posts Page (Blog)
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

$blog_id = get_option( 'page_for_posts' );

$page_title = (get_field('blog_title', $blog_id)) ? get_field('blog_title', $blog_id) : get_the_title( $blog_id );

get_header(); ?>
<div class="blog">

	<header class="header">
        <div class="header--background">
            <div class="header__content">
                <div class="column">
                    <h1 class="heading heading--larger"><?php echo $page_title ?></h1>
	                <?php the_field('stand_first', $blog_id) ?>
                </div>
            </div>
        </div>
        <div id="blog-search" class="header__filters">
            <div class="row">
                <form id="blog-select" class="blog-select" action="<?php echo get_post_type_archive_link( 'post' ) ?>#blog-search" method="get">
					<?php $args = array(
						'show_option_none' => 'All Posts',
						'option_none_value'  => '0',
						'selected' => get_query_var('cat'),
						'class'              => 'blog-filter',
					); ?>
                    <div class="medium-push-2 medium-4 large-push-3 large-3 column"><?php wp_dropdown_categories( $args ); ?></div>
					<?php
					//Get authors
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => -1
					);
					// The Query
					$author_query = new WP_Query( $args );

					// The Loop
					if ( $author_query->have_posts() ) {
						$authors = array( 0 => 'All Authors');
						$options = '';
						$select_template = '<div class="medium-push-2 medium-4 large-push-3 large-3 column"><select name="%1$s" id="%1$s" class="blog-filter">%2$s</select></div>';
						$option_template = '<option value="%s"%s>%s</option>';
						$query_var = intval(get_query_var( 'author' ));

						while ( $author_query->have_posts() ) {
							$author_query->the_post();
							$key = get_the_author_meta('ID');
							$name = get_the_author_meta('display_name');
							$authors[$key] = $name;
						}

						foreach ($authors as $key => $author) {
							$selected = ( $key === $query_var ) ? ' selected':'';
							$options .= sprintf($option_template, $key, $selected, $author);
						}
						/* Restore original Post Data */
						wp_reset_postdata();
						printf($select_template, 'author', $options);
					}
					?>
                    <div class="column">
                        <input class="js-blog-submit" type="submit" name="blog-submit" value="blog" />
                    </div>
                </form>
            </div>
        </div>
	</header>
	<div id="blog" role="main" class="blog__main row small-up-1 medium-up-2 large-up-3" data-equalizer data-equalize-by-row="true">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'post' ); ?>
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
<?php get_template_part('template-parts/section','layouts'); ?>
<?php get_footer();
