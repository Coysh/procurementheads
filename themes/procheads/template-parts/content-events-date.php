<?php
/**
 * The default template for events category month view
 **
 * @package procheads
 * @since procheads 1.0.0
 */

$date = get_field('date_of_event', false, false);
$date = new DateTime($date);

?>

<div class="event event--lead column column-block">
    <div class="event--lead-wrapper" data-equalizer-watch>
	    <?php printf('<h2 class="event--lead-date"  data-equalizer-watch>%s<br/><span class="event--lead-year">%s</span></h2>',$date->format('F'),$date->format('Y')); ?>
    </div>
</div>
