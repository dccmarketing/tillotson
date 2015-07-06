<?php
/**
 * Template part for displaying single posts.
 *
 * @package DocBlock
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header contentsingle"><?php

		the_title( '<h1 class="entry-title">', '</h1>' );

		?><div class="entry-meta"><?php

			tillotson_posted_on();

		?></div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content"><?php

		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tillotson' ),
			'after'  => '</div>',
		) );

	?></div><!-- .entry-content -->

	<footer class="entry-footer"><?php

		tillotson_entry_footer();

	?></footer><!-- .entry-footer -->
</article><!-- #post-## -->