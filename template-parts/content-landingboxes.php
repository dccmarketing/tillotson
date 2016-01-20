<?php
/**
 * The template part for displaying landing page boxes
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tillotson
 */

switch( $box['link_destination'] ) {

	case 'Page' 			: $link = $box['link_page']; break;
	case 'Internal' 		: $link = $box['internal_page']; break;
	case 'External' 		: $link = $box['external_page']; break;
	case 'Market' 			: $link = get_term_link( $box['link_market'] ); break;
	case 'Product Category' : $link = get_term_link( $box['link_category'] ); break;

}

?><li class="landing-box">
	<a aria-label="<?php echo esc_attr( $box['box_text'] ); ?>" href="<?php echo esc_url( $link ); ?>">
		<div class="img-kits-landing" style="background-image:url(<?php echo esc_url( $image ); ?>)"></div>
		<h3 class="menu-label show"><?php echo esc_html( $box['box_text'] ); ?></h3>
	</a>
</li>