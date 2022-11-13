<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content=" Manucure, french manucure, prothésiste ongulaire,semi-permanet, beauté des mains, pose de vernis, manucure Russe, renfort ongles naturel, ongle en gel, rallongement chablon, popits, pose en gel( capsule américaine), épilation, épilation femme, sourcils, Lèvres, Menton, épilation maillot simple, épilation maillot échancré, épilation maillot integral, épilation homme">
  <meta name="description" content=" Prothésiste ongulaire, esthéticienne des Monts du Lyonnais, Saint Symphorien sur Coise, Aveize, Chazelles sur Lyon, sainte foy l'argentiére, saint Laurent de Chamousset, Pommeys, Duerne">
  <meta property="og:descritpion" content="Prothésiste Ongulaire, Esthéticienne des Monts du Lyonnais, Saint Symphorien sur Coise, Aveize, Chazelles sur Lyon, sainte foy l'argentiére, saint Laurent de Chamousset, Pommeys, Duerne">
  <title><?php the_title() ?> <?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>

<body class="kalys-body">
  <header class="nav-header">
    <nav class="navbar navbar-expand-lg mb-4" style="background-color: <?= get_theme_mod('header_background'); ?>!important ">
      <div class="container-fluid kalys-header">
        <a href="<?= home_url('/') ?>" class="nav_logo" title=" <?= __('Homepage', 'kalys') ?>">
          <img class="Kalys-logo-nav " src="<?= get_theme_mod('logo') ?>" alt="">
        </a>
        <a class="navbar-brand" href="<?php bloginfo('url') ?>"><?php bloginfo('name') ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <?php wp_nav_menu([
            'theme_location' => 'header',
            'container' => false,
            'menu_class' => 'navbar-nav me-auto',
            'my-2 my-lg-0 navbar-nav-scroll',
            'sticky-top',

          ])
          ?>
        </div>
        <?= get_search_form() ?>
      </div>
    </nav>
  </header>
  <div class="container container-header">