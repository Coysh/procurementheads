<?php
/**
 * Block template file: template-parts/blocks/hubs/hubs.php
 *
 * Hubs Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'hubs-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'hubs';
if( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}
if( ! empty( $block['align'] ) ) {
	$classes .= ' align' . $block['align'];
}

if( $is_preview ) {
  $classes .= ' is-admin';
}
?>




<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if( have_rows('hubs') ): ?>
    <div class="hubs">
      <?php while( have_rows('hubs') ): the_row(); 
        $image = get_sub_field('image');
        $page_link = get_sub_field('page_link');
        $title = get_sub_field('title');
        ?>
<div class="carousel-cell">
        <a href="<?php the_sub_field('page_link'); ?>">
          
            <?php echo wp_get_attachment_image( $image['id'], 'full' ); ?>
            <h3><?php the_sub_field('title'); ?></h3>
    
        </a>
</div>
     
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p>Please add some slides.</p>
  <?php endif; ?>
</div>






