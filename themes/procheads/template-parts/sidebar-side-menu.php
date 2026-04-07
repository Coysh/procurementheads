<?php
$menu = get_term(get_nav_menu_locations()['top-bar-r-b'], 'nav_menu')->name;
if ( is_numeric( procheads_is_in_menu( $menu ) ) ) : ?>
<div class="sidebar__item sidebar__menu">
	<?php procheads_top_bar_menu(3); ?>
</div>
<?php endif;