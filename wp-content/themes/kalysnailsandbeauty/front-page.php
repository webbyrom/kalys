<?php get_header(); ?>


<main class="kalys-main-accueil" id="kalys_main_accueil">
    <?php
    if (is_front_page()) {
        echo do_shortcode('[rev_slider alias="slider-2"][/rev_slider]');
    }
    ?>
    <H1 class="accueil-title"><?= get_bloginfo('name') . get_bloginfo('description') ?></H1>
    <h2><?php the_title() ?></h2>
    <?php the_content() ?>
</main>


<?php get_footer(); ?>