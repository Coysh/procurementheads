<?php
$feature_type = get_sub_field('ft_dark_or_light');
?>

<section class="section section--feature section--<?php echo esc_attr($feature_type) ?>" data-equalizer data-equalize-on="large">
    <div class="section__column section__column--text" data-equalizer-watch>
        <div class="section__column-wrapper">
            <h2 class="heading heading--blog"><?php the_sub_field('ft_title') ?></h2>
            <div class="section__content"><?php the_sub_field('ft_content') ?></div>
	        <?php
	        $include_link = get_sub_field('ft_include_link');
	        if ( $include_link ) :
		        $button_template = '<a href="%s" class="button">%s</a>';
		        $link_type = get_sub_field('ft_link_type');
		        if ( $link_type === 'custom' ) :
			        $buttonLink = esc_url(get_sub_field('ft_link_custom'));
		        else :
			        //Picker
			        $link_picker = get_sub_field('ft_link_picker');
			        $buttonLink = get_the_permalink($link_picker[0]);
		        endif;
		        echo sprintf($button_template, $buttonLink, get_sub_field('ft_link_title'));
	        endif;
	        ?>
        </div>
    </div>
    <?php
    $image = get_sub_field('ft_image');
    $background_image = ' ';

    if( !empty($image) ):

        // vars
        $image_url = $image['sizes'][ 'large'];

        $background_image = sprintf(' style="background-image:url(%s)" ',$image_url);

    endif;
    ?>
    <div class="section__column section__column--image"<?php echo $background_image ?>data-equalizer-watch>
        <?php


        if ( $feature_type === "light" ) :
            $subtitle = get_sub_field('ft_subtitle');
            if ( $subtitle || $include_link ) :
                echo '<div class="section__column--image-overlay">';
            endif;
            if ( $subtitle ) :
                echo '<h3 class="heading heading--subtitle">' . $subtitle . '</h3>';
            endif;
            if ( $include_link ) :
                $button_template = '<a href="%s" class="heading heading--subtitle-link">%s</a>';
                echo sprintf($button_template, $buttonLink, get_sub_field('ft_image_link_title'));
            endif;
            if ( $subtitle || $include_link ) :
                echo '</div>';
            endif;
        endif;
        ?>
    </div>
</section>