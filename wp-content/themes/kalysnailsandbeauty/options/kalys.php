<?php
class KalysMenuPage
{

    const GROUP = 'kalys_options';
    public static function register()
    {
        add_action('admin_menu', [self::class, 'addMenu']);
        add_action('admin_init', [self::class, 'registerSettings']);
    }
    public static function registerSettings()
    {
        register_setting(self::GROUP, 'kalys_horaire');
        add_settings_section('kalys_options_section', 'Paramètres', function () {
            echo "vous pouvez gérer les paramètres ici";
        }, self::GROUP);
        add_settings_field('kalys_options_horaires', "Horaire d'ouverture", function () {
?>
            <textarea name="kalys_horaire" cols="30" rows="10" style="width: 90%"><?= get_option('kalys_horaire') ?></textarea>
        <?php
        }, self::GROUP, 'kalys_options_section');
    }
    public static function addMenu()
    {
        add_options_page("Gestion de kalys", "Kalys", "manage_options", self::GROUP, [self::class, 'render']);
    }
    public static function render()
    {
        ?>
        <h1>Gestion de Kalys</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields(self::GROUP);
            do_settings_sections(self::GROUP);
            submit_button('') ?>
        </form>
<?php

    }
}
