</div>
<footer>
    <div class="container container-footer">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="http://localhost/kalys/"><?php bloginfo('name') ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <?php wp_nav_menu([
                        'theme_location' => 'footer',
                        'menu_class' => 'navbar-nav me-auto'
                    ]) ?>
                    <div class="container container-footer">
                        <p class="texte-center">Kalys footer</p>
                    </div>
                </div>
                <div>
                    <?= get_option('kalys_horaire') ?>
                </div>

</footer>

<?php wp_footer(); ?>
</body>

</html>