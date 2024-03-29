<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content=" Manucure, french manucure, prothésiste ongulaire,semi-permanent, beauté des mains, pose de vernis, manucure Russe, renfort ongles naturels, ongle en gel, rallongement chablon, popits, pose en gel( capsule américaine), épilation, épilation femme, sourcils, Lèvres, Menton, épilation maillot simple, épilation maillot échancré, épilation maillot integral, épilation homme">
  <meta name="description" content=" Prothésiste ongulaire, esthéticienne des Monts du Lyonnais, Saint Symphorien sur Coise, Aveize, Chazelles sur Lyon, sainte foy l'argentiére, saint Laurent de Chamousset, Pommeys, Duerne">
  <meta property="og:descritpion" content="Prothésiste Ongulaire, Esthéticienne des Monts du Lyonnais, Saint Symphorien sur Coise, Aveize, Chazelles sur Lyon, sainte foy l'argentière, saint Laurent de Chamousset, Pommeys, Duerne">
  <title><?php the_title() ?> <?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header id="kalys_header" class="kalys_header">
    <nav id="kalys_nav_menu" class="kalys_nav_menu nav container-fluid" style="background-color: <?= get_theme_mod('header_background') ?>">
      <!---------------link icone responsive menu ------->
 <!---burger icon to responsive menu---->
 <a href="#" id="icon_responsive" class="icone_responsive"></a>
      <a href="<?= home_url('/'); ?>" class="nav_logo" title="<?= __('Homepage', 'kalys') ?>">
        <img src="<?= get_theme_mod('logo') ?>" alt="">
      </a>
      <!--------menu navigation------->
      <?= esc_html(kalys_primary_nav());

      ?>
     
      <button id="kalys_price" class="Kalys-price">
        <a href="http://localhost/kalys/wp-content/uploads/2023/03/Tarifs-Kalys.pdf" target="_blank" value="download" method="get">Tarifs</a>
      </button>
    </nav>

  </header>