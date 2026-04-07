<?php
function procheads_get_row_layout() {
if( get_row_layout() == 'custom' ):

get_template_part('template-parts/feature','custom');

elseif( get_row_layout() == 'page' ):

get_template_part('template-parts/feature','page');

endif;

}