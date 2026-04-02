<?php
/**
 * The template for displaying member archive pages
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
 * @since 1.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>
<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

    <?php get_sidebar(); ?>

<?php endif ?>
    <div id="primary" <?php astra_primary_class(); ?>>
        <?php
        astra_primary_content_top(); ?>

       <div class="team-members">
           <?php while (have_posts() ) : the_post(); ?>
               
           <?php $team_contact = get_field( 'tm_job_title' ); ?>
           
               <article class="team-member agl agl-fadeCSSUp">
                      <header>
                          <a href="<?php echo get_permalink( $post->ID ); ?>">
                          <picture>
                              <?php the_post_thumbnail('large'); ?>
                          </picture>
                        </a>
                      </header>
                      
                      <footer>
                          <a href="<?php echo get_permalink( $post->ID ); ?>">
                          <h3 class="team-member__name">
                              <?php the_title(); ?>
                        
                          </h3>
                          </a>
                <h5><?php the_field('tm_job_title'); ?></h5>
                          <p><?php the_excerpt(); ?></p>
                      </footer>
                  </article>
      

           
           <?php endwhile; ?>
       </div>

       <?php astra_primary_content_bottom();
        ?>
    </div><!-- #primary -->
<?php
if ( astra_page_layout() == 'right-sidebar' ) :

    get_sidebar();

endif;

get_footer(); ?>

<style>
    .team-members {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr;
        grid-column-gap: 0px;
        grid-row-gap: 32px;
    }
    

    @media screen and (min-width: 50rem) { 
    .team-members {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: 1fr;
    grid-column-gap: 64px;
    grid-row-gap: 64px;
    }

    }
    
    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 1),
@media only screen and (min-device-width: 834px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) {
  /* Your CSS styles for iPads (including iPad Pro) go here */
.team-members {
grid-template-columns: repeat(2, 1fr);
}

}
    .team-member img {
        border-radius: 5px;
        box-shadow: 5px 5px 10px 0 rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }
    
    .post-type-archive-team .site-main {
        margin-top: 5rem;
    }
</style>