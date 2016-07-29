<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Tillotson
 */

$class 	= '';
$desc 	= '';
$docs 	= '';
$list 	= '';
$title 	= '';

?><article>
	<div class="page-content"><?php

	if ( ! is_tax( 'product_market' ) ) {

		$docs = get_field( 'service_docs', $taxterm );

	}

	$desc = wc_format_content( term_description() );

	if ( ! empty( $desc ) && ! empty( $docs ) ) {

		$class = 'split';

	}

	if ( ! empty( $desc ) ) {

		?><section class="desc <?php echo $class; ?>"><?php

			if ( ! empty( $docs ) ) {

				?><h2 class="header-desc"><?php esc_html_e( get_theme_mod( 'category_description_header' ), 'tillotson' ); ?></h2><?php

			}

			echo $desc;

		?></section><?php

	}

	if ( ! empty( $docs ) ) {

		?><section class="docs <?php echo $class; ?>">
			<h2 class="header-docs"><?php esc_html_e( get_theme_mod( 'category_docs_header' ), 'tillotson' ); ?></h2>
			<ul class="service-docs"><?php

			foreach ( $docs as $doc ) {

				?><li class="service-doc">
					<a href="<?php echo esc_url( $doc['service_document']['url'] ); ?>"><?php

						esc_html_e( $doc['service_document']['title'], 'tillotson' );

					?></a>
				</li><?php

			}

			?></ul>
		</section><?php

	}

	?></div><!-- .entry-content --><?php

	$title 	= get_field( 'features_title', $taxterm );
	$list 	= get_field( 'features_list', $taxterm );

	if( ! empty( $title ) && ! empty( $list ) ) {

		?><div class="features">
			<h2><?php echo $title; ?></h2>
			<div class="features-list"><?php echo $list; ?></div>
		</div><?php

	}

?></article><!-- #post-## -->