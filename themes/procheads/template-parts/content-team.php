<a href="<?php the_permalink() ?>" id="post-<?php the_ID(); ?>" class="team-item column column-block">
	<div class="team-item__wrapper">
		<?php if ( has_post_thumbnail() ) : ?>
            <div class="team-item__image">
				<?php the_post_thumbnail('post-thumbnail'); ?>
            </div>
		<?php endif; ?>
		<div class="team-item__content">
            <h2 class="heading heading--team-member"><?php the_title(); ?></h2>
            <?php if ( get_field('tm_job_title') ) : ?><h3 class="heading heading--team-sub"><?php the_field('tm_job_title'); ?></h3><?php endif; ?>
			<?php if (get_field('stand_first') ) : ?><div class="stand-first"><?php the_field('stand_first') ?></div><?php endif; ?>
		</div>
	</div>
</a>