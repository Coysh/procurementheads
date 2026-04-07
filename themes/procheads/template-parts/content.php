<?php
/**
* The default template for displaying content
*
* @package procheads
* @since procheads 1.0.0
*/
$feat_image = get_the_post_thumbnail_url(get_the_ID(),'medium');
$over_image = get_field('override_image');

if ( !empty($over_image) ) {
$size = 'medium';
$src = $over_image['sizes'][ $size ];

} elseif( !empty($feat_image) ){
$src = $feat_image;
}

if( !empty($src) ):

$bk_image = sprintf(' style="background-image:url(%s);"',$src);

endif;

?>

<a href="<?php the_permalink() ?>" id="post-<?php the_ID(); ?>" class="blog-item column column-block">
    <div class="blog-item__wrapper">
        <div class="blog-item__header"<?php echo $bk_image ?>>
        </div>
        <div class="blog-item__content">
            <h2 class="blog-item--title"><?php the_title(); ?></h2>
        </div>
    </div>
</a>