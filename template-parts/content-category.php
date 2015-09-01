<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Tillotson
 */

if ( $image ) {

	echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';

}

?><article><?php

	$desc = get_field( 'category_description', $term  );

	if ( ! empty( $desc ) ) :

		?><div class="page-content"><?php echo $desc; ?></div><!-- .entry-content --><?php

	endif;

	$title 	= get_field( 'features_title', $term );
	$list 	= get_field( 'features_list', $term );

	if( ! empty( $title ) && ! empty( $list ) ) :

		?><div class="features">
			<h2><?php echo $title; ?></h2>
			<div class="features-list"><?php echo $list; ?></div>
		</div><?php

	endif;

?></article><!-- #post-## -->