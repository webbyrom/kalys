<?php
 require_once('inc/kalys-supports.php');
 require_once('inc/assets.php');
 require_once('inc/apparence.php');
 require_once('inc/menus.php');
 require_once('inc/images.php');


 /***
  * icon reseaux sociaux du footer
  */
 function kalys_icon(string $name): string {
    $spriteUrl = get_template_directory_uri() . '/assets/logo/logo-reseaux.svg';
    return <<<HTML
    <svg class="icon"><use xlink:href="{$spriteUrl}#{$name}"></use></svg>
    HTML;
 }

 
