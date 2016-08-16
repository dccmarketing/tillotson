<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tillotson
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header justcontent"><?php

		the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );

		if ( 'post' == get_post_type() ) :

			?><div class="entry-meta"><?php

				tillotson_posted_on();

			?></div><!-- .entry-meta --><?php

		endif;

	?></header><!-- .entry-header -->

	<div class="entry-content"><?php

			the_excerpt();

	?></div><!-- .entry-content -->
</article><!-- #post-## -->
