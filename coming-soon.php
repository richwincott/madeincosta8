<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo( 'name' ); ?></title>
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
            justify-content: center;
        }
    </style>

    <?php wp_head(); ?>
</head>
<body style="text-align: center;">
    <img src="<?php echo get_template_directory_uri(); ?>/img/763907261_18003302318978503_5232659097694014864_n.jpg" style="width:800px; max-width: 100%; margin: 0 auto;" alt="">
    <p>coming soon</p>
    <p><a href="https://www.instagram.com/madeincosta8/" style="display: flex;
    align-items: center;
    justify-content: center; margin-right: 10px;">
        <img src="<?php echo get_template_directory_uri(); ?>/img/instagram_logo_icon_189247-4278989595.png" width="40px" alt="">
        madeincosta8
    </a></p>

    <?php wp_footer(); ?>
</body>
</html>
