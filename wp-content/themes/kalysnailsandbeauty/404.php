<?php get_header() ?>
<h1>Page introuvable:<?php wp_title(); ?></h1>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php the_post_thumbnail('large') . get_template_directory_uri() . '/assets/images/404-kalys_352837939_Preview.png'; ?>
        <p>
            Cette page n'existe pas
        </p>
    <?php endwhile ?>
<?php else : ?>
    <h3>Oupsssss page introuvable</h3>
<?php endif; ?>
<?php get_footer() ?>