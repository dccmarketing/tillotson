<?php
/**
 * Template part for after the header, but before the content area
 *
 * @package Tillotson
 */

global $tillotson_themekit;

if ( is_front_page() ) {

	putRevSlider( 'homepage' );

	$lawnpage = get_page_by_title( 'Lawn & Garden' );
	$racingpage = get_page_by_title( 'Racing' );

	?><div class="divisions">
		<div class="wrap-divisions">
			<div class="division carbs">
				<a class="link-carbs" href="<?php echo get_term_link( 'carburetors', 'product_cat' ); ?>">
					<div class="wrap-img"><?php

						echo $tillotson_themekit->get_home_logo( 'carbs' );

					?></div>
					<div class="wrap-text">
						<span class="text-division"><?php

							esc_html_e( 'Lawn & Garden', 'tillotson' );

						?></span>
					</div>
				</a>
			</div>
			<div class="division racing">
				<a class="link-racing" href="<?php echo get_permalink( $racingpage->ID ); /*get_term_link( 'racing', 'product_cat' );*/ ?>">
					<div class="wrap-img"><?php

						echo $tillotson_themekit->get_home_logo( 'racing' );

					?></div>
					<div class="wrap-text">
						<span class="text-division"><?php

							esc_html_e( 'Racing', 'tillotson' );

						?></span>
					</div>
				</a>
			</div>
			<div class="division power">
				<a class="link-power" href="<?php echo get_term_link( 'generators', 'product_cat' ); ?>">
					<div class="wrap-img"><?php

						echo $tillotson_themekit->get_home_logo( 'power' );

					?></div>
					<div class="wrap-text">
						<span class="text-division"><?php

							esc_html_e( 'Generators', 'tillotson' );

						?></span>
					</div>
				</a>
			</div>
		</div>
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