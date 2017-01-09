<?php

/**
 * Template file for the SimpleMap Category taxonomy archive.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tillotson
 */

get_header();

?><div id="primary" class="content-area">
	<main id="main" class="site-main" role="main"><?php

	if ( have_posts() ) :

		/* Start the Loop */
		while ( have_posts() ) : the_post();

			$meta = get_post_custom( get_the_ID() );
			echo '<pre>Location Order: '; print_r( $meta['locationorder'] ); echo '</pre>';

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_type() );

		endwhile;

	endif;

	$queried 	= get_queried_object();
	$unordered 	= apply_filters( 'tillotson-unordered-dealers', '', $queried );

	if ( is_object( $unordered ) && $unordered->have_posts() ) :

		/* Start the Loop */
		while ( $unordered->have_posts() ) : $unordered->the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_type() );

		endwhile;

	endif;

	if ( ! have_posts() && ! is_object( $unordered ) ) :

		get_template_part( 'template-parts/content', 'none' );

	else :

		the_posts_navigation();

	endif;

	?></main><!-- #main -->
</div><!-- #primary --><?php

get_footer();
