<?php
/**
 * Template Name: Landing Page, Products
 *
 * Description: Products landing page
 *
 * @package Tillotson
 */

get_header();

	?><div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main"><?php

			while ( have_posts() ) : the_post();

				?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page-content"><?php

						the_content();

					?></div><!-- .entry-content -->
					<div>
						<h2><?php

							$catlabel = get_field( 'category_label' );

							if ( ! empty( $catlabel ) ) {

								echo esc_html( $catlabel );

							}

						?></h2>
						<ul class="landing-boxes"><?php

						$cats = get_field( 'by_category' );

						if ( ! empty( $cats ) ) {

							foreach ( $cats as $box ) {

								set_query_var( 'box', $box );
								set_query_var( 'image', $box['image']['sizes']['thumbnail'] );
								get_template_part( 'template-parts/content', 'landingboxes' );

							} // foreach

						}

						?></ul><!-- .boxes -->
					</div>
					<div>
						<h2><?php

							$typelabel = get_field( 'type_label' );

							if ( ! empty( $typelabel ) ) {

								echo esc_html( $typelabel );

							}

						?></h2>
						<ul class="landing-boxes"><?php

						$types = get_field( 'by_type' );

						if ( ! empty( $types ) ) {

							foreach ( $types as $box ) {

								set_query_var( 'box', $box );
								set_query_var( 'image', $box['image']['sizes']['thumbnail'] );
								get_template_part( 'template-parts/content', 'landingboxes' );

							} // foreach

						}

						?></ul><!-- .boxes -->
					</div>
				</article><!-- #post-## --><?php

			endwhile; // loop

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();