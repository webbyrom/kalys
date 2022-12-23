<?php
require_once('inc/kalys-supports.php');
require_once('inc/assets.php');
require_once('inc/apparence.php');
require_once('inc/menus.php');
require_once('inc/images.php');
/*require_once('inc/query/posts.php');*/
/*require_once('inc/taxonomy.php');*/
require_once('inc/comments.php');

/***
 * icon reseaux sociaux du footer
 */
function kalys_icon(string $name): string
{
   $spriteUrl = get_template_directory_uri() . '/assets/logo/logo-reseaux.svg';
   return <<<HTML
    <svg class="icon"><use xlink:href="{$spriteUrl}#{$name}"></use></svg>
    HTML;
}

/****
 * fonction pour la pagination
 */
function kalys_pagination(): string
{
   return '<div class="pagination">' .
      paginate_links([
         'prev_text' => kalys_icon('arrow'),
         'next_text' => kalys_icon('arrow')
      ]);
}
function kalys_paginate_comments(): void {
   echo '<div class="paginatin">';
   paginate_comments_links([
      'prev_text' => kalys_icon('arrow'),
      'next_text' => kalys_icon('arrow')]);
      echo '</div>';

}
