<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to visual-composer-starter/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'visual-composer-starter' ), strip_tags( $args['product_name'] ) ) : '';
	?>
	<div class="quantity">
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'visual-composer-starter' ); ?></label>
		<div class="vct-input-qty">
			<input
					type="number"
					id="<?php echo esc_attr( $input_id ); ?>"
					class="input-text qty text"
					step="<?php echo esc_attr( $step ); ?>"
					min="<?php echo esc_attr( $min_value ); ?>"
					max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
					name="<?php echo esc_attr( $input_name ); ?>"
					value="<?php echo esc_attr( $input_value ); ?>"
					title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'visual-composer-starter' ); ?>"
					size="4"
					pattern="<?php echo esc_attr( $pattern ); ?>"
					inputmode="<?php echo esc_attr( $inputmode ); ?>"
					aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
			<span class="vct-input-qty-control vct-input-qty-control-add"></span>
			<span class="vct-input-qty-control vct-input-qty-control-remove"></span>
		</div>

	</div>
	<?php
}
