<?php
/**
 * Template part for displaying posts.
 *
 * @package Tillotson
 */

global $tillotson_themekit;

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="icon"><?php echo $tillotson_themekit->the_svg( 'diamonds' ); ?></div>
	<div class="content">
		<header class="entry-header justcontent"><?php

			the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );

			if ( 'post' == get_post_type() ) :

				?><div class="entry-meta"><?php

					tillotson_posted_on();

				?></div><!-- .entry-meta --><?php

			endif;

		?></header><!-- .entry-header -->

		<div class="entry-content"><?php

				/* translators: %s: Name of current post */
				the_excerpt(/* sprintf(
					wp_kses( esc_html__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'tillotson' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) */);

		?></div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->