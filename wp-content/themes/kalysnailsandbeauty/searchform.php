<form action="<?= esc_url(home_url('/')) ?>" class="form-group form-search">
    <input type="search" placeholder="<?= __('Search post', 'kalys') ?>" name="s" value="<?= get_search_query() ?>">
    <button type="submit">
       <?= kalys_icon('search'); ?>
    </button>
</form>