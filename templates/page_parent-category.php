<?php
/**
 * Template Name: Parent Category Page
 *
 * Description: Displays info about a parent category with the children
 * categories and their product links underneath.
 *
 * @package Tillotson
 */

global $tillotson_themekit;

$parent 	= get_field( 'product_category' );
$kids 		= $tillotson_themekit->get_subcats( 'product_cat', $parent, array( 'hide_empty' => FALSE ) );
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

			?><div class="wrap-subcategories"><?php

				foreach ( $kids as $kid ) {

					$thumbnail_id 	= get_woocommerce_term_meta( $kid->term_id, 'thumbnail_id', true );
					$image 			= wp_prepare_attachment_for_js( $thumbnail_id );

					if ( $image ) {

						echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';

					}

					?><div class="category-kid">
						<h2><?php echo $kid->name; ?></h2><?php

						$desc = get_field( 'category_description', $kid );

						if ( ! empty( $desc ) ) :

							?><div class="content-category-kid"><?php echo $desc; ?></div><!-- .entry-content --><?php

						endif;

					?></div><!-- #post-## --><?php

					$grandkids = $tillotson_themekit->get_subcats( 'product_cat', $kid->term_id, array( 'hide_empty' => FALSE ), $kid->slug );

					?><div class="category-grandkid"><?php

					foreach ( $grandkids as $grandkid ) {

						?><a class="link-category-grandchild" href="<?php

							echo get_term_link( $grandkid, $grandkid->taxonomy );

						?>"><?php

							echo esc_html( $grandkid->name );

						?></a><?php

					} // foreach

					?></div><!-- .category-grandkid --><?php

				} // kids foreach

			?></div><!-- .wrap-subcategories -->
		</main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();