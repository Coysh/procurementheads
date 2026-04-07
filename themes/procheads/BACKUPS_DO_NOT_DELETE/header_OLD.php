<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package procheads
 * @since procheads 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php wp_head(); ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-91628490-1', 'auto');
            ga('send', 'pageview');
        </script>
	</head>
	<body>
	<?php do_action( 'procheads_after_body' ); ?>

	<?php do_action( 'procheads_layout_start' ); ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="head-bar">
            <div class="row">
                <div class="head-bar__contact">
                    <ul>
                        <?php printf('<li><a href="tel:%1$s"><span class="fa-stack fa-gray"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-phone fa-stack-1x fa-inverse"></i></span> %1$s</a></li>', esc_attr(get_field('company_phone','options'))); ?>
                        <?php printf('<li><a href="mailto:%1$s"><i class="fa fa-envelope" aria-hidden="true"></i> %1$s</a></li>', esc_attr(get_field('company_email','options'))); ?>
                    </ul>
                </div>
                <div class="head-bar__social">
                    <?php
                    procheads_render_social_icon_list('header');
                    ?>
                </div>
            </div>
		</div>

		<nav id="site-navigation" class="main-navigation top-bar" role="navigation">

            <div class="top-bar__left">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo"><img src="<?php echo esc_url(get_field('company_logo','options')); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
			</div>
			<div class="top-bar__right">
                <div class="top-bar__right-wrapper js-menu-target">
                    <div class="top-bar__right-menu">
		                <?php procheads_top_bar_menu(); ?>
                    </div>
                    <div class="top-bar__right-buttons">
		                <?php procheads_top_bar_r_buttons(); ?>
                    </div>
                </div>
            </div>
            <button class="menu-icon js-menu-button" type="button" data-toggle="mobile-menu"><i class="fa fa-bars" aria-hidden="true"></i> <span class="show-for-sr">menu</span></button>
		</nav>
	</header>

	<section class="container">
		<?php do_action( 'procheads_after_header' );
