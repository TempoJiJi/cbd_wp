<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$option = get_option('pe-redux');
$highLightSale = '';

if ($option['is_sale_highlight']) {
    
    $highLightSale = 'sales_highlighted';
    
}

if (class_exists('Redux')) {
    
    
//    $shopColumns = 'column_' . $option['shop_columns'];
};

?>


            
            <div class="pe--products-grid <?php echo esc_attr($highLightSale) ?>">
            
        
        
