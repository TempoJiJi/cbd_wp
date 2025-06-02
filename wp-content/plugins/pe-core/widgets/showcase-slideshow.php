<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeShowcaseSlideshow extends Widget_Base {
    
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
    return 'peshowcaseslideshow';
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
    return __( 'Pe Showcase Slideshow', 'pe-core' );
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
    return 'eicon-post-slider pe-widget';
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
    return [ 'pe-showcase' ];
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
       
        $this->start_controls_section(
            'section_project_title',
            [
                'label' => __( 'Showcase', 'pe-core' ),
            ]
        );
       
       $options = [];

        $projects = get_posts( [
            'post_type'  => 'portfolio',
            'numberposts' => -1
        ] );

        foreach ( $projects as $project ) {
            $options[ $project->ID ] = $project->post_title;
        }
       
       $repeater = new \Elementor\Repeater();
       
       $repeater->add_control(
        'select_project',
           [
               'label' => esc_html__('Select Project', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SELECT,
               'label_block' => true,
               'options' => $options
           ]
       );
       

       $repeater->add_control(
			'custom_thumb_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>If you apply custom thumbnail for the project, the special page transition animations for this project will no longer work, The default page transition will be triggered.</span></div>',
                 'condition' => ['custom_thumb!' => 'none'],
			]
		);
       
       
       $repeater->add_control(
			'custom_thumb',
			[
				'label' => esc_html__( 'Custom Thumbnail', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'pe-core' ),
					'image' => esc_html__( 'Image', 'pe-core' ),
					'video' => esc_html__( 'Video', 'pe-core' ),
				],

			]
		);
       
       $repeater->add_control(
        'featured_image',
           [    
                'label' => esc_html__('Featured Image', 'pe-core'),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'default' => [
                   'url' => \Elementor\Utils::get_placeholder_image_src(),
               ],
                'condition' => [
                    'custom_thumb' => 'image',
                ]
           ]
       );
       
       $repeater->add_control(
			'video_provider',
			[
				'label' => esc_html__( 'Video Provider', 'pe-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'vimeo',
				'options' => [
					'self' => esc_html__( 'Self-Hosted', 'pe-core' ),
					'vimeo' => esc_html__( 'Vimeo', 'pe-core' ),
					'youtube' => esc_html__( 'YouTube', 'pe-core' ),
				],
                'condition' => [
                    'custom_thumb' => 'video',
                ]
			]
		);
       
       $repeater->add_control(
            'video_id',
           [
               'label' => esc_html__('Video ID', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'ai' => false,
                'condition' => [
                    'video_provider!' => 'self',
                    'custom_thumb' => 'video',
                ],
           ]
        );
       
       $repeater->add_control(
        'self_video',
           [    
                'label' => esc_html__('Self-Hosted Video', 'pe-core'),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'media_types' => ['video'],
               'default' => [
                   'url' => \Elementor\Utils::get_placeholder_image_src(),
               ],
                'condition' => [
                    'video_provider' => 'self',
                    'custom_thumb' => 'video',
                ]
           ]
       );
       
       $repeater->add_control(
        'custom_title',
           [
               'label' => esc_html__('Custom Title', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
           ]
       );
       
       $repeater->add_control(
        'custom_category',
           [
               'label' => esc_html__('Custom Category', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT
           ]
       );
       
       $repeater->add_control(
        'custom_meta',
           [
               'label' => esc_html__('Custom Meta', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXTAREA,
               'rows' => 4
           ]
       );
       
       
       
       $this->add_control(
        'project_repeater',
           [
               'type' => \Elementor\Controls_Manager::REPEATER,
               'fields' => $repeater->get_controls()
           ]
       );

       
//       $this->add_control(
//        'button_text',
//           [
//               'label' => esc_html__('Button Text', 'pe-core'),
//               'type' => \Elementor\Controls_Manager::TEXT,
//               'default' => esc_html__('View Case', 'pe-core'),
//           ]
//       );


       
       $this->add_control(
        'animate_speed',
           [
               'label' => esc_html__('Speed', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 3000,
               'max' => 30000,
               'step' => 100,
               'default' => 7500
           ]
       );
              
       $this->add_control(
        'direction',
           [
               'label' => esc_html__('Direction', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SELECT,
               'options' => [
                   'vertical' => esc_html__('Vertical', 'pe-core'),
                   'horizontal' => esc_html__('Horizontal', 'pe-core')
               ],
               'default' => 'horizontal'
           ]
       );

       
       $this->end_controls_section();
       
       $this->start_controls_section(
        'button_settings',
           [
               'label' => esc_html__('Button', 'pe-core')
           ]
       );
       
       pe_button_settings($this);
       
       $this->end_controls_section();
       
       
       

        $this->start_controls_section(
            'nav_settings',
            [
                'label' => __( 'Navigation', 'pe-core' ),
            ]
        );
       
       
       
       $this->add_control(
           'navigation',
           [
               'label' => esc_html__('Navigation', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SWITCHER,
               'return_value' => 'yes'
           ]
       );
       
       $this->add_control(
        'navigate_type',
           [
               'label' => esc_html__('Navigation Type', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SELECT,
               'options' => [
                   'text' => esc_html__('Text', 'pe-core'),
                   'icon' => esc_html__('Icon', 'pe-core')
               ],
               'default' => 'text',
               'condition' => [
                   'navigation' => 'yes'
               ]
           ]
       );
       
       $this->add_control(
        'prev_text',
           [
               'label' => esc_html__('Prev Text', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => 'Prev',
               'condition' => [
                   'navigation' => 'yes',
                   'navigate_type' => 'text'
               ]
           ]
       );
       
       $this->add_control(
        'next_text',
           [
               'label' => esc_html__('Next Text', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => 'Next',
               'condition' => [
                   'navigation' => 'yes',
                   'navigate_type' => 'text'
               ]
           ]
       );
       
       $this->add_control(
        'prev_icon',
           [
               'label' => esc_html__('Prev Icon', 'pe-core'),
               'type' => \Elementor\Controls_Manager::ICONS,
               'condition' => [
                   'navigation' => 'yes',
                   'navigate_type' => 'icon'
               ]
           ]
       );
       
       $this->add_control(
        'next_icon',
           [
               'label' => esc_html__('Next Icon', 'pe-core'),
               'type' => \Elementor\Controls_Manager::ICONS,
               'condition' => [
                   'navigation' => 'yes',
                   'navigate_type' => 'icon'
               ]
           ]
       );
       
       $this->end_controls_section();
       
       pe_cursor_settings($this);
       
       $this->start_controls_section(
			'style',
			[                
				'label' => esc_html__( 'Styling', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'title_typography',
               'label' => esc_html__('Title Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .leksa-showcase-slideshow .project-title'
           ]
       );

       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'cats_typography',
               'label' => esc_html__('Category Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .leksa-showcase-slideshow .project-category'
           ]
       );

       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'content_typography',
               'label' => esc_html__('Content Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .leksa-showcase-slideshow .project-excerpt'
           ]
       );

       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'nav_typography',
               'label' => esc_html__('Navigation Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .leksa-showcase-slideshow .showcase-footer .slides-nav .text-p',
               'condition' => [
                   'navigate_type' => 'text'
               ],
           ]
       );

       $this->add_control(
        'nav_icon_size',
           [
               'label' => esc_html__('Navigate Icon Size', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'size_units' => ['px'],
               'range' => [
                   'px' => [
                       'min' => 0,
                       'max' => 100,
                       'step' => 1
                   ]
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-showcase-slideshow .showcase-footer .slides-nav .text-p i' => 'font-size: {{SIZE}}{{UNIT}}',
                   '{{WRAPPER}} .leksa-showcase-slideshow .showcase-footer .slides-nav .text-p svg' => 'width: {{SIZE}}{{UNIT}}',
               ],
               'condition' => [
                   'navigate_type' => 'icon'
               ]
           ]
       );
         
       $this->add_control(
        'style_divider_4',
           [
               'type' => \Elementor\Controls_Manager::DIVIDER
           ]
       );
       
       $this->add_responsive_control(
        'meta_padding',
           [
               'label' => esc_html__('Meta Padding', 'pe-core'),
               'type' => \Elementor\Controls_Manager::DIMENSIONS,
               'size_units' => ['px', '%'],
               'default' => [
                   'unit' => 'px',
                   'isLinked' => true
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-showcase-slideshow .lss-projects-wrapper .showcase-project .project-meta '=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
               ]
           ]
       );

       $this->add_responsive_control(
        'meta_border_radius',
           [
               'label' => esc_html__('Meta Border Radius', 'pe-core'),
               'type' => \Elementor\Controls_Manager::DIMENSIONS,
               'default' => [
                   'unit' => 'px',
                   'isLinked' => true
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-showcase-slideshow .lss-projects-wrapper .showcase-project .project-meta '=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
               ]
           ]
       );

       
       $this->add_control(
        'style_divider_5',
           [
               'type' => \Elementor\Controls_Manager::DIVIDER
           ]
       );
       
       $this->add_responsive_control(
        'meta_width',
           [
               'label' => esc_html__('Meta Width', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'size_units' => ['px', 'vw', '%'],
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
               'selectors' => [
                   '{{WRAPPER}} .leksa-showcase-slideshow .project-meta' => 'width: {{SIZE}}{{UNIT}}'
               ]
           ]
       );
       
       $this->add_responsive_control(
        'meta_height',
           [
               'label' => esc_html__('Meta Height', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'size_units' => ['px', 'vh', '%'],
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
               'selectors' => [
                   '{{WRAPPER}} .leksa-showcase-slideshow .project-meta' => 'min-height: {{SIZE}}{{UNIT}}'
               ]
           ]
       );
    
       
		$this->end_controls_section();
    
       
pe_button_style_settings($this, 'Button');
       
       
       
       
       $this->start_controls_section(
			'image_styles',
			[
                
				'label' => esc_html__( 'Controls', 'pe-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
       
       $this->start_controls_tabs(
           'style_tabs'
       );
       
       $this->start_controls_tab(
           'style_normal_tab',
           [
               'label' => esc_html__( 'Number', 'textdomain' ),
           ]
       );
       
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'fraction_number_typography',
               'label' => esc_html__('Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .leksa-showcase-slideshow .f-number',
           ]
       );

       $this->add_responsive_control(
        'fn_padding',
           [
               'label' => esc_html__('Padding', 'pe-core'),
               'type' => \Elementor\Controls_Manager::DIMENSIONS,
               'size_units' => ['px', '%'],
               'default' => [
                   'unit' => 'px',
                   'isLinked' => true
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-showcase-slideshow .fn-item '=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
               ]
           ]
       );

           
           

       $this->end_controls_tab();
       
       $this->start_controls_tab(
           'style_nav_tab',
           [
               'label' => esc_html__( 'Navigate', 'textdomain' ),
           ]
       );
       

       
       
       $this->add_responsive_control(
        'fb_padding',
           [
               'label' => esc_html__('Padding', 'pe-core'),
               'type' => \Elementor\Controls_Manager::DIMENSIONS,
               'size_units' => ['px', '%'],
               'default' => [
                   'unit' => 'px',
                   'isLinked' => true
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-showcase-slideshow .fb-item '=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
               ]
           ]
       );
           
           

       $this->end_controls_tab();

       $this->end_controls_tabs();

       $this->end_controls_section();
       
       

       pe_color_options($this);
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
             if ((isset($_GET['offset']))) {
        
        $offset = $_GET['offset'];
        
    } else {
         $offset = 0;
     } 
        
        
        $classes = [];
        
        array_push($classes , [$settings['background'] , $settings['bordered'] , $settings['underlined'] , $settings['marquee'] , $settings['show_icon'] , $settings['icon_position'] , $settings['button_size'] , $settings['advanced_colors']]);
        $mainClasses = implode(' ' , array_filter($classes[0]));
        
        ob_start();

        \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );

        $icon = ob_get_clean();
        
        $buttonText = $settings['button_text'];
            
        $buttonHTML = ($settings['icon_position'] === 'icon__left' ? $icon : '')  . $buttonText . ($settings['icon_position'] === 'icon__right' ? $icon :'') ;
        
        
      
   $args = array(  
        'post_type' => 'portfolio',
        'post_status' => 'publish',
         'tax_query' => array(
        array(
             'taxonomy' => 'project-categories', 
            'field' => 'term_id',           
        )
    )
    );
        
        foreach ($settings['project_repeater'] as $item) {
            
                if ($item['custom_thumb'] !== 'none') {
            
            $custom = [
                'type' => $item['custom_thumb'],
                'provider' => $item['video_provider'],
                'imageUrl' => $item['featured_image'],
                'videoUrl' => $item['self_video'],
                'videoId' => $item['video_id']
            ];
            
            
        } else {
            
            $custom = false;
        }
            
        }
        
        $cursor = pe_cursor($this);
        
        ?>

<div class="leksa-showcase-slideshow <?php echo $settings['direction'] ?>" data-speed="<?php echo $settings['animate_speed'] ?>">

    <div class="lss-fraction">
        <span class="lss-current">01</span>
        <span class="lss-total">05</span>
    </div>

    <div class="lss-projects-wrapper">

        <?php foreach ($settings['project_repeater'] as $item ) { ?>

        <div class="showcase-project">

            <div class="project-image project__image__<?php echo $item['select_project'] ?>">

                <?php pe_project_image($item['select_project'] , $custom , false); ?>

            </div>

            <div class="project-meta">

                <div class="project-title no-margin">
                    <?php if ($item['custom_title']) {

                            echo $item['custom_title']; } else { 
                
                            echo get_the_title($item['select_project']);  } ?>

                </div>




                <div class="project-button">

                    <div class="pe--button <?php echo esc_attr($mainClasses); ?> ">
                        
                        <div class="pe--button--wrapper">

                        <a href="<?php echo get_the_permalink($item['select_project']); ?>" class='barba--trigger' <?php echo $cursor ?> data-id="<?php echo $item['select_project']; ?>">

                            <span class="pb__main"><?php echo $buttonHTML ?>

                                <?php if ($settings['underlined'] !== 'pb--underlined') {
                    if($settings['background'] === 'pb--background' || $settings['bordered'] === 'pb--bordered') {
                ?>


                                <span class="pb__hover"><?php echo $buttonHTML ?></span>

                                <?php } } ?>

                            </span>
                            
                            <?php if ($settings['marquee'] === 'pb--marquee') { ?>

			<div class="pb--marquee--wrap <?php echo $settings['marquee_direction'] ?>" aria-hidden="true">
				<div class="pb--marquee__inner">
					<span><?php echo $buttonHTML ?></span>
					<span><?php echo $buttonHTML ?></span>
					<span><?php echo $buttonHTML ?></span>
					<span><?php echo $buttonHTML ?></span>
				</div>
			</div>

			<?php } ?>


           



                        </a>
                            
                            </div>

                    </div>

                </div>

            </div>


        </div>

        <?php } ?>





    </div>

    <!-- Image Slider -->
    <div class="fc-images-slider swiper-container">

        <div class="swiper-wrapper"></div>

    </div>
    <!--/ Image Slider -->

    <div class="showcase-footer wrapper-full">

        <div class="showcase-footer-left">
            <?php if ($settings['navigation'] === 'yes') { ?>

            <div class="slides-nav">

                <div class="slide-prev text-p">

                    <?php if ($settings['navigate_type'] === 'text') {
            echo $settings['prev_text'];
        } else if ($settings['navigate_type'] === 'icon') {
            \Elementor\Icons_Manager::render_icon( $settings['prev_icon']);
        } ?>


                </div>
                <div class="slide-next text-p">
                    <?php if ($settings['navigate_type'] === 'text') {
            echo $settings['next_text'];
        } else if ($settings['navigate_type'] === 'icon') {
            \Elementor\Icons_Manager::render_icon( $settings['next_icon']);
        } ?>


                </div>

            </div>



            <?php } ?>



        </div>

        <div class="showcase-footer-right c-col-4 sm-12 no-margin">

            <div class="fss-categories">

                <?php foreach ($settings['project_repeater'] as $item) { ?>

                <div class="project-category">

                    <?php
                       if ($item['custom_category']) {
                           echo $item['custom_category'];
                       } else { 
                        $terms = get_the_terms( $item['select_project'], 'project-categories');

                        if ($terms) {

                        foreach($terms as $term) {

                        echo esc_html($term->name);

                        } }                                        
                       }
                        
                        ?>

                </div>


                <?php } ?>

            </div>

        </div>


    </div>



</div>


<?php }



    }
