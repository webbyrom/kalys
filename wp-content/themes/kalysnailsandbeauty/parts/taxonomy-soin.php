<?php get_header(); ?>

<h1><?= esc_html(get_queried_object()->name)  ?></h1>
<p><?= esc_html(get_queried_object()->description) ?></p>
<!------------filtre des actualités via la taxonomy --->
<?php $soins = get_terms(['taxonomy' => 'soin']); ?>
<?php if (is_array($soins)): ?>
<ul class="nav nav-pills my-4">
    <?php foreach($soins as $soin): ?>
        <li class="nav-item">
            <a href="<?= get_term_link($soin) ?>" class="nav-link <?= is_tax('soin', $soin ->term_id) ? 'active' : '' ?>"><?= $soin->name ?></a>
        </li>
        <?php endforeach; ?>
</ul>
<?php endif ?>
<!----- affichage des actualités-->
<?php if (have_posts()) : ?>
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
            <div class="col-sm-4">
                <?php get_template_part('parts/post'); ?><!----va recuper le contenue du dossier parts et le fichier post.php--->
            </div>
        <?php endwhile ?>
    </div>
    <?php kalys_pagination() ?>
<?= paginate_links(); ?>
<?php else : ?>
    <h3>Pas d'articles</h3>
<?php endif; ?>
<?php get_footer(); ?>