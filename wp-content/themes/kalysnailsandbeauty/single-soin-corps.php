<?php

/***********
 * Template Name: épilation
 */
?>
<?php get_header(); ?>
<section class="kalys-section-epilation">
    <div class="kalys-epilation-slider">
        <?php add_revslider('slider-4'); ?>
    </div>
    <div class="tilte-epilation">
        <h2 class="kalys-epilation-title"><?php single_post_title() ?></h2>
    </div>
    <div class="space-gradient"></div>
    <div class="kalys-epilation-main ">
        <?php the_content() ?>
    </div>
</section>
<?php get_footer(); ?>