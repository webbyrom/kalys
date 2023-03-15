<?php
$networks = [
    'facebook'  => 'Facebook',
    'instagram' => 'Instagram',
    'tiktok'    =>  'TikTok'
];
?>
<div class="footer_social">
    <?php foreach ($networks as $name => $label) : ?>
        <?php if (!empty($instance[$name])) : ?>
            <a href="<?= esc_url($instance[$name]) ?>" title="<?= sprintf(esc_attr('Me suivre sur %s', 'kalys'), $label); ?>">
                <?= kalys_icon($name) ?>
            </a>
        <?php endif ?>
    <?php endforeach; ?>
</div>
<div class="footer_credits"><a href="<?= esc_html($instance['Design_by']); ?>">Design by Web-byRom</a></div>
