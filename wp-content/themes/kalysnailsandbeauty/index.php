<?php get_header(); ?>

<h1>Bienvenue sur le site: <?php wp_title(); ?></h1>
<h2><?php bloginfo('description'); ?></h2>

<?php if (have_posts()) : ?>
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
            <div class="col-sm-4">
                <div class="card">
                    <img src="<?php the_post_thumbnail() ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title() ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php the_category() ?></h6>
                        <p class="card-text"><?php the_excerpt() ?></p>
                        <a href="<?php the_permalink() ?>" class="btn btn-primary">Voir Plus</a>
                    </div>
                </div>
            </div>

        <?php endwhile ?>
    </div>
<?php else : ?>
    <h3>Pas d'articles</h3>
<?php endif; ?>
<?php get_footer(); ?>