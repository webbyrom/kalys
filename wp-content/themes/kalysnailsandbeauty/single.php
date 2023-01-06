<?php get_header(); ?>
<div class="container page-sidebar">
    <div class="test-page-archive">
        <h2 class="page-archive"><?php single_post_title() ?></h2>
    </div>
    <?php the_content() ?>

    <aside class="sidebar">
        <?php dynamic_sidebar('blog') ?>
    </aside>
</div>
<?php get_footer(); ?>