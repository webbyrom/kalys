<?php 
require_once('inc/walkers/commentWalker.php');
$count = absint(get_comments_number());
?>
<div class="comments">
    <div class="comments_title">
        <?php if (get_comments_number() > 0 ): ?>
            <?= sprintf(_n('%d Commentaire', '%d Commentaires', $count), $count); ?>
        <?php else: ?>
            <?= __('Leave a comment', 'kalys'); ?>
        <?php endif; ?>
    </div>
    <?php wp_list_comments(['style' => 'div', 'walker' => new KalysCommentWalker()]); ?>
    <?php if (comments_open()): ?>
        <?php comment_form(['title_reply' => '']); ?>
    <?php endif; ?>
</div>








