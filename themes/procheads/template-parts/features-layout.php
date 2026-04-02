<?php


// check if the page flexible content field has rows of data
if( have_rows('feature_type') ):

	// loop through the rows of data
	while ( have_rows('feature_type') ) : the_row();

		procheads_get_row_layout();

	endwhile;

endif;
