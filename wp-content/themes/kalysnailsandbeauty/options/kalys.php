<?php
class KalysMenuPage
{

    const GROUP = 'kalys_options';
    public static function register()
    {
        add_action('admin_menu', [self::class, 'addMenu']);
        add_action('admin_init', [self::class, 'registerSettings']);
        add_action('admin_enqueue_scripts', [self::class, 'registerScripts']);
    }
    public static function registerScripts ($suffix){
        if ($suffix === 'settings_page_kalys_options'){
        wp_register_style('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', [], false);
        wp_register_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', [], false, true);
        wp_register_script('kalys_admin', get_template_directory_uri() . '/assets/js/kalys.js/kalys-admin.js', ['flatpickr'], false, true);
        wp_enqueue_style('flatpickr');
        wp_enqueue_script('flatpickr');
        wp_enqueue_script('kalys_admin');
        }
    }
    public static function registerSettings()
    {
        register_setting(self::GROUP, 'kalys_horaire');
        register_setting(self::GROUP, 'kalys_date');
        add_settings_section('kalys_options_section', 'Paramètres', function () {
            echo "vous pouvez gérer les paramètres ici";
        }, self::GROUP);
        add_settings_field('kalys_options_horaire', "Horaires d'ouverture", function () {
            ?>
            <textarea name="kalys_horaire" cols="30" rows="10" style="width: 90%"><?= esc_html(get_option('kalys_horaire')) ?></textarea>
        <?php
        }, self::GROUP, 'kalys_options_section');
        /****
         * enregiqtrement de la date
         */
        add_settings_field('kalys_options_date', "Date d'ouverture", function () {
            ?>
            <input type="text" name="kalys_date" value="<?= esc_attr(get_option('kalys_date')) ?>"class="kalys_datepicker">
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
