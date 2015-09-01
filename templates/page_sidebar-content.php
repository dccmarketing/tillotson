<?php
/**
 * Template Name: Sidebar Content
 *
 * Description: Page template with sidebar on the left-side
 *
 * @package Tillotson
 */

get_header(); ?>

	<div id="primary" class="content-area sidebar-content">
		<main id="main" class="site-main" role="main"><?php

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

			endwhile; // loop

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_sidebar( 'left' );
get_footer();