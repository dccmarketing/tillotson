<?php
/**
 * The markup for the Location Order metabox.
 *
 * @package 		Tillotson
 */

$atts['class'] 			= '';
$atts['id'] 			= 'locationorder';
$atts['label'] 			= __( 'Order', 'tillotson' );
$atts['name'] 			= 'locationorder';
$atts['type'] 			= 'number';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( 'tillotson-field-' . $atts['id'], $atts );

?><p><?php

include( get_stylesheet_directory() . '/template-parts/fields/text.php' );
unset( $atts );

?></p>
