<?php

$feature_colour = get_sub_field('feature_colour');
$feature_bk_colour = get_sub_field('feature_colour_bk');
$feature_logos = get_sub_field('feature_logos');
$feature_quote = get_sub_field('feature_quote');
$feature_company_job_title = get_sub_field('feature_company_job_title');
$feature_company_name = get_sub_field('feature_company_name');
$feature_title = get_sub_field('feature_title');
$feature_text = get_sub_field('feature_text');
$feature_text_copy = get_sub_field('feature_text_copy');
$bool_button = get_sub_field('feature_include_button');
?>
<div class="testimonial testimonial--<?php echo esc_attr($feature_colour) ?> testimonial--bk-<?php echo esc_attr($feature_bk_colour) ?>">
	<div class="row">
		<div class="testimonial__wrapper">
			<div class="testimonial__right">
				<?php if ($feature_title) : ?><h3 class="blog-item--title"><?php echo $feature_title ?></h3><?php endif; ?>
				<?php if ($feature_text) : ?><div class="testimonial__text"><?php echo $feature_text ?></div><?php endif; ?>
				<?php if ($feature_text_copy) : ?><div class="testimonial__emphasis"><?php echo $feature_text_copy ?></div><?php endif; ?>
				<?php if ($bool_button) : ?><a href="<?php echo esc_url(get_field('button_page_link')) ?>" class="button"><?php the_field('button_title') ?></a><?php endif; ?>
			</div>
			<div class="testimonial__left">
				<?php
				if( !empty($feature_logos) ): ?>
					<div class="testimonial__logo">
						<img src="<?php echo $feature_logos['sizes'][ 'medium' ]; ?>" alt="<?php echo $feature_logos['alt']; ?>" />
					</div>
				<?php endif; ?>
				<div class="testimonial__quote">
					<?php if ($feature_quote) : ?><div class="testimonial__quote-text"><?php echo $feature_quote ?></div><?php endif; ?>
					<?php if ($feature_company_job_title) : ?><div class="testimonial__quote-jobtitle"><?php echo $feature_company_job_title ?></div><?php endif; ?>
					<?php if ($feature_company_name) : ?><div class="testimonial__quote-company"><?php echo $feature_company_name ?></div><?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>