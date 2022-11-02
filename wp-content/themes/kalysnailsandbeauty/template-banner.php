<?php
/*
* Template Name: Page avec bannière
* Template Post Type: page, post
*/
?>
<?php get_header() ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1><?php the_title() ?></h1>
        <?php the_post_thumbnail('medium') ?>
        <?php the_content() ?>
<?php endwhile;
endif; ?>

<?php get_footer() ?>