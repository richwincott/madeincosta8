<?php get_header(); ?>
<div class="home-hero" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/img/768615352_18003907130978503_7040886833167885518_n.jpg' ); ?>');">
    <div class="home-hero-overlay"></div>
    <div class="home-hero-logo">
        <h2>Real hands make real clothes</h2>
        <p> We design and sell digital crochet patterns you make yourself.</p>
        
        <div class="home-cta-container">
            <a class="home-cta-button" href="<?php echo esc_url( home_url( '/collections' ) ); ?>">
                Explore our collections
            </a>
        </div>
    </div>
</div>
<?php get_footer(); ?>
