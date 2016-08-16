<?php
/**
 * Template Name: Page with Menus
 *
 * Description: Displays a page with selected menus.
 *
 * @package Tillotson
 */

$image_url 	= get_theme_mod( 'default_product_category_logo' );
$image_id 	= attachment_url_to_postid( $image_url );
$image 		= wp_prepare_attachment_for_js( $image_id );
$fields 	= get_fields();

get_header();

	?><div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main"><?php

		// This is the content for upper part of the page
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // loop

			?><div class="wrap-menus"><?php

				if ( ! empty( $fields['menus'] ) ) {

					foreach ( $fields['menus'] as $menu ) {

						//showme( $menu );

						?><section class="category-kid">
							<h2><?php echo $menu['menu']->name; ?></h2><?php

							if ( ! empty( $menu['menu_image'] ) ) {

								echo '<p>' . wp_get_attachment_image( $menu['menu_image'], 'medium' ) . '</p>';

							}

						?></section><!-- #post-## -->
						<div class="category-menu">
							<div class="wrap-menu">
								<div class="menu-cat"><?php

									//showme( $menu['menu'] );

									$menu_name 						= $menu['menu']->slug;
									$menu_args['container']			= 'div';
									$menu_args['container_id']		= 'menu-' . $menu_name;
									$menu_args['container_class']	= 'menu nav-' . $menu_name;
									$menu_args['menu']				= $menu_name;
									$menu_args['menu_id']			= 'menu-' . $menu_name . '-items';
									$menu_args['menu_class']		= 'menu-items';
									$menu_args['depth']				= 1;
									$menu_args['fallback_cb']		= '';

									wp_nav_menu( $menu_args );

								?></div>
							</div>
						</div><!-- .category-menu --><?php

					} // kids foreach

				}

			?></div><!-- .wrap-subcategories -->
		</main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();
