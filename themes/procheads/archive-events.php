<?php
/**
 * The template for displaying events archive pages
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
$bk_image = get_field('events_bk_image','option');

if( !empty($bk_image) ):


	$size = 'large';
	$src = $bk_image['sizes'][ $size ];

	$bk_image = sprintf(' style="background-image:url(%s);"',$src);

endif;
get_header(); ?>
<div class="events">
    <header class="header">
        <div class="header--background"<?php echo $bk_image ?>>
            <div class="header__content">
                <div class="large-4 column">
                    <h1><?php the_field('events_title', 'option') ?></h1>
                </div>
                <div class="large-8 column">
                    <?php the_field('events_instructions', 'option') ?>
                </div>
            </div>
        </div>
        <div id="event-search" class="header__filters">
            <div class="row">
                <form id="event-select" class="event-select" action="<?php echo get_post_type_archive_link( 'events' ) ?>#event-search" method="get">
                    <?php echo procheads_events_dates_dropdown(); ?>
                    <?php echo procheads_events_category_dropdown(); ?>
                    <div class="column">
                        <input class="js-events-submit" type="submit" name="events-submit" value="events" />
                    </div>
                </form>
            </div>
        </div>

    </header>
    <?php if ( have_posts() ) : ?>
      <div role="main" class="events__main row small-up-1 medium-up-4 large-up-6" data-equalizer data-equalize-by-row="true" id="events__main">

        <?php
        /* Start the Loop */
        $new_month = 0;
        $new_year = 0;
        ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php
            /* Pre loop We need to split these into months */
            $event_date = get_field('date_of_event', false, false);
            $event_date = new DateTime($event_date);
            $event_month = intval($event_date->format('m'));
            $event_year = intval($event_date->format('Y'));

            if ( $new_month !== $event_month ) {
                get_template_part( 'template-parts/content', 'events-date' );
                $new_month = $event_month;
                $new_year = $event_year;
            }

            ?>
            <?php get_template_part( 'template-parts/content', 'events' ); ?>
        <?php endwhile; ?>

      </div>
    <?php else : ?>
		    <div class="jobs__main row jobs__main--none">
			    <div class="column">
				    <?php get_template_part( 'template-parts/content', 'no-jobs' ); ?>
			    </div>
		    </div>

        <?php endif; // End have_posts() check. ?>
    <div class="features__background">
        <div class="features__background--wrapper">
            <aside class="features" data-equalizer data-equalize-by-row="true" id="features">
	            <?php
	            $global_features = get_field('event_features_global_features','options');
	            procheads_global_features($global_features); ?>
                <?php
				// check if the event flexible content field has rows of data
				if( have_rows('event_features_feature_type','options') ):

					// loop through the rows of data
					while ( have_rows('event_features_feature_type','options') ) : the_row();

						procheads_get_row_layout();

					endwhile;

				endif;
				?>
            </aside>
        </div>
    </div>
</div>

<?php get_footer();
