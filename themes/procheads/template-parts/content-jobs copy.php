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
<a href="<?php the_permalink(); ?>" class="job-listing">
    <header class="job-listing__header">
        <h3 class="job-listing__heading"><?php the_title(); ?></h3>
	    <?php if ( $salary )  printf('<p class="job-listing__salary">%s</p>', $salary) ?>
	    <?php if ( $job_meta['location'] ) printf('<p class="job-listing__location">%s</p>', $job_meta['location']) ?>
    </header>
    <div class="job-listing__content">
	    <?php the_field('stand_first'); ?>
    </div>
    <footer class="job-listing__footer">
        VIEW JOB
    </footer>
</a>
