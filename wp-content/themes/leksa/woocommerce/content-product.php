<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<!-- Single Product -->
<div <?php wc_product_class( 'pe-single-product', $product ); ?>>

    <a href="<?php echo apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ); ?>">
        <!-- Product URL -->

        <div class="product-wrap">
            
            <?php
                
            if ($product->is_on_sale()) {
    $regular_price = (float) $product->get_regular_price();
    $sale_price = (float) $product->get_price();
    $discount_percentage = calculate_discount_percentage($regular_price, $sale_price);

    if ($discount_percentage > 0) {
        echo '<p class="discount-badge">-' . $discount_percentage . '%</p>';
    }
}
            
            ?>

            <!-- Product Image -->
            <div class="product-image">


                <?php $attachment_ids = $product->get_gallery_image_ids(); 
        
                if ($attachment_ids) { ?>

                <!-- Product Image Front -->
                <img class="product-image-front" src="<?php echo get_the_post_thumbnail_url(); ?>">
                <!--/ Product Image Front -->

                <?php foreach( $attachment_ids as $key => $attachment_id ) { 
                
                if ($key == 0) {
                   
                ?>

                <img class="product-image-back" src="<?php  echo esc_url($Original_image_url = wp_get_attachment_url( $attachment_id )); ?>">

                <?php       }  } } else { ?>

                <img src="<?php echo get_the_post_thumbnail_url(); ?>">
                <?php } ?>

            </div>
            <!--/ Product Image -->

            <!-- Product Meta -->
            <div class="product-meta text-h6">

                <?php echo '<div class="product-name ' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped  ?>

                <?php if ( $price_html = $product->get_price_html() ) : ?>
                <div class="product-price"><?php echo do_shortcode($price_html); ?></div><!-- Product Price -->
                <?php endif; ?>


            </div>
            <!--/ Product Meta -->

        </div>

    </a>

    <div class="product-acts" data-barba-prevent="all"><?php 
        
    echo apply_filters(
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf(
		'<a href="%s" data-product-id="' .  get_the_ID() . '" data-quantity="%s" class="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		esc_html( $product->add_to_cart_text() )
	),
	$product,
	$args
);

    ?></div>
    
    



</div>
<!--/ Single Product -->
