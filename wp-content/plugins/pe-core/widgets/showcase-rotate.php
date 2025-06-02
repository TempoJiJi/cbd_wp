<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeShowcaseRotate extends Widget_Base
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
        return 'peshowcaserotate';
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
        return __('Pe Showcase Rotate', 'pe-core');
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
        return 'eicon-sync pe-widget';
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
        return ['pe-showcase'];
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
                'label' => __('Showcase', 'pe-core'),
            ]
        );

        $options = [];

        $projects = get_posts([
            'post_type' => 'portfolio',
            'numberposts' => -1
        ]);

        foreach ($projects as $project) {
            $options[$project->ID] = $project->post_title;
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


        $this->add_control(
            'project_hover',
            [
                'label' => esc_html__('Hover Animation', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'pe-core'),
                    'bulge' => esc_html__('Bulge', 'pe-core'),
                    'zoom' => esc_html__('Zoom', 'pe-core'),
                ],

            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'View Case'
            ]
        );


        $this->add_control(
            'rotate_speed',
            [
                'label' => esc_html__('Rotate Speed', 'pe-core'),
                'desc' => esc_html__('As it approaches 0, it speeds up. It stops at 0.', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['ms'],
                'range' => [
                    'ms' => [
                        'min' => -20,
                        'max' => 20,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'ms',
                    'size' => -20
                ],
            ]
        );


        $this->add_control(
            'intro_animate',
            [
                'label' => esc_html__('Intro', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'intro--on'
            ]
        );

        $this->add_control(
            'intro_duration',
            [
                'label' => esc_html__('Intro Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'step' => 0.1,
                'default' => 2,
                'condition' => [
                    'intro_animate' => 'intro--on'
                ]
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'switcher_section',
            [
                'label' => __('Switcher', 'pe-core'),
            ]
        );

        $this->add_control(
            'switcher',
            [
                'label' => esc_html__('Switcher', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'switcher_left_text',
            [
                'label' => esc_html__('Left', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Scroll',
                'condition' => [
                    'switcher' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'switcher_right_text',
            [
                'label' => esc_html__('Right', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Explore',
                'condition' => [
                    'switcher' => 'yes'
                ]
            ]
        );




        $this->end_controls_section();

        pe_cursor_settings($this);

        $this->start_controls_section(
            'content_styles',
            [
                'label' => esc_html__('Content', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-rotate .showcase-project .meta-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_project_tab',
            [
                'label' => esc_html__('Meta', 'pe-core'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-rotate .project-wrap .project-title'
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_category_typography',
                'label' => esc_html__('Category Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-rotate .project-wrap .project-category'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-rotate .project-wrap .project-excerpt'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_button_typography',
                'label' => esc_html__('Button Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-rotate .project-wrap a'
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'pe-core')
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'hover_title_typography',
                'label' => esc_html__('Tıtle Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-rotate .hover-wrapper .project-title'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'hover_category_typography',
                'label' => esc_html__('Category Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-rotate .hover-wrapper .project-category'
            ]
        );





        $this->end_controls_tab();



        $this->end_controls_tabs();




        $this->end_controls_section();


        $this->start_controls_section(
            'switcher_style',
            [

                'label' => esc_html__('Switcher', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'switcher_style_tabs'
        );

        $this->start_controls_tab(
            'style_active_tab',
            [
                'label' => esc_html__('Active', 'pe-core')
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'switcher_typography',
                'label' => esc_html__('Switcher Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-rotate .switch-item'
            ]
        );


        $this->add_control(
            'active_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-rotate .lsc-switcher .switch-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'active_padding',
            [
                'label' => esc_html__('Active Space', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-rotate .lsc-switcher .switch-item' => 'padding: {{SIZE}}{{UNIT}}'
                ]
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__('Normal', 'pe-core')
            ]
        );


        $this->add_control(
            'switcher_space',
            [
                'label' => esc_html__('Out Space', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-rotate .lsc-switcher' => 'padding: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'out_radius',
            [
                'label' => esc_html__('Out Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-rotate .lsc-switcher' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );


        $this->end_controls_tab();


        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'sizes',
            [

                'label' => esc_html__('Sizes', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vw', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 1
                    ],
                    'vw' => [
                        'min' => 5,
                        'max' => 30,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-rotate .project-wrap' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 1
                    ],
                    'vh' => [
                        'min' => 5,
                        'max' => 50,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 25,
                        'step' => 1
                    ]
                ],

                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-rotate .showcase-project' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-rotate .showcase-project .project-image, {{WRAPPER}} .leksa-showcase-rotate .showcase-project .project-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );



        $this->end_controls_section();

        pe_color_options($this);

    }

    protected function render()
    {
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
        $hover = $settings['project_hover'];

        ?>
        <div class="leksa-showcase-rotate style-scroll <?php echo $settings['intro_animate']; ?>"
            data-intro="<?php echo $settings['intro_duration'] ?>" data-rotate-speed="<?php echo $settings['rotate_speed']['size'] ?>">



            <div class="lsc-wrapper image-wrapper">

                <?php foreach ($settings['project_repeater'] as $item) { ?>

                    <div class="showcase-project needs--handle">

                        <div class="project-wrap">

                            <div class="project-image project__image__<?php echo $item['select_project'] ?> <?php echo $hover ?>">
                            <a href="<?php echo get_the_permalink($item['select_project']); ?>"
                                                class="barba--trigger" <?php echo $cursor ?>
                                                data-id="<?php echo $item['select_project'] ?>">


                                <?php pe_project_image($item['select_project'], $custom, false); ?>
                                </a>
                            </div>

                            <div class="project-meta">

                                <div class="meta-inner">

                                    <div class="sr--met--top">
                                        <div class="project-title text-h5">
                                                      <a href="<?php echo get_the_permalink($item['select_project']); ?>"
                                                class="barba--trigger" <?php echo $cursor ?>
                                                data-id="<?php echo $item['select_project'] ?>">

  

                                            <?php if ($item['custom_title']) {

                                                echo $item['custom_title'];
                                            } else {

                                                echo get_the_title($item['select_project']);
                                            } ?>
 </a>
                                        </div>

                                        <div class="project-category">

                                            <?php
                                            if ($item['custom_category']) {
                                                echo $item['custom_category'];
                                            } else {
                                                $terms = get_the_terms($item['select_project'], 'project-categories');

                                                if ($terms) {

                                                    foreach ($terms as $term) {

                                                        echo esc_html($term->name);

                                                    }
                                                }
                                            }

                                            ?>
                                        </div>

                                    </div>

                                    <div class="sr--met--bott">

                                        <div class="project-excerpt">

                                            <?php if ($item['custom_meta']) {

                                                echo $item['custom_meta'];
                                            } else {

                                                echo get_field('excerpt', $item['select_project']);
                                            } ?>

                                        </div>

                                        <div class="project-button">

                                            <a href="<?php echo get_the_permalink($item['select_project']); ?>"
                                                class="barba--trigger" <?php echo $cursor ?>
                                                data-id="<?php echo $item['select_project'] ?>">

                                                <i aria-hidden="true" class="material-icons md-arrow_outward" data-md-icon="arrow_outward"></i>

                                            </a>

                                        </div>



                                    </div>


                                </div>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>



            <div class="lsc-controls">

                <div class="lsc-switcher">

                    <span class="switch-item style-scroll active">
                        <?php echo $settings['switcher_left_text']; ?>

                    </span>
                    <span class="switch-item style-explore">

                        <?php echo $settings['switcher_right_text']; ?>

                    </span>

                    <span class="switch-bg"></span>

                </div>


            </div>



        </div>


    <?php }



}
