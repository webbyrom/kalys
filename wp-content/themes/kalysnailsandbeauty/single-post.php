<?php get_header(); ?>
<div class="container-fluid">
    <?php add_revslider('slider-6'); ?>
</div>
<div class="container-fluid container-single-post">
    <h2 class="single-post-title">
        <?php single_post_title() ?>
    </h2>
    <div class="space-gradient"></div>
</div>

<div class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php the_post_thumbnail('large'); ?>
        <?php endwhile; ?>
        <?= kalys_pagination() ?>
    <?php else : ?>
        <h3 class="no-news"><?= __('Pas de News', 'kalys') ?></h3>
    <?php endif; ?>
    <article class="single-post-kalys container">
        <h3 class="single-post-title"><?php the_title() ?></h3>
        <p class="singlepost">
            <?php the_content() ?>
        </p>
    </article>
</div>
<aside class="news-sidebar">
    <?php dynamic_sidebar('blog') ?>
</aside>

<?php get_footer(); ?>