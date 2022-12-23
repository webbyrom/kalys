<?php
/******
 * Template Name: Page Contact
 * 
 *
 */
?>
<?php get_header(); ?>
<section class="kalys-section-contact">
    <div class="kalys-contact-slider">
    <?php add_revslider('slider-2'); ?>
    </div>
    <h2 class="kalys-contact-title"><?php the_title() ?></h2>
    <div class="space-gradient"></div>
    <div class="kalys-contact-main">
        <?php the_content() ?>
    </div>
</section>
<?php get_footer(); ?>