<!DOCTYPE html>
<html lang="en" style="margin-top: 0px !important;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>madeincosta8</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100dvh;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            flex-direction: column;
            align-items: center;
			justify-content: space-between;

        }
		.menu ul {
			list-style: none;
			padding-left: 0;
		}
		.menu li {
			display: inline-block;
		}
    </style>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="text-align: center;">

	<img src="<?php echo get_template_directory_uri(); ?>/img/763907261_18003302318978503_5232659097694014864_n.jpg" style="width:300px; max-width: 100%;" alt="">
	
	<?php
		wp_nav_menu( array(
			'container'     => '',
			'theme_location' => 'menu-1',
			'depth'             => 1,
			'items_wrap' => '%3$s'
		) );
	?>