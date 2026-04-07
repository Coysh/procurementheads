<?php 

function procheads_feature_post() {

$labels = array(
'name'                  => _x( 'Feature', 'Post Type General Name', 'procheads' ),
'singular_name'         => _x( 'Feature', 'Post Type Singular Name', 'procheads' ),
'menu_name'             => __( 'Features', 'procheads' ),
'name_admin_bar'        => __( 'Features', 'procheads' ),
'archives'              => __( 'Feature Archives', 'procheads' ),
'attributes'            => __( 'Feature Attributes', 'procheads' ),
'parent_item_colon'     => __( 'Parent Feature:', 'procheads' ),
'all_items'             => __( 'All Features', 'procheads' ),
'add_new_item'          => __( 'Add New Feature', 'procheads' ),
'add_new'               => __( 'Add New', 'procheads' ),
'new_item'              => __( 'New Feature', 'procheads' ),
'edit_item'             => __( 'Edit Feature', 'procheads' ),
'update_item'           => __( 'Update Feature', 'procheads' ),
'view_item'             => __( 'View Feature', 'procheads' ),
'view_items'            => __( 'View Features', 'procheads' ),
'search_items'          => __( 'Search Feature', 'procheads' ),
'not_found'             => __( 'Not found', 'procheads' ),
'not_found_in_trash'    => __( 'Not found in Trash', 'procheads' ),
'featured_image'        => __( 'Featured Image', 'procheads' ),
'set_featured_image'    => __( 'Set featured image', 'procheads' ),
'remove_featured_image' => __( 'Remove featured image', 'procheads' ),
'use_featured_image'    => __( 'Use as featured image', 'procheads' ),
'insert_into_item'      => __( 'Insert into Feature', 'procheads' ),
'uploaded_to_this_item' => __( 'Uploaded to this Feature', 'procheads' ),
'items_list'            => __( 'Features list', 'procheads' ),
'items_list_navigation' => __( 'Features list navigation', 'procheads' ),
'filter_items_list'     => __( 'Filter Features list', 'procheads' ),
);
$args = array(
'label'                 => __( 'Feature', 'procheads' ),
'description'           => __( 'Feature content used by pages', 'procheads' ),
'labels'                => $labels,
'supports'              => array( 'title', 'revisions', ),
'taxonomies'            => array(),
'hierarchical'          => false,
'public'                => true,
'show_ui'               => true,
'show_in_menu'          => true,
'menu_position'         => 5,
'menu_icon'             => 'dashicons-align-center',
'show_in_admin_bar'     => true,
'show_in_nav_menus'     => false,
'can_export'            => true,
'has_archive'           => true,
'exclude_from_search'   => true,
'publicly_queryable'    => false,
'capability_type'       => 'post',
);
register_post_type( 'features', $args );

}
add_action( 'init', 'procheads_feature_post', 0 );