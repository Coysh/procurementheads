<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package procheads
 * @since procheads 1.0.0
 */

?>

        </section>

		<div class="footer">
			<footer class="footer__wrapper row small-up-1 medium-up-2 large-up-4">
				<?php do_action( 'procheads_before_footer' ); ?>
                <div class="footer__navigation footer--part column column-block">
                    <?php printf('<h4>%s</h4>',get_field('footer_title_navigation', 'options')); ?>
                    <?php procheads_footer(); ?>
                </div>
                <div class="footer__contact footer--part column column-block">
	                <?php printf('<h4>%s</h4>',get_field('footer_title_contact', 'options')); ?>
                    <?php the_field('company_address','options'); ?>
                </div>
                <div class="footer__social footer--part column column-block">
	                <?php printf('<h4>%s</h4>',get_field('footer_title_social', 'options')); ?>
                    <?php procheads_render_social_icon_list('footer'); ?>
                </div>
                <div class="footer__details footer--part column column-block">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo"><img src="<?php echo esc_url(get_field('company_logo','options')); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
                    <?php printf('<p>%s</p>',get_field('company_tagline', 'options')); ?>
	                <?php procheads_top_bar_r_buttons(); ?>
                </div>
				<?php do_action( 'procheads_after_footer' ); ?>
			</footer>
		</div>

		<?php do_action( 'procheads_layout_end' ); ?>


<?php wp_footer(); ?>
<?php do_action( 'procheads_before_closing_body' ); ?>
</body>
</html>
