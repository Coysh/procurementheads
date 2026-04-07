<?php
$bk_image = get_sub_field('feature_background_image');

if( !empty($bk_image) ):


$size = 'medium';
$src = $bk_image['sizes'][ $size ];

$bk_image = sprintf(' style="background-image:url(%s);"',$src);

endif;
?>

<div class="feature feature--custom">
    <div class="feature--border"<?php echo $bk_image ?> data-equalizer-watch>
        <div class="feature__content">
            <?php
            $button_title = esc_html(get_sub_field('button_title'));
            $button_css_bk = esc_attr(get_sub_field('button_colour'));
            $button_url = esc_url(get_sub_field('button_link'));
            printf('<h2><a href="%s">%s</a></h2>',$button_url, get_sub_field('feature_title'));
            if (get_sub_field('feature_intro')) : ?><p><?php the_sub_field('feature_intro') ?></p><?php endif;
            printf('<a href="%s" class="button button--%s">%s</a>', $button_url, $button_css_bk, $button_title);
            ?>
        </div>
    </div>
</div>