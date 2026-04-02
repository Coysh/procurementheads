<?php
function procheads_render_social_icon_list($position){
	if( have_rows('social_links', 'options') ):
		echo '<ul class="head-bar__social-list">';
		// loop through the rows of data
		while ( have_rows('social_links', 'options') ) : the_row();

			$sn_image = get_sub_field('social_network_header_icon');
			if ($position === 'footer') {
				$sn_image = get_sub_field('social_network_footer_icon');
			}

			$sn_link = esc_url(get_sub_field('social_network_link'));
			$sn_name = get_sub_field('social_network_header_icon');
			$sn_fa_code = get_sub_field('social_network_fa');

			// display a sub field value
			printf('<li><a href="%s" target="_blank"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-%s fa-stack-1x fa-inverse"></i></span></a></li>', $sn_link, esc_attr($sn_fa_code), $sn_name );


		endwhile;
		echo '</ul>';

	endif;
}

function procheads_render_social_share_list(){
	$template = '<div class="single__share"><dl class="single__share--list">%s</dl></div>';
	$item = '<dt class="single__share--link"><a href="%s" target="_blank"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-%s fa-stack-1x fa-inverse"></i></span><span class="show-for-sr">Share with %s</span></a></dt>';

	$items = '<dt class="single__share--title">Share</dt>';
	$items .= sprintf( $item, 'https://twitter.com/home?status=' . urlencode( get_the_permalink() ), 'twitter', 'Twitter' );
	$items .= sprintf( $item, 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_the_permalink() ), 'facebook', 'Facebook');
	$items .= sprintf( $item, 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_the_permalink() ), 'linkedin', 'LinkedIn');

	return sprintf($template, $items);

}

function procheads_render_member_social_list($postID){
	$phone = get_field('tm_phone', $postID);
	$email = get_field('tm_email', $postID);
	$twitter_url = get_field('tm_twitter_url', $postID);
	$linkedIn_url = get_field('tm_linked_in', $postID);

	$template = '<div class="single__share single__share--team"><dl class="single__share--list">%s</dl></div>';
	$item = '<dt class="single__share--link single__share--link-icon"><a href="%s" target="_blank"><i class="fa fa-%s"></i><span class="show-for-sr">%s</span></a></dt>';
	$item_no_icon = '<dt class="single__share--link"><a href="%s">%s</a></dt>';

	$items = sprintf( '<dt class="single__share--title">Contact %s</dt>', get_the_title($postID));
	if ($phone) {	$items .= sprintf( $item_no_icon, 'tel:' . preg_replace('/\s+/', '', esc_attr($phone)), '<em>t:</em> ' . esc_html($phone) ); }
	if ($email) {	$items .= sprintf( $item_no_icon, 'mailto:' . esc_attr($email), '<em>e:</em> ' . esc_html($email)); }
	if ($twitter_url) {	$items .= sprintf( $item, $twitter_url, 'twitter', 'Twitter' ); }
	if ($linkedIn_url) { $items .= sprintf( $item, $linkedIn_url, 'linkedin', 'LinkedIn'); }

	return sprintf($template, $items);

}

function procheads_is_in_menu( $menu = null, $object_id = null ) {

	// get menu object
	$menu_object = wp_get_nav_menu_items( esc_attr( $menu ) );

	// stop if there isn't a menu
	if( ! $menu_object )
		return false;


	// use the current post if object_id is not specified
	if( !$object_id ) {
		global $post;
		$object_id = get_queried_object_id();
	}

	//Check if we have a menu item, returns the parent
	foreach( $menu_object as $post_object ) {
		if( intval($post_object->object_id) === $object_id ) {
			return intval($post_object->menu_item_parent);
		}
	}
	return false;

}

function procheads_aps_default_read_capability( $capability ) {
	$capability = 'read';

	return $capability;
}
add_filter( 'aps_default_read_capability', 'procheads_aps_default_read_capability' );