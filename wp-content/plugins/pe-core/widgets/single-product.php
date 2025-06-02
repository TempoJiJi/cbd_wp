<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeSingleProduct extends Widget_Base {
 
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
    return 'pesingleproduct';
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
    return __( 'Pe Single Product', 'pe-core' );
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
    return 'eicon-single-product pe-widget';
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

      
      $options = [];

        $projects = get_posts( [
            'post_type'  => 'product',
            'numberposts' => -1
        ] );

        foreach ( $projects as $project ) {
            $options[ $project->ID ] = $project->post_title;
        }
      
        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Product', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

      
        $this->add_control(
			'select_project',
			[
				'label' => __( 'Select Product', 'pe-core'),
				'label_block' => true,
                'description' => __('Select project which will display in the slider.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
			]
		);
       

       	$this->add_control(
			'product_style',
			[
				'label' => esc_html__( 'Product Style', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => [
					'classic' => esc_html__( 'Classic', 'pe-core' ),
					'metro' => esc_html__( 'Metro', 'pe-core' ),
				],
			]
		
        
        );$this->add_control(
			'product_layout',
			[
				'label' => esc_html__( 'Product Layout', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'dark',
				'options' => [
					'dark' => esc_html__( 'Dark', 'pe-core' ),
					'light' => esc_html__( 'Light', 'pe-core' ),
				],
			]
		);
       
       $this->add_control(
			'title_position',
			[
				'label' => esc_html__( 'Title Position', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'metas-bottom',
				'options' => [
					'metas-bottom' => esc_html__( 'Bottom', 'pe-core' ),
					'metas-top' => esc_html__( 'Top', 'pe-core' ),
				],
			]
		);
       

       
		$this->add_responsive_control(
			'product_width',
			[
				'label' => esc_html__( 'Width', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .pe-single-product' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
       
 

       
        $this->add_responsive_control(
        'alignment',
           [
               'label' => esc_html__('Alignment', 'pe-core'),
               'type' => \Elementor\Controls_Manager::CHOOSE,
               'options' => [
                   'left' => [
                       'title' => esc_html__('Left', 'pe-core'),
                       'icon' => 'eicon-text-align-left',
                   ],
                   'center' => [
                       'title' => esc_html__('Center', 'pe-core'),
                       'icon' => 'eicon-text-align-center'
                   ],
                   'right' => [
                       'title' => esc_html__('Right', 'pe-core'),
                       'icon' => 'eicon-text-align-right',
                   ],

               ],
               'default' => 'left',
               'toggle' => true,
               		'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
           ]
       );
       
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
                'label' => esc_html__('Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .product-meta',
			]
		);
       
       $this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}} !important',
				],
			]
		);


		$this->end_controls_section();
  
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $id = $settings['select_project'];

        
        $classes = $settings['product_style'] .' '. $settings['title_position'] .' '. $settings['product_layout'] .' '. $settings['title_position'] .' '. $settings['alignment'] . ' pe-single-product ';
        
        $args = array(
    'post_type' => 'product',
    'posts_per_page' => 1,
    'post__in'=> array($id)
);
        
         $the_query = new \WP_Query( $args ); 
        
?>


<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>



<?php  $product = wc_get_product( get_the_ID()); ?>
<div <?php wc_product_class( $classes, $product ); ?>>

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


<?php endwhile; wp_reset_query(); ?>
<!--/ Single Product -->
<?php 
    }

}
