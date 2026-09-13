<?php

function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 250,
        'single_image_width'    => 300,

        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );

    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

function mytheme_register_menus() {
    register_nav_menus( array(
        'menu-1' => __( 'Primary Menu', 'madeincosta8' ),
    ) );
}

add_action( 'after_setup_theme', 'mytheme_register_menus' );

function mytheme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'automatic-feed-links' );
}

add_action( 'after_setup_theme', 'mytheme_setup' );

function mytheme_enqueue_styles() {
    wp_enqueue_style( 'madeincosta8-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}

add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_styles' );

function mytheme_enqueue_scripts() {
    wp_enqueue_script( 'madeincosta8-navigation', get_template_directory_uri() . '/js/navigation.js', array(), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_scripts' );

function mytheme_coming_soon_gate() {
    if ( is_user_logged_in() || is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return;
    }

    include get_template_directory() . '/coming-soon.php';
    exit;
}

add_action( 'template_redirect', 'mytheme_coming_soon_gate' );