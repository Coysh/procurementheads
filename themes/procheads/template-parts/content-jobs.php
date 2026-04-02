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
$salary = ( get_field( 'custom_salary_display' ) ) ? get_field( 'custom_salary_display' ) : ( isset( $job_meta['salary_scale'] ) ? $job_meta['salary_scale'] : '' );
$location = isset( $job_meta['location'] ) ? $job_meta['location'] : '';

?>
<a href="<?php the_permalink(); ?>" class="job-listing">
    <header class="job-listing__header">
        <?php if ( $location ) printf( '<h4 class="job-listing__location">%s</h4>', $location ) ?>
    </header>

    <div class="job-listing__content">
        <h3 class="job-listing__heading"><?php the_title(); ?></h3>
        <?php if ( $salary ) printf( '<p class="job-listing__salary">%s</p>', $salary ) ?>
    </div>
</a>
