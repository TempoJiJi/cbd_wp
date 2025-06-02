<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeSiteNavigation extends Widget_Base {
 
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
    return 'pesitenavigation';
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
    return __( 'Site Navigation', 'pe-core' );
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
    return 'eicon-menu-toggle pe-widget';
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
    return [ 'pe-dynamic' ];
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
       
    
         $registered = wp_get_nav_menus();
         $menus = [];
           
                if ($registered) {
                foreach ($registered as $menu) {
                    
                    $name = $menu->name;
                    $id = $menu->term_id;
                    
                  $menus[$name] = $name;
                    
             }
         }

        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __( 'Site Navigation', 'pe-core' ),
            ]
        );
       
        $this->add_control(
			'menu_style',
			[
				'label' => esc_html__( 'Navigation Style', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => [
					'classic'  => esc_html__( 'Classic', 'pe-core' ),
					'fullscreen' => esc_html__( 'Fullscreen', 'pe-core' ),
					'popup' => esc_html__( 'Popup', 'pe-core' ),
				],
			]
		);
       
        $templates = [];

        $templates = get_posts( [
            'post_type'  => 'elementor_library',
            'numberposts' => -1
        ] );

        foreach ( $templates as $template ) {
            $templates[ $template->ID ] = $template->post_title;
        }
       
       $this->add_control(
			'select_template',
			[
				'label' => __( 'Select Menu Template', 'pe-core'),
				'label_block' => false,
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $templates,
			]
		);
	   
	    $this->add_control(
			'nav_visibility',
			[
				'label' => esc_html__( 'Show Navigation:', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'always--show',
				'options' => [
					'always--show'  => esc_html__( 'Always', 'pe-core' ),
					'show--sticky' => esc_html__( 'When heeader stkicked/fixed.', 'pe-core' ),
					'show--on--top' => esc_html__( 'When header on top.', 'pe-core' ),
				],
			]
		);

       $this->end_controls_section();
       
       	$this->start_controls_section(
			'style',
			[
                
				'label' => esc_html__( 'Styling', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->end_controls_section();
       
       pe_color_options($this);

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $option = get_option('pe-redux');
        $menuClasses = 'menu main-menu';
        $style = $settings['menu_style'];
		
		$this->add_render_attribute(
		'_wrapper',
		[
			'class' =>  'wd--' . $settings['nav_visibility']

		]
		);

 
      if ($style === 'classic') {
            
            echo '<nav id="site-navigation" class="main-navigation classic">';
            
            
              wp_nav_menu(
				array(
					'theme_location' => '',
					'menu'        => $settings['select_menu'],
                    'container'     => false,
                    'menu_class'    => $menuClasses
				)
			);

            echo '</nav>';

        } else if ($style === 'popup' || $style === 'fullscreen') { ?>

<div class="site--nav nav--<?php echo $style; ?>">

    <div class="menu--toggle--wrap">

        <div class="menu--toggle toggle--plus has--bg has--hover">

            <span class="toggle-line"></span>
            <span class="toggle-line"></span>

        </div>

    </div>

    <div class="site--menu">

        <?php 
                                        
          echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['select_template']);
                                      
        ?>

    </div>

</div>

<?php }

         
            
    }

}
