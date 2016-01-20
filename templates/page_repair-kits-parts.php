<?php
/**
 * Template Name: Repair Kits & Parts Page
 *
 * @package Tillotson
 */

global $tillotson_themekit;

$parent 	= get_field( 'product_category' );
$kids 		= $tillotson_themekit->get_cats( 'product_cat', array( 'hide_empty' => FALSE, 'parent' => $parent ) );
$image_url 	= get_theme_mod( 'default_product_category_logo' );
$image_id 	= attachment_url_to_postid( $image_url );
$image 		= wp_prepare_attachment_for_js( $image_id );

//showme( $kids );

get_header();

	?><div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main"><?php

			while ( have_posts() ) : the_post();

				?><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /><?php

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // loop

			?><div class="wrap-subcategories"><?php

				$markets = array( 'all' => 'All', 'lawn-garden' => 'Lawn & Garden', 'racing' => 'Racing' );

				foreach ( $markets as $slug => $name ) {

					?><section class="category-kid">
						<h2><?php echo $name; ?></h2>
					</section><!-- #post-## -->
					<div class="category-grandkid"><?php

						foreach ( $kids as $kid ) {

							if ( 'all' !== $slug ) {

								set_query_var( 'referer', $slug );

							}

							set_query_var( 'grandkid', $kid );
							get_template_part( 'template-parts/content', 'grandkid' );

							//showme( $kid );

						} // kids foreach

					?></div><?php

				}



				?></div><!-- .wrap-subcategories -->
		</main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();