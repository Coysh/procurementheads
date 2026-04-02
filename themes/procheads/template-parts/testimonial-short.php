<?php
$short_title = get_sub_field('short_intro_text');
$short_repeater = get_sub_field('short_testimonial');
$column = 0;
$row = 0;
?>
<?php if ($short_repeater) : ?>
<div class="short">
	<div class="row">
		<?php if ($short_title) : ?><h3 class="short__heading"><?php echo $short_title ?></h3><?php endif; ?>
		<?php foreach($short_repeater as $short) : ?>
			<?php
			$short_logo = $short['short_logo'];
			$short_quote = $short['short_quote'];
			$short_company_job_title = $short['short_company_job_title'];
			$short_company_name = $short['short_company_name'];
			$short_video = $short['video_url'];

			//YouTube needs the jsapi attached
			if ( strrpos($short_video, 'youtube') ) {

				preg_match('/src="(.+?)"/', $short_video, $matches);
				$src = $matches[1];


                // add extra params to iframe src
				$params = array(
					'enablejsapi'    => 1
				);

				$new_src = add_query_arg($params, $src);

				$short_video = str_replace($src, $new_src, $short_video);


                // add extra attributes to iframe html
				$attributes = 'class="iframe iframe-youtube"';

				$short_video = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $short_video);

            }

			//Vimeo needs the jsapi attached
			if ( strrpos($short_video, 'vimeo') ) {

				preg_match('/src="(.+?)"/', $short_video, $matches);
				$src = $matches[1];


				// add extra params to iframe src
				$params = array(
					'api'    => 1
				);

				$new_src = add_query_arg($params, $src);

				$short_video = str_replace($src, $new_src, $short_video);


				// add extra attributes to iframe html
				$attributes = 'class="iframe iframe-vimeo"';

				$short_video = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $short_video);

			}

			$output = '';
			if( !empty($short_logo) ):
				$output .= '<a href="#" class="short__item js-testimonials">';
				$output .= '<img src="' . $short_logo['sizes'][ 'medium' ] . '" alt="' . $short_logo['alt'] . '" />';
				$output .= '</a>';
			endif;
				$output .= '<div class="short__quote">';
					if ($short_quote) : $output .= '<div class="short__quote-text">' . $short_quote . '</div>'; endif;
					if ($short_company_job_title) : $output .= '<div class="short__quote-jobtitle">' . $short_company_job_title . '</div>'; endif;
					if ($short_company_name) : $output .= '<div class="short__quote-company">' . $short_company_name . '</div>'; endif;
					if ($short_video) : $output .= '<div class="short__quote-video" style="max-width:' . get_field('tst_video_width','options') . 'px">' . $short_video . '</div>'; endif;
				$output .= '</div>';

			$arr_rows[$column][$row] = $output;
			$row++;
			if ($row >= 4) {
				$column++;
				$row = 0;
			}
			?>
		<?php endforeach; ?>
		<?php if ( $arr_rows ) : ?>
			<?php foreach($arr_rows as $column_idx => $logo_column) : ?>
				<div class="short__wrapper">
					<?php foreach($logo_column as $row_idx => $log_item) : ?>
						<?php echo $log_item; ?>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
