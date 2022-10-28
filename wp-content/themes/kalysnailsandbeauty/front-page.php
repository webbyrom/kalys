<?php get_header() ?>

<?php while(have_posts()) : the_post() ?>
    <h1><?php the_title() ?> : <?php wp_title() ?></h1>
    <h2><?php bloginfo('description') ?></h2>
    <?php the_content() ?>
    <a href="<?= get_post_type_archive_link('post') ?>">voir les derniéres actualités</a>
<?php endwhile; ?>


<?php get_footer() ?>