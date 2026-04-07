<?php
function procheads_global_features($global_features) {
if ( is_array( $global_features ) ) :
if ( in_array('job', $global_features)) : ?>
<div class="feature feature--jobs feature--find">
	<div class="feature--border" data-equalizer-watch>
		<div class="feature__header">
			<h2><?php the_field('find_your_perfect_job_title','options') ?></h2>
		</div>
		<div class="feature__content">
			<?php the_field('find_your_perfect_job_intro','options') ?>
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
					<input class="button button--dark" type="submit" name="submit" value="SEARCH" />
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if ( in_array('candidate', $global_features)) : ?>
	<div class="feature feature--candidate feature--find">
		<div class="feature--border" data-equalizer-watch>
			<div class="feature__header">
				<h2><?php the_field('find_your_perfect_candidate_title','options') ?></h2>
			</div>
			<div class="feature__content">
				<?php the_field('find_your_perfect_candidate_intro','options') ?>
				<?php gravity_form(2, false, false, false, '', true, 200); ?>
			</div>
		</div>
	</div>
<?php endif;
endif;
}