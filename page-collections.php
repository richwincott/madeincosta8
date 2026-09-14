<?php get_header(); ?>
<div class="site-content">
    <h1><?php the_title(); ?></h1>
    <div class="collections-grid">
        <?php
        $collections = get_terms( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'exclude'    => array( get_option( 'default_product_cat', 0 ) ),
        ) );

        if ( ! empty( $collections ) && ! is_wp_error( $collections ) ) :
            foreach ( $collections as $collection ) :
                $thumbnail_id = get_term_meta( $collection->term_id, 'thumbnail_id', true );
                $image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : wc_placeholder_img_src( 'large' );
                ?>
                <a class="collection-card" href="<?php echo esc_url( get_term_link( $collection ) ); ?>" style="background-image: url('<?php echo esc_url( $image_url ); ?>');">
                    <span class="collection-card-overlay"></span>
                    <span class="collection-card-title"><?php echo esc_html( $collection->name ); ?></span>
                </a>
                <?php
            endforeach;
        else :
            ?>
            <p>No collections yet.</p>
            <?php
        endif;
        ?>
    </div>
</div>
<?php get_footer(); ?>
