<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PePostField extends Widget_Base {
 
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
    return 'pepostfield';
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
    return __( 'Post Field', 'pe-core' );
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
    return 'eicon-post-info pe-widget';
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
       
       
        // Tab Title Control
        $this->start_controls_section(
            'section_tab_title',
            [
                'label' => __( 'Post Fields', 'pe-core' ),
            ]
        );
       
        $this->add_control(
            'field_type',
            [
                'label' => esc_html__('Field Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'title',
                'options' => [
                    'title' => esc_html__('Title', 'pe-core'),
                    'category' => esc_html__('Category', 'pe-core'),
                    'author' => esc_html__('Author', 'pe-core'),
                    'date' => esc_html__('Date', 'pe-core'),
                    'tags' => esc_html__('Tags', 'pe-core'),
                    'content' => esc_html__('Content', 'pe-core'),

            ],
            'label_block' => true,
        ]
        );

       
       $this->add_control(
			'text_type',
			[
				'label' => esc_html__( 'Text Size', 'pe-core' ),
                'description' => esc_html__('This option will not change HTML tag of the element, this option only for typographic scaling.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'text-p' => [
						'title' => esc_html__( 'P', 'pe-core' ),
						'icon' => ' eicon-editor-paragraph',
					],
                    'text-h1' => [
						'title' => esc_html__( 'H1', 'pe-core' ),
						'icon' => ' eicon-editor-h1',
					],
                    'text-h2' => [
						'title' => esc_html__( 'H2', 'pe-core' ),
						'icon' => ' eicon-editor-h2',
					],
                    'text-h3' => [
						'title' => esc_html__( 'H3', 'pe-core' ),
						'icon' => ' eicon-editor-h3',
					],
                    'text-h4' => [
						'title' => esc_html__( 'H4', 'pe-core' ),
						'icon' => ' eicon-editor-h4',
                    ],
                    'text-h5' => [
						'title' => esc_html__( 'H5', 'pe-core' ),
						'icon' => ' eicon-editor-h5',
					],
                    'text-h6' => [
						'title' => esc_html__( 'H6', 'pe-core' ),
						'icon' => ' eicon-editor-h6',
					]

				],
				'default' => 'text-p',
				'toggle' => true,
			]
		);
       
       $this->add_control(
            'paragraph_size',
            [
                'label' => esc_html__('Paragraph Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Normal', 'pe-core'),
                    'p-small' => esc_html__('Small', 'pe-core'),
                    'p-large' => esc_html__('Large', 'pe-core'),

            ],
            'label_block' => true,
                   'condition' => ['text_type' => 'text-p'],
        ]
        );
       
       $this->add_control(
            'heading_size',
            [
                'label' => esc_html__('Heading Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Normal', 'pe-core'),
                    'md-title' => esc_html__('Medium', 'pe-core'),
                    'big-title' => esc_html__('Large', 'pe-core'),

            ],
            'label_block' => true,
            'condition' => ['text_type' => 'text-h1'],
        ]
        );
       
       
       
       
       
       $this->add_control(
        'remove_breaks',
           [
                'label' => esc_html__('Remove Breaks on Mobile', 'pe-core'),
                'description' => esc_html__('On mobile screens "br" tags will be removed.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'hide-br-mobile',
                'default' => '',

           ]
       );
       
              
     $this->add_control(
        'remove_margins',
           [
                'label' => esc_html__('Remove Margins', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'no-margin',
                'default' => '',

           ]
       );
	   
	   
	   $this->add_control(
        'has_bg',
           [
                'label' => esc_html__('Background', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'has--bg',
                'default' => '',

           ]
       );
       
        $this->end_controls_section();

	   
	             $this->start_controls_section(
			'style',
			[
                
				'label' => esc_html__( 'Style', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
       
    $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
                'label' => esc_html__('Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .text-wrapper p',
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
                   'justify' => [
                       'title' => esc_html__('Justify', 'pe-core'),
                       'icon' => 'eicon-text-align-justify',
                   ],
               ],
               'default' => 'left',
               'toggle' => true,
               		'selectors' => [
					'{{WRAPPER}} .text-wrapper' => 'text-align: {{VALUE}};',
				],
           ]
       );
        
		$this->add_responsive_control(
			'width',
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
                        'step' => 1,
					],
				],
//				'default' => [
//					'unit' => '%',
//					'size' => 100,
//				],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
       
      $this->add_responsive_control(
			'border-radius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .text-wrapper a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
       $this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .text-wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	   

    $this->end_controls_section();
	   
	   
        $this->start_controls_section(
            'section_animate',
            [
                'label' => __( 'Animations', 'pe-core' ),
            ]
         );
       
            $this->add_control(
			'insert2_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>"Line" based animations deprecated because of inserted elements.</span></div>',
                 'condition' => ['additional' => 'insert'],
			]
		);
       
              $this->add_control(
			'dynamic2_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>Scrubbing/pinning deprecated because of the dynamic word.</span></div>',
                 'condition' => ['additional' => 'dynamic'],
			]
		);
       
        $this->add_control(
            'select_animation',
            [
                'label' => esc_html__('Select Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'description' => esc_html__( 'Will be used as intro animation.', 'textdomain' ),
                'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'charsUp' => esc_html__('Chars Up', 'pe-core'),
                'charsDown' => esc_html__('Chars Down', 'pe-core'),
                'charsRight' => esc_html__('Chars Right', 'pe-core'),
                'charsLeft' => esc_html__('Chars Left', 'pe-core'),
                'wordsUp' => esc_html__('Words Up', 'pe-core'),
                'wordsDown' => esc_html__('Words Down', 'pe-core'),
                'linesUp' => esc_html__('Lines Up', 'pe-core'),
                'linesDown' => esc_html__('Lines Down', 'pe-core'),
                'charsScaleUp' => esc_html__('Chars Scale Up', 'pe-core'),
                'charsScaleDown' => esc_html__('Chars Scale Down', 'pe-core'),
                'charsFlipUp' => esc_html__('Chars Flip Up', 'pe-core'),
                'charsFlipDown' => esc_html__('Chars Flip Down', 'pe-core'),
                'linesMask' => esc_html__('Lines Mask', 'pe-core'),
            ],
            'label_block' => true,
        ]
        );
       
       $this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Animation Options', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
       
       $this->start_controls_tabs(
	   'animation_options_tabs'
        );
       
       $this->start_controls_tab(
	   'basic_tab',
	   [
		'label' => esc_html__( 'Basic', 'textdomain' ),
	   ]
       );
       
       $this->add_control(
        'duration',
           [
               'label'=> esc_html__('Duration', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0.1,
               'step' => 0.1,
               'default' => 1.5
           ]
       );
       
       $this->add_control(
        'delay',
           [
               'label'=> esc_html__('Delay', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'step' => 0.1,
               'default' => 0
           ]
       );
       
        $this->add_control(
        'stagger',
           [
               'label' => esc_html__('Stagger', 'pe-core'),
                'description' => esc_html__('Delay between animated elements (for multiple element animation types)', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'max' => 1,
               'step' => 0.01,
               'default' => 0.1,
           ]
       );

       
       $this->add_control(
        'scrub',
           [
                'label' => esc_html__('Scrub', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
               	'default' => 'false',
                 'description' => esc_html__('Animation will follow scrolling behavior of the page.', 'pe-core'),
                 'condition' => ['additional!' => 'dynamic'],


           ]
       );
       
       $this->add_control(
        'pin',
           [
                'label' => esc_html__('Pin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'true',
               	'default' => 'false',
                    'description' => esc_html__('Animation will be pinned to window during animation.', 'pe-core'),
                  'condition' => ['additional!' => 'dynamic'],

           ]
       );

       $this->end_controls_tab();
       
         $this->start_controls_tab(
	   'advanced_tab',
	   [
		'label' => esc_html__( 'Advanced', 'textdomain' ),
	   ]
       );
       
       $this->add_control(
        'show_markers',
           [
                'label' => esc_html__('Markers', 'pe-core'),
                'description' => esc_html__('Shows (only in editor) animation start and end points and adjust them.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
               	'default' => 'false',
                'return_value' => 'true',

           ]
       );
       
       $this->add_control(
        'anim_start',
           [
               'label' => esc_html__('Animation Start Point', 'pe-core'),
               'type' => \Elementor\Controls_Manager::CHOOSE,
               'description' => esc_html__('Animation will be triggered when the element enters the desired point of the view.', 'pe-core'),
               'options' => [
                   'top top' => [
                       'title' => esc_html__('Top', 'pe-core'),
                       'icon' => 'eicon-v-align-top',
                   ],
                   'center center' => [
                       'title' => esc_html__('Center', 'pe-core'),
                       'icon' => 'eicon-v-align-middle'
                   ],
                   'top bottom' => [
                       'title' => esc_html__('Bottom', 'pe-core'),
                       'icon' => ' eicon-v-align-bottom',
                   ],
               ],
               'default' => 'top bottom',
               'toggle' => false,
           ]
       );
       
      $this->add_control(
			'start_offset',
			[
				'label' => esc_html__( 'Start Offset', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
                 'condition' => ['show_markers' => 'true'],
			]
		);
       
      $this->add_control(
        'anim_end',
           [
               'label' => esc_html__('Animation End Point', 'pe-core'),
               'type' => \Elementor\Controls_Manager::CHOOSE,
                              'description' => esc_html__('Animation will be end when the element enters the desired point of the view. (For scrubbed/pinned animations)', 'pe-core'),
               'options' => [
                   'bottom bottom' => [
                       'title' => esc_html__('Bottom', 'pe-core'),
                       'icon' => 'eicon-v-align-bottom',
                   ],
                   'center center' => [
                       'title' => esc_html__('Center', 'pe-core'),
                       'icon' => 'eicon-v-align-middle'
                   ],
               ],
               'default' => 'bottom bottom',
               'toggle' => false,
           ]
       );
       
       
       $this->add_control(
			'end_offset',
			[
				'label' => esc_html__( 'End Offset', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
                 'condition' => ['show_markers' => 'true'],
			]
		);
       
              
       $this->add_control(
            'pin_target',
           [
               'label' => esc_html__('Pin Target', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
               'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),

           ]
        );
       
       $this->add_control(
        'animate_out',
           [
                'label' => esc_html__('Animate Out', 'pe-core'),
                'description' => esc_html__('Animation will be played backwards when leaving from viewport. (For scrubbed/pinned animations)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
               	'default' => 'false',
                'return_value' => 'true',

           ]
       );


       $this->end_controls_tab();

       $this->end_controls_tabs();
       
        $this->end_controls_section();
       
  pe_color_options($this);
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
       
        
        $start = $settings['start_offset'] ? $settings['start_offset']['size'] : 0;
        $end = $settings['end_offset'] ? $settings['end_offset']['size'] : 0;
        $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';
        

        
        $dataset = '{'. 
            'duration=' . $settings['duration'] . ''.
            ';delay=' . $settings['delay'] . ''.
            ';stagger=' . $settings['stagger'] . ''.
            ';pin=' . $settings['pin'] . ''.
            ';pinTarget=' . $settings['pin_target'] . ''.
            ';scrub=' . $settings['scrub'] . ''.
            ';markers=' . $settings['show_markers'] . ''.
            ';start=' . $start . ''.
            ';startpov=' . $settings['anim_start'] . ''.
            ';end=' . $end . ''.
            ';endpov=' . $settings['anim_end'] . ''.
            ';out=' . $out . ''.
            ';inserted=false'.
        '}';

        $checkMarkers = '';
        
       if ( \Elementor\Plugin::$instance->editor->is_edit_mode() && $settings['show_markers'] ) {
            $checkMarkers = ' markers-on';
       }
        
       $animation = $settings['select_animation'] !== 'none' ?  $settings['select_animation'] : '';
        
        
       	$this->add_render_attribute(
		'attributes',
		  [
			 'class' => [$settings['text_type'] , $settings['paragraph_size'] , $settings['remove_margins'] , $settings['remove_breaks'] ],
		  ]
	   );
   
        $animation = $settings['select_animation'] !== 'none' ?  $settings['select_animation'] : '';
        
        $this->add_render_attribute(
		'animation_attributes',
		  [
			 'data-animate' => 'true',
			 'data-animation' => [$animation],
			 'data-settings' => [$dataset],
		  ]
	   );
        
        $animationAttributes = $settings['select_animation'] !== 'none' ? $this->get_render_attribute_string('animation_attributes') :'';
        
        $text = 'dummy';
        $type = $settings['field_type'];
        
        global $wp_query;
        
		
		 $args = array(  
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'order' => 'ASC'
    	);

    $loop = new \WP_Query( $args ); 
    wp_reset_postdata(); 
		
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		
   	 while ( $loop->have_posts() ) : $loop->the_post();  
		
		$id = get_the_ID();
        
 		endwhile; wp_reset_query();

 		} else {
				
		$id = $wp_query->post->ID;
	}
		
        if ($type === 'title') {
            
            $text = get_the_title($id);
            
        } else if ($type === 'category') {
			
			       $text = get_the_category_list( esc_html__( ' ', 'pe-theme' ) );
		

            
        } else if ($type === 'author') {
			
			$text = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s', 'post author', 'pe-theme' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);


            
        } else if ($type === 'date') {
			
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$text = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'pe-theme' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
            
        } else if ($type === 'tags') {

			$text = get_the_tag_list( '', esc_html_x( '  ', '', 'pe-theme' ) );
			
            
        } else if ($type === 'content') {
            
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { 
				
			 $text = the_content($id);
				
			} else {
				
				$text = the_content($id);
				
			}

        };
		
		
		

?>

<div class="text-wrapper <?php echo esc_attr($settings['has_bg']) ?>">

	<p <?php echo $this->get_render_attribute_string('attributes') ?><?php echo $animationAttributes ?>> <?php echo $text; ?></p>

</div>

<?php 
    }

}
