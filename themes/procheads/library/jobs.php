<?php

function procheads_job_field_names(){
	return array('contract','location');
	//return array('level', 'contract', 'salary_scale', 'location');
}
// Custom query vars
function procheads_add_jobs_query_vars_filter( $vars ){
	$field_names = procheads_job_field_names();
	foreach ( $field_names as $field_name ) {
		$vars[] = $field_name;
	}
	return $vars;
}
add_filter( 'query_vars', 'procheads_add_jobs_query_vars_filter' );

// Register Custom Post Type - Jobs
function procheads_jobs_post_type() {

$labels = array(
'name'                  => _x( 'Jobs', 'Post Type General Name', 'procheads' ),
'singular_name'         => _x( 'Job', 'Post Type Singular Name', 'procheads' ),
'menu_name'             => __( 'Jobs', 'procheads' ),
'name_admin_bar'        => __( 'Job', 'procheads' ),
'archives'              => __( 'Jobs Archives', 'procheads' ),
'attributes'            => __( 'Job Attributes', 'procheads' ),
'parent_item_colon'     => __( 'Parent Job:', 'procheads' ),
'all_items'             => __( 'All Jobs', 'procheads' ),
'add_new_item'          => __( 'Add New Job', 'procheads' ),
'add_new'               => __( 'Add New', 'procheads' ),
'new_item'              => __( 'New Job', 'procheads' ),
'edit_item'             => __( 'Edit Job', 'procheads' ),
'update_item'           => __( 'Update Job', 'procheads' ),
'view_item'             => __( 'View Job', 'procheads' ),
'view_items'            => __( 'View Jobs', 'procheads' ),
'search_items'          => __( 'Search Jobs', 'procheads' ),
'not_found'             => __( 'Not found', 'procheads' ),
'not_found_in_trash'    => __( 'Not found in Trash', 'procheads' ),
'featured_image'        => __( 'Featured Image', 'procheads' ),
'set_featured_image'    => __( 'Set featured image', 'procheads' ),
'remove_featured_image' => __( 'Remove featured image', 'procheads' ),
'use_featured_image'    => __( 'Use as featured image', 'procheads' ),
'insert_into_item'      => __( 'Insert into Job', 'procheads' ),
'uploaded_to_this_item' => __( 'Uploaded to this Job', 'procheads' ),
'items_list'            => __( 'Jobs list', 'procheads' ),
'items_list_navigation' => __( 'Jobs list navigation', 'procheads' ),
'filter_items_list'     => __( 'Filter Jobs list', 'procheads' ),
);
$rewrite = array(
'slug'                  => 'jobs',
'with_front'            => false,
'pages'                 => true,
'feeds'                 => true,
);
$args = array(
'label'                 => __( 'Job', 'procheads' ),
'description'           => __( 'Jobs', 'procheads' ),
'labels'                => $labels,
'supports'              => array( 'title', 'editor', 'author', 'revisions', ),
'taxonomies'            => array( 'jobs_category', 'post_tag' ),
'hierarchical'          => false,
'public'                => true,
'show_ui'               => true,
'show_in_menu'          => true,
'menu_position'         => 5,
'menu_icon'             => 'dashicons-clipboard',
'show_in_admin_bar'     => true,
'show_in_nav_menus'     => true,
'can_export'            => true,
'has_archive'           => true,
'exclude_from_search'   => false,
'publicly_queryable'    => true,
'capability_type'       => 'post',
'rewrite'               => $rewrite,
'show_in_rest'          => true,
);
register_post_type( 'jobs', $args );

}
add_action( 'init', 'procheads_jobs_post_type', 0 );

// Register Custom Taxonomy
function jobs_category() {

	$labels = array(
		'name'                       => _x( 'Jobs categories', 'Taxonomy General Name', 'procheads' ),
		'singular_name'              => _x( 'Job category', 'Taxonomy Singular Name', 'procheads' ),
		'menu_name'                  => __( 'Jobs category', 'procheads' ),
		'all_items'                  => __( 'All Items', 'procheads' ),
		'parent_item'                => __( 'Parent Item', 'procheads' ),
		'parent_item_colon'          => __( 'Parent Item:', 'procheads' ),
		'new_item_name'              => __( 'New Item Name', 'procheads' ),
		'add_new_item'               => __( 'Add New Item', 'procheads' ),
		'edit_item'                  => __( 'Edit Item', 'procheads' ),
		'update_item'                => __( 'Update Item', 'procheads' ),
		'view_item'                  => __( 'View Item', 'procheads' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'procheads' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'procheads' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'procheads' ),
		'popular_items'              => __( 'Popular Items', 'procheads' ),
		'search_items'               => __( 'Search Items', 'procheads' ),
		'not_found'                  => __( 'Not Found', 'procheads' ),
		'no_terms'                   => __( 'No items', 'procheads' ),
		'items_list'                 => __( 'Items list', 'procheads' ),
		'items_list_navigation'      => __( 'Items list navigation', 'procheads' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
		'show_in_quick_edit'         => false
	);
	register_taxonomy( 'jobs_category', array( 'jobs' ), $args );

}
add_action( 'init', 'jobs_category', 0 );

function procheads_remove_jobs_category_from_edit() {
	remove_meta_box( 'jobs_category'.'div', 'jobs', 'side' );
}
add_action( 'admin_menu', 'procheads_remove_jobs_category_from_edit' );

function procheads_load_level_field_choices( $field ) {

	$field_name = $field['name'];

	$parent_of_field_name = sprintf('parent_of_%s_dropdown', $field_name );

	// reset choices
	$field['choices'] = array();


	$term_ID = get_field($parent_of_field_name, 'option', false);

	$terms = get_terms( array(
		'taxonomy' => 'jobs_category',
		'hide_empty' => false,
		'child_of'  => $term_ID
	) );

	$field['choices'][ 0 ] = 'N/A';

	$parents = array();
	foreach ( $terms as $term ) {
		if ( $term->parent === $term_ID ) {
			$parents[] = $term;
		}
	}

	foreach ( $parents as $parent ) :
		$field['choices'][ esc_attr( $parent->term_id ) ] = esc_attr( $parent->name );
		//Indent the children
		foreach ( $terms as $term ) {
			if ( $term->parent === $parent->term_id ) {
				$field['choices'][ esc_attr( $term->term_id ) ] = esc_attr( '- ' . $term->name );
			}
		}
	endforeach;

//	foreach ( $terms as $term ) :
//		$field['choices'][ esc_attr( $term->term_id ) ] = esc_attr( $term->name );
//	endforeach;


	// return the field
	return $field;

}

add_filter('acf/load_field/name=level', 'procheads_load_level_field_choices');
add_filter('acf/load_field/name=contract', 'procheads_load_level_field_choices');
add_filter('acf/load_field/name=salary_scale', 'procheads_load_level_field_choices');
add_filter('acf/load_field/name=location', 'procheads_load_level_field_choices');

function procheads_insert_child_term($term_to_add, $field_name, $taxonomy, $post_id) {
	$term_id = false;
	if ( $term_to_add && $field_name ) {
		//Clear the update field
		update_field('add_' . $field_name, '', $post_id);

		//Determine the parent
		$parent_term_id = get_field('parent_of_' . $field_name . '_dropdown', 'option', false);

		//Override parent if the location field has been set to a County
		if ( $field_name === 'location' ) {
			$location_id = get_field( 'location' );
			$location_term = get_term( $location_id, $taxonomy );
			if ( $location_term->parent === $parent_term_id ){
				//a parent term is selected so make that the new parent
				$parent_term_id = $location_term->term_id;
			}
		}

		$new_level = wp_insert_term( $term_to_add, $taxonomy, $args = array('parent'=> $parent_term_id) );
		if ( is_wp_error( $new_level ) ) {
			// Term exists so set $level_id to error term_id.
			$term_id = $new_level->error_data['term_exists'];
		} else {
			$term_id = $new_level['term_id'];
		}

		//Set the level field to the new level
		update_field($field_name, $term_id, $post_id);
	}
	return $term_id;
}

/**
 *
 * When a job is submitted, update the jobs_category based on the 'level', 'contract' dropdowns
 * Or check there is an addition to the categroy and add the term
 *
 * @param $post_id
 */
function procheads_save_jobs_meta( $post_id ) {

	if ( get_post_type() != 'jobs' ) return;
	$taxonomy = 'jobs_category';
	$check_additions = procheads_job_field_names();

	$term_IDs = false;

	foreach ( $check_additions as $check ) {
		$add_check = get_field( 'add_'. $check );
		if ( $add_check ) {
			//Add new term
			$check_additions[$check] = procheads_insert_child_term( $add_check, $check, $taxonomy, $post_id);
		} else {
			//No new terms added so get the existing values
			$check_additions[$check] = get_field($check,$post_id);
		}
		if ( $check_additions[$check] ) {
			if( is_array( $check_additions[$check] ) ) {
				foreach ( $check_additions[$check] as $add_term ) {
					$term_IDs[] = intval( $add_term );
				}
			} else {
				$term_IDs[] = intval( $check_additions[$check] );
			};
		}
	}


	//This will wipe all existing terms from the post.
	wp_set_object_terms( $post_id, $term_IDs, $taxonomy );

}

add_action( 'acf/save_post', 'procheads_save_jobs_meta', 100, 1 );

function procheads_jobs_dropdown( $term_ID, $class = '' ) {
	if ( ! $term_ID ) {
		return false;
	}

	$taxonomy = 'jobs_category';
	$parent_term = get_term( $term_ID, $taxonomy );

	if ( is_wp_error( $parent_term ) || ! $parent_term ) {
		return false;
	}

	$terms = get_terms( array(
		'taxonomy'   => $taxonomy,
		'hide_empty' => true,
		'child_of'   => $term_ID
	) );

	$field[0] = $parent_term->name;

	$class = ( $class ) ? ' ' . esc_attr( $class ) : '';

	$parents = array();
	foreach ( $terms as $term ) {
		if ( $term->parent === $term_ID ) {
			$parents[] = $term;
		}
	}

	foreach ( $parents as $parent ) :
		$field[ esc_attr( $parent->slug ) ] = esc_attr( $parent->name );
		// Indent the children
		foreach ( $terms as $term ) {
			if ( $term->parent === $parent->term_id ) {
				$field[ esc_attr( $term->slug ) ] = esc_attr( '- ' . $term->name );
			}
		}
	endforeach;

	$select_template = '<select name="%1$s" id="%1$s" class="jobs-filter%2$s">%3$s</select>';
	$option_template = '<option value="%s"%s>%s</option>';

	$query_var = get_query_var( $parent_term->slug );

	$options = '';
	foreach ( $field as $key => $name ) :
		$selected = ( $key === $query_var ) ? ' selected' : '';
		$options .= sprintf( $option_template, $key, $selected, $name );
	endforeach;

	return sprintf( $select_template, $parent_term->slug, $class, $options );
}


function procheads_pre_get_jobs( $wp_query ) {

	// Only interested in Jobs query
	if ( isset( $wp_query->query['post_type'] ) && $wp_query->query['post_type'] === 'jobs' || isset( $wp_query->query['jobs_category'] ) ) {
		set_query_var( 'posts_per_page', -1 );
		$check_additions = procheads_job_field_names();
		$jobs_query = array();

		foreach ( $check_additions as $check ) {
			if ( isset( $wp_query->query[ $check ] ) && get_query_var( $check, 0 ) ) {
				$jobs_query[] = get_query_var( $check );
			}
		}

		if ( count( $jobs_query ) ) {
			set_query_var( 'jobs_category', implode( '+', $jobs_query ) );
		}
	}

}


add_action('pre_get_posts', 'procheads_pre_get_jobs' );

function procheads_get_job_terms($post_ID, $separator, $slug = false, $parent = false) {
	$terms = get_the_terms( $post_ID, 'jobs_category' );
	$post_terms = array();
	$name = ($slug) ? 'slug' : 'name';

	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$post_terms[$term->term_id] = $term->$name;
		}
		if ( count($post_terms) ) {
			return implode($separator, $post_terms);
		}
	}

	return false;
}


function procheads_get_job_meta( $post_ID ) {
	$meta_array = array();
	$taxonomy = 'jobs_category';

	$terms = get_the_terms( $post_ID, $taxonomy );

	if ( is_array( $terms ) ) {
		foreach ( $terms as $term ) {
			$parent = get_term( $term->parent, $taxonomy );

			if ( is_object( $parent ) && $parent->parent !== 0 ) {
				// This is a child; we need the parent
				$term->name .= ', ' . $parent->name;
				$parent = get_term( $parent->parent, $taxonomy );
			}
			$value = $term->name;
			if ( is_object( $parent ) && isset( $meta_array[ $parent->slug ] ) ) {
				$value = $meta_array[ $parent->slug ] . ', ' . $term->name;
			}
			if ( is_object( $parent ) ) {
				$meta_array[ $parent->slug ] = $value;
			}
		}
	}

	return $meta_array;
}


function procheads_check_cookie_last_viewed() {
	$post_type = get_post_type();
	$singular = is_singular( "jobs" );

	if ( $post_type === "jobs" && $singular ) {
		$id = get_the_ID();
		$cookie_name = 'procheads_jobs_viewed';

		if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
			//No cookie
			$viewed = array($id);
		} else {
			//Cookie found
			$viewed = procheads_get_last_viewed_cookie_array($cookie_name);
			//If the page is already here
			if ( !is_array($viewed) || in_array($id, $viewed) ) return;
			array_unshift($viewed, $id);
		}
		procheads_set_last_viewed_cookie($viewed, $cookie_name);
	}
}
add_action( 'template_redirect', 'procheads_check_cookie_last_viewed' );

function procheads_get_last_viewed_cookie_array($cookie_name){
	$cookie = $_COOKIE[$cookie_name];
	$cookie = stripslashes($cookie);
	$savedCardArray = json_decode($cookie, true);
	return $savedCardArray;
}

function procheads_clear_last_viewed_cookie($cookie_name){
	unset( $_COOKIE[$cookie_name] );
	setcookie( $cookie_name, null, -1, '/' );
}

function procheads_set_last_viewed_cookie($viewed, $cookie_name){
	$json = json_encode($viewed);
	setcookie( $cookie_name, $json, strtotime( '+30 days' ), COOKIEPATH, COOKIE_DOMAIN );
}

function procheads_jobs_listing_shortcode() {
	ob_start();

	$field_names = procheads_job_field_names();
	?>
	<style>
		.jobs__header__filters { margin-bottom: 4rem; }
		.category-select {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			grid-column-gap: 32px;
			max-width: 70%;
		}
		@media screen and (max-width: 30rem) {
			.category-select {
				grid-template-columns: 1fr;
				width: 100%;
				max-width: 100%;
			}
		}
		#jobs__main {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			grid-column-gap: 3rem;
			grid-row-gap: 3rem;
		}
		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
			#jobs__main {
				grid-template-columns: repeat(2, 1fr);
				grid-column-gap: 2rem;
				grid-row-gap: 2rem;
			}
		}
		.job-listing__heading {
			font-size: 1.5rem;
			line-height: 2rem;
			margin-bottom: 1.5rem;
		}
		.job-listing__header {
			background-color: #6baa2d;
			border-radius: 1rem 1rem 0 0;
			padding: 1.25rem;
		}
		.job-listing__content { padding: 1.25rem; }
		.job-listing__header h4 {
			color: #fff;
			text-transform: uppercase;
			font-weight: 600;
			font-size: 1rem;
			font-family: Montserrat, sans-serif !important;
			margin-bottom: 0 !important;
		}
		.job .job-listing__content .job-listing__salary {
			font-size: 1.25rem;
			color: #6baa2d;
			font-weight: 900;
			font-family: 'Montserrat', sans-serif;
			margin-bottom: 0;
		}
	</style>

	<div id="job-search" class="jobs__header__filters">
		<div class="row">
			<form name="jobs-filter" id="category-select" class="category-select js-category-select" action="<?php echo esc_url( get_post_type_archive_link( 'jobs' ) ); ?>#job-search" method="get">
				<?php
				foreach ( $field_names as $field_name ) {
					$parent_of_field_name = sprintf( 'parent_of_%s_dropdown', $field_name );
					$term_ID = get_field( $parent_of_field_name, 'option', false );
					printf( '<div class="select">%s</div>', procheads_jobs_dropdown( $term_ID, 'js-jobs-filter' ) );
				}
				?>
				<div class="submit-btn">
					<input class="js-jobs-submit" type="submit" name="job-submit" value="Search" />
				</div>
			</form>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<div role="main" class="jobs__main" data-equalizer data-equalize-by-row="true" id="jobs__main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $data_categories = procheads_get_job_terms( get_the_ID(), ',', true ); ?>
				<article id="job-<?php the_ID(); ?>" class="job js-job column column-block agl agl-fadeCSSUp" data-category="<?php echo esc_attr( $data_categories ); ?>">
					<div class="job--border">
						<div class="job__main" data-equalizer-watch>
							<?php get_template_part( 'template-parts/content', 'jobs' ); ?>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<div class="jobs__main row jobs__main--none">
			<div class="column">
				<?php get_template_part( 'template-parts/content', 'no-jobs' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="row">
		<?php
		if ( function_exists( 'procheads_pagination' ) ) :
			procheads_pagination();
		elseif ( is_paged() ) :
		?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'astra' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'astra' ) ); ?></div>
		</nav>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'jobs_listing', 'procheads_jobs_listing_shortcode' );

function procheads_role_summary_shortcode()
{
	ob_start();
	?>

		<?php while (have_posts()):
			the_post(); ?>
				<?php
				$team_members = get_field('choose_member');
				$consultant = ($team_members[0]) ? esc_attr(get_the_title($team_members[0])) : 'na';
				?>
		<?php endwhile; ?>

		<div class="role_summary_widget agl agl-fadeCSSUp">
			<header>
				<h2><?php echo __("Role Summary", "procheads") ?></h2>
			</header>
			<div class="role_info">
				<?php
				$job_meta = procheads_get_job_meta(get_the_ID());
				$salary = (get_field('custom_salary_display')) ? get_field('custom_salary_display') : (isset($job_meta['salary_scale']) ? $job_meta['salary_scale'] : '');
				$contract = isset($job_meta['contract']) ? $job_meta['contract'] : '';
				$location = isset($job_meta['location']) ? $job_meta['location'] : '';
				$level = isset($job_meta['level']) ? $job_meta['level'] : '';
				?>
				<dl class="details-list">
					<?php if ($contract): ?>
							<dt class="details-list--term">Contract:</dt>
							<dd class="details-list--def"><?php echo esc_html($contract); ?></dd>
					<?php endif; ?>
					<?php if ($location): ?>
							<dt class="details-list--term">Location:</dt>
							<dd class="details-list--def"><?php echo esc_html($location); ?></dd>
					<?php endif; ?>
					<?php if ($level): ?>
							<dt class="details-list--term">Level:</dt>
							<dd class="details-list--def"><?php echo esc_html($level); ?></dd>
					<?php endif; ?>
					<?php if ($salary): ?>
							<dt class="details-list--term">Salary:</dt>
							<dd class="details-list--def"><h3><?php echo esc_html($salary); ?></h3></dd>
					<?php endif; ?>
				</dl>
				<button class="button open-button">Apply for this role now</button>
				<dialog class="modal" id="modal">
					<iframe src="<?php echo get_field('apply_url'); ?>" width="600" height="1200" style="width:100%;border:0;"></iframe>
					<button class="button close-button">Close pop-up</button>
				</dialog>
			</div>
		</div><!-- .role_summary_widget -->

		<?php if ($team_members): ?>
				<?php foreach ($team_members as $team_member): ?>
						<div class="your_consultant_widget agl agl-fadeCSSUp">
							<header>
								<h2><?php echo __("Your Consultant", "procheads") ?></h2>
							</header>
							<div class="consultant_info">
								<div class="consultant_profile">
									<div class="consultant_image">
										<?php
										$thumb_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($team_member), 'thumbnail');
										if (!empty($thumb_image_url[0])): ?>
												<img src="<?php echo esc_url($thumb_image_url[0]); ?>" class="job__role-portrait">
										<?php endif; ?>
									</div>
									<div class="consultant_name">
										<h3><?php echo get_the_title($team_member); ?></h3>
										<?php if (get_field('tm_job_title', $team_member)): ?>
												<h4><?php echo get_field('tm_job_title', $team_member); ?></h4>
										<?php endif; ?>
									</div>
								</div>

								<?php
								$user_display_email = get_field('tm_email', $team_member);
								$user_contact_number = get_field('tm_phone', $team_member);
								$user_linkedin_url = get_field('tm_linked_in', $team_member);
								?>
								<ul class="contact-list">
									<?php if ($user_contact_number): ?>
											<li>
												<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 22.621l-3.521-6.795c-.008.004-1.974.97-2.064 1.011-2.24 1.086-6.799-7.82-4.609-8.994l2.083-1.026-3.493-6.817-2.106 1.039c-7.202 3.755 4.233 25.982 11.6 22.615.121-.055 2.102-1.029 2.11-1.033z"/></svg>
												<a href="tel:<?php echo esc_attr($user_contact_number); ?>"><?php echo esc_html($user_contact_number); ?></a>
											</li>
									<?php endif; ?>
									<?php if ($user_display_email): ?>
											<li>
												<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.042 23.648c-7.813 0-12.042-4.876-12.042-11.171 0-6.727 4.762-12.125 13.276-12.125 6.214 0 10.724 4.038 10.724 9.601 0 8.712-10.33 11.012-9.812 6.042-.71 1.108-1.854 2.354-4.053 2.354-2.516 0-4.08-1.842-4.08-4.807 0-4.444 2.921-8.199 6.379-8.199 1.659 0 2.8.876 3.277 2.221l.464-1.632h2.338c-.244.832-2.321 8.527-2.321 8.527-.648 2.666 1.35 2.713 3.122 1.297 3.329-2.58 3.501-9.327-.998-12.141-4.821-2.891-15.795-1.102-15.795 8.693 0 5.611 3.95 9.381 9.829 9.381 3.436 0 5.542-.93 7.295-1.948l1.177 1.698c-1.711.966-4.461 2.209-8.78 2.209zm-2.344-14.305c-.715 1.34-1.177 3.076-1.177 4.424 0 3.61 3.522 3.633 5.252.239.712-1.394 1.171-3.171 1.171-4.529 0-2.917-3.495-3.434-5.246-.134z"/></svg>
												<a href="mailto:<?php echo esc_attr($user_display_email); ?>"><?php echo esc_html($user_display_email); ?></a>
											</li>
									<?php endif; ?>
									<?php if ($user_linkedin_url): ?>
											<li>
												<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
												<a href="<?php echo esc_url($user_linkedin_url); ?>" target="_blank">Connect with me on LinkedIn</a>
											</li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
				<?php endforeach; ?>
		<?php endif; ?>

		<style>
			.modal {
				max-width: 66ch;
			}
			.modal > * {
				margin: 0 0 0.5rem 0;
			}
			.modal::-webkit-backdrop {
				background: rgba(0, 0, 0, 0.4);
			}
			.modal::backdrop {
				background: rgba(0, 0, 0, 0.4);
			}
		</style>

		<script>
			const modal = document.querySelector("#modal");
			const openModal = document.querySelector(".open-button");
			const closeModal = document.querySelector(".close-button");

			openModal.addEventListener("click", () => {
				modal.showModal();
			});

			closeModal.addEventListener("click", () => {
				modal.close();
			});
		</script>

		<?php
		return ob_get_clean();
}
add_shortcode('role_summary', 'procheads_role_summary_shortcode');

add_action( 'astra_sidebars_before', function() {
    if ( is_singular('jobs') ) {
        echo do_shortcode('[role_summary]');
    }
});