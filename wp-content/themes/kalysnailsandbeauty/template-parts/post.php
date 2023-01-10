<article class="home-news">
    <div class="row">
        <div class="row ">
            <div class="col">
                <div class="card" style="width: 25rem;">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink() ?>" title="<?= esc_attr(get_the_title()) ?>" class="news-img">
                            <?php the_post_thumbnail('medium', true) ?>
                        <?php else : ?>
                            <img width="100%" height="250" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mN8c/CJCwAICQLXkCArnAAAAABJRU5ErkJggg=="> <?php endif ?>

                        <div class="card-body">
                            <a href="<?php the_permalink() ?>" class="news-title"><?php the_title() ?></a>
                            <div class="news-date"><?= sprintf(__('Published on %s at %s', 'kalys'), get_the_date(), get_the_time()) ?></div>
                            <div class="news-header">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                ?>
                                    <a href="<?= get_term_link($categories[0]) ?>" class="news-catego"><?= $categories[0]->name ?></a>
                                </div>
                        <?php endif ?>
                        <!--<h5 class="card-title">Card title</h5>--->
                        <div class="card-text"><?php the_excerpt() ?></div>


                        <a href="<?php the_permalink() ?>" class="read-news">Lire la suite</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</article>