<?php
/**
 * Template Name: Homepage
 *
 * Description: The home page template
 *
 * @package Tillotson
 */

get_header();

	?><div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main"><?php

			while ( have_posts() ) : the_post();

				?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="page-header contentpage"><?php

						the_title( '<h1 class="page-title">', '</h1>' );

					?></header><!-- .entry-header -->

					<div class="page-content"><?php

						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tillotson' ),
							'after'  => '</div>',
						) );

					?></div><!-- .entry-content -->

					<footer class="entry-footer"><?php

						edit_post_link( esc_html__( 'Edit', 'tillotson' ), '<span class="edit-link">', '</span>' );

					?></footer><!-- .entry-footer -->
				</article><!-- #post-## --><?php

			endwhile; // loop

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();