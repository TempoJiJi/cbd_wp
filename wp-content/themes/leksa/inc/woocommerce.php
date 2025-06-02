<?php
function leksa_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 150,
        'single_image_width'    => 300,
        
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );
}

add_action( 'after_setup_theme', 'leksa_add_woocommerce_support' );


function leksa_remove_shop_breadcrumbs(){
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
 
}
add_action('template_redirect', 'leksa_remove_shop_breadcrumbs' );

add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
     

if (is_woocommerce_activated()) {

function custom_product_archive_filter() {
    if (is_shop() || is_product_category()) {
        $categories = get_terms('product_cat'); 

        
         $option = get_option('pe-redux');
    
    if($option['is_filterable']) {


?>

<div class="pe--products-filtering">
    
    <ul class="np-filters">
        
        <?php  
        
        echo '<li data-cat="filter-all" class="all active">' . esc_html('All' , 'leksa') . '</li>';
        
        foreach ($categories as $category) {
            
            echo '<li data-cat="' .  esc_attr($category->slug) . '" class="product_cat cat_' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</li>';
        } ?>
    
    </ul>

</div>

<?php 
    }
    }
}

add_action('woocommerce_before_shop_loop', 'custom_product_archive_filter', 10);


function custom_product_category_filter_query($query) {
    if (isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
        $query->set('product_cat', sanitize_text_field($_GET['product_cat']));
    }
    return $query;
}

add_filter('woocommerce_product_query', 'custom_product_category_filter_query');


remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

function leksa_product_count() {
   
        global $wp_query;

        $total_products = $wp_query->found_posts;

        echo '<span>(' . $total_products . ')</span>';
   
}

function calculate_discount_percentage($regular_price, $sale_price) {
    if ($regular_price > 0 && $sale_price > 0 && $regular_price > $sale_price) {
        $discount = round(((($regular_price - $sale_price) / $regular_price) * 100), 1);
        return $discount;
    }
    return 0;
}

// functions.php dosyanıza aşağıdaki kodu ekleyin

function custom_element_before_sorting() {
    $option = get_option('pe-redux');
    
    if($option['grid_switcher']) {
        
         echo '<div class="npg-switch">
            <span class="material-icons switch-def active">grid_view</span>
            <span class="material-icons switch-2">splitscreen</span>
    
    </div>';
        
    } else {
        
        return;
    }
    
   
}

add_action('woocommerce_before_shop_loop', 'custom_element_before_sorting', 15);

/**
 * Is woocommerce page
 *
 * @param   string $page        ( 'cart' | 'checkout' | 'account' | 'endpoint' )
 * @param   string $endpoint    If $page == 'endpoint' and you want to check for specific endpoint
 * @return  boolean
 */
if( ! function_exists('is_woocommerce_page') ){
    function is_woocommerce_page( $page = '', $endpoint = '' ){
        if( ! $page ){
            return ( is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url() );
        }

        switch ( $page ) {
            case 'cart':
                return is_cart();
                break;

            case 'checkout':
                return is_checkout();
                break;

            case 'account':
                return is_account_page();
                break;

            case 'endpoint':
                if( $endpoint ) {
                    return is_wc_endpoint_url( $endpoint );
                }

                return is_wc_endpoint_url();
                break;
        }

        return false;
    }
}


add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
        
function woocommerce_ajax_add_to_cart() {

            $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
            $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
            $variation_id = absint($_POST['variation_id']);
            $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
            $product_status = get_post_status($product_id);

            if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

                do_action('woocommerce_ajax_added_to_cart', $product_id);

                if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                    wc_add_to_cart_message(array($product_id => $quantity), true);
                }

                WC_AJAX :: get_refreshed_fragments();
            } else {

                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

                echo wp_send_json($data);
            }

            wp_die();
        }
}