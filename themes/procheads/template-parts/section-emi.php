<?php
$bk_image = get_field('emi_background_image','option');

if( !empty($bk_image) ):


	$size = 'large';
	$src = $bk_image['sizes'][ $size ];

	$bk_image = sprintf(' style="background-image:url(%s);"',$src);

endif;
?>
<aside class="emi"<?php echo $bk_image ?>>
	<div class="emi__header row column">
		<h2><?php the_field('emi_title', 'options') ?></h2>
		<?php the_field('emi_introduction', 'options') ?>
	</div>
	<div class="emi__wrapper row small-up-1 medium-up-2 large-up-4">

		<?php
		// check if the repeater field has rows of data
		if( have_rows('statistics', 'options') ):

			// loop through the rows of data
			while ( have_rows('statistics', 'options') ) : the_row();

				$stat_title = esc_html(get_sub_field('stat_title'));
				$stat_desc = esc_html(get_sub_field('stat_description'));
				printf('<div class="emi__stat column column-block"><h3>%s</h3><p>%s</p></div>', $stat_title, $stat_desc);

			endwhile;

		endif;
		?>

	</div>
    <?php if ( ! get_field('emi_hide_download_links', 'options' ) ) : ?>
	<div class="emi__footer row column">
		<a href="<?php the_field('emi_report_pdf','options')?>" class="button button--light"><?php the_field('emi_download_button_title','options')?></a><br/>
		<a href="<?php the_field('link_to_view_online','options')?>" class="emi__online-link"><?php the_field('emi_view_online_link_text','options')?></a>
	</div>
    <?php endif; ?>
</aside>