<?php
/**
 * Template Name: Full-width, no sidebar
 *
 * Description: A full-width template with no sidebar
 *
 * @package Tillotson
 */

get_header();

	?><div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main"><?php

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // loop

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();