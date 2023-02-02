<?php

/***********
 * Template Name: test filter Manucure
 */
?>
<?php get_header() ?>
<div class="flex-row">
				<form action="#" method="POST" id="avis_filters" class="flex-row">
					<div class="flex-row">
					<input type="radio" value="all_categ" id="all_categ" class="avis_filter" name="category_avis_filters"><label for="all_categ">Toutes</label>
					
					<?php 
					if( $terms = get_terms( array( 'taxonomy' => 'categories-avis' ) ) ) :
						foreach( $terms as $term ) :
							echo '<input type="radio" id="' . $term->term_id . '" value="' . $term->term_id . '" name="category_avis_filters" class="avis_filters"/><label for="' . $term->term_id. '">' . $term->name . '</label>';
						endforeach;
					endif;
					?>
				</div>
				<div class="flex-row">
					<input type="radio" value="all_niveau" id="all_niveau" class="avis_filter" name="niveau_avis_filters"><label for="all_niveau">Toutes</label>
					
					<?php 
						if( $terms = get_terms( array( 'taxonomy' => 'niveau-avis' ) ) ) :
							foreach( $terms as $term ) :
								echo '<input type="radio" id="' . $term->term_id . '" value="' . $term->term_id . '" name="niveau_avis_filters" class="avis_filters"/><label for="' . $term->term_id. '">' . $term->name . '</label>';
							endforeach;
						endif;?>
					</div>
					<!-- required hidden field for admin-ajax.php -->
					<input type="hidden" name="action" value="ccavisfilter" />
				</form>
			</div>
		
		   <?php 
			// le début de ma boucle
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' =>'avis',
				'posts_per_page' =>5,
				'paged' => $paged
			);
			$query = new WP_Query( $args ); ?>
			<?php if ( $query->have_posts() ) : ?>
		    <div id="cc_avis_wrap" class="flex-row">
			       <?php while ( $query->have_posts() ) : $query->the_post(); 
					$taxonomies = array('categories-avis','niveau-avis');
					$termsArray = wp_get_object_terms($post->ID, $taxonomies, array( 'orderby' => 'term_order' ) );  
					$termsString = ""; 
					foreach ( $termsArray as $term ) {  
					$termsString .= $term->slug.' '; 
					} ?>
            </div>
</div>
<section class="kalys-manucure-sidebar">
    <aside class="kalys-sidebar">
        <?php dynamic_sidebar('blog') ?>
    </aside>
</section>
<?php get_footer(); ?>