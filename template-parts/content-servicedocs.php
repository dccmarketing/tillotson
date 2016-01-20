<?php
/**
 * The template part for displaying a lists of service documents
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tillotson
 */

?><div class="wrap-docs"><?php

	if ( ! empty( $args['label'] ) ) {

		?><h2><?php esc_html_e( $args['label'], 'tillotson' ); ?>
			<a name="<?php esc_html_e( $args['type'], 'tillotson' ); ?>"></a>
		</h2><?php

	}

	if ( ! empty( $args['description'] ) ) {

		?><p><?php esc_html_e( $args['description'], 'tillotson' ); ?></p><?php

	}

	?><ul><?php

	foreach ( $files as $file ) {

		if ( empty( $file ) ) { continue; }

		?><li class="doc">
			<a href="<?php echo esc_url( $file['url'] ); ?>"><?php esc_html_e( $file['title'], 'tillotson' ); ?></a>
		</li><?php

	}

	?></ul>
</div>