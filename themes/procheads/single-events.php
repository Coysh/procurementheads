<?php
/**
 * The template for displaying all single jobs
 *
 * @package procheads
 * @since procheads 1.0.0
 */

get_header(); ?>

<div id="single-event" role="main" class="single no-banner">
    <div class="row">
        <?php do_action( 'procheads_before_content' ); ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php
            $date = get_field('date_of_event', false, false);
            $date = new DateTime($date);
            ?>
            <article <?php post_class('single__article') ?> id="post-<?php the_ID(); ?>">
                <header class="single__header">
                    <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail();
                    }  ?>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <h2 class="event-date"><?php echo $date->format('l jS F, Y'); ?></h2>
                </header>
                <?php do_action( 'procheads_post_before_entry_content' ); ?>
                <div class="entry-content">
                    <?php if (get_field('stand_first') ) : ?><div class="stand-first"><?php the_field('stand_first') ?></div><?php endif; ?>
                    <?php the_content(); ?>
                    <?php edit_post_link( __( 'Edit', 'procheads' ), '<span class="edit-link">', '</span>' ); ?>
                </div>
	            <?php echo procheads_render_social_share_list(); ?>

                <aside class="article-features__wrapper" data-equalizer data-equalize-by-row="true" id="features">
                    <?php
                    $global_features = get_field('global_features');
                    procheads_global_features($global_features); ?>
                    <?php
                    // check if the event flexible content field has rows of data
                    if( have_rows('feature_type') ):

                        // loop through the rows of data
                        while ( have_rows('feature_type') ) : the_row();

                            procheads_get_row_layout();

                        endwhile;

                    endif;
                    ?>
                </aside>
            </article>
        <?php endwhile;?>

        <?php do_action( 'procheads_after_content' ); ?>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer();
