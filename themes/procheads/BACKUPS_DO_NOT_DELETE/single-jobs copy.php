<?php
/**
 * The template for displaying all single jobs
 *
 * @package procheads
 * @since procheads 1.0.0
 */

get_header(); ?>
<div class="jobs single single--jobs js-form-target">

    <header class="header">
        <div class="header--background">
            <div class="header__content">
                <div class="column">
                    <h1 class="heading heading--larger"><?php echo __('JOB DETAILS', 'procheads');?></h1>
                </div>
            </div>
        </div>
    </header>

	<div id="job-post" role="main">

        <div class="row">
		<?php do_action( 'procheads_before_content' ); ?>
		<?php while ( have_posts() ) : the_post(); ?>
            <?php
            $team_members = get_field('choose_member');
			$consultant = ($team_members[0]) ? esc_attr(get_the_title($team_members[0])) : 'na';
            ?>
			<article id="post-<?php the_ID(); ?>" class="single__article js-form-scroll">
                <button class="button button--close js-form-button show-on-open">CLOSE <i class="fa fa-times" aria-hidden="true"></i></button>
				<header class="single__header">
					<h1 class="heading heading--blog"><?php the_title(); ?></h1>
				</header>
				<?php do_action( 'procheads_post_before_entry_content' ); ?>

                <div class="entry-content">
					<?php if (get_field('stand_first') ) : ?><div class="stand-first"><?php the_field('stand_first') ?></div><?php endif; ?>

                    <div class="hide-on-open">
					    <?php the_content(); ?>
                    </div>
				</div>
				<?php  ?>
                <div id="apply-form" class="">
					<?php //gravity_form(1, false, false, false, array("consultant" => $consultant), true, 100); ?>
					<iframe src="<?php print get_field('apply_url') ?>" width="600" height="1200" style="width:100%;border:0;"></iframe>
                </div>

            </article>
            <aside class="sidebar hide-on-open">

                <div class="sidebar__wrapper">
                    <div class="sidebar__item job__details">
                        <h2 class="heading heading--sidebar"><?php echo __("JOB SUMMARY","procheads")?></h2>
						<?php
						$job_meta = procheads_get_job_meta( get_the_ID() );
						$salary = ( get_field('custom_salary_display') ) ? get_field('custom_salary_display') : $job_meta['salary_scale'];
						?>
                        <dl class="details-list">
							<?php if ( $job_meta['contract'] )  printf('<dt class="details-list--term">Contract:</dt><dd class="details-list--def">%s</dd>', $job_meta['contract']) ?>
							<?php if ( $job_meta['location'] ) printf('<dt class="details-list--term">Location:</dt><dd class="details-list--def">%s</dd>', $job_meta['location']) ?>
							<?php if ( $job_meta['level'] )  printf('<dt class="details-list--term">Level:</dt><dd class="details-list--def">%s</dd>', $job_meta['level']) ?>
							<?php if ( $salary )  printf('<dt class="details-list--term">Salary:</dt><dd class="details-list--def">%s</dd>', $salary) ?>
                        </dl>
                        <button class="button button--apply js-form-button">APPLY NOW</button>
                    </div>
					<?php


					if ( $team_members ) :
						foreach($team_members as $team_member) : ?>
                            <div class="sidebar__item job__role">
                                <div class="job__role-wrapper">
                                    <h2 class="heading heading--sidebar"><?php echo __("CONSULTANT DETAILS","procheads")?></h2>
                                    <p class="job__role-lead"><?php echo __("This role is managed by:","procheads")?></p>
									<?php
									$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $team_member ), 'thumbnail' );
									if ( ! empty( $thumb_image_url[0] ) ) {
										echo '<img src="' . esc_url( $thumb_image_url[0] ) . '" class="job__role-portrait">';
									}
									?>
                                    <h3 class="job__role-name"><?php echo get_the_title($team_member) ?></h3>
									<?php if( get_field('tm_job_title',$team_member) ) : ?>
                                        <h4 class="job__role-title"><?php echo get_field('tm_job_title',$team_member) ?></h4>
									<?php endif; ?>
									<?php
									$user_display_email = get_field('tm_email', $team_member);
									$user_contact_number = get_field('tm_phone', $team_member);
									$user_linkedin_url = get_field('tm_linked_in', $team_member);
									?>
                                    <ul class="contact-list">
										<?php if ($user_display_email) printf('<li><a href="mailto:%1$s"><i class="fa fa-envelope" aria-hidden="true"></i> %1$s</a></li>',$user_display_email); ?>
										<?php if ($user_contact_number) printf('<li><a href="tel:%1$s"><i class="fa fa-phone-square" aria-hidden="true"></i> %1$s</a></li>',$user_contact_number); ?>
										<?php if ($user_linkedin_url) printf('<li><a href="%s"><i class="fa fa-linkedin" aria-hidden="true"></i> Connect on <strong>LinkedIn</strong></a></li>',$user_linkedin_url); ?>
                                    </ul>
									<?php the_field('blue_box') ?>
                                </div>
                            </div>
						<?php endforeach;
					endif;
					?>

                </div>
            </aside>

			<?php do_action( 'procheads_after_content' ); ?>
		<?php endwhile;?>
        </div>
	</div>
</div>
<?php get_template_part('template-parts/section','layouts'); ?>
<?php get_footer();
