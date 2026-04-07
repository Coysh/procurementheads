<?php
/**
 * The template for displaying homepage
 *
 * @package procheads
 * @since procheads 1.0.0
 */

get_header(); ?>

<?php do_action( 'procheads_before_content' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
    <article class="home">
        <?php
        $bkstyle = '';
        if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
            $bkstyle = sprintf(' style="background-image: url(%s)"',get_the_post_thumbnail_url(get_the_ID(),'xxlarge'));
        }
        ?>
        <header class="banner"<?php echo $bkstyle; ?>>
            <div class="row">
                <div class="banner__content">
                    <h1 class="banner--heading"><?php the_field('banner_title') ?></h1>
                    <div class="banner--intro"><?php the_field('banner_intro') ?></div>
                </div>
            </div>
        </header>
	    <?php do_action( 'procheads_page_before_entry_content' ); ?>
        <div class="home__background">
            <div class="home__background--wrapper">
                <div class="features">
                    <div class="feature feature--jobs feature--find">
                        <div class="feature--bk">
                            <div class="feature__header">
                                <h2 class="heading heading--underline"><?php the_field('find_your_job_title') ?></h2>
                            </div>
                            <div class="feature__content">
                                <form id="category-select" class="feature-job-category-select" action="<?php echo get_post_type_archive_link( 'jobs' ) ?>#job-search" method="get">
					                <?php
					                $field_names = array('location', 'contract');
					                foreach ( $field_names as $field_name ) {
						                $parent_of_field_name = sprintf('parent_of_%s_dropdown', $field_name );
						                $term_ID = get_field($parent_of_field_name, 'option', false);
						                echo procheads_jobs_dropdown( $term_ID );
					                }
					                ?>
                                    <div class="feature__submit">
                                        <input class="button button--primary" type="submit" name="submit" value="Search" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
<?php endwhile;?>
<?php get_template_part('template-parts/section','layouts'); ?>

<?php do_action( 'procheads_after_content' ); ?>


<?php get_footer();
