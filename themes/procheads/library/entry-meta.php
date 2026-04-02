<?php
/**
 * Entry meta information for posts
 *
 * @package procheads
 * @since procheads 1.0.0
 */

if ( ! function_exists( 'procheads_entry_meta' ) ) :
	function procheads_entry_meta() {

		echo '<p class="heading heading--byline"><span class="fulldate">' . get_the_date('F j, Y') . ' </span> ';

        $team_member = get_field('choose_member');
        if ( $team_member ) :
			echo 'by <span class="author">' . get_the_title($team_member[0]) . '</span></p>';
        endif;
	}
endif;
if ( ! function_exists( 'procheads_date_meta' ) ) :
	function procheads_date_meta() {
		echo '<time class="updated" datetime="' . get_the_time( 'c' ) . '"><span class="updated--j">' . get_the_date('d') . '</span><span class="updated--my">' . get_the_date('M Y') . '</span></time>';
	}
endif;
