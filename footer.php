<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Tillotson
 */

		?></div><!-- .wrap -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wrap wrap-footer">
			<div class="site-info">
				<div class="copyright">&copy <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url(), 'tillotson' ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></div>
				<div class="credits"><?php printf( esc_html__( 'Site created by %1$s', 'tillotson' ), '<a href="https://dccmarketing.com/" target="_blank">DCC Marketing</a>' ); ?></div>
			</div><!-- .site-info -->
		</div><!-- .wrap-footer -->
	</footer><!-- #colophon -->
</div><!-- #page --><?php

wp_footer();

?></body>
</html>