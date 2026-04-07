<?php
/**
 * The default template for job content
 *
 * Used for both single and index/archive/search.
 *
 * @package procheads
 * @since procheads 1.0.0
 */

$job_meta = procheads_get_job_meta( get_the_ID() );
$salary = ( get_field('custom_salary_display') ) ? get_field('custom_salary_display') : $job_meta['salary_scale'];

?>
<a href="<?php the_permalink(); ?>" class="picks__job-link agl agl-fadeCSSUp">
    <header class="picks__job-header">
        <?php if ( $job_meta['location'] ) printf('<h4 class="picks__job-location">%s</h4>', $job_meta['location']) ?>
       
	    
    </header>
    <div class="picks__job-content">
        <h3 class="picks__job-heading"><?php the_title(); ?></h3>
        <?php if ( $salary )  printf('<p class="picks__job-salary">%s</p>', $salary) ?>
    </div>
</a>

<style>
    .picks__job-header {
        background-color: #6BAA2D;
        border-radius: 5px 5px 0 0;
        padding: 1.25rem;
    }

    .picks__job-content {
        padding: 1.25rem;
    }
    
    .picks__job-location {
        text-transform: uppercase;
        color: #fff !important;
        font-size: 18px !important;
        margin-bottom: 0 !important;
    }
    
    .picks__job-link {
        background-color: #fff;
        display: block;
        border-radius: 5px;
     
        text-decoration: none !important;
        
    }
</style>