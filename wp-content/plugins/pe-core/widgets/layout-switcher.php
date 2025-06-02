<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeLayoutSwitcher extends Widget_Base {
 
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
    return 'pelayoutswitcher';
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
    return __( 'Pe Layout Switcher', 'pe-core' );
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
    return 'eicon-dual-button pe-widget';
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
    return [ 'pe-header' ];
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
                'label' => __( 'Site Logo', 'pe-core' ),
            ]
        );

	   $this->add_control(
			'style',
			[
				'label' => esc_html__( 'Style', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ls_switcher',
				'options' => [
					'ls_switcher' => esc_html__( 'Switcher', 'pe-core' ),
					'ls_button'  => esc_html__( 'Button', 'pe-core' ),
				],
			]
		);
       
       $this->add_control(
			'dark_text',
			[
				'label' => esc_html__( 'Dark Text', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'DARK', 'pe-core' ),
			]
		);
       
       $this->add_control(
			'light_text',
			[
				'label' => esc_html__( 'Light Text', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'LIGHT', 'pe-core' ),
			]
		);
       
         $this->add_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'pe-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pe-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pe-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);
       
        $this->add_control(
            'show_labels',
            [
                'label' => esc_html__('Show Labels', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => ['style' => 'ls_button']
            ]
        );
     
        $this->end_controls_section();
       
       pe_color_options($this);

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $option = get_option('pe-redux');

?>



<div class="pe-layout-switcher <?php echo $settings['style'] ?>">

	<div class="pl--switch">
		
		<span class="pl--follower"></span>
		
	</div>
	

</div>


<?php
    }

}
