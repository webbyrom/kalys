<form class="form-inline my-2 my-lg-0" role="search" action="<? esc_url(home_url('/')) ?>">
    <input class="form-control mr-sm-2" name ="s" type="search" placeholder="Recherche" aria-label="Search" value="<?= get_search_query() ?>">
    <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
</form>