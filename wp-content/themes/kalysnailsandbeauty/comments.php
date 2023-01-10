<?php
require_once('inc/walkers/CommentWalker.php');
$count = absint(get_comments_number());
?>
<div class="comments">
    <div class="comments_title">
        <?php if (get_comments_number() > 0) : ?>
            <?= sprintf(_n('%d Commentaire', '%d Commentaires', $count), $count); ?>
        <?php else : ?>
            <?= __('Leave a reply', 'kalys'); ?>
        <?php endif; ?>
    </div>
    <!--- si besoin rajouter une div pour entrourer wp_list_comments---->
    <div class="commet__list">
        <?php wp_list_comments(['style' => 'div', 'walker' => new KalysCommentWalker()]); ?>
    </div>

    <?= kalys_paginate_comments() ?>

    <?php if (comments_open()) : ?>
        <?php comment_form(); ?>
    <?php endif; ?>

</div>