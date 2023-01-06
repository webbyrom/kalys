<?php get_header(); ?>
<section class="kalys-epilation-archive">
    <div class="kalys-epilation-archive-slider">
        <?php add_revslider('slider-4'); ?>
    </div>
    <div class="tilte-epilation-archive">
        <h2 class="kalys-epilation-archive-title"><?php single_post_title() ?></h2>
    </div>
    <div class="space-gradient"></div>
    <div class="kalys-epilation-archive-main">
        <div class="kalys-single-epilation">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="archive-img-en-avant">
                        <?php the_post_thumbnail('thumbnail') ?>
                    </div>
        </div>
        <?php the_content() ?>
    </div>
<?php endwhile;
            endif; ?>
<aside class="kalys-sidebar">
    <?php dynamic_sidebar('blog') ?>
</aside>
</section>
<?php get_footer(); ?>