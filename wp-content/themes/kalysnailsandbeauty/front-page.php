<?php get_header(); ?>


<main class="kalys-main-accueil" id="kalys_main_accueil">
    <H1 class="accueil-title"><?= get_bloginfo('name') . get_bloginfo('description') ?></H1>
    <h2><?php the_title() ?></h2>
   <?php the_content() ?>
</main>


<?php get_footer(); ?>