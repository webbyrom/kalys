<?php get_header(); ?>
<div class="container page-sidebar">
    <?php the_content() ?>

    <aside class="sidebar">
        <?php dynamic_sidebar('blog') ?>
    </aside>
</div>
<?php get_footer(); ?>