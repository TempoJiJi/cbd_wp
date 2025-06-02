<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeIcon extends Widget_Base {
 
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
    return 'peicon';
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
    return __( 'Pe Icon', 'pe-core' );
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
    return 'eicon-favorite pe-widget';
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
                'label' => __( 'Icon', 'pe-core' ),
            ]
        );
       
        
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
       
         $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pe--icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pe--icon svg' => 'width: {{SIZE}}{{UNIT}};',
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
        
       
       
        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'pe-core'),
                'label_off' => esc_html__('Off', 'pe-core'),
                'default'   => 'has-bg',
                'return_value' => 'has-bg'
            ]
        );
       
        $this->add_responsive_control(
			'background_size',
			[
				'label' => esc_html__( 'Background Size', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pe--icon.has-bg .pe--icon--bg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
				],
                'condition' => [
                    'background' => 'has-bg'
                ]
			]
		);
       
              
       
        $this->add_control(
            'border',
            [
                'label' => esc_html__('Border', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'pe-core'),
                'label_off' => esc_html__('Off', 'pe-core'),
                'return_value' => 'bordered'
            ]
        );
       
       		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .pe-info-box',
                      'condition' => [
                    'border' => 'bordered'
                ]
			]
		);
              

       
        $this->add_control(
            'hover_effects',
            [
                'label' => esc_html__('Hover Effects', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'pe-core'),
                'label_off' => esc_html__('Off', 'pe-core'),
                'default'   => false,
                'return_value' => 'has-hover'
            ]
        );
       
        $this->add_control(
			'hover_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>You can edit hover preferences from "Style" tab above..</span></div>',
                  'condition' => ['hover_effects' => 'has-hover'],
                
			]
		);
       

    
        $this->end_controls_section();
       
         // Tab Title Control
        $this->start_controls_section(
            'motion_section',
            [
                'label' => __( 'Motion Effects', 'pe-core' ),
            ]
        );
       
     $this->add_control(
	   'motion',
        [
        'label' => esc_html__('Motion Effects', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '',
        'options' => [
            '' => esc_html__('None', 'pe-core'),
            'icon--motion me--rotate' => esc_html__('Rotate', 'pe-core'),
            'icon--motion me--flip-x' => esc_html__('Flip X', 'pe-core'),
            'icon--motion me--flip-y' => esc_html__('Flip Y', 'pe-core'),
            'icon--motion me--slide-left' => esc_html__('Slide Left', 'pe-core'),
            'icon--motion me--slide-right' => esc_html__('Slide Right', 'pe-core'),
            'icon--motion me--slide-up' => esc_html__('Slide Up', 'pe-core'),
            'icon--motion me--slide-down' => esc_html__('Slide Down', 'pe-core'),
            'icon--motion me--hearth-beat' => esc_html__('Heartbeat', 'pe-core'),
                
        ],
            'label_block' => true
        ]
       );
       
       $this->add_control(
        'motion_duration',
           [
               'label'=> esc_html__('Duration', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0.1,
               'step' => 0.1,
               'default' => 1,
                'condition' => ['motion!' => 'none'],
           ]
       );
       
       $this->add_control(
        'motion_repeat_delay',
           [
               'label'=> esc_html__('Repeat Delay', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'step' => 0.1,
               'default' => 0,
               'condition' => ['motion!' => 'none'],
           ]
       );
       
       
        $this->end_controls_section();
       
        $this->start_controls_section(
            'interactions_section',
            [
                'label' => __( 'Interactions', 'pe-core' ),
            ]
        );
       
        $this->add_control(
	   'interaction',
        [
        'label' => esc_html__('Interaction', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '',
        'options' => [
            '' => esc_html__('None', 'pe-core'),
            'pe--link' => esc_html__('Link', 'pe-core'),
            'pe--scroll--button' => esc_html__('Scroll', 'pe-core'),
//            'popup' => esc_html__('Popup (Template)', 'pe-core'),
                
        ],
          'label_block' => true
        ]
       );
       
       $this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' , 'custom_attributes' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
                 'condition' => ['interaction' => 'pe--link'],
			]
		);
       
       $this->add_control(
            'scroll_target',
           [
               'label' => esc_html__('Scroll To', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'placeholder' => esc_html__('Eg: #aboutContainer', 'pe-core'),
                'description' => esc_html__('Enter a target ID or exact number of desired scroll position ("0" for scrolling top)', 'pe-core'),
                'condition' => ['interaction' => 'pe--scroll--button'],
           ]
        );
       
      $this->add_control(
        'scroll_duration',
           [
               'label'=> esc_html__('Duration', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0.1,
               'step' => 0.1,
               'default' => 1,
                'description' => esc_html__('Seconds', 'pe-core'),
                'condition' => ['interaction' => 'pe--scroll--button'],
           ]
       );

       
       $this->end_controls_section();
       
       pe_cursor_settings($this);


    
       pe_color_options($this);
       
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();
        $classes = [];
        
        array_push($classes , [$settings['background'] , $settings['hover_effects'] , $settings['interaction']]);
        $buttonClasses = implode(' ' , array_filter($classes[0]));
        
        ob_start();

        \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );

        $icon = ob_get_clean();
   
        // Button Link
        if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'link', $settings['link'] );
		}
        
        // Motion Atrributes
        $this->add_render_attribute(
		'motion_attributes',
		  [
              'data-duration' => $settings['motion_duration'],
              'data-delay' => $settings['motion_repeat_delay'],
              
		  ]
	   );
        $motionAttributes = $settings['motion'] !== 'none' ? $this->get_render_attribute_string('motion_attributes') : '';
        
        
        //Scroll Button Attributes
      $this->add_render_attribute(
		'scroll_attributes',
		  [
              'data-scroll-to' => $settings['scroll_target'],
              'data-scroll-duration' => $settings['scroll_duration'],
              
		  ]
	   );
        
        $scrollAttributes = $settings['interaction'] === 'pe--scroll--button' ? $this->get_render_attribute_string('scroll_attributes') :'';
        
        $cursor = pe_cursor($this);
        
        
?>

<div class="pe--icon <?php echo esc_attr($buttonClasses); ?>" <?php echo $scrollAttributes ?>>

    <?php if (!empty( $settings['link']['url'] ) ) { ?>

    <a <?php echo $this->get_render_attribute_string( 'link' ); ?> <?php echo $cursor ?>>

        <?php } ?>

        <div class="pe--icon--wrap <?php echo $settings['motion'] ?>" <?php echo $motionAttributes ?>>

            <?php echo $icon; ?>

        </div>
        
        <?php if ($settings['background'] === 'has-bg') { ?>
        
        <span class="pe--icon--bg"></span>
        
        <?php } ?>

        <?php if ( ! empty( $settings['link']['url'] ) ) { ?>
    </a>
    <?php } ?>

</div>

<?php 
    }

}
