<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeProductsArchive extends Widget_Base {
 
  /**
   * Retrieve the widget name.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'peproductsarchive';
  }
 
  /**
   * Retrieve the widget title.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __( 'Pe Products Archive', 'pe-core' );
  }
 
  /**
   * Retrieve the widget icon.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'eicon-products-archive pe-widget';
  }
 
  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return [ 'pe-content' ];
  }


  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since 1.1.0
   *
   * @access protected
   */
   protected function _register_controls() {

  
$this->start_controls_section(
      'widget_content',
      [
        'label' => __( 'Products', 'pe-core' ),
      ]
    );
       
          
      $options = array();

        $args = array(
            'hide_empty' => true,
            'taxonomy' => 'product_cat'
        );

        $categories = get_categories($args);

        foreach ( $categories as $key => $category ) {
          $options[$category->term_id] = $category->name;
        }

        $this->add_control(
         'filter_cats',
          [
             'label' => __( 'Categories', 'pe-core' ),
             'type' => \Elementor\Controls_Manager::SELECT2,
             'multiple' => true,
             'options' => $options,
            ]
        );
       
        $this->add_control(
			'exclude_projects',
			[
				'label' => esc_html__( 'Exclude Products', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'eg: 1458 8478 ', 'pe-core' ),
				'description' => esc_html__( 'Enter projects ids which you dont want to display in this widget.', 'pe-core' ),
			]
		);
      
        $this->add_control(
			'number_posts',
			[
				'label' => esc_html__( 'Max Number of Products', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 10,
			]
		);
      
        $this->add_control(
			'order_by',
			[
				'label' => esc_html__( 'Order By', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'ID'  => esc_html__( 'ID', 'pe-core' ),
					'title'  => esc_html__( 'Title', 'pe-core' ),
					'date'  => esc_html__( 'Date', 'pe-core' ),
					'author'  => esc_html__( 'Autpe-core' ),
					'type'  => esc_html__( 'Type', 'pe-core' ),
					'rand'  => esc_html__( 'Random', 'pe-core' ),

				],
			]
		);
      
        $this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__( 'ASC', 'pe-core' ),
					'DESC'  => esc_html__( 'DESC', 'pe-core' )

				],
                
			]
		);

       
        $this->add_control(
			'style_switch',
			[
				'label' => __( 'Style Swticher', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core' ),
				'label_off' => __( 'No', 'pe-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
    
       
      $this->add_control(
			'filterable',
			[
				'label' => __( 'Filterable?', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core' ),
				'label_off' => __( 'No', 'pe-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
       
       $this->add_control(
			'products_count',
			[
				'label' => __( 'Products count on title', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pe-core' ),
				'label_off' => __( 'No', 'pe-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
       
        $this->add_control(
            'all_text',
           [
               'label' => esc_html__('Show All Text', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'placeholder' => esc_html__('Write your text here', 'pe-core'),
               'default' => esc_html__('All', 'pe-core'),
                'condition' => ['filterable' => 'yes'],
           ]
        );


      $this->add_control(
			'grid_columns',
			[
				'label' => esc_html__( 'Grid Columns', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'col-3',
				'options' => [
					'col-2' => esc_html__( '2 Columns', 'pe-core' ),
					'col-3' => esc_html__( '3 Columns', 'pe-core' ),
					'col-4' => esc_html__( '4 Columns', 'pe-core' ),
		
				],

			]
		);

       
       $this->add_responsive_control(
			'items_gap',
			[
				'label' => esc_html__( 'Items Gap', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .pe-products-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
      
    $this->end_controls_section();

        $this->start_controls_section(
            'cursor_interactions',
            [
                'label' => __( 'Cursor Interactions', 'pe-core' ),
            ]
            );
       
        $this->add_control(
			'cursor_type',
			[
				'label' => esc_html__( 'Interaction', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'pe-core' ),
					'text' => esc_html__( 'Text', 'pe-core' ),
					'icon' => esc_html__( 'Icon', 'pe-core' ),
					'none' => esc_html__( 'None', 'pe-core' ),
		
				],

			]
		);
       
       	$this->add_control(
			'cursor_icon',
			[
				'label' => esc_html__( 'Icon', 'pe-core' ),
				'description' => esc_html__( 'Only Material Icons allowed, do not select Font Awesome icons.', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
                     'condition' => ['cursor_type' => 'icon'],
			]
		);
       
       $this->add_control(
			'cursor_text',
			[
				'label' => esc_html__( 'Icon', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                 'condition' => ['cursor_type' => 'text'],
			]
		);
       
       
          $this->end_controls_section();
       
         $this->start_controls_section(
			'Style',
			[
				'label' => esc_html__( 'Style', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
       
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Page Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} h1.woocommerce-products-header__title.page-title.text-h3'
            ]
        );
       
       $this->add_control(
        'title_color',
           [
               'label' => esc_html__('Page Title Color', 'pe-core' ),
               'type' => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
                   '{{WRAPPER}} h1.woocommerce-products-header__title.page-title.text-h3' => 'color: {{VALUE}}'
               ]
           ]
       );
       
       $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'filters_typography',
                'label' => esc_html__('Filters Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe-products-filtering ul li'
            ]
        );
       
       $this->add_control(
        'filters_color',
           [
               'label' => esc_html__('Filters Color', 'pe-core' ),
               'type' => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
                   '{{WRAPPER}} .pe-products-filtering ul li' => 'color: {{VALUE}}'
               ]
           ]
       );
       
       $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_title_typography',
                'label' => esc_html__('Product Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .product-name.woocommerce-loop-product__title'
            ]
        );
       
       $this->add_control(
        'product_title_color',
           [
               'label' => esc_html__('Product Title Color', 'pe-core' ),
               'type' => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
                   '{{WRAPPER}} .product-name.woocommerce-loop-product__title' => 'color: {{VALUE}}'
               ]
           ]
       );
       
       $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_price_typography',
                'label' => esc_html__('Product Price Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .product-price'
            ]
        );
       
       $this->add_control(
        'product_price_color',
           [
               'label' => esc_html__('Product Price Color', 'pe-core' ),
               'type' => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
                   '{{WRAPPER}} .product-price' => 'color: {{VALUE}}'
               ]
           ]
       );
       


       

        $this->end_controls_section();
       

       
       
    }

    protected function render() {
      $settings = $this->get_settings();
        
        $excluded = explode(" " , $settings['exclude_projects']);

   $cats = $settings['filter_cats'];
$category_slugs = array();

foreach ($cats as $cat_id) {
    $category = get_term($cat_id, 'product_cat');
    if (!is_wp_error($category)) {
        $category_slugs[] = $category->slug;
    }
}
        
$args = array(
    'status' => 'publish', 
    'limit' => $settings['number_posts'], 
    'orderby' => $settings['order_by'], 
    'order' => $settings['order'], 
    'exclude' => $excluded, 
    'category' => $category_slugs,
);

$products = wc_get_products($args);
        $total_products = count($products);

                  $cursorType = $settings['cursor_type'];
        $cursorInteraction = '';
        $cursorSettings = '';
        
                if ($cursorType !== 'none') {
            
            $cursorInteraction = ' cursor-' . $cursorType;
            
            if ($cursorType === 'icon') {
                
                  $str = $settings['cursor_icon']['value'];
            $delimiter = ' ';
            $icon = explode($delimiter, $str);
            
            $lib = 'data-lib="' . str_replace('-', ' ',$icon[0]) . '"';
            $ico = 'data-cursor-icon="' . $icon[1] . '"';
            $ico = 'data-cursor-icon="' . str_replace('md-', '',$icon[1]) . '"';
            
            $cursorSettings = $lib . ' ' . $ico;
                
            } else if ($cursorType === 'text') {
                
                $cursorText = 'data-cursor-text="' . $settings['cursor_text'] . '"';
                 $cursorSettings = $cursorText;
            }
          
            
        } else {
            
            $cursorInteraction = ' no-cursor-interaction';
        }

        

        
?>


<!-- Products -->

<div class="archive-products-section">


    <div class="pe--products-grid-controls">

        <?php if ($settings['filterable']) { ?>


        <div class="pe--products-filtering">

            <ul class="np-filters">

                <?php  
       woocommerce_catalog_ordering();
        echo '<li data-cat="filter-all" class="all active">' . esc_html($settings['all_text']) . '</li>';
        
foreach ($cats as $cat_id) {
    $category = get_term($cat_id, 'product_cat');
    if (!is_wp_error($category)) {
        echo '<li data-cat="' .  esc_attr($category->slug) . '" class="product_cat cat_' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</li>';
    }
}
    
    ?>

            </ul>

        </div>

        <?php } ?>


        <?php if ($settings['style_switch']) { ?>

        <div class="npg-switch">
            <span class="material-icons switch-def active">grid_view</span>
            <span class="material-icons switch-2">splitscreen</span>

        </div>

        <?php } ?>

    </div>


    <div class="pe--products-grid <?php echo esc_attr($settings['grid_columns']) ?>">


        <?php foreach ($products as $product) {
        
    
            
        ?>
        <!-- Single Product -->
        <div <?php wc_product_class( 'pe-single-product', $product );  ?>>
            
            

                <a href="<?php echo apply_filters( 'woocommerce_loop_product_link', $product->get_permalink() ); ?>" class="<?php echo esc_attr($cursorInteraction) ?>" <?php echo $cursorSettings; ?>>
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

                        <?php  $attachment_ids = $product->get_gallery_image_ids();
                        $image = $product->get_image();
                        preg_match('/<img.*?src=["\'](.*?)["\'].*?>/i', $image, $matches);
                       $image_url = get_the_post_thumbnail_url($product->get_id(), 'shop_catalog');



                        if ($attachment_ids) { ?>

                        <!-- Product Image Front -->
                        <img class="product-image-front" src="<?php echo $image_url; ?>">
                        <!--/ Product Image Front -->

                        <?php foreach( $attachment_ids as $key => $attachment_id ) { 
                
                if ($key == 0) {
          $attachment_url = wp_get_attachment_url($attachment_id);
                echo '<img class="product-image-back" src="' . esc_url($attachment_url) . '">';
                
                }  } 
                                             
                        } else { ?>

                        <img src="<?php echo $image_url ?>">
                        <?php } ?>

                    </div>
                    <!--/ Product Image -->

                    <!-- Product Meta -->
                    <div class="product-meta text-h6">

                        <?php echo '<div class="product-name ' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . $product->get_title() . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped  ?>

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
		'<a href="%s" data-product-id="' .  $product->get_id() . '" data-quantity="%s" class="%s" %s>%s</a>',
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

        <?php } ?>
    </div>


    <!--/Products -->


    <?php 
    }

}
