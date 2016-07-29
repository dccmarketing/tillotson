<?php
/**
 * Template Name: Landing Page with Boxes
 *
 * Description: A landing page with linked boxes.
 *
 * @package Tillotson
 */

$fields = get_fields();

get_header();

	?><div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main"><?php

			while ( have_posts() ) : the_post();

				?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page-content"><?php

						the_content();

					?></div><!-- .entry-content --><?php

					if ( ! empty( $fields['box_group'] ) ) :

						foreach( $fields['box_group'] as $group ) :

							if ( ! empty( $group['group_title'] ) ) {

								?><h2><?php echo esc_html( $group['group_title'] ); ?></h2><?php

							}

							?><ul class="landing-boxes"><?php

							foreach( $group['boxes'] as $box ) :

								?><li class="landing-box">
									<a aria-label="<?php echo esc_attr( $box['text'] ); ?>" href="<?php echo esc_url( $box['url'] ); ?>">
										<div class="img-kits-landing" style="background-image:url(<?php echo esc_url( $box['image']['sizes']['medium'] ); ?>)"></div>
										<h3 class="menu-label show"><?php echo esc_html( $box['text'] ); ?></h3>
									</a>
								</li><?php

							endforeach;

						?></ul><!-- .landing-boxes --><?php

						endforeach;

					endif; // group

				?></article><!-- #post-## --><?php

			endwhile; // loop

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();