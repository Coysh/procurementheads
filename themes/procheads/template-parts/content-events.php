<?php
/**
 * The default template for events content
 **
 * @package procheads
 * @since procheads 1.0.0
 */

$data_categories = procheads_get_event_terms(get_the_ID(), ',', true);
$name_categories = procheads_get_event_terms(get_the_ID(), ', ');

$event_date = get_field('date_of_event', false, false);
$date = new DateTime($event_date);

$data_month = intval($date->format('m'));
$data_year =  intval($date->format('Y'));

?>
<div id="event-<?php the_ID(); ?>" class="event event--single column column-block" data-category="<?php echo $data_categories ?>" data-month="<?php echo $data_month ?>" data-year="<?php echo $data_year ?>">
    <a href="<?php the_permalink(); ?>" class="event--single-link">
        <div class="event--single-wrapper" data-equalizer-watch>
            <h3 class="event--single-type"><?php echo $name_categories; ?></h3>
            <p class="event--single-day"><?php echo $date->format('j') ?></p>
        </div>
    </a>
</div>
