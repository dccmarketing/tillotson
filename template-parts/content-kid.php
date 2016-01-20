<?php
/**
 * The template part for displaying a child category
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tillotson
 */

global $tillotson_themekit;

$thumbnail_id 	= get_woocommerce_term_meta( $kid->term_id, 'thumbnail_id', true );
$image 			= wp_prepare_attachment_for_js( $thumbnail_id );
$fields 		= get_fields( $kid );
$grandkids 		= $tillotson_themekit->get_product_lines( $kid->name );

//showme( $kid );
//showme( $fields );
//showme( $grandkids );

if ( $image ) {

	echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';

}

// This is the category description
?><section class="category-kid">
	<h2><?php echo $kid->name; ?></h2><?php

	if ( ! empty( $fields['category_description'] ) ) :

		?><div class="content-category-kid"><?php echo $fields['category_description']; ?></div><!-- .entry-content --><?php

	endif;

?></section><!-- #post-## -->
<div class="category-grandkid">
	<div class="wrap-grandkid"><?php

	if ( ! empty( $grandkids ) ) {

		set_query_var( 'category', $category->slug );

		foreach ( $grandkids as $grandkid ) {

			set_query_var( 'grandkid', $grandkid );
			set_query_var( 'line', $grandkid->slug );
			get_template_part( 'template-parts/content', 'grandkid' );

		} // foreach

	}

	?></div>
</div><!-- .category-grandkid -->