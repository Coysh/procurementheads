<?php
$postID = get_the_ID();
if ( is_home() ) {
	$postID = get_option( 'page_for_posts' );
}
$page_features = get_field('choose_page_features', $postID);


if( $page_features ):
	foreach( $page_features as $feature_ID ) :

		if( have_rows('sections', $feature_ID) ):


			// loop through the rows of data
			while ( have_rows('sections', $feature_ID) ) : the_row();

				if( get_row_layout() == 'jobs' ):

					get_template_part('template-parts/section','jobs');

// 				elseif( get_row_layout() == 'knowledge' ):
// 
// 					get_template_part('template-parts/section','knowledge');
// 
// 				elseif( get_row_layout() == 'page_feature' ):
// 
// 					get_template_part('template-parts/section','page-feature');
// 
// 				elseif( get_row_layout() == 'testimonials' ):
// 
// 					get_template_part( 'template-parts/section', 'testimonials');
// 
// 				elseif( get_row_layout() == 'findjob' ):
// 
// 					get_template_part( 'template-parts/section', 'findjob');

				endif;

			endwhile;

		endif;


	endforeach;
endif;

