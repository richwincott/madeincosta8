<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="text-align: center;">
<?php wp_body_open(); ?>

	<header class="site-header">
		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/img/763907261_18003302318978503_5232659097694014864_n.png" class="site-logo" alt="<?php bloginfo( 'name' ); ?>">
			</a>
		</div>

		<nav class="main-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'container'      => false,
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'nav-menu',
					'depth'          => 1,
				) );
			?>
		</nav>

		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			<span class="menu-toggle-bar"></span>
			<span class="menu-toggle-bar"></span>
			<span class="menu-toggle-bar"></span>
			<span class="screen-reader-text">Menu</span>
		</button>
	</header>