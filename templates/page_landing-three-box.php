<?php
/**
 * Template Name: Landing Page, Three Boxes
 *
 * Description: A landing page with three link boxes
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
					<ul class="landing-boxes"><?php

					$boxes = get_field( 'boxes' );

					if ( ! empty( $boxes ) ) {

						foreach ( $boxes as $box ) {

							set_query_var( 'box', $box );
							set_query_var( 'image', $box['image']['sizes']['medium'] );
							get_template_part( 'template-parts/content', 'landingboxes' );

						} // foreach

					}

					?></ul><!-- .boxes -->
				</article><!-- #post-## --><?php

			endwhile; // loop

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();