<?php get_header() ?>
<div class="container-fluid kalys-news-full">
    <div class="kalys-home-slider">
        <?php add_revslider('Actus'); ?>
    </div>
    <div class="container-fluid kalys-news">
        <h1 class="title-news"><?php if(is_category()) : ?>
            <?php single_cat_title() ?>
            <?php elseif (is_search()): ?>
                <?= sprintf(__('Result of the research "%s"', 'kalys'), get_search_query()); ?>
            <?php else: ?>
                <?php single_post_title() ?>
            <?php endif ?>
    </h1>
        <div class="space-gradient"></div>
        <div class="container news-list g-4">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post'); ?>
                <?php endwhile; ?>
                    <?= kalys_pagination() ?>
            <?php else : ?>
                <h3 class="no-news"><?= __('Pas de News', 'kalys') ?></h3>
            <?php endif; ?>
        </div>
        <aside class="news-sidebar">
            <?php dynamic_sidebar('blog') ?>
        </aside>
    </div>
</div>
<?php get_footer(); ?>