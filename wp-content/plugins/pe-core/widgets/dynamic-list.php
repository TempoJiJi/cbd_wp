<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeDynamicList extends Widget_Base {
 
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
    return 'pedynamiclist';
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
    return __( 'Pe Dynamic List', 'pe-elementor' );
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
    return 'eicon-bullet-list';
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
       
       
       
       
        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => esc_html__( 'Tab Title', 'pe-core' ),
            ]
        );
       
        $this->add_control(
            'list_direction',
            [
                'label' => esc_html__('Lisssst Direction', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'vertical' => esc_html__('Vertical', 'pe-core'),
                    'horizontal' => esc_html__('Horizontal', 'pe-core')
                ],
                'default' => 'vertical',
                'label_block' => true
            ]
        );


       $repeater = new \Elementor\Repeater();
       
       $repeater->add_control(
        'list_item_title',
           [
               'label' => esc_html__('List Item Title', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXTAREA,
               'rows' => 2,
               'placeholder' => esc_html__('Write Your List Title', 'pe-core')
           ]
        );
       
       $repeater->add_control(
        'list_item_number',
           [
               'label' => esc_html__('List Item Number', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'placeholder' => esc_html__('Write Number', 'pe-core')
           ]
       );
       
       $repeater->add_control(
        'list_item_image',
           [
               'label' => esc_html__('List Item Image', 'pe-core'),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'default' => [
                   'url' => \Elementor\Utils::get_placeholder_image_src()
               ]
           ]
       );
       
       $repeater->add_control(
        'list_item_url',
           [
               'label' => esc_html__('List Item URL', 'pe-core'),
               'type' => \Elementor\Controls_Manager::URL,
               'options' => ['url', 'is_external', 'nofollow'],
               'default' => [
                   'url' => '',
                   'is_external' => true,
                   'nofollow' => true
               ]
           ]
       );
       
       	$this->add_control(
			'dynamic_list',
			[
				'label' => esc_html__( 'Dynamic List', 'pe-core'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'show_label' => true,
			]
		);
       
       
        $this->end_controls_section();

       
        $this->start_controls_section(
			'animate',
			[
				'label' => esc_html__( 'Animate' , 'pe-core'),
			]
		);
       
        $this->add_control(
            'select_animation',
            [
                'label' => esc_html__('Select Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('None', 'pe-core'),
                'data-animation=charsUp' => esc_html__('Chars Up', 'pe-core'),
                'data-animation=charsDown' => esc_html__('Chars Down', 'pe-core'),
                'data-animation=charsRight' => esc_html__('Chars Right', 'pe-core'),
                'data-animation=charsLeft' => esc_html__('Chars Left', 'pe-core'),
                'data-animation=wordsUp' => esc_html__('Words Up', 'pe-core'),
                'data-animation=wordsDown' => esc_html__('Words Down', 'pe-core'),
                'data-animation=linesUp' => esc_html__('Lines Up', 'pe-core'),
                'data-animation=linesDown' => esc_html__('Lines Down', 'pe-core'),
                'data-animation=charsFadeOn' => esc_html__('Chars Fade On', 'pe-core'),
                'data-animation=wordsFadeOn' => esc_html__('Words Fade On', 'pe-core'),
                'data-animation=linesFadeOn' => esc_html__('Lines Fade On', 'pe-core'),
                'data-animation=charsScaleUp' => esc_html__('Chars Scale Up', 'pe-core'),
                'data-animation=charsScaleDown' => esc_html__('Chars Scale Down', 'pe-core'),
                'data-animation=charsRotateIn' => esc_html__('Chars Rotate In', 'pe-core'),
                'data-animation=charsFlipUp' => esc_html__('Chars Flip Up', 'pe-core'),
                'data-animation=charsFlipDown' => esc_html__('Chars Flip Down', 'pe-core'),
                'data-animation=linesMask' => esc_html__('Lines Mask', 'pe-core'),
                'data-animation=wordsJustifyCollapse' => esc_html__('Words Justify Collapse', 'pe-core'),
                'data-animation=wordsJustifyExpand' => esc_html__('Words Justify Expand', 'pe-core'),
                'data-animation=slideLeft' => esc_html__('Slide Left', 'pe-core'),
                'data-animation=slideRight' => esc_html__('Slide Right', 'pe-core'),
            ],
            'label_block' => true
        ]
        );
       
       $this->add_control(
        'fade',
           [
                'label' => esc_html__('Fade', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'fade',
                'condition' => [
                    'select_animation' => ['charsUp', 'charsDown', 'charsRight', 'charsLeft', 'wordsUp', 'wordsDown', 'linesUp', 'linesDown']
                ]
           ]
       );
       
       $this->add_control(
        'data_scrub',
           [
               'label' => esc_html__('Scrub', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SWITCHER,
               'label_on' => esc_html__('On', 'pe-core'),
               'label_off' => esc_html__('Off', 'pe-core'),
               'return_value' => 'data-scrub=true'
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
                'name' => 'dynamic_list_typography',
                'label' => esc_html__('Dynamic List Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe-dynamic-list li a'
            ]
        ); 
       
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sup_typography',
                'label' => esc_html__('Sup Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .pe-dynamic-list li a sup'
            ]
        );
        
        $this->add_control(
            'dynamic_list_color',
            [
                'label' => esc_html__('Dynamic List Color', 'pe-core'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pe-dynamic-list li a' => 'color: {{VALUE}}'
                ]
            ]
        );
        
        $this->end_controls_section();
        
            
        
    }   

    protected function render() {
        $settings = $this->get_settings_for_display();

?>

<div class="pe-dynamic-list <?php echo $settings['list_direction'] ?>" <?php echo $settings['select_animation']  . " " . $settings['data_scrub'] ?>>

    <ul>

        <?php  if ($settings['dynamic_list'])
        
            foreach ($settings['dynamic_list'] as $item ) {
            
                echo "<li> <a href='" . $item['list_item_url']['url'] . "'>" . esc_html($item['list_item_title']) . "<sup>/" . $item['list_item_number'] . "</sup> </a> <div class='list-image'> <img src='" . $item['list_item_image']['url']. "'> </div> </li>";
                
            }
            
        ?>


    </ul>
</div>





<?php 
    }

}
