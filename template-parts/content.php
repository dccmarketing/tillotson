<?php
/**
 * Template part for displaying posts.
 *
 * @package Tillotson
 */

global $tillotson_themekit;

?><article id="post-<?php the_ID(); ?>" <?php post_class( 'just-content' ); ?>>
	<div class="icon"><?php echo $tillotson_themekit->the_svg( 'diamonds' ); ?></div>
	<div class="content">
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
	</div><!-- .content -->
</article><!-- #post-## -->