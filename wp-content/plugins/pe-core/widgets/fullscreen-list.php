<?php
namespace PeElementor\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class PeFullscreenList extends Widget_Base {
    
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
    return 'pefullscreenlist';
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
    return __( 'Pe Fullscreen List', 'pe-core' );
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
    return 'eicon-bullet-list pe-widget';
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
        'custom_date',
           [
               'label' => esc_html__('Custom Date', 'pe-core'),
               'type' => \Elementor\Controls_Manager::TEXT
           ]
       );
       
       $this->add_control(
        'project_repeater',
           [
               'type' => \Elementor\Controls_Manager::REPEATER,
               'fields' => $repeater->get_controls()
           ]
       );
       
       $this->add_control(
        'speed',
           [
               'label' => esc_html__('Animate Speed', 'pe-core'),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 3000,
               'max' => 20000,
               'step' => 100,
               'default' => 6000
           ]
       );

       
       
       
       $this->end_controls_section();

       pe_cursor_settings($this);
       pe_text_animation_settings($this);
       
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
               'name' => 'title_typography',
               'label' => esc_html__('Title Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .leksa-fullscreen-list .project-title'
           ]
       );

              $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'cats_typography',
               'label' => esc_html__('Category Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .leksa-fullscreen-list .project-category'
           ]
       );
       
              
       $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
           [
               'name' => 'date_typography',
               'label' => esc_html__('Date Typography', 'pe-core'),
               'selector' => '{{WRAPPER}} .leksa-fullscreen-list .project-date'
           ]
       );
       
       $this->add_responsive_control(
            'image_width',
           [
               'label' => esc_html__('Width', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'size_units' => ['px', '%'],
               'range' => [
                   'px' => [
                       'min' => 50,
                       'max' => 750,
                       'step' => 1,
                   ],
                   '%' => [
                       'min' => 10,
                       'max' => 100,
                       'step' => 1
                   ]
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-fullscreen-list .showcase-project' => 'width: {{SIZE}}{{UNIT}}'
               ]
           ]
       );
       
       $this->add_control(
        'equal_height',
           [
               'label' => esc_html__('Equal Height', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SWITCHER,
               'return_value' => 'equal_height',
           ]
       );
       
       $this->add_responsive_control(
        'image_height',
           [
               'label' => esc_html__('Height', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'size_units' => ['px', '%', 'vh'],
               'range' => [
                   'px' => [
                       'min' => 100,
                       'max' => 1000,
                       'step' => 1
                   ],
                   '%' => [
                       'min' => 10,
                       'max' => 100,
                       'step' => 1
                   ],
                   'vh' => [
                       'min' => 10,
                       'max' => 100,
                       'step' => 1
                   ]
               ],
               'condition' => [
                   'equal_height' => 'equal_height'
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-fullscreen-list.equal_height .showcase-project .project-image' => 'height: {{SIZE}}{{UNIT}}'
               ]
           ]
       );
       
       $this->add_control(
        'image_border_radius',
           [
               'label' => esc_html__('Border Radius', 'pe-core'),
               'type' => \Elementor\Controls_Manager::DIMENSIONS,
               'size_units' => ['px', '%'],
               'default' => [
                   'unit' => 'px',
                   'isLinked' => true,
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-fullscreen-list .project-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
               ]
           ]
       );
       
       $this->add_control(
        'image_top_offset',
           [
               'label' => esc_html__('Image Top Offset', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'size_units' => ['px', '%'],
               'range' => [
                   'px' => [
                       'min' => 0,
                       'max' => 1000,
                       'step' => 1,
                   ],
                   '%' => [
                       'min' => 0,
                       'max' => 100,
                       'step' => 1
                   ]
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-fullscreen-list .lfs-secondary-wrap .showcase-project' => 'top: {{SIZE}}{{UNIT}}'
               ]
           ]
       );
       
       $this->add_control(
        'image_right_offset',
           [
               'label' => esc_html__('Image Right Offset', 'pe-core'),
               'type' => \Elementor\Controls_Manager::SLIDER,
               'size_units' => ['px', '%'],
               'range' => [
                   'px' => [
                       'min' => 0,
                       'max' => 1000,
                       'step' => 1,
                   ],
                   '%' => [
                       'min' => 0,
                       'max' => 100,
                       'step' => 1
                   ]
               ],
               'selectors' => [
                   '{{WRAPPER}} .leksa-fullscreen-list .lfs-secondary-wrap .showcase-project' => 'right: {{SIZE}}{{UNIT}}'
               ]
           ]
       );


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
        $animation =  pe_text_animation($this);
        
        ?>



<div class="leksa-fullscreen-list infinity_list <?php echo $settings['equal_height']; ?>" data-speed="<?php echo $settings['speed']; ?>">


    <div class="lfs-main-wrap" <?php echo $animation ?> >

        <?php foreach ($settings['project_repeater'] as $item) { ?>

        <div class="project-title text-h1" >

            <a class="barba--trigger" href="<?php echo esc_url(get_the_permalink($item['select_project'])); ?>" <?php echo $cursor ?> data-id="<?php echo $item['select_project'] ?>">

                <?php if ($item['custom_title']) {

        echo $item['custom_title']; } else { 
                
        echo get_the_title($item['select_project']);  } ?>

            </a>
        </div>

        <?php } ?>


    </div>

    <div class="lfs-secondary-wrap">

        <?php foreach ($settings['project_repeater'] as $item) { ?>

        <div class="showcase-project">

            <div class="project-image project__image__<?php echo $item['select_project']; ?>">

               <?php pe_project_image($item['select_project'] , $custom , true); ?>
                
            </div>

            <div class="project-meta">

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
                <div class="project-date">

                    <?php if ($item['custom_date']) { 
                        
                        echo $item['custom_date'];
                        
                        } else { 
                        
                            echo get_field('date' , $item['select_project']);
                            
                        } ?>

                </div>

            </div>


        </div>


        <?php } ?>


    </div>


</div>

<?php }



    }
