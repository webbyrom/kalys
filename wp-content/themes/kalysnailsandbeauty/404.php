<?php get_header() ?>
    <h1>Pages introuvable: <?php wp_title(); ?></h1>
    <?php the_post_thumbnail() . 'http://localhost/kalys/wp-content/uploads/2022/10/404-kalys_352837939_Preview.png'; ?>
    <p>
        Cette page n'existe pas
    </p>
<?php get_footer() ?>