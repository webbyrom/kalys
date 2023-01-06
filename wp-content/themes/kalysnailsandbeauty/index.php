<?php get_header() ?>

<div class="container-fluid">
    <div class="kalys_slider_header">
        <?php add_revslider('slider-3'); ?>
    </div>

    <h2 class=" test-archive page-title"><?php the_title() ?></h2>
    <div class="space-gradient"></div>
    <div class="container archive-container">
        <div class="test-archive">
            <?php the_post_thumbnail('large') ?>
        </div>
        <div class="content-archive">
            <?php the_content() ?>
        </div>

    </div>
    <aside class="kalys-sidebar">
        <?php dynamic_sidebar('blog') ?>
    </aside>
</div>
<?php get_footer() ?>