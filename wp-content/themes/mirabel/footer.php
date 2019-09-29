<?php
/**
 * Footer
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

if ( visualcomposerstarter_is_the_footer_displayed() ) : ?>
	<?php visualcomposerstarter_hook_before_footer(); ?>
	<footer id="footer">
		<?php
		if ( get_theme_mod( 'vct_footer_area_widget_area', false ) ) :
			$footer_columns = get_theme_mod( 'vct_footer_area_widgetized_columns', 1 );
			$footer_columns_width = 12 / $footer_columns;
			?>
			<div class="footer-widget-area">
				<div class="<?php echo esc_attr( visualcomposerstarter_get_content_container_class() ); ?>">
					<div class="row">
						<div class="col-md-<?php echo esc_attr( $footer_columns_width ); ?>">
							<?php if ( is_active_sidebar( 'footer' ) ) : ?>
								<?php dynamic_sidebar( 'footer' ); ?>
							<?php endif; ?>
						</div>
						<?php for ( $i = 2; $i <= $footer_columns; $i ++ ) : ?>
							<div class="col-md-<?php echo esc_attr( $footer_columns_width ); ?>">
								<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
									<?php dynamic_sidebar( 'footer-' . $i ); ?>
								<?php endif; ?>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</footer>
	<?php visualcomposerstarter_hook_after_footer(); ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
