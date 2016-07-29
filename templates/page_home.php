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
				<h2 class="title-section" id="home-tech-header"><?php esc_html_e( get_theme_mod( 'home_tech_header' ), 'tillotson' ); ?></h2><?php

				$links = get_field( 'tech_links' );

				foreach ( $links as $link ) {

					if ( 'Internal' === $link['link_type'] ) {

						$url = $link['link_page'];

					} else {

						$url = $link['link_url'];

					}

					if ( ! empty( $link['link_anchor'] ) ) {

						$url .= '#' . $link['link_anchor'];

					}

					if ( 'info' === $link['link_icon'] ) {

						$icon = '<span class="dashicons dashicons-info"></span>';

					} elseif ( empty( $link['link_icon'] ) ) {

						$icon = $tillotson_themekit->get_svg( 'diamonds' );

					} else {

						$icon = $tillotson_themekit->get_svg( $link['link_icon'] );

					}

					?><article class="hentry <?php echo esc_attr( $link['link_icon'] ); ?>">
						<div class="icon"><?php echo $icon; ?></div>
						<div class="content">
							<header class="entry-header">
								<h3 class="entry-title">
									<a href="<?php echo esc_url( $url ) ?>"><?php esc_html_e( $link['link_title'], 'tillotson' ); ?></a>
								</h3>
							</header><!-- .entry-header -->

							<div class="entry-content"><?php

								echo $link['link_description'];

							?></div><!-- .entry-content -->
						</div>
					</article><!-- <?php echo '.' . esc_attr( $link['link_icon'] ); ?> --><?php

				} // foreach

			?></div>
			<div class="wrap-news"><?php

			$home = $tillotson_themekit->get_posts( 'post', array( 'posts_per_page' => 3 ), 'home' );

			if ( $home->have_posts() ) {

				if( get_option( 'show_on_front' ) == 'page' ) {

					$link = get_permalink( get_option( 'page_for_posts' ) );

				} else  {

					$link = bloginfo('url');

				}

				?><h2 class="title-section" id="home-news-header"><a class="" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( get_theme_mod( 'home_news_header' ), 'tillotson' ); ?></a> <a class="icon-rss" href="<?php echo bloginfo('rss2_url'); ?>"><span class="dashicons dashicons-rss"></span><span class="screen-reader-text"><?php esc_html_e( 'Subscribe to the Tillotson news RSS feed.', 'tillotson' ); ?></span></a></h2><?php

				while ( $home->have_posts() ) : $home->the_post();

					get_template_part( 'template-parts/content', 'home' );

				endwhile; // loop

				?><a class="link-more" href="<?php echo esc_url( get_site_url() ) . '/news'; ?>"><?php echo wp_kses( _e( '<span>More</span><span class="screen-reader-text">news from Tillotson</span>', 'tillotson' ), array( 'span' => array( 'class' => array() ) ) ); ?></a><?php

			}

		?></div>
		</main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();