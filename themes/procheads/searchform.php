<?php
/**
 * The template for displaying search form
 *
 * @package procheads
 * @since procheads 1.0.0
 */

do_action( 'procheads_before_searchform' ); ?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<?php do_action( 'procheads_searchform_top' ); ?>
	<div class="input-group">
		<input type="text" class="input-group-field" value="" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'procheads' ); ?>">
		<?php do_action( 'procheads_searchform_before_search_button' ); ?>
		<div class="input-group-button">
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'procheads' ); ?>" class="button">
		</div>
	</div>
	<?php do_action( 'procheads_searchform_after_search_button' ); ?>
</form>
<?php do_action( 'procheads_after_searchform' );
