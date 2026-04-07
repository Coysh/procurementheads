<?php
$image = get_sub_field('jb_background_image');
$background_image = ' ';

if( !empty($image) ):

	// vars
	$image_url = $image['sizes'][ 'large'];

	$background_image = sprintf(' style="background-image:url(%s)" ',$image_url);

endif;
?>
<section class="section section--job-finder"<?php echo $background_image; ?>>
	<div class="section__wrapper">
		<div class="features">
			<div class="feature feature--jobs feature--find">
				<div class="feature--bk">
					<div class="feature__header">
						<h2 class="heading heading--underline heading--white"><?php the_sub_field('jb_title') ?></h2>
					</div>
					<div class="feature__content">
						<form id="category-select" class="feature-job-category-select" action="<?php echo get_post_type_archive_link( 'jobs' ) ?>#job-search" method="get">
							<?php
							$field_names = array('location', 'salary_scale', 'level');
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
</section>