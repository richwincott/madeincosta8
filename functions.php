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
    wp_enqueue_style( 'madeincosta8-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
}

add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_styles' );

function mytheme_enqueue_scripts() {
    $nav_js_path = get_template_directory() . '/js/navigation.js';
    wp_enqueue_script( 'madeincosta8-navigation', get_template_directory_uri() . '/js/navigation.js', array(), filemtime( $nav_js_path ), true );
}

add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_scripts' );

function mytheme_coming_soon_gate() {
    if ( current_user_can( 'manage_options' ) || is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return;
    }

    // Always allow the My Account page through (login, register, lost password, orders, etc.)
    // so customers can create/manage accounts even while the rest of the site is gated.
    if ( function_exists( 'is_account_page' ) && is_account_page() ) {
        return;
    }

    include get_template_directory() . '/coming-soon.php';
    exit;
}

add_action( 'template_redirect', 'mytheme_coming_soon_gate' );

function mytheme_no_page_cache_headers() {
    if ( is_admin() ) {
        return;
    }

    nocache_headers();
}

add_action( 'send_headers', 'mytheme_no_page_cache_headers' );

function mytheme_rename_category_to_collection( $translated_text, $text, $domain ) {
    if ( 'woocommerce' !== $domain || is_admin() ) {
        return $translated_text;
    }

    $replacements = array(
        'Category:'   => 'Collection:',
        'Categories:' => 'Collections:',
        'Category'    => 'Collection',
        'Categories'  => 'Collections',
    );

    return isset( $replacements[ $text ] ) ? $replacements[ $text ] : $translated_text;
}

add_filter( 'gettext', 'mytheme_rename_category_to_collection', 10, 3 );

function mytheme_rename_category_to_collection_plural( $translation, $single, $plural, $number, $domain ) {
    if ( 'woocommerce' !== $domain || is_admin() ) {
        return $translation;
    }

    $replacements = array(
        'Category:'   => 'Collection:',
        'Categories:' => 'Collections:',
        'Category'    => 'Collection',
        'Categories'  => 'Collections',
    );

    return isset( $replacements[ $single ] ) ? ( 1 === (int) $number ? $replacements[ $single ] : ( isset( $replacements[ $plural ] ) ? $replacements[ $plural ] : $translation ) ) : $translation;
}

add_filter( 'ngettext', 'mytheme_rename_category_to_collection_plural', 10, 5 );