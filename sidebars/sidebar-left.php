<?php
/**
 * The sidebar for the Sidrbar Content page template
 *
 * @package DocBlock
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?><div id="secondary" class="widget-area sidebar-left" role="complementary"><?php

	dynamic_sidebar( 'sidebar-1' );

?></div><!-- #secondary -->