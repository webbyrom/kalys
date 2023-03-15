<?php get_header() ?>
<div class="container-fluid kalys-news-full">
    <div class="kalys-home-slider">
        <?php add_revslider('Actus'); ?>
    </div>
</div>
<div class="container-fluid kalys-news">
    <h1 class="title-news"><?php if (is_category()) : ?>
            <?php single_cat_title() ?>
        <?php elseif (is_search()) : ?>
            <?= sprintf(__('résultat de la recherche "%s"', 'kalys'), get_search_query()); ?>
        <?php else : ?>
            <?php single_post_title() ?>
        <?php endif ?>
    </h1>
    <div class="space-gradient"></div>

    <main class="kalys-news container-fluid">
        <div class="container news-list g-4">
            <?php the_content() ?>
        </div>
        <aside class="news-sidebar">
            <?php dynamic_sidebar('blog') ?>
        </aside>
</div>
</main>


<?php get_footer(); ?>