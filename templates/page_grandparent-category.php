<?php
/**
 * Template Name: Grandparent Category Page
 *
 * Description: Displays info about a category At the bottom are
 * the child categories with their child category links underneath.
 *
 * @package Tillotson
 */

global $tillotson_themekit;

$parent 	= get_field( 'product_category' );
$kids 		= $tillotson_themekit->get_cats( 'product_cat', array( 'hide_empty' => FALSE, 'parent' => $parent->term_id ) );
$image_url 	= get_theme_mod( 'default_product_category_logo' );
$image_id 	= attachment_url_to_postid( $image_url );
$image 		= wp_prepare_attachment_for_js( $image_id );

get_header();

	?><div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main"><?php

			while ( have_posts() ) : the_post();

				?><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /><?php

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // loop

			do_action( 'repairkit_docs_list' );

			?><div class="wrap-subcategories"><?php

				set_query_var( 'category', $parent );

				foreach ( $kids as $kid ) {

					set_query_var( 'kid', $kid );
					get_template_part( 'template-parts/content', 'kid' );

				} // kids foreach

			?></div><!-- .wrap-subcategories -->
		</main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();