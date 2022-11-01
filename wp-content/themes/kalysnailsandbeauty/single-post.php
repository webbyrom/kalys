<?php get_header() ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h1><?php the_title() ?></h1>
                <?php if (get_post_meta(get_the_ID(), SponsoMetaBox::META_KEY, true) === '1') : ?>
                        <div class="alert alert-info">
                                Cet article est sponsorié
                        </div>
                <?php endif ?>
                <?php the_post_thumbnail('medium') ?>
                <?php the_content() ?>
<?php endwhile;
endif; ?>

<?php get_footer() ?>