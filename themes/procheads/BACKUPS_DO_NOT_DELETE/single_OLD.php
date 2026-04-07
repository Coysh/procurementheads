<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package procheads
 * @since procheads 1.0.0
 */

$blog_id = get_option( 'page_for_posts' );

$page_title = (get_field('blog_title', $blog_id)) ? get_field('blog_title', $blog_id) : get_the_title( $blog_id );


get_header(); ?>

<div id="single" role="main" class="single">
    <header class="header">
        <div class="header--background">
            <div class="header__content">
                <div class="column">
                    <h1 class="heading heading--larger"><?php echo $page_title ?></h1>
					<?php the_field('stand_first', $blog_id) ?>
                </div>
            </div>
        </div>
    </header>
    <div class="row">
    <?php do_action( 'procheads_before_content' ); ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class('single__article') ?> id="post-<?php the_ID(); ?>">
            <header class="single__header">
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail();
                }  ?>
                <h1 class="heading heading--blog"><?php the_title(); ?></h1>
                <?php echo procheads_entry_meta(); ?>
            </header>
            <?php do_action( 'procheads_post_before_entry_content' ); ?>
            <div class="entry-content">
                <?php if (get_field('stand_first') ) : ?><div class="stand-first"><?php the_field('stand_first') ?></div><?php endif; ?>
                <?php the_content(); ?>
            </div>
            <?php
            $team_member = get_field('choose_member');
            if ( $team_member ) :
	            $thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $team_member[0] ), 'thumbnail' );
                printf('<a href="%s" class="single__team-member" >', get_the_permalink($team_member[0]));
	            if ( ! empty( $thumb_image_url[0] ) ) {
		            echo '<img src="' . esc_url( $thumb_image_url[0] ) . '" class="job__role-portrait">';
	            }
                echo '<p>' . __('FIND OUT MORE ABOUT', 'procheads') . '<br/><span class="author">' . get_the_title($team_member[0]) . '</span></p></a>';
            endif;
            ?>
            <?php echo procheads_render_social_share_list(); ?>
        </article>
    <?php endwhile;?>

    <?php do_action( 'procheads_after_content' ); ?>
    <?php get_sidebar(); ?>
    </div>
</div>
<?php get_template_part('template-parts/section','layouts'); ?>
<?php get_footer();
