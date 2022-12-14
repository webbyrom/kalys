<?php get_header(); ?>


<main class="kalys-main-accueil" id="kalys_main_accueil">
    <div class="kalys-header-slider">
        <?php
        if (is_front_page()) {
            echo do_shortcode('[rev_slider alias="slider-2"][/rev_slider]');
        }
        ?>
    </div>
    <div class="kalys-col-full">
        <h2 class="kalys-title-page"><?php the_title() ?></h2>

        <div class="space-gradient"></div>

        <div class="kalys-accueil-section">
            <?php the_content() ?>

        </div>
    </div>
</main>


<?php get_footer(); ?>