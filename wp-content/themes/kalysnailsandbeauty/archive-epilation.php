<?php get_header(); ?>

<h1>Toutes nos epilations</h1>
<!----- affichage des actualités-->
<?php if (have_posts()) : ?>
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
            <div class="col-sm-4">
                <?php get_template_part('parts/card', 'post'); ?><!----va recuper le contenue du dossier parts et le fichier post.php--->
            </div>
        <?php endwhile ?>
    </div>
    <?php kalys_pagination() ?>
<?= paginate_links(); ?>
<?php else : ?>
    <h3>Pas d'articles</h3>
<?php endif; ?>
<?php get_footer(); ?>