<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Tillotson
 */

get_header();

if ( ! is_product() ) {

	$class = 'content-sidebar';

} else {

	$class = '';

}

	?><div id="primary" class="content-area woocommerce-page <?php echo $class; ?>">
		<main id="main" class="site-main" role="main"><?php

			woocommerce_content();

		?></main><!-- #main -->
	</div><!-- #primary --><?php

if ( ! is_product() ) {

	get_sidebar();

}

get_footer();