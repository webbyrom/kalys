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
    <div class="kalys-epilation-main">
        <?php $kalysEpilations = get_terms(['taxonomy' => 'épilation']); ?>
        <ul class="nav nav-pills">
            <?php foreach ($kalysEpilations as $kalysEpilation) : ?>
                <li class="nav-item">
                    <a href="<?= get_term_link($kalysEpilation) ?>" class="nav-link <?= is_tax('épilation', $kalysEpilation->term_id) ? 'active' : '' ?>"><?= $kalysEpilation->name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="row kalys-post-epiation my-4">
            <?php
            $kalysPostEpil = array_map(function ($term) {
                return $term->term_id;
            }, get_the_terms(get_post_type(), 'épilation'));
            $query = new WP_Query([
                'post__not-in'  => [get_the_ID()],
                'post_type' => 'soin-corps',
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'post_per_page' => 3,
                'tax_query' => [
                    'taxonomy'  =>  'épilation',
                    'terms' => $kalysPostEpil,
                ],
                'meta_query' => ['compare' => 'EXISTS']
            ]);
            while ($query->have_posts()) : $query->the_post(); ?>
                <div class="card-group col-sm-4">
                    <div class="card" style="width: 18rem;">
                        <?php the_post_thumbnail('thumbnail', ['class' => 'card-img-top', 'alt' => '', 'style' => 'height: auto;']) ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title() ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php the_category('-') ?></h6>
                            <ul>
                                <?php
                                the_terms(get_the_ID(), 'épilation', '<li>', '</li><li>', '</li>');
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
            <?php the_content() ?>
        </div>

    </div>
</section>
<?php get_footer(); ?>