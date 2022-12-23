<?php get_header() ?>

<div class="container-fluid">
    <div class="kalys_slider_header">
        <?php add_revslider('slider-3'); ?>
    </div>

    <h1 class="page-title"><?php single_post_title() ?></h1>
    <div>
        <?php the_content() ?>
    </div>
    <aside class="kalys-sidebar">
        <?php dynamic_sidebar('blog') ?>
    </aside>
</div>
<?php get_footer() ?>