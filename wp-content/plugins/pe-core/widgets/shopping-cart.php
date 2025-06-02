<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class peShoppingCart extends Widget_Base {
 
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
    return 'peshoppingcart';
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
    return __( 'Shopping Cart', 'leksa-elementor' );
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
    return 'eicon-cart-light pe-widget';
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
    return [ 'leksa-header' ];
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
       
       
        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __( 'Shopping Cart', 'your-custom-plugin' ),
            ]
        );
       
        $this->add_control(
			'cart_text',
			[
				'label' => esc_html__( 'Cart Text', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                  'default' => esc_html('CART' , 'leksa-elementor')
			]
		);
       
       $this->add_responsive_control(
        'alignment',
           [
               'label' => esc_html__('Alignment', 'leksa-elementor'),
               'type' => \Elementor\Controls_Manager::CHOOSE,
               'options' => [
                   'left' => [
                       'title' => esc_html__('Left', 'leksa-elementor'),
                       'icon' => 'eicon-text-align-left',
                   ],
                   'center' => [
                       'title' => esc_html__('Center', 'leksa-elementor'),
                       'icon' => 'eicon-text-align-center'
                   ],
                   'right' => [
                       'title' => esc_html__('Right', 'leksa-elementor'),
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
                'label' => esc_html__('Typography', 'leksa-elementor'),
				'selector' => '{{WRAPPER}} .leksa-cart-button',
			]
		);
       
       $this->add_control(
			'background',
			[
				'label' => esc_html__( 'Background Color', 'leksa-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .leksa-cart-button' => 'background-color: {{VALUE}}',
				],
			]
		);
       
       $this->add_control(
			'count_background',
			[
				'label' => esc_html__( 'Cart Count Background Color', 'leksa-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .leksa-cart-button::before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .leksa-cart-button::after' => 'background-color: {{VALUE}}',
				],
			]
		);
       
       $this->add_control(
			'count_color',
			[
				'label' => esc_html__( 'Cart Count Background Color', 'leksa-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .leksa-cart-button::after' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
            'visibility',
            [
                'label' => __( 'Visibility', 'pe-core'),
				'label_block' => true,
				'default' => 'show--only--woo',
                'type' => \Elementor\Controls_Manager::SELECT,
                'prefix_class' => '',
				'options' => [
					'show-only-woo' => esc_html__( 'Only WooCommerce Pages', 'pe-core' ),
					'show-everywhere' => esc_html__( 'Everywhere', 'pe-core' ),
				],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $option = get_option('pe-redux');
        
$text = $settings['cart_text'];
?>

<div class="leksa-shopping-cart" data-barba-prevent='all'>


    <?php 
          if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
              
              echo woo_cart_but($text , false);
              
            } else {
    
            echo woo_cart_but($text , true);
            }
        
         ?>
        

</div>

<?php
    }

}
