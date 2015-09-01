<?php
/**
 * Template part for displaying single posts.
 *
 * @package Tillotson
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content"><?php

		the_content();

	?></div><!-- .entry-content -->

	<footer class="entry-footer"><?php

		tillotson_posted_on();

		tillotson_entry_footer();

	?></footer><!-- .entry-footer -->
</article><!-- #post-## -->