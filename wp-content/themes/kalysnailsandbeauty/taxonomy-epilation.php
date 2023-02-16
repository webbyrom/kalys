<?php get_header() ?>
<div class=" container-fluid archive-soin-corps">
   
        <!------- revslider here----->
        <?php add_revslider('post-type'); ?>
</div>
<div class="container-fluid archive-main">
    <h2 class="archive-soin-corps"><?php the_title() ?></h2>
<div class="space-gradient"></div>
<?php the_content() ?>
</div> 




<?php get_footer() ?>
