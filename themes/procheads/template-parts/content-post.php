<?php
/**
 * The default template for displaying post content
 *
 * @package procheads
 * @since procheads 1.0.0
 */
$feat_image = get_the_post_thumbnail_url(get_the_ID(),'medium');
$over_image = get_field('override_image');


if( !empty($feat_image) ):

	$bk_image = sprintf(' style="background-image:url(%s);"',$feat_image);

endif;

?>

<a href="<?php the_permalink() ?>" id="post-<?php the_ID(); ?>" class="blog-item column column-block"  data-equalizer-watch>
    <div class="blog-item__wrapper">
        <div class="blog-item__header"<?php echo $bk_image ?>>
		    <?php procheads_date_meta(); ?>
        </div>
        <div class="blog-item__content">
            <h2 class="blog-item--title"><?php the_title(); ?></h2>
		    <?php procheads_entry_meta(); ?>
        </div>
    </div>
</a>
