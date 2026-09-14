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

// All products are downloadable - disable shipping sitewide (hides the
// Shipping address section on My Account, shipping fields at checkout,
// and any shipping calculators).
add_filter( 'wc_shipping_enabled', '__return_false' );

// Move price out of its default position (right after the title) and group
// it with the Add to Cart button instead, placed after the short
// description. Wrapped in a shared div so the two can sit side by side.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'mytheme_price_and_add_to_cart', 25 );

function mytheme_price_and_add_to_cart() {
    echo '<div class="price-and-cart">';
    woocommerce_template_single_price();
    woocommerce_template_single_add_to_cart();
    echo '</div>';
}

// Replace the Cart link's label in the nav menu with a cart icon + item
// count badge, without touching any other menu item.
function mytheme_cart_nav_icon( $title, $item, $args, $depth ) {
    if ( ! function_exists( 'wc_get_page_id' ) || ! function_exists( 'WC' ) ) {
        return $title;
    }

    if ( 'page' !== $item->object || (int) $item->object_id !== wc_get_page_id( 'cart' ) ) {
        return $title;
    }

    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

    return '<span class="cart-icon">'
        . '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>'
        . '<span class="cart-contents-count">' . esc_html( $count ) . '</span>'
        . '</span>';
}

add_filter( 'nav_menu_item_title', 'mytheme_cart_nav_icon', 10, 4 );

// Keep that badge live-updated via WooCommerce's existing AJAX cart-fragments
// system, so it changes instantly after Add to Cart with no page reload.
function mytheme_cart_count_fragment( $fragments ) {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    $fragments['.cart-contents-count'] = '<span class="cart-contents-count">' . esc_html( $count ) . '</span>';
    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'mytheme_cart_count_fragment' );