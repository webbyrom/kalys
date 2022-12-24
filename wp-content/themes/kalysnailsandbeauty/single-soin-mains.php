<?php
/***********
 * Template Name: Manucure
 */
?>
<?php get_header(); ?>
<section class="kalys-section-manucure">
    <div class="kalys-manucure-slider">
    <?php add_revslider('full-width-slider1'); ?>
    </div>
    <div class="tilte-manucure">
        <h2 class="kalys-manucure-title"><?php the_title() ?></h2>
    </div>
    <div class="space-gradient"></div>
    <div class="kalys-manucure-main">
        <?php the_content() ?>
    </div>
</section>
<?php get_footer(); ?>