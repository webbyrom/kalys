<?php get_header() ?>

<?php while (have_posts()) : the_post() ?>
    <h1><?php the_title() ?> : <?php wp_title() ?></h1>
    <h2><?php bloginfo('description') ?></h2>
    <div class="container-fluid container-home text-center"><!--- debut templating page accueil-->
        <div class="row">
            <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0 ">
                <img src="" class="rounded float-left" alt="...">
                <img src="" class="rounded float-right" alt="...">
            </div>
            <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0 ">

            </div>
        </div>

    </div>
    <?php the_content() ?>
    <a href="<?= get_post_type_archive_link('post') ?>">voir les derniéres actualités</a>
<?php endwhile; ?>


<?php get_footer() ?>