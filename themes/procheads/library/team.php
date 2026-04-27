<?php
// Register Custom Post Type - team
function procheads_team_post_type() {

	$labels = array(
		'name'                  => _x( 'Team', 'Post Type General Name', 'procheads' ),
		'singular_name'         => _x( 'Team', 'Post Type Singular Name', 'procheads' ),
		'menu_name'             => __( 'Team', 'procheads' ),
		'name_admin_bar'        => __( 'Team Member', 'procheads' ),
		'archives'              => __( 'team Archives', 'procheads' ),
		'attributes'            => __( 'Team Attributes', 'procheads' ),
		'parent_item_colon'     => __( 'Parent Team:', 'procheads' ),
		'all_items'             => __( 'All Team Members', 'procheads' ),
		'add_new_item'          => __( 'Add New Member', 'procheads' ),
		'add_new'               => __( 'Add New', 'procheads' ),
		'new_item'              => __( 'New Team Member', 'procheads' ),
		'edit_item'             => __( 'Edit Team Member', 'procheads' ),
		'update_item'           => __( 'Update Team Member', 'procheads' ),
		'view_item'             => __( 'View Team Member', 'procheads' ),
		'view_items'            => __( 'View team Member', 'procheads' ),
		'search_items'          => __( 'Search team Member', 'procheads' ),
		'not_found'             => __( 'Not found', 'procheads' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'procheads' ),
		'featured_image'        => __( 'Featured Image', 'procheads' ),
		'set_featured_image'    => __( 'Set featured image', 'procheads' ),
		'remove_featured_image' => __( 'Remove featured image', 'procheads' ),
		'use_featured_image'    => __( 'Use as featured image', 'procheads' ),
		'insert_into_item'      => __( 'Insert into Team', 'procheads' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Team Member', 'procheads' ),
		'items_list'            => __( 'team list', 'procheads' ),
		'items_list_navigation' => __( 'team list navigation', 'procheads' ),
		'filter_items_list'     => __( 'Filter team list', 'procheads' ),
	);
	$rewrite = array(
		'slug'                  => 'team',
		'with_front'            => false,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Team', 'procheads' ),
		'description'           => __( 'team', 'procheads' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'author', 'revisions', ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 7,
		'menu_icon'             => 'dashicons-groups',
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
	register_post_type( 'team', $args );

}
add_action( 'init', 'procheads_team_post_type', 0 );

function procheads_team_member_shortcode()
{
	ob_start();
	?>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="single__featured-image">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php endif; ?>
		<header class="single__header">
			<h2 class="heading heading--team"><?php the_title(); ?></h2>
			<?php if ( get_field('tm_job_title') ) : ?>
				<h3 class="heading heading--team-sub"><?php echo esc_html( get_field('tm_job_title') ); ?></h3>
			<?php endif; ?>
		</header>
	<?php
	return ob_get_clean();
}
add_shortcode('team_member', 'procheads_team_member_shortcode');

