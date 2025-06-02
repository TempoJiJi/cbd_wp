<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeShowcaseTable extends Widget_Base
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
        return 'peshowcasetable';
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
        return __('Pe Showcase Table', 'pe-core');
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
        return 'eicon-info-box pe-widget';
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
            'button_icon',
            [
                'label' => esc_html__('Click Button', 'pe-core'),
                'type' => \Elementor\Controls_Manager::ICONS,
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

        $this->end_controls_section();

        pe_cursor_settings($this);

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Content', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .showcase-table .project-title'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cats_typography',
                'label' => esc_html__('Category Typography', 'pe-core'),
                'selector' => '{{WRAPPER}} .showcase-table .project-category'
            ]
        );

        $this->add_control(
            'icon_rotate',
            [
                'label' => esc_html__('Icon Rotate', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 360,
                'step' => 1,
                'defaut' => 0,
                'selectors' => [
                    '{{WRAPPER}} .showcase-table .project-icon i' => "transform: rotate({{VALUE}}deg)"
                ]
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'pe-core'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 200,
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} .showcase-table i' => 'font-size: {{VALUE}}px'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_styles',
            [

                'label' => esc_html__('Size', 'pe-core'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'project_width',
            [
                'label' => esc_html__('Width', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-table .showcase-project' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );


        $this->add_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'pe-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 750,
                        'step' => 1
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-table .showcase-project' => 'height: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-table .showcase-project' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-table .showcase-project' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'pe-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .showcase-table .showcase-project .project-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
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
        <div class="showcase-table" style="--tableMargin: 25px">

            <div class="st-wrapper">

                <?php foreach ($settings['project_repeater'] as $item) { ?>

                    <div class="showcase-project needs--handle">

                        <div class="project-image project__image__<?php echo $item['select_project']; ?> <?php echo $hover ?>">
                            <a class="barba--trigger" href="<?php echo get_the_permalink($item['select_project']); ?>" <?php echo $cursor ?> data-id="<?php echo $item['select_project'] ?>">

                                <?php pe_project_image($item['select_project'], $custom, false); ?>
                            </a>
                        </div>

                        <div class="project-meta">

                            <div class="meta-content">

                                <div class="project-title">

                                    <?php if ($item['custom_title']) {

                                        echo $item['custom_title'];
                                    } else {

                                        echo get_the_title($item['select_project']);
                                    } ?>

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

                            <div class="project-icon">
                                <a class="barba--trigger" href="<?php echo get_the_permalink($item['select_project']); ?>" <?php echo $cursor ?> data-id="<?php echo $item['select_project'] ?>">
                                    <?php \Elementor\Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?>
                                </a>
                            </div>



                        </div>




                    </div>


                <?php } ?>


            </div>


        </div>


    <?php }



}
