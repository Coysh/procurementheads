<?php
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'ProcHeads Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> true
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header and Footer Settings',
		'menu_title'	=> 'Company Details (Header/Footer)',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Jobs Settings',
		'menu_title'	=> 'Jobs',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Team Settings',
		'menu_title'	=> 'Team',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Sidebar Settings',
		'menu_title'	=> 'Sidebar',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Video Settings',
		'menu_title'	=> 'Video',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Custom 404',
		'menu_title'	=> '404 Not Found',
		'parent_slug'	=> 'theme-general-settings',
	));

}

function acf_google_api_init() {

	acf_update_setting('google_api_key', 'AIzaSyD9-1kvmHKhjzOsOdbtpHBpfVxa0RSEC3k');
}

add_action('acf/init', 'acf_google_api_init');
