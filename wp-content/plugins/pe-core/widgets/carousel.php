<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeCarousel extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'pecarousel';
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
    public function get_title()
    {
        return __('Carousel', 'pe-core');
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
    public function get_icon()
    {
        return 'eicon-slider-push pe-widget';
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
    public function get_categories()
    {
        return ['pe-content'];
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
    protected function _register_controls()
    {


        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Carousel Content', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'carousel_type',
            [
                'label' => esc_html__('Carousel Type', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'portfolio',
                'options' => [
                    'portfolio' => esc_html__('Projects', 'pe-core'),
                    'post' => esc_html__('Posts', 'pe-core'),
                    'product' => esc_html__('Products', 'pe-core'),
                    'images' => esc_html__('Images', 'pe-core'),
                ],

            ]
        );

        $portfolios = [];

        $projects = get_posts([
            'post_type' => 'portfolio',
            'numberposts' => -1
        ]);

        foreach ($projects as $project) {
            $portfolios[$project->ID] = $project->post_title;
        }

        $repeater = new \Elementor\Repeater();


        $repeater->add_control(
            'select_project',
            [
                'label' => __('Select Project', 'pe-core'),
                'label_block' => true,
                'description' => __('Select project which will display in the slider.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $portfolios,
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
                'label' => esc_html__('Custom Thumbnail', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'image' => esc_html__('Image', 'pe-core'),
                    'video' => esc_html__('Video', 'pe-core'),
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
                'label' => esc_html__('Video Provider', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vimeo',
                'options' => [
                    'self' => esc_html__('Self-Hosted', 'pe-core'),
                    'vimeo' => esc_html__('Vimeo', 'pe-core'),
                    'youtube' => esc_html__('YouTube', 'pe-core'),
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




        $this->add_control(
            'projects_list',
            [
                'label' => esc_html__('Projects', 'pe-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false,
                'condition' => ['carousel_type' => 'portfolio'],
            ]
        );


        $this->add_control(
            'cat',
            [
                'label' => esc_html__('Category', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => "true",
                'default' => "true",
                'condition' => ['carousel_type' => 'portfolio']
            ]
        );




        $this->add_control(
            'title_pos',
            [
                'label' => esc_html__('Title Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column-reverse' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'column',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} article' => 'flex-direction: {{VALUE}};',
                ],
                'condition' => ['carousel_type' => 'portfolio']
            ]
        );

        $this->add_control(
            'carousel_images',
            [
                'label' => esc_html__('Add Images', 'pe-core'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'show_label' => false,
                'default' => [],
                'condition' => ['carousel_type' => 'images'],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_settings',
            [
                'label' => esc_html__('Carousel Settings', 'pe-core'),
            ]
        );


        $this->add_control(
            'carousel_id',
            [
                'label' => esc_html__('Carousel ID', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('An id will required if the carousel controls from other widgets will be used.', 'pe-core'),
                'ai' => false,
            ]
        );


        $this->add_control(
            'carousel_behavior',
            [
                'label' => esc_html__('Carousel Behavior', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cr--drag',
                'options' => [
                    'cr--drag' => esc_html__('Drag', 'pe-core'),
                    'cr--scroll' => esc_html__('Scroll', 'pe-core'),
                ],
            ]
        );

        $this->add_control(
            'carousel_trigger',
            [
                'label' => esc_html__('Carousel Trigger', 'pe-core'),
                'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('Normally the carousel pin itself but in some cases, a custom trigger may required.', 'pe-core'),
                'ai' => false,
                'condition' => ['carousel_behavior' => 'cr--scroll'],
            ]
        );

        $this->add_control(
            'scroll_speed',
            [
                'label' => esc_html__('Speed', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 30000,
                'step' => 100,
                'condition' => [
                    'carousel_behavior' => 'cr--scroll'
                ]
            ]
        );

        $this->add_responsive_control(
            'items_width',
            [
                'label' => esc_html__('Items Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--wrapper' => '--itemsWidth: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_gapo',
            [
                'label' => esc_html__('Space Between Items', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_pos',
            [
                'label' => esc_html__('Items Position', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'pe-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .carousel--wrapper' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'equal_height',
            [
                'label' => esc_html__('Custom Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'pe-core'),
                'label_off' => esc_html__('No', 'pe-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .thmb' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'equal_height' => 'yes'
                ],
            ]
        );



        $this->end_controls_section();

        pe_cursor_settings($this);

        $this->start_controls_section(
            'section_animate',
            [
                'label' => __('Animations', 'pe-core'),
            ]
        );

        $this->add_control(
            'select_animation',
            [
                'label' => esc_html__('Select Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'description' => esc_html__('Will be used as intro animation.', 'textdomain'),
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'fadeIn' => esc_html__('Fade In', 'pe-core'),
                    'fadeUp' => esc_html__('Fade Up', 'pe-core'),
                    'fadeDown' => esc_html__('Fade Down', 'pe-core'),
                    'fadeLeft' => esc_html__('Fade Left', 'pe-core'),
                    'fadeRight' => esc_html__('Fade Right', 'pe-core'),
                    'slideUp' => esc_html__('Slide Up', 'pe-core'),
                    'slideLeft' => esc_html__('Slide Left', 'pe-core'),
                    'slideRight' => esc_html__('Slide Right', 'pe-core'),
                    'scaleUp' => esc_html__('Scale Up', 'pe-core'),
                    'scaleDown' => esc_html__('Scale Down', 'pe-core'),
                    'maskUp' => esc_html__('Mask Up', 'pe-core'),
                    'maskDown' => esc_html__('Mask Down', 'pe-core'),
                    'maskLeft' => esc_html__('Mask Left', 'pe-core'),
                    'maskRight' => esc_html__('Mask Right', 'pe-core'),

                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__('Animation Options', 'textdomain'),
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
                'label' => esc_html__('Basic', 'textdomain'),
            ]
        );

        $this->add_control(
            'duration',
            [
                'label' => esc_html__('Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'step' => 0.1,
                'default' => 1.5
            ]
        );

        $this->add_control(
            'delay',
            [
                'label' => esc_html__('Delay', 'pe-core'),
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
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'advanced_tab',
            [
                'label' => esc_html__('Advanced', 'textdomain'),
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
                'label' => esc_html__('Start Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
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
                'label' => esc_html__('End Offset', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
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


        $this->start_controls_section(
            'carousel_styles',
            [

                'label' => esc_html__('Carousel Styles', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title', 'pe-core'),
                'selector' => '{{WRAPPER}} .carousel--item .post-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cat_typography',
                'label' => esc_html__('Category', 'pe-core'),
                'selector' => '{{WRAPPER}} .post-categories',
            ]
        );

        $this->add_control(
            'cats_padding',
            [
                'label' => esc_html__('Category Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 0.5,
                    'right' => 1,
                    'bottom' => 0.5,
                    'left' => 1,
                    'unit' => 'em',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--item .post-meta .post-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'cats_radius',
            [
                'label' => esc_html__('Category Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel--item .post-meta .post-categories' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}'
                ]
            ]
        );


        $this->end_controls_section();

        pe_color_options($this);



    }

    protected function render()
    {
        $settings = $this->get_settings();
        $type = $settings['carousel_type'];
        $carouselClasses = [];


        $carouselId = $settings['carousel_id'] ? $settings['carousel_id'] : 'cr--' . $this->get_id();


        array_push($carouselClasses, [$carouselId, 'pe--carousel', 'cr--' . $settings['carousel_type'], $settings['carousel_behavior']]);
        $mainClasses = implode(' ', array_filter($carouselClasses[0]));

        if ($type === 'portfolio') {

            // Animations 
            $start = $settings['start_offset'] ? $settings['start_offset']['size'] : 0;
            $end = $settings['end_offset'] ? $settings['end_offset']['size'] : 0;
            $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';

            $dataset = '{' .
                'duration=' . $settings['duration'] . '' .
                ';delay=' . $settings['delay'] . '' .
                ';stagger=' . $settings['stagger'] . '' .
                ';pin=' . $settings['pin'] . '' .
                ';pinTarget=' . $settings['pin_target'] . '' .
                ';scrub=' . $settings['scrub'] . '' .
                ';markers=' . $settings['show_markers'] . '' .
                ';start=' . $start . '' .
                ';startpov=' . $settings['anim_start'] . '' .
                ';end=' . $end . '' .
                ';endpov=' . $settings['anim_end'] . '' .
                ';out=' . $out . '' .
                '}';

            $checkMarkers = '';

            if (\Elementor\Plugin::$instance->editor->is_edit_mode() && $settings['show_markers']) {
                $checkMarkers = ' markers-on';
            }


            $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

            //Scroll Button Attributes
            $this->add_render_attribute(
                'animation_settings',
                [
                    'data-anim-general' => 'true',
                    'data-animation' => $animation,
                    'data-settings' => $dataset,

                ]
            );

            $animationSettings = $settings['select_animation'] !== 'none' ? $this->get_render_attribute_string('animation_settings') : '';

            $speed = $settings['scroll_speed'];
            
            if (!$speed) {
                $speed = 5000;
            }

            $cursor = pe_cursor($this);

        }





        ?>

        <div class="<?php echo $mainClasses; ?>" data-trigger='<?php echo $settings['carousel_trigger'] ?>' data-speed="<?php echo $speed; ?>">

            <div class="carousel--wrapper anim-multiple" <?php echo $animationSettings; ?>>

                <?php if ($type === 'portfolio') {

                    foreach ($settings['projects_list'] as $key => $project) {

                        $id = $project['select_project'];
                        $category = $settings['cat'];

                        $classes = [];

                        $customThumb = $project['custom_thumb'] !== 'none' ? 'custom__thumb' : '';
                        $classes[] = 'pe--single--project psp--elementor ' . $customThumb . '';

                        if ($project['custom_thumb'] !== 'none') {

                            $custom = [
                                'type' => $project['custom_thumb'],
                                'provider' => $project['video_provider'],
                                'imageUrl' => $project['featured_image'],
                                'videoUrl' => $project['self_video'],
                                'videoId' => $project['video_id']
                            ];


                        } else {

                            $custom = false;
                        }

                        
                        ?>

                        <!-- Carusel Item -->
                        <div class="carousel--item inner--anim" data-index="<?php echo esc_attr($key) ?>">

                            <article id="post-<?php the_ID($id); ?>" <?php post_class($classes, $id); ?>                 <?php echo $cursor ?>>

                                <a class="barba--trigger" data-id="<?php echo esc_attr($id) ?>"
                                    href="<?php echo esc_url(get_permalink($id)) ?>" <?php echo $cursor ?>>
                                    <div class="thmb project__image__<?php echo $id ?>">

                                        <?php pe_project_image($id, $custom, true); ?>

                                    </div>

                                </a>

                                <?php if ($category) { ?>

                                    <!-- Meta -->
                                    <div class="post-meta">

                                        <?php if ($category) { ?>

                                            <div class="post-categories">
                                                <?php

                                                $terms = get_the_terms($id, 'project-categories');
                                                if ($terms) {

                                                    $term_names = array();

                                                    foreach ($terms as $term) {
                                                        $term_names[] = esc_html($term->name);
                                                    }

                                                    $cats = implode(', ', $term_names);
                                                    echo $cats;
                                                }

                                                ?>
                                            </div>

                                        <?php } ?>

                                    </div>
                                    <!--/ Meta -->

                                <?php } ?>


                                <!-- Post Details -->
                                <div class="post-details">

                                    <!-- Title -->
                                    <a href="<?php echo esc_url(get_permalink($id)) ?>" <?php echo $cursor ?>>

                                        <?php echo '<h6 class="post-title entry-title">' . get_the_title($id) . '</h6>'; ?>

                                    </a>
                                    <!--/ Title -->

                                </div>
                                <!--/ Post Details -->

                            </article>

                        </div>
                        <!--/ Carusel Item -->


                    <?php }
                } ?>

                <?php

                if ($type === 'images') {

                    foreach ($settings['carousel_images'] as $key => $image) {
                        $key++ ?>

                        <!-- Carusel Item -->
                        <div class="carousel--item" data-index="<?php echo esc_attr($key) ?>">

                            <div class="single-image"><img src="<?php echo esc_url($image['url']) ?>"></div>

                        </div>
                        <!--/ Carusel Item -->

                    <?php }
                } ?>

            </div>

        </div>

        <?php
    }

}
