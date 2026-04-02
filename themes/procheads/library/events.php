<?php
function procheads_events_field_names(){
	return array('event_month' => 'Months', 'event_year' => 'Years');
}

// Custom query vars
function procheads_add_events_query_vars_filter( $vars ){
	$field_names = procheads_events_field_names();
	foreach ( $field_names as $key => $field_name ) {
		$vars[] = $key;
	}
	return $vars;
}
add_filter( 'query_vars', 'procheads_add_events_query_vars_filter' );

// Register Custom Post Type - Events
function procheads_events_post_type() {

$labels = array(
'name'                  => _x( 'Events', 'Post Type General Name', 'procheads' ),
'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'procheads' ),
'menu_name'             => __( 'Events', 'procheads' ),
'name_admin_bar'        => __( 'Event', 'procheads' ),
'archives'              => __( 'Events Archives', 'procheads' ),
'attributes'            => __( 'Event Attributes', 'procheads' ),
'parent_item_colon'     => __( 'Parent Event:', 'procheads' ),
'all_items'             => __( 'All Events', 'procheads' ),
'add_new_item'          => __( 'Add New Event', 'procheads' ),
'add_new'               => __( 'Add New', 'procheads' ),
'new_item'              => __( 'New Event', 'procheads' ),
'edit_item'             => __( 'Edit Event', 'procheads' ),
'update_item'           => __( 'Update Event', 'procheads' ),
'view_item'             => __( 'View Event', 'procheads' ),
'view_items'            => __( 'View Events', 'procheads' ),
'search_items'          => __( 'Search Events', 'procheads' ),
'not_found'             => __( 'Not found', 'procheads' ),
'not_found_in_trash'    => __( 'Not found in Trash', 'procheads' ),
'featured_image'        => __( 'Featured Image', 'procheads' ),
'set_featured_image'    => __( 'Set featured image', 'procheads' ),
'remove_featured_image' => __( 'Remove featured image', 'procheads' ),
'use_featured_image'    => __( 'Use as featured image', 'procheads' ),
'insert_into_item'      => __( 'Insert into Event', 'procheads' ),
'uploaded_to_this_item' => __( 'Uploaded to this Event', 'procheads' ),
'items_list'            => __( 'Events list', 'procheads' ),
'items_list_navigation' => __( 'Events list navigation', 'procheads' ),
'filter_items_list'     => __( 'Filter Events list', 'procheads' ),
);
$rewrite = array(
	'slug'                  => 'events',
	'with_front'            => false,
	'pages'                 => true,
	'feeds'                 => true,
);
$args = array(
'label'                 => __( 'Event', 'procheads' ),
'description'           => __( 'Events', 'procheads' ),
'labels'                => $labels,
'supports'              => array( 'title', 'editor', 'thumbnail', 'author', 'revisions', ),
'taxonomies'            => array( 'events_category', 'post_tag' ),
'hierarchical'          => false,
'public'                => true,
'show_ui'               => true,
'show_in_menu'          => true,
'menu_position'         => 6,
'menu_icon'             => 'dashicons-calendar-alt',
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
register_post_type( 'events', $args );

}
add_action( 'init', 'procheads_events_post_type', 0 );

// Register Custom Taxonomy
function events_category() {

	$labels = array(
		'name'                       => _x( 'Events categories', 'Taxonomy General Name', 'procheads' ),
		'singular_name'              => _x( 'Event category', 'Taxonomy Singular Name', 'procheads' ),
		'menu_name'                  => __( 'Events category', 'procheads' ),
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
	);
	register_taxonomy( 'events_category', array( 'events' ), $args );

}
add_action( 'init', 'events_category', 0 );

function procheads_pre_get_events( $wp_query ) {

	//only interested in Jobs query
	if ( $wp_query->query['post_type'] === 'events' || $wp_query->query['events_category'] ){
		set_query_var('posts_per_page', -1 );
		set_query_var('meta_key', 'date_of_event');
		set_query_var('orderby', 'meta_value_num');
		set_query_var('order', 'ASC');
		$today = date('Ymd');
		//Need to find if the date is filtered
		$query_month = sprintf('%02d', intval( get_query_var('event_month')));
		$query_year = intval( get_query_var('event_year') );

		//Limit to a month and this year
		if ( intval($query_month) || intval($query_year) ) {

			$find_date = $query_year;
			$find_end_date = $query_year + 1;

			if ( intval($query_month) ) {
				$find_date = $query_year . $query_month . '01';
				$find_end_date = $query_year . $query_month . 't';
			}


			set_query_var('meta_query', array(
					array(
						'key'		=> 'date_of_event',
						'compare'	=> '>=',
						'value'		=> $find_date,
					),
					array(
						'key'		=> 'date_of_event',
						'compare'	=> '<=',
						'value'		=> $find_end_date,
					)
				)
			);
			return;
		}
		//Default query from todays date
		set_query_var('meta_query', array(
				array(
					'key'		=> 'date_of_event',
					'compare'	=> '>=',
					'value'		=> $today,
				)
			)
		);

	}

}
add_action('pre_get_posts', 'procheads_pre_get_events' );

function procheads_events_category_dropdown(){

	$taxonomy = 'events_category';

	$terms = get_terms( array(
		'taxonomy' => $taxonomy,
		'hide_empty' => true,
	) );

	$field[ 0 ] = 'All Events';

	$parents = array();
	foreach ( $terms as $term ) {
		if ( $term->parent === 0 ) {
			$parents[] = $term;
		}
	}

	foreach ( $parents as $parent ) :
		$field[ esc_attr( $parent->slug ) ] = esc_attr( $parent->name );
		//Indent the children
		foreach ( $terms as $term ) {
			if ( $term->parent === $parent->term_id ) {
				$field[ esc_attr( $term->slug ) ] = esc_attr( '- ' . $term->name );
			}
		}
	endforeach;

	$select_template = '<div class="large-3 column"><select name="%1$s" id="%1$s" class="events-filter">%2$s</select></div>';
	$option_template = '<option value="%s"%s>%s</option>';

	$query_var = get_query_var( $taxonomy );

	$options = '';
	foreach ( $field as $key => $name ) :
		$selected = ( $key === $query_var ) ? ' selected':'';
		$options .= sprintf($option_template, $key, $selected, $name);
	endforeach;

	return sprintf($select_template, $taxonomy, $options);
}

function procheads_events_dates_dropdown(){

	$dropdowns = procheads_events_field_names();

	$output = '';

	//Grab all the events and loop through collecting the dates;
	$args = array(
		'post_type' => 'events',
		'posts_per_page' => -1
	);
	$events_query = new WP_Query( $args );
	// The Loop
	if ( $events_query->have_posts() ) {
		$event_month = $event_year = array();
		while ( $events_query->have_posts() ) {
			$events_query->the_post();
			$event_date = get_field('date_of_event', false, false);
			$event_date = new DateTime($event_date);
			$event_month[intval($event_date->format('m'))] = $event_date->format('F');
			$event_year[intval($event_date->format('Y'))] = $event_date->format('Y');
		}
		/* Restore original Post Data */
		wp_reset_postdata();
	}
	$event_months = array_unique($event_month);
	ksort($event_months);
	$event_years = array_unique($event_year);
	ksort($event_years);

	$event_dates = array('event_month' => $event_months, 'event_year' => $event_years);


	foreach ( $dropdowns as $drop_key => $dropdown ){
		$query_var = intval(get_query_var( $drop_key ));

		$select_template = '<div class="large-3 column"><select name="%1$s" id="%1$s" class="events-filter">%2$s</select></div>';
		$option_template = '<option value="%s"%s>%s</option>';

		$options = sprintf($option_template, 0, null, 'All ' . $dropdown);
		//Override for year
		if ( $drop_key === 'event_year' ) {
			if ( $query_var === 0 ) $query_var = intval(date('Y'));
			$options = '';
		}

		foreach ( $event_dates[$drop_key] as $key => $name ) :
			$selected = ( $key === $query_var ) ? ' selected':'';
			$options .= sprintf($option_template, $key, $selected, $name);
		endforeach;

		$output .= sprintf($select_template, $drop_key, $options);
	}

	return $output;

}

function procheads_get_event_terms($post_ID, $separator, $slug = false, $parent = false){
	$terms = get_the_terms( $post_ID, 'events_category' );
	$post_terms = array();
	$name = ($slug) ? 'slug' : 'name';

	foreach ($terms as $term) {
		$post_terms[$term->term_id] = $term->$name;
	}
	if ( count($post_terms) ) {
		return implode($separator, $post_terms);
	}
	return false;
}