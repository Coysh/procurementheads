<section class="picks">
	<?php if ( get_sub_field('jobs_title') ) : ?>
	<header class="picks__header">
		<!-- <h2 class="heading heading--underline"><?php the_sub_field('jobs_title'); ?></h2> -->
    </header>
	<?php endif; ?>
	<div class="picks__wrapper row small-up-1 medium-up-2 large-up-3" data-equalizer data-equalize-by-row="true" id="picks">
        <?php
        $posts = get_sub_field('jobs_picker');
        if( $posts ): ?>
            <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
                <?php setup_postdata($post); ?>
                <article class="picks__job column column-block">
                    <div class="picks__job-wrapper" data-equalizer-watch>
                        <?php get_template_part('template-parts/content','jobs-short'); ?>
                    </div>
                </article>
            <?php endforeach; ?>
	        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
        <?php endif; ?>
	</div>
</section>


<style>
        .picks__header h2 {
                color: #fff;
        }
        
        
        .picks__job-salary {
            font-size: 1.25rem;
            color: #6baa2d;
            font-weight: 900;
            font-family: 'Montserrat',sans-serif;
            margin-bottom: 0 !important; 
        }
        

        
        
        @media screen and (max-width: 40rem) { 
        .picks__wrapper {
display: grid;
        grid-template-columns: 1fr !important;
        grid-template-rows: 1fr !important;
        grid-column-gap: 0px;
        grid-row-gap: 32px;
        }
        /* .astra-advanced-hook-22897 {
            padding: 2rem 1.5rem;
        } */
        }
        .picks__wrapper {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                grid-template-rows: 1fr;
                grid-column-gap: 48px;
                grid-row-gap: 48px;    
        }
        

</style>