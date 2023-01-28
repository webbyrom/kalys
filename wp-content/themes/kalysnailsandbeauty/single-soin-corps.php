<?php

/***********
 * Template Name: épilation
 */
?>
<?php get_header(); ?>
<section class="kalys-section-epilation container">
    <div class="kalys-epilation-slider">
        <?php add_revslider('slider-4'); ?>
    </div>
    <div class="kalys-epilation-bg">
        <div class="tilte-epilation">
            <h1 class="kalys-epilation-title"><?php single_post_title() ?></h1>
        </div>
        <div class="space-gradient"></div>
        <div class="kalys-epilation-main ">
            <?php the_content() ?>
        </div>
    </div>

</section>
<?php get_footer(); ?>