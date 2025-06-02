<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeShowcaseCarousel extends Widget_Base
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
        return 'peshowcasecarousel';
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
        return __('Pe Showcase Carousel', 'pe-core');
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
        return 'eicon-posts-carousel pe-widget';
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
            'divider_0',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'default_view',
            [
                'label' => esc_html__('Default View', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'wide' => esc_html__('Wide', 'pe-core'),
                    'narrow' => esc_html__('Narrow', 'pe-core')
                ],
                'default' => 'narrow'
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
            'divider_1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'scroll_speed',
            [
                'label' => esc_html__('Scroll', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 5000,
                'max' => 30000,
                'step' => 100,
                'default' => 10000
            ]
        );

        $this->add_control(
            'image_duration',
            [
                'label' => esc_html__('Image Hover', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 5,
                'step' => 0.1,
                'default' => 1,
            ]
        );

        $this->add_control(
            'text_duration',
            [
                'label' => esc_html__('Text Hover', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 5,
                'step' => 0.1,
                'default' => 0.5,
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .lsc-image-wrap .project-image .project-title' => 'transition: all {{VALUE}}s ease',
                    '{{WRAPPER}} .leksa-showcase-carousel .project-meta' => 'transition: opacity {{VALUE}}s ease'
                ]
            ]
        );

        $this->add_control(
            'switch_duration',
            [
                'label' => esc_html__('Switch', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 5,
                'step' => 0.1,
                'default' => 0.5,
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .project-image' => 'transition: width {{VALUE}}s ease',
                    '{{WRAPPER}} .leksa-showcase-carousel .lsc-title-wrap' => 'transition: opacity {{VALUE}}s ease'
                ]
            ]
        );

        $this->add_control(
            'progressbar_line',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'progressbar',
            [
                'label' => esc_html__('Progressbar', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'progress_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .lsc-progressbar' => 'width: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'progressbar' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'switcher_advanced',
            [
                'label' => esc_html__('Switcher', 'pe-core')
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
            'switcher_wide_text',
            [
                'label' => esc_html__('Left', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Wide',
                'condition' => [
                    'switcher' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'switcher_narrow_text',
            [
                'label' => esc_html__('Right', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Narrow',
                'condition' => [
                    'switcher' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        pe_cursor_settings($this);
        pe_general_animation_settings($this);

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Image', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 5
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .project-image' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );



        $this->add_responsive_control(
            'wide_width',
            [
                'label' => esc_html__('Wide Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                //               'description' => 'The value of "Wide Width" should be greater than the value of "Narrow Width".',
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 5
                    ],
                ],
                'default' => [
                    'size' => 800,
                    'unit' => 'px'
                ]
            ]
        );


        $this->add_responsive_control(
            'narrow_width',
            [
                'label' => esc_html__('Narrow Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 5
                    ],
                ],
                'default' => [
                    'size' => 400,
                    'unit' => 'px'
                ]
            ]
        );


        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Image Space', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .project-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .project-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'content_options',
            [

                'label' => esc_html__('Content', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'style_divider_0',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'narrow_title_typography',
                'label' => esc_html__('Narrow Title', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-carousel.narrow .project-title'
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'wide_title_typography',
                'label' => esc_html__('Wide Title', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-carousel.wide .project-title'
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cat_typography',
                'label' => esc_html__('Category', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-carousel .project-category'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'year_typography',
                'label' => esc_html__('Year', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-showcase-carousel .project-date'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'switcher_style',
            [

                'label' => esc_html__('Switcher', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
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
                'selector' => '{{WRAPPER}} .leksa-showcase-carousel .switch-item'
            ]
        );




        $this->add_control(
            'active_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 40,
                    'right' => 40,
                    'bottom' => 40,
                    'left' => 40,
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .switch-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
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
                'default' => [
                    'unit' => 'px',
                    'size' => 20
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .switch-item' => 'padding: {{SIZE}}{{UNIT}}'
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
                'default' => [
                    'unit' => 'px',
                    'size' => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .lsc-switcher' => 'padding: {{SIZE}}{{UNIT}}'
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
                    'top' => 40,
                    'right' => 40,
                    'bottom' => 40,
                    'left' => 40,
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-showcase-carousel .lsc-switcher' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );


        $this->end_controls_tab();


        $this->end_controls_tabs();

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
                    'field' => 'term_id'
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

        <div <?php echo pe_general_animation($this) ?>
            class="leksa-showcase-carousel anim-multiple <?php echo $settings['default_view'] ?> light"
            data-speed="<?php echo $settings['scroll_speed']; ?>"
            data-image-duration="<?php echo $settings['image_duration']; ?>"
            data-switch-duration="<?php echo $settings['switch_duration'] ?>"
            style="--narrowWidth: <?php echo $settings['narrow_width']['size']; ?>px; --wideWidth:<?php echo $settings['wide_width']['size']; ?>px">

            <div class="lsc-wrapper">

                <div class="lsc-image-wrap">

                    <div class="images-wrapper">

                        <?php foreach ($settings['project_repeater'] as $item) { ?>
                            <div class="showcase-project needs--handle">
                                <a class="barba--trigger" href="<?php echo get_the_permalink($item['select_project']); ?>" <?php echo $cursor ?> data-id="<?php echo $item['select_project']; ?>">
                                    <div
                                        class="inner--anim project-image project__image__<?php echo $item['select_project']; ?> <?php echo $hover ?>">
                                        <div class="parallax--wrap">

                                            <?php pe_project_image($item['select_project'], $custom, false); ?>
                                        </div>
                                    </div>

                                </a>

                                <div class="project-meta--inner">


                                    <div class="project-title text-h5">

                                        <?php echo get_the_title($item['select_project']); ?>


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

                            </div>

                        <?php } ?>
                    </div>

                </div>



            </div>

            <div class="lsc-footer wrapper">

                <div class="lsc-footer-left">

                    <div class="project-meta-wrap">

                        <?php foreach ($settings['project_repeater'] as $item) { ?>

                            <div class="project-meta">

                                <div class="project-title text-h5">

                                    <?php echo get_the_title($item['select_project']); ?>


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

                        <?php } ?>

                    </div>

                    <?php if ($settings['progressbar'] === 'yes') { ?>

                        <div class="lsc-progressbar">

                            <div class="progress-line active-line"></div>
                            <div class="progress-line bg-line"></div>

                        </div>



                    <?php } ?>



                </div>

                <div class="lsc-footer-right">

                    <?php if ($settings['switcher'] === 'yes') { ?>

                        <div class="lsc-switcher">

                            <span class="switch-item style-wide">
                                <?php echo $settings['switcher_wide_text']; ?>
                            </span>

                            <span class="switch-item style-narrow">
                                <?php echo $settings['switcher_narrow_text']; ?>
                            </span>

                            <span class="switch-bg"></span>

                        </div>

                    <?php } ?>




                </div>

            </div>



        </div>


    <?php }



}
