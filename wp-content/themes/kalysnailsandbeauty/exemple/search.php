<?php get_header(); ?>
<form class="row row-cols-lg-auto g-3 align-items-center">
  <div class="col-12">

    <div class="input-group">
      <div class="input-group-text">@</div>
      <input type="text"  name="s" class="form-control" value="<?= get_search_query() ?>" placeholder="Votre recherche">
    </div>
  </div>

  <div class="col-12">
    <label class="visually-hidden" for="inlineFormSelectPref">Preference</label>
    <select class="form-select" id="inlineFormSelectPref">
      <option selected>Choose...</option>
      <option value="1">One</option>
      <option value="2">Two</option>
      <option value="3">Three</option>
    </select>
  </div>

  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="inlineFormCheck">
      <label class="form-check-label" for="inlineFormCheck">
        Remember me
      </label>
    </div>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>







<h1>résultat de votre recherche "<?= get_search_query() ?>"</h1>
<?php if (have_posts()) : ?>
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
            <div class="col-sm-4">
                <?php get_template_part('parts/card', 'post'); ?><!----va recuper le contenue du dossier parts et le fichier post.php--->
            </div>
        <?php endwhile ?>
    </div>
    <?php kalys_pagination() ?>
<?= paginate_links(); ?>
<?php else : ?>
    <h3>Pas d'articles</h3>
<?php endif; ?>
<?php get_footer(); ?>









