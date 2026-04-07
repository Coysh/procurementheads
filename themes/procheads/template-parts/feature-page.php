<?php
$pages = get_sub_field('pages');

if( $pages ): ?>
	<?php foreach( $pages as $post): // variable must be called $post (IMPORTANT) ?>
		<?php setup_postdata($post); ?>
        <?php
		$feat_image = get_the_post_thumbnail_url(get_the_ID(),'medium');
		$over_image = get_field('override_image');
		$class = '';
		$bk_image = '';

		if ( !empty($over_image) ) {
			$size = 'medium';
			$src = $over_image['sizes'][ $size ];

		} elseif( !empty($feat_image) ){
			$src = $feat_image;
		}

		if( !empty($src) ):

			$bk_image = sprintf(' style="background-image:url(%s);"',$src);
		    $class = ' feature--has-background';

		endif;

        ?>
		<div class="feature feature--page feature--custom">
            <div class="feature--border<?php echo $class; ?>"<?php echo $bk_image ?> data-equalizer-watch>
                <div class="feature__content">
                    <?php
                    $button_title = (get_field('override_button_title'))? : 'MORE';
                    $button_css_bk = (get_field('override_button_colour'))? : 'dark';
                    $button_url = get_permalink(); ?>
                    <h2><a href="<?php echo $button_url ?>"><?php echo(get_field('override_title'))? : get_the_title(); ?></a></h2>
                    <p><?php echo(get_field('override_intro'))? : get_field('stand_first'); ?></p>
                    <?php printf('<a href="%s" class="button button--%s">%s</a>', $button_url, $button_css_bk, $button_title); ?>
                </div>
            </div>
        </div>
	<?php endforeach; ?>
<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif;


