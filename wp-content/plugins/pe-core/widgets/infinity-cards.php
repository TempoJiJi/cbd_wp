<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class peInfiniteCards extends Widget_Base
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
        return 'peinfinitecards';
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
        return __('Pe Infinite Cards', 'pe-core');
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
        return 'eicon-posts-group pe-widget';
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
            'repeater_divider_1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
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
            'repeater_divider_2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );

        $repeater->add_control(
            'custom_title',
            [
                'label' => esc_html__('Custom Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes'
            ]
        );

        $repeater->add_control(
            'custom_title_text',
            [
                'label' => esc_html__('Custom Title', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'custom_title' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'repeater_divider_3',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
            ]
        );



        $this->add_control(
            'project_repeater',
            [
                'label' => esc_html__('Projects', 'pe-core'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false
            ]
        );

        $this->add_control(
            'vertical_class',
            [
                'label' => esc_html__('Vertical Class', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'horizontal_class',
            [
                'label' => esc_html__('Horizontal Class', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
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




        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Text Typography', 'pe-core'),
                'condition' => [
                    'toggle_type' => 'text',
                    'menu_style' => 'toggle'
                ],
                'selector' => '{{WRAPPER}} .text-inner',
            ]
        );

        $this->add_control(
            'divider_1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control(
            'switch_duration',
            [
                'label' => esc_html__('Switch Duration', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0.1,
                'max' => 3,
                'step' => 0.1,
                'default' => 1
            ]
        );

        $this->add_control(
            'animate_speed',
            [
                'label' => esc_html__('Animate Speed (ms)', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 20000,
                'step' => 100,
                'default' => 5000
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_sw',
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
            'switcher_vertical_text',
            [
                'label' => esc_html__('Left', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Vertical',
                'condition' => [
                    'switcher' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'switcher_horizontal_text',
            [
                'label' => esc_html__('Right', 'pe-core'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Horizontal',
                'condition' => [
                    'switcher' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        pe_cursor_settings($this);
        pe_general_animation_settings($this);

        $this->start_controls_section(
            'project_elements',
            [

                'label' => esc_html__('Project', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'project_styles'
        );

        $this->start_controls_tab(
            'image_style_tab',
            [
                'label' => esc_html__('Image', 'textdomain'),
            ]
        );

        $this->add_responsive_control(
            'project_width',
            [
                'label' => esc_html__('Project Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 1
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400
                ],
                
            ]
        );

        $this->add_responsive_control(
            'project_height',
            [
                'label' => esc_html__('Project Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px' , 'vh' , 'svh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-infinity-cards .showcase-project' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'project_margin',
            [
                'label' => esc_html__('Margin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ]
            ]
        );

        $this->add_responsive_control(
            'project_border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-infinity-cards .showcase-project .project-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_style_tab',
            [
                'label' => esc_html__('Title', 'textdomain'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .leksa-infinity-cards .showcase-project .project-title'
            ]
        );


        $this->add_responsive_control(
            'title_border_radius',
            [
                'label' => esc_html__('Title Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-infinity-cards .showcase-project .project-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Title Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-infinity-cards .showcase-project .project-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .leksa-infinity-cards .showcase-project .project-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'title_vertical_alignment',
            [
                'label' => esc_html__('Vertical Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'v-align-top' => [
                        'title' => esc_html__('Top', 'pe-core'),
                        'icon' => 'eicon-v-align-top'
                    ],
                    'v-align-bottom' => [
                        'title' => esc_html__('Bottom', 'pe-core'),
                        'icon' => 'eicon-v-align-bottom'
                    ]
                ],
                'default' => 'v-align-top',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'title_horizontal_alignment',
            [
                'label' => esc_html__('Title Horizontal Alignment', 'pe-core'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'h-align-left' => [
                        'title' => esc_html__('Left', 'pe-core'),
                        'icon' => 'eicon-h-align-left'
                    ],
                    'h-align-right' => [
                        'title' => esc_html__('Right', 'pe-core'),
                        'icon' => 'eicon-h-align-right'
                    ]
                ],
                'default' => 'h-align-left',
                'toggle' => 'true',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'style_divider_1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER
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
                'selector' => '{{WRAPPER}} .leksa-infinity-cards .switch-item'
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
                    '{{WRAPPER}} .leksa-infinity-cards .lic-switcher .switch-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
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
                    '{{WRAPPER}} .leksa-infinity-cards .lic-switcher .switch-item' => 'padding: {{SIZE}}{{UNIT}}'
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
                    '{{WRAPPER}} .leksa-infinity-cards .lic-switcher' => 'padding: {{SIZE}}{{UNIT}}'
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
                    '{{WRAPPER}} .leksa-infinity-cards .lic-switcher' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
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




        <div  <?php echo pe_general_animation($this) ?> class="leksa-infinity-cards anim-multiple <?php echo $settings['title_vertical_alignment'] . ' ' . $settings['title_horizontal_alignment']; ?> style-infinity"
            data-speed="<?php echo $settings['animate_speed'] ?>" data-duration="<?php echo $settings['switch_duration'] ?>"
            data-project-width="" data-project-height="<?php echo $settings['project_height']['size']; ?>"
            style="--projectWidth:<?php echo $settings['project_width']['size']; ?>px; --projectHeight: <?php echo $settings['project_height']['size']; ?>px"
            data-vertical-class="<?php if ($settings['vertical_class']) {
                echo $settings['vertical_class'];
            } else {
                echo 'no-class';
            } ?>"
            data-horizontal-class="<?php if ($settings['horizontal_class']) {
                echo $settings['horizontal_class'];
            } else {
                echo 'no-class';
            } ?>">

            <div class="lic-wrapper">

                <?php foreach ($settings['project_repeater'] as $item) { ?>

                    <div class="showcase-project inner--anim">

                        <a href="<?php echo get_the_permalink($item['select_project']); ?>" class="barba--trigger" <?php echo $cursor ?> data-id="<?php echo $item['select_project']; ?>">

                            <div class="project-image project__image__<?php echo $item['select_project']; ?> <?php echo $hover ?>">

                                <?php pe_project_image($item['select_project'], $custom, false); ?>


                            </div>
                            <div class="project-title">
                                <?php if ($item['custom_title_text']) { ?>

                                    <?php echo $item['custom_title_text']; ?>

                                <?php } else { ?>

                                    <?php echo get_the_title($item['select_project']); ?>

                                <?php } ?>

                            </div>

                        </a>

                    </div>

                <?php } ?>



            </div>

            <?php if ($settings['switcher'] === 'yes') { ?>

                <div class="lic-switcher">

                    <span class="switch-item switch-infinite">

                        <?php echo $settings['switcher_vertical_text']; ?>

                    </span>
                    <span class="switch-item switch-collapse">

                        <?php echo $settings['switcher_horizontal_text']; ?>

                    </span>

                    <span class="switch-bg"></span>

                </div>

            <?php } ?>

        </div>





    <?php }



}
