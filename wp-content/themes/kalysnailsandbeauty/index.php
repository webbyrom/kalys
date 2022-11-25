<?php get_header() ?>

<div class="container">

    <h1 class="page-title">
        <?php if(is_category()): ?>
            <?php single_cat_title() ?>
        <?php elseif (is_search()): ?>
            <?= sprintf(__('Votre Recherche"%s"', 'kalys'), get_search_query()); ?>;
        <?php else: ?>
            <?php single_post_title() ?></h1>
        <?php endif ?>

    <div class="page-sidebar">
        <div>
            <div class="news-list">

                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/post'); ?>

                    <?php endwhile; ?>
                    <?= kalys_pagination() ?>
                    <?= kalys_icon('arrow') ?>
                    </a>
            </div>
        <?php else : ?>
            <h2><?= __('Pas d\'actualités', 'kalys') ?></h2>
        <?php endif; ?>
        </div>
    </div>

    <aside class="sidebar">
        <?php dynamic_sidebar('blog') ?>
    </aside>
</div>
</div>
<?php get_footer() ?>