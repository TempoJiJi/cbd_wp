<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$option = get_option('pe-redux');
$sidebar = 'left-sidebar';
$animTitle = 'false';
$pageHeader = true;
$shopPageTitle = '';


if (class_exists('Redux')) {

    $shopPageTitle = $option['shop_page_title_show'];
    $sidebar =$option['shop_sidebar'];
};

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>

<?php if ($pageHeader != false) { ?>
<!-- Page Header -->
<div data-anim="true" class="page-header shop-page-header section">

    <div class="page-header-wrap pe-wrapper">
        
        <div class="pe-col-12">
            
               <?php if ($shopPageTitle) { ?>

        <!-- Page Title -->
        <div class="page-title">
            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title text-h3"><?php echo esc_html($option['shop_page_title']) ?></h1>
            <?php 
    
    if($option['products_count']) {
    
        leksa_product_count();
        
        }
    endif; ?>
        </div>
        <!-- /Page Title -->

        <?php } else { ?>

        <!-- Page Title -->
        <div class="page-title" data-anim="<?php echo esc_attr($animTitle); ?>">
            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title text-h3"><?php woocommerce_page_title(); ?></h1>
            <?php 
                         
    if($option['products_count']) {
    
        leksa_product_count();
        
        }
                      
                      endif; ?>
        </div>
        <!-- /Page Title -->

        <?php } ?>
        
        </div>


    </div>

</div>
<!-- /Page Header -->

<?php } ?>
<div class="section archive-products-section">

<div class="pe-wrapper">
        <?php if (($sidebar === 'left-sidebar') && (is_active_sidebar('shop-sidebar'))) { ?>

        <div class="pe-col3">

            <?php dynamic_sidebar('shop-sidebar');  ?>

        </div>

        <?php } ?>

        <?php if (($sidebar === 'no-sidebar') || (!is_active_sidebar('shop-sidebar'))) { ?>
        
        <div class="pe-col-12">
            <?php } else { ?>

            <div class="pe-col9 sidebar-active">

                <?php } 
            
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	
    echo '<div class="pe--products-grid-controls">';
    
    do_action( 'woocommerce_before_shop_loop' );
    
    echo '</div>';
    
	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();
                
    	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
                
                
                ?>

            </div>


            <?php if (($sidebar === 'right-sidebar')  && (is_active_sidebar('shop-sidebar'))) { ?>

            <div class="pe-col3">

                <?php dynamic_sidebar('shop-sidebar'); ?>

            </div>

            <?php } 



} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' ); ?>

     



 

    <?php



get_footer();
