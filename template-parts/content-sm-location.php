<?php
/**
 * Template part for SimpleMap Locations in a location category archive.
 *
 * @package Tillotson
 */

global $tillotson_themekit;

$meta = get_post_custom( get_the_ID() );

//$tillotson_themekit->pretty( $meta );

?><article id="post-<?php the_ID(); ?>" <?php post_class( 'simplemap-location' ); ?>>
	<div class="icon"><?php echo $tillotson_themekit->the_svg( 'diamonds' ); ?></div>
	<div class="content">
		<header class="entry-header justcontent"><?php

			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

		?></header><!-- .entry-header -->
		<div class="entry-content">
			<div class="sm-single-location-default-template">
				<div class="sm-single-location-data">
					<address><?php

						$lines = array( 'location_address', 'location_address2', 'location_city', 'location_state', 'location_zip', 'location_country' );
						$address = '';

						foreach ( $lines as $line ) {

							if ( empty( $meta[$line][0] ) || ' ' === $meta[$line][0] ) { continue; }

							$address .= $meta[$line][0] . ', ';

							echo esc_html( $meta[$line][0] );

							if ( 'location_address' === $line || 'location_address2' === $line ) {

								?><br><?php

							} elseif ( 'location_country' === $line ) {

								echo '';

							} else {

								?>, <?php

							}

						} // foreach

					?></address><?php

					if ( ! empty( $address ) ) {

						?><a href="<?php

							$link = $tillotson_themekit->make_map_link( $address );

							echo $link;

						?>"><?php

						printf(
							wp_kses(
								__( 'Google Map<span class="screen-reader-text"> for %1$s</span>', 'tillotson'
								),
								array( 'span' => array( 'class' => array() ) )
							),
							esc_html( get_the_title() )
						);

						?></a><?php

					}

					?><ul class="sm-single-location-data-ul"><?php

						$checks = array( 'location_phone', 'location_email', 'location_fax', 'location_url' );

						foreach ( $checks as $check ) {

							if ( empty( $meta[$check][0] ) ) { continue; }

							?><li><?php

								if ( 'location_fax' === $check ) {

									esc_html_e( 'Fax: ', 'tillotson' );

									echo $meta[$check][0];

								} else {

									if ( 'location_email' === $check ) {

										$prefix = esc_html__( 'Email: ', 'tillotson' );
										$url 	= 'mailto:' . sanitize_email( $meta[$check][0] );

									} elseif( 'location_phone' === $check ) {

										$prefix = esc_html__( 'Phone: ', 'tillotson' );
										$phone 	= $tillotson_themekit->make_number( $meta[$check][0] );
										$url 	= 'tel:' . esc_attr( $phone );

									} else {

										$prefix = esc_html__( 'Website: ', 'tillotson' );
										$url 	= esc_url( $meta[$check][0] );

									}

									echo $prefix;

									?><a class="<?php

										echo esc_attr( $check );

									?>" href="<?php

										echo $url;

									?>"><?php

										echo esc_html( $meta[$check][0] );

									?></a><?php

								}

							?></li><?php

						} // foreach

					?></ul>
				</div>
			</div><?php

			//the_content();

		?></div><!-- .entry-content -->
	</div><!-- .content -->
</article><!-- #post-## -->