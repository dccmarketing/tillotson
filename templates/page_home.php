<?php
/**
 * Template Name: Homepage
 *
 * Description: The home page template
 *
 * @package Tillotson
 */

global $tillotson_themekit;

get_header();

	?><div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main">
			<div class="wrap-tech">
				<h2 class="title-section"><?php esc_html_e( 'Tillotson Technical Information', 'tillotson' ); ?></h2>
				<article class="manuals hentry">
					<div class="icon"><?php echo $tillotson_themekit->the_svg( 'manuals' ); ?></div>
					<div class="content">
						<header class="entry-header">
							<h3 class="entry-title">
								<a href="<?php echo esc_url( get_site_url() . '/downloads#manuals' ) ?>"><?php esc_html_e( 'Service Manuals', 'tillotson' ); ?></a>
							</h3>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<p><?php

							esc_html_e( 'See an in-depth overview on the inner workings of our carburettors.', 'tillotson' );

							?></p>
						</div><!-- .entry-content -->
					</div>
				</article><!-- #post-## -->
				<article class="brochures hentry">
					<div class="icon"><?php echo $tillotson_themekit->the_svg( 'brochure' ); ?></div>
					<div class="content">
						<header class="entry-header">
							<h3 class="entry-title">
								<a href="<?php echo esc_url( get_site_url() . '/downloads#brochures' ) ?>"><?php esc_html_e( 'Product Brochures', 'tillotson' ); ?></a>
							</h3>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<p><?php

							esc_html_e( 'Learn more about the innovative products available from Tillotson.', 'tillotson' );

							?></p>
						</div><!-- .entry-content -->
					</div>
				</article><!-- #post-## -->
				<article class="more-info hentry">
					<div class="icon"><span class="dashicons dashicons-info"></span></div>
					<div class="content">
						<header class="entry-header">
							<h3 class="entry-title">
								<a href="<?php echo esc_url( get_site_url() . '/downloads' ); ?>"><?php esc_html_e( 'More Information', 'tillotson' ); ?><span class="screen-reader-text"><?php esc_html_e( 'about Tillotson products', 'tillotson' ); ?></span></a>
							</h3>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<p><?php

							esc_html_e( 'Browse the entire Tillotson collection of resources, spec sheets, and technical information.', 'tillotson' );

							?></p>
						</div><!-- .entry-content -->
					</div>
				</article><!-- #post-## -->
			</div>
			<div class="wrap-news"><?php

			$home = $tillotson_themekit->get_posts( 'post', array( 'posts_per_page' => 3 ), 'home' );

			if ( $home->have_posts() ) {

				if( get_option( 'show_on_front' ) == 'page' ) {

					$link = get_permalink( get_option( 'page_for_posts' ) );

				} else  {

					$link = bloginfo('url');

				}

				?><h2 class="title-section"><a class="" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'Tillotson News', 'tillotson' ); ?></a> <a class="icon-rss" href="<?php echo bloginfo('rss2_url'); ?>"><span class="dashicons dashicons-rss"></span><span class="screen-reader-text"><?php esc_html_e( 'Subscribe to the Tillotson news RSS feed.', 'tillotson' ); ?></span></a></h2><?php

				while ( $home->have_posts() ) : $home->the_post();

					get_template_part( 'template-parts/content', 'home' );

				endwhile; // loop

				?><a class="link-more" href="<?php echo esc_url( site_url( '/news' ) ); ?>"><?php echo wp_kses( _e( '<span>More</span><span class="screen-reader-text">news from Tillotson</span>', 'tillotson' ), array( 'span' => array( 'class' => array() ) ) ); ?></a><?php

			}

		?></div>
		</main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();