<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Tillotson
 */

global $tillotson_themekit;

		?></div><!-- .wrap -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wrap wrap-footer">
			<div class="logo-years">
				<img src="<?php echo get_stylesheet_directory_uri() . '/images/100years.png'; ?>" alt="Tillotson 100-year Annivsary Logo" />
			</div>
			<div class="site-info">
				<ul>
					<li>&copy <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url(), 'tillotson' ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></li>
					<li><address>Clash Industrial Estate, Tralee, Co. Kerry, Ireland</address></li>
					<li><a href="tel:353667162500">Tel: +353 66 716 2500</a></li>
					<li><a href="mailto:<?php echo sanitize_email( 'sales@tillotson.ie' ); ?>">sales@tillotson.ie</a></li>
				</ul>
			</div><!-- .site-info -->
		</div><!-- .wrap-footer -->
	</footer><!-- #colophon -->
</div><!-- #page --><?php

wp_footer();

?></body>
</html>