<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Tillotson
 */

if ( $image ) {

	echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';

}

?><article>
	<div class="page-content"><?php

	$desc = get_field( 'category_description', $term  );
	$docs = get_field( 'service_docs', $term );
	$class = '';

	if ( ! empty( $desc ) && ! empty( $docs ) ) {

		$class = 'split';

	}

	if ( ! empty( $desc ) ) {

		?><section class="desc <?php echo $class; ?>">
			<h2 class="header-desc"><?php esc_html_e( 'Description', 'tillotson' ); ?></h2><?php

				echo $desc;

		?></section><?php

	}



	if ( ! empty( $docs ) ) {

		?><section class="docs <?php echo $class; ?>">
			<h2 class="header-docs"><?php esc_html_e( 'Service Documents', 'tillotson' ); ?></h2>
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

	$title 	= get_field( 'features_title', $term );
	$list 	= get_field( 'features_list', $term );

	if( ! empty( $title ) && ! empty( $list ) ) {

		?><div class="features">
			<h2><?php echo $title; ?></h2>
			<div class="features-list"><?php echo $list; ?></div>
		</div><?php

	}

?></article><!-- #post-## -->