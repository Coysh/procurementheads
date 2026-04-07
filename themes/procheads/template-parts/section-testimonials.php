<section class="section section--testimonials">
	<div class="section__wrapper">
		<div class="section__column section__column--testimonials">
			<h3 class="heading heading--knowledge"><?php the_sub_field('tst_title') ?></h3>
			<div class="carousel js-carousel">
				<?php
				$testimonials = get_sub_field('tst_testimonials');
				if( $testimonials ):
					foreach( $testimonials as $testimonial ) :
						echo '<div class="quote">' . $testimonial['tst_content'] ;
						if ( $testimonial['tst_citation'] ) :
							echo '<div class="citation">' . $testimonial['tst_citation'] . '</div>';
						endif;
						echo '</div>';
					endforeach;
				endif;
				?>
			</div>
		</div>
		<?php if ( !get_field('sb_hide_feature', 'options') ) : ?>
			<div class="sidebar__item sidebar__item-blogs sidebar__item-center">
				<div class="sidebar__item-wrapper ">
					<h5 class="heading heading--knowledge"><?php the_field('sb_title', 'option'); ?></h5>
					<div class="sidebar__item-content">
						<?php the_field('sb_content', 'option'); ?>
					</div>
					<?php
					if ( get_field('sb_add_link', 'option' ) ) :
						$button_template = '<a href="%s" class="button hollow">%s</a>';
						$link_picker = get_field('sb_link_picker','option');
						$buttonLink = get_the_permalink($link_picker[0]);
						echo sprintf($button_template, $buttonLink, get_field('sb_link_title','option'));
					endif;
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>

</section>
