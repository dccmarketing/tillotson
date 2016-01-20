<?php
/**
 * Template part for after the header, but before the content area
 *
 * @package Tillotson
 */

global $tillotson_themekit;

if ( is_front_page() ) {

	putRevSlider( 'homepage' );

	$categories['carbs'] 	= array( 'Lawn & Garden', 'carburetors', 'product_cat' );
	$categories['racing'] 	= array( 'Racing', 'racing', 'product_market' );
	$categories['power'] 	= array( 'Generators', 'generators', 'product_cat' );

	?><div class="divisions">
		<div class="wrap-divisions"><?php

		foreach ( $categories as $category => $info ) {

			?><div class="division <?php echo $category; ?>">
				<a class="link-<?php echo $category; ?>" href="<?php echo get_term_link( $info[1], $info[2] ); ?>">
					<div class="wrap-img"><?php

						echo $tillotson_themekit->get_home_logo( $category );

					?></div>
					<div class="wrap-text">
						<span class="text-division"><?php

							esc_html_e( $info[0], 'tillotson' );

						?></span>
					</div>
				</a>
			</div><?php

		} // foreach

		?></div>
	</div><?php

} else {

	?><div class="header-page">
		<header class="page-header contentpage"><?php

			echo apply_filters( 'tillotson_precontent_title', the_title( '<h1 class="page-title">', '</h1>', FALSE ) );

		?></header>
	</div><?php

}

?><div class="breadcrumbs">
	<div class="wrap-crumbs"><?php

		do_action( 'tillotson_breadcrumbs' );

	?></div>
</div>