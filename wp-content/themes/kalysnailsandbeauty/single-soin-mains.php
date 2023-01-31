<?php

/***********
 * Template Name: Manucure
 */
?>
<?php get_header(); ?>
<section class="kalys-section-manucure container">
    <div class="kalys-manucure-slider">
        <?php add_revslider('slider-5'); ?>
    </div>
    <div class="tilte-manucure">
        <h1 class="kalys-manucure-title kalys-title-page"><?php single_post_title() ?></h1>
    </div>
    <div class="main-container-manucure">

        <div class="space-gradient"></div>
        <?php the_content() ?>
        <div class="kalys-manucure-main">

            <?php $kalysManucures = get_terms(['taxonomy' => 'manucure']); ?>
            <ul class="nav nav-pills">
                <?php foreach ($kalysManucures as $kalysManucure) : ?>
                    <li class="nav-item">
                        <a href="<?= get_term_link($kalysManucure) ?>" class="nav-link <?= is_tax('manucure', $kalysManucure->term_id) ? 'active' : '' ?>"><?= $kalysManucure->name ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="row kalys-post-manucure my-4">
                <?php
                $kalysPostMan = array_map(function ($term) {
                    return $term->term_id;
                }, get_the_terms(get_post_type(), 'manucure'));

                $query = new WP_Query([
                    'post__not-in'  => [get_the_ID()],
                    'post_type' => 'soin-mains',
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_per_page' => 3,
                    'tax_query' => [
                        'taxonomy'  =>  'manucure',
                        'terms' => $kalysPostMan,
                    ],
                    'meta_query' => ['compare' => 'EXISTS']
                ]);
                while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="card-group col-sm-4 zoom-img-card-hover card-full-manucure">
                        <div class="card zoom-img-card" style="width: 18rem;">
                            <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'alt' => '', 'style' => 'height: auto;']) ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title() ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php the_category('-') ?></h6>
                                <ul>
                                    <?php
                                    the_terms(get_the_ID(), 'manucure', '<li>', '</li><li>', '</li>');
                                    ?>
                                </ul>
                                <p class="card-text">
                                    <?php the_excerpt() ?>
                                </p>
                                <a href="<?php the_permalink() ?>" class="card-link">Voir plus</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                
            </div>
</section>
<!---
<section class="kalys-manucure-sidebar">
    <aside class="kalys-sidebar">
        <?php dynamic_sidebar('blog') ?>
    </aside>
</section>---->
<?php get_footer(); ?>