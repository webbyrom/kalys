<?php get_header(); ?>
<!---- revslider ------>
<div class="container-fluid">
    <?php add_revslider('slider-6'); ?>
</div>
<!-----fin de revslicer---->

<!---------titre et séparatuer gradient------>
<div class="container-fluid ">
    <h2 class="single-post-title">
        <?php single_post_title() ?>
    </h2>
    <div class="space-gradient"></div>
</div>
<!---------contenu des articles-------->
<div class="container px-4 container-single-post page-sidebar">
    <?php while (have_posts()) : the_post(); ?>
        <section class="single-post-kalys container">
            <header class=" row gx-5 news-single-post">
                <h3 class="news-single-title"><?php the_title() ?></h3>
                <div class="news-single-body">
                    <?php

                    $categories = get_the_category();
                    if (!empty($categories)) :
                    ?>
                        <a href="<?= get_term_link($categories[0]) ?>" class="news-catego sigle-post-link"><?= $categories[0]->name ?></a>
                    <?php endif ?>
                    <div class="news-date"><?= sprintf(__('Published on %s at %s', 'kalys'), get_the_date(), get_the_time()) ?></div>
                </div>
            </header>
            <div class="row single-post-img container">
                <?php if (has_post_thumbnail()) : ?>
                    <p class="container">
                        <?= the_post_thumbnail('medium'); ?>
                    </p>
                <?php endif ?>
                <div class="container">
                    <?php the_content() ?>

                </div>
            </div>
        </section>
    <?php endwhile ?>
</div>
<!------- Partie commentaire------->
<?php
if (comments_open()|| get_comments_number() >0) {
    comments_template();
};
?>
<!-------------------sidebar--------------->
<aside class="news-sidebar">
    <?php dynamic_sidebar('blog') ?>
</aside>
<?php get_footer() ?>