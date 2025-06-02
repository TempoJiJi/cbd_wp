<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Leksa
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function leksa_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

    if (class_exists("Redux")) {
        $option = get_option('pe-redux');
        
        $footerVisibility = 'show--footer';
        
       if (get_field('show_footer') !== null) {
        $footerVisibility = get_field('show_footer') ? 'show--footer' : 'hide--footer';
       }
        
        $classes[] = $footerVisibility;
    
        $classes[] = get_field('page_layout');

        $classes[] = 'loader__' . $option['loader_type'];
        
        $option['smooth_scroll'] || isset($_GET['smoothscroll']) ? $classes[] = 'smooth-scroll' : '';

        
    }

	return $classes;
}
add_filter( 'body_class', 'leksa_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function leksa_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'leksa_pingback_header' );

function leksa_excerpt_length($length){ return 30; } 

add_filter('excerpt_length', 'leksa_excerpt_length');

function leksa_unset_url_field($fields){
    if(isset($fields['url']))
       unset($fields['url']);
       unset($fields['cookies']);
       return $fields;
}

add_filter('comment_form_default_fields', 'leksa_unset_url_field');

function leksa_comment_form_fields($comment_fields) {
    if (isset($comment_fields['comment'])) {
        $comment_field = $comment_fields['comment'];
        unset($comment_fields['comment']);
        $comment_fields['comment'] = $comment_field;
    }

    return $comment_fields;
}

add_filter( 'comment_form_fields', 'leksa_comment_form_fields', 10, 1 );

function leksa_comment_placeholders( $fields )
    
{
    $fields['author'] = str_replace(
        '<input',
        '<input placeholder="'
        /* Replace 'theme_text_domain' with your theme’s text domain.
         * I use _x() here to make your translators life easier. :)
         * See http://codex.wordpress.org/Function_Reference/_x
         */
            . _x(
                'Your Name',
                'comment form placeholder',
                'leksa'
                )
            . '"',
        $fields['author']
    );
    
    $fields['email'] = str_replace(
        '<input id="email"',
        /* We use a proper type attribute to make use of the browser’s
         * validation, and to get the matching keyboard on smartphones.
         */
        '<input id="email" placeholder="' . esc_html('contact@example.com' , 'leksa') . '"',
        $fields['email']
    );


    return $fields;
}

add_filter( 'comment_form_default_fields', 'leksa_comment_placeholders' );

function leksa_textarea_placeholder( $leksa_textarea ) {
    $leksa_textarea['comment_field'] = str_replace(
        '<textarea',
        '<textarea placeholder="' . esc_html('Write your comment here' , 'leksa') . '"',
        $leksa_textarea['comment_field']
    );
    return $leksa_textarea;
}

add_filter( 'comment_form_defaults', 'leksa_textarea_placeholder' );  

if (!function_exists('leksa_comments')) {
    
function leksa_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
    $is_pingback_comment = $comment->comment_type == 'pingback';
    $comment_class = 'comment';
    if ( $is_pingback_comment ) {
        $comment_class .= ' pingback-comment';
    }
	?>

<li>
    <div class="<?php echo esc_attr($comment_class); ?>">
        <div class="comment-meta">
            <?php if ( ! $is_pingback_comment ) { ?>
            <div class="image"> <?php echo get_avatar($comment, 75); ?> </div>
            <?php } ?>

            <div class="comment-usr">

                <h6 class="name"><?php if ( $is_pingback_comment ) { esc_html_e( 'Pingback:', 'leksa' ); } ?><?php echo get_comment_author_link(); ?></h6>
                <span class="comment_date"><?php comment_date(); ?></span>

            </div>

        </div>

        <div class="text_holder" id="comment-<?php echo comment_ID(); ?>">
            <?php comment_text(); ?>
        </div>

        <?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']) ) ); ?>

    </div>

    <?php if ($comment->comment_approved == '0') : ?>
    <p><em><?php esc_html_e('Your comment is awaiting moderation.', 'leksa'); ?></em></p>
    <?php endif; ?>
    <?php 
}
}


// Modify comments header text in comments
add_filter( 'leksa_title_comments', 'child_title_comments');

function leksa_child_title_comments() {
    return esc_html__e(comments_number( '<h3>No Responses</h3>', '<h3>1 Response</h3>', '<h3>% Responses...</h3>' ), 'leksa');
}

function leksa_comment_validation_init() {
    
    if(is_single() && comments_open() ) { ?>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#commentform').validate({
                rules: {
                    author: {
                        required: true,
                        minlength: 2
                    },

                    email: {
                        required: true,
                        email: true
                    },

                    comment: {
                        required: true,
                        minlength: 20
                    }
                },

                messages: {
                    author: "<?php echo esc_html('Please fill the required field' , 'leksa') ?>",
                    email: "<?php echo esc_html('Please enter a valid email address.' , 'leksa') ?>",
                    comment: "<?php echo esc_html('Please fill the required field.' , 'leksa') ?>",
                },

                errorElement: "div",
                errorPlacement: function(error, element) {
                    element.after(error);
                }

            });
        });

    </script>
    <?php
    }
}
add_action('wp_footer', 'leksa_comment_validation_init');


/**
 * Change the Tag Cloud's Font Sizes.
 */

function leksa_tag_cloud_font_sizes( array $args ) {
    $args['smallest'] = '1';
    $args['largest'] = '1';
    $args['unit'] = 'em';

    return $args;
};

add_filter( 'widget_tag_cloud_args', 'leksa_tag_cloud_font_sizes');


add_action( 'woocommerce_after_single_product', 'leksa_output_related_products', 25);

function leksa_output_related_products(){
    
	$args = array( 
        'posts_per_page' => 4,  
        'orderby' => 'rand' 
 ); 
   	woocommerce_related_products( apply_filters( 'leksa_output_related_products_args', $args ) ); 
}

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}

add_filter('wp_nav_menu_objects', 'leksa_wp_nav_menu_objects', 10, 2);

function leksa_wp_nav_menu_objects( $items, $args ) {
    
    // loop
    foreach( $items as $key => $item ) {

        $hasChildren = get_field('add_sub' , $item);
       
        if ($hasChildren && get_field('select_template' , $item)) {
            
             $template = get_field('select_template' , $item);
             $id = $template->ID;
            
            $items[$key]->classes[] = 'leksa-has-children';
            $items[$key]->classes[] = 'sub_id_' . $id;
            
            
            
             echo '<div class="leksa-sub-menu-wrap sub_' . $id . '">' . \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($id) . '</div>';   
        }   
    }
    // return
    return $items;
    
}