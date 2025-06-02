<?php

function pe_general_animation_settings($widget, $tab = false , $container = false)
{


    $widget->start_controls_section(
        'section_animate',
        [
            'label' => __('Animations', 'pe-core'),
            'tab' => $tab,
        ]
    );

    if ($container) {

        $widget->add_control(
			'pin_container',
			[
				'label' => esc_html__('Pin Container', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'prefix_class' => 'pinned_',
				'default' => false,
			]
		);

		$widget->add_control(
			'pin_container_target',
			[
				'label' => esc_html__('Pin Target', 'pe-core'),
				'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('Normally the container pin itself but in some cases, a custom trigger may required.', 'pe-core'),
				'ai' => false,
				'prefix_class' => 'pin_container_',
				'condition' => ['pin_container' => 'true'],
			]
		);

    }

    $widget->add_control(
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

    $widget->add_control(
        'view',
        [
            'label' => esc_html__( 'View', 'textdomain' ),
            'type' => \Elementor\Controls_Manager::HIDDEN,
            'default' => 'animated',
            'prefix_class' => 'will__',
            'condition' => ['select_animation!' => 'none'],
        ]
    );

    $widget->add_control(
        'more_options',
        [
            'label' => esc_html__('Animation Options', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->start_controls_tabs(
        'animation_options_tabs'
    );

    $widget->start_controls_tab(
        'basic_tab',
        [
            'label' => esc_html__('Basic', 'textdomain'),
        ]
    );

    $widget->add_control(
        'duration',
        [
            'label' => esc_html__('Duration', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0.1,
            'step' => 0.1,
            'default' => 1.5
        ]
    );

    $widget->add_control(
        'delay',
        [
            'label' => esc_html__('Delay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 0.1,
            'default' => 0
        ]
    );

    $widget->add_control(
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


    $widget->add_control(
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

    $widget->add_control(
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

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'advanced_tab',
        [
            'label' => esc_html__('Advanced', 'textdomain'),
        ]
    );

    $widget->add_control(
        'pinned_target',
        [
            'label' => esc_html__('Pin Target', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
            'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),

        ]
    );


    $widget->add_control(
        'start_references',
        [
            'label' => esc_html__('Start References', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'references_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           This references below are adjusts the animation start/end positions on the screen. <b>For Example: If you select <u>'Top' for item reference point</u> and <u>'Bottom' for the window reference point</u>; animation will start when item's top edge enters the window's bottom edge.</b></div>",


        ]
    );

    $widget->add_control(
        'item_ref_start',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'top',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_start',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'bottom',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'end_references',
        [
            'label' => esc_html__('End References', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'end_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>For scrubbed/pinned animations only.</div>",
        ]
    );

    $widget->add_control(
        'item_ref_end',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'bottom',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_end',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'top',
            'toggle' => false,
        ]
    );



    $widget->add_control(
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

    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();

}

function pe_general_animation($widget)
{

    $settings = $widget->get_settings_for_display();

    $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';

    $dataset = '{' .
        'duration=' . $settings['duration'] . '' .
        ';delay=' . $settings['delay'] . '' .
        ';stagger=' . $settings['stagger'] . '' .
        ';pin=' . $settings['pin'] . '' .
        ';pinTarget=' . $settings['pinned_target'] . '' .
        ';scrub=' . $settings['scrub'] . '' .
        ';item_ref_start=' . $settings['item_ref_start'] . '' .
        ';window_ref_start=' . $settings['window_ref_start'] . '' .
        ';item_ref_end=' . $settings['item_ref_end'] . '' .
        ';window_ref_end=' . $settings['window_ref_end'] . '' .
        ';out=' . $out . '' .
        '}';

    $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

    //Scroll Button Attributes
    $widget->add_render_attribute(
        'animation_settings',
        [
            'data-anim-general' => 'true',
            'data-animation' => $animation,
            'data-settings' => $dataset,

        ]
    );

    $animationSettings = $settings['select_animation'] !== 'none' ? $widget->get_render_attribute_string('animation_settings') : '';
    return $animationSettings;

}

function pe_image_animation_settings($widget)
{

    $widget->start_controls_section(
        'section_animate',
        [
            'label' => __('Animations', 'pe-core'),
        ]
    );

    $widget->add_control(
        'select_animation',
        [
            'label' => esc_html__('Select Animation', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'description' => esc_html__('Will be used as intro animation.', 'textdomain'),
            'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'scale' => esc_html__('Scale', 'pe-core'),
                'block' => esc_html__('Block', 'pe-core'),
                'mask' => esc_html__('Mask', 'pe-core'),

            ],
            'label_block' => true,
        ]
    );

    $widget->add_control(
        'mask_type',
        [
            'label' => esc_html__('Mask Type', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'square',
            'options' => [
                'square' => esc_html__('Square', 'pe-core'),
                'circle' => esc_html__('Circle', 'pe-core'),
                'triangle' => esc_html__('Triangle', 'pe-core'),
                'rhombus' => esc_html__('Rhombus', 'pe-core'),
                'hexagon' => esc_html__('Hexagon', 'pe-core'),
                'left_arrow' => esc_html__('Left Arrow', 'pe-core'),
                'right_arrow' => esc_html__('Right Arrow', 'pe-core'),
                'left_chevron' => esc_html__('Left Chevron', 'pe-core'),
                'right_chevron' => esc_html__('Right Chevron', 'pe-core'),
                'star' => esc_html__('Star', 'pe-core'),
                'close' => esc_html__('Close', 'pe-core'),
            ],
            'label_block' => true,
            'condition' => [
                'select_animation' => 'mask',
            ]
        ]
    );

    $widget->add_control(
        'square_mask_start',
        [
            'label' => esc_html__('Start Mask', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['%'],
            'default' => [
                'top' => 10,
                'right' => 20,
                'bottom' => 23,
                'left' => 50,
                'unit' => '%',
                'isLinked' => false,
            ],
            'condition' => [
                'mask_type' => 'square',
                'select_animation' => 'mask',
            ]
        ]
    );

    $widget->add_control(
        'square_mask_end',
        [
            'label' => esc_html__('End Mask', 'pe-core'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['%'],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => '%',
                'isLinked' => false,
            ],
            'condition' => [
                'mask_type' => 'square',
                'select_animation' => 'mask',
            ]
        ]
    );

    $widget->add_control(
        'square_mask_radius',
        [
            'label' => esc_html__('Square Radius', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'mask_type' => 'square',
                'select_animation' => 'mask',
            ]
        ]
    );



    $widget->start_controls_tabs(
        'circle_tabs',
        [
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]

    );

    $widget->start_controls_tab(
        'circle_start_tab',
        [
            'label' => esc_html__('Start', 'textdomain'),
        ]
    );

    $widget->add_responsive_control(
        'circle_size_start',
        [
            'label' => esc_html__('Circle Size', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 50,
            ],
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );

    $widget->add_responsive_control(
        'circle_top_pos_start',
        [
            'label' => esc_html__('Circle Top Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 50,
            ],
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );

    $widget->add_responsive_control(
        'circle_left_pos_start',
        [
            'label' => esc_html__('Circle Left Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 50,
            ],
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );


    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'circle_end_tab',
        [
            'label' => esc_html__('End', 'textdomain'),
        ]
    );

    $widget->add_responsive_control(
        'circle_size_end',
        [
            'label' => esc_html__('Circle Size', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 50,
            ],
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );

    $widget->add_responsive_control(
        'circle_top_pos_end',
        [
            'label' => esc_html__('Circle Top Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 50,
            ],
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );

    $widget->add_responsive_control(
        'circle_left_pos_end',
        [
            'label' => esc_html__('Circle Left Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 50,
            ],
            'condition' => [
                'mask_type' => 'circle',
            ]
        ]
    );


    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->add_control(
        'transform_origin',
        [
            'label' => esc_html__('Animation Origin', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top left' => [
                    'title' => esc_html__('Top Left', 'pe-core'),
                    'icon' => 'material-icons md-north_west',
                ],
                'top center' => [
                    'title' => esc_html__('Top Center', 'pe-core'),
                    'icon' => 'material-icons md-north'
                ],
                'top right' => [
                    'title' => esc_html__('Top Right', 'pe-core'),
                    'icon' => 'material-icons md-north_east',
                ],
                'left center' => [
                    'title' => esc_html__('Left', 'pe-core'),
                    'icon' => 'material-icons md-west',
                ],
                'center center' => [
                    'title' => esc_html__('Center Center', 'pe-core'),
                    'icon' => 'material-icons md-filter_center_focus',
                ],
                'right center' => [
                    'title' => esc_html__('Right', 'pe-core'),
                    'icon' => 'material-icons md-east',
                ],
                'bottom left' => [
                    'title' => esc_html__('Bottom Left', 'pe-core'),
                    'icon' => 'material-icons md-south_west',
                ],
                'bottom center' => [
                    'title' => esc_html__('Bottom Center', 'pe-core'),
                    'icon' => 'material-icons md-south'
                ],
                'bottom right' => [
                    'title' => esc_html__('Bottom Right', 'pe-core'),
                    'icon' => 'material-icons md-south_east',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .single-image[data-anim-image=true]' => 'transform-origin: {{VALUE}};',
                '{{WRAPPER}} .single-image[data-anim-image=true] img' => 'transform-origin: {{VALUE}};',
            ],
            'default' => 'center center',
            'label_block' => true,
            'toggle' => false,
            'condition' => [
                'select_animation' => 'scale',
            ]
        ]
    );

    $widget->add_control(
        'start_scale',
        [
            'label' => esc_html__('Start Scale', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 0.1,
            'default' => 0,
            'condition' => [
                'select_animation' => 'scale',
            ]

        ]
    );

    $widget->add_control(
        'end_scale',
        [
            'label' => esc_html__('End Scale', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 0.1,
            'default' => 1,
            'condition' => [
                'select_animation' => 'scale',
            ]

        ]
    );

    $widget->add_control(
        'block_direction',
        [
            'label' => esc_html__('Image Type', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'up' => esc_html__('Up', 'pe-core'),
                'down' => esc_html__('Down', 'pe-core'),
                'left' => esc_html__('Left', 'pe-core'),
                'right' => esc_html__('Right', 'pe-core'),
            ],
            'default' => 'up',
            'condition' => [
                'select_animation' => 'block',
            ],
            'label_block' => true
        ]
    );

    $widget->add_control(
        'block_color',
        [
            'label' => esc_html__('Block Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .single-image[data-animation=block]::after' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'select_animation' => 'block',
            ],
        ]
    );


    $widget->add_control(
        'inner_scale',
        [
            'label' => esc_html__('Inner Scale', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'true',
        ]
    );

    $widget->add_control(
        'ia_more_options',
        [
            'label' => esc_html__('Animation Options', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->start_controls_tabs(
        'animation_options_tabs'
    );

    $widget->start_controls_tab(
        'basic_tab',
        [
            'label' => esc_html__('Basic', 'textdomain'),
        ]
    );

    $widget->add_control(
        'duration',
        [
            'label' => esc_html__('Duration', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0.1,
            'step' => 0.1,
            'default' => 1.5
        ]
    );

    $widget->add_control(
        'delay',
        [
            'label' => esc_html__('Delay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 0.1,
            'default' => 0
        ]
    );

    $widget->add_control(
        'stagger',
        [
            'label' => esc_html__('Stagger', 'pe-core'),
            'description' => esc_html__('Delay between animated elements (for multiple element animation types)', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'step' => 0.01,
            'default' => 0.1,
        ]
    );


    $widget->add_control(
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

    $widget->add_control(
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

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'advanced_tab',
        [
            'label' => esc_html__('Advanced', 'textdomain'),
        ]
    );


    $widget->add_control(
        'anim_pin_target',
        [
            'label' => esc_html__('Pin Target', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
            'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),

        ]
    );


    $widget->add_control(
        'start_references',
        [
            'label' => esc_html__('Start References', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'references_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           This references below are adjusts the animation start/end positions on the screen. <b>For Example: If you select <u>'Top' for item reference point</u> and <u>'Bottom' for the window reference point</u>; animation will start when item's top edge enters the window's bottom edge.</b></div>",


        ]
    );

    $widget->add_control(
        'item_ref_start',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'top',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_start',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'bottom',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'end_references',
        [
            'label' => esc_html__('End References', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'end_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>For scrubbed/pinned animations only.</div>",
        ]
    );

    $widget->add_control(
        'item_ref_end',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'bottom',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_end',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'top',
            'toggle' => false,
        ]
    );


    $widget->add_control(
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


    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();


}

function pe_image_animation($widget)
{

    $settings = $widget->get_settings_for_display();

    $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';


    if ($settings['mask_type'] === 'square') {

        $squareStart = ';square_start=inset(' . $settings['square_mask_start']['top'] . '% ' . $settings['square_mask_start']['right'] . '% ' . $settings['square_mask_start']['bottom'] . '% ' . $settings['square_mask_start']['left'] . '% ' . 'round ' . $settings['square_mask_radius'] . 'px)';

        $squareEnd = ';square_end=inset(' . $settings['square_mask_end']['top'] . '% ' . $settings['square_mask_end']['right'] . '% ' . $settings['square_mask_end']['bottom'] . '% ' . $settings['square_mask_end']['left'] . '% ' . 'round ' . $settings['square_mask_radius'] . 'px)';

    } else {

        $squareStart = '';
        $squareEnd = '';
    }


    if ($settings['mask_type'] === 'circle') {

        $circleStart = ';circle_start=circle(' . $settings['circle_size_start']['size'] . '% at ' . $settings['circle_left_pos_start']['size'] . '% ' . $settings['circle_top_pos_start']['size'] . '%)';

        $circleEnd = ';circle_end=circle(' . $settings['circle_size_end']['size'] . '% at ' . $settings['circle_left_pos_end']['size'] . '% ' . $settings['circle_top_pos_end']['size'] . '%)';

    } else {

        $circleStart = '';
        $circleEnd = '';
    }


    $dataset = '{' .
        'duration=' . $settings['duration'] . '' .
        ';delay=' . $settings['delay'] . '' .
        ';stagger=' . $settings['stagger'] . '' .
        ';pin=' . $settings['pin'] . '' .
        ';pinTarget=' . $settings['anim_pin_target'] . '' .
        ';scrub=' . $settings['scrub'] . '' .
        ';item_ref_start=' . $settings['item_ref_start'] . '' .
        ';window_ref_start=' . $settings['window_ref_start'] . '' .
        ';item_ref_end=' . $settings['item_ref_end'] . '' .
        ';window_ref_end=' . $settings['window_ref_end'] . '' .
        ';out=' . $out . '' .
        ';start_scale=' . $settings['start_scale'] . '' .
        ';end_scale=' . $settings['end_scale'] . '' .
        ';inner_scale=' . $settings['inner_scale'] . '' .
        ';block_direction=' . $settings['block_direction'] . '' .
        ';mask_start=' . $settings['mask_type'] . '' . $squareStart . $squareEnd . $circleStart . $circleEnd .
        '}';



    $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

    //Scroll Button Attributes
    $widget->add_render_attribute(
        'animation_settings',
        [
            'data-anim-image' => 'true',
            'data-animation' => $animation,
            'data-animation-direction' => $settings['block_direction'],
            'data-settings' => $dataset,

        ]
    );

    $animationSettings = $settings['select_animation'] !== 'none' ? $widget->get_render_attribute_string('animation_settings') : '';

    return $animationSettings;



}

function pe_text_animation_settings($widget, $multiple = false)
{


    $widget->start_controls_section(
        'section_animate',
        [
            'label' => __('Animations', 'pe-core'),
        ]
    );

    $widget->add_control(
        'insert2_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>"Line" based animations deprecated because of inserted elements.</span></div>',
            'condition' => ['additional' => 'insert'],
        ]
    );

    $widget->add_control(
        'dynamic2_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>Scrubbing/pinning deprecated because of the dynamic word.</span></div>',
            'condition' => ['additional' => 'dynamic'],
        ]
    );

    $widget->add_control(
        'select_animation',
        [
            'label' => esc_html__('Select Animation', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'description' => esc_html__('Will be used as intro animation.', 'textdomain'),
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

    $widget->add_control(
        'more_options',
        [
            'label' => esc_html__('Animation Options', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->start_controls_tabs(
        'animation_options_tabs'
    );

    $widget->start_controls_tab(
        'basic_tab',
        [
            'label' => esc_html__('Basic', 'textdomain'),
        ]
    );

    $widget->add_control(
        'duration',
        [
            'label' => esc_html__('Duration', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0.1,
            'step' => 0.1,
            'default' => 1.5
        ]
    );

    $widget->add_control(
        'delay',
        [
            'label' => esc_html__('Delay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 0.1,
            'default' => 0
        ]
    );

    $widget->add_control(
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


    $widget->add_control(
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

    $widget->add_control(
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

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'advanced_tab',
        [
            'label' => esc_html__('Advanced', 'textdomain'),
        ]
    );


    $widget->add_control(
        'pin_target',
        [
            'label' => esc_html__('Pin Target', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Eg: #container2', 'pe-core'),
            'description' => esc_html__('You can enter a container id/class which the element will be pinned during animation.', 'pe-core'),

        ]
    );


    $widget->add_control(
        'start_references',
        [
            'label' => esc_html__('Start References', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'references_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           This references below are adjusts the animation start/end positions on the screen. <b>For Example: If you select <u>'Top' for item reference point</u> and <u>'Bottom' for the window reference point</u>; animation will start when item's top edge enters the window's bottom edge.</b></div>",


        ]
    );

    $widget->add_control(
        'item_ref_start',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'top',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_start',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'bottom',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'end_references',
        [
            'label' => esc_html__('End References', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'after',
        ]
    );

    $widget->add_control(
        'end_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>For scrubbed/pinned animations only.</div>",
        ]
    );

    $widget->add_control(
        'item_ref_end',
        [
            'label' => esc_html__('Item Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'bottom',
            'toggle' => false,
        ]
    );

    $widget->add_control(
        'window_ref_end',
        [
            'label' => esc_html__('Window Reference Point', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'pe-core'),
                    'icon' => 'eicon-v-align-top',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'pe-core'),
                    'icon' => 'eicon-v-align-middle'
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'pe-core'),
                    'icon' => ' eicon-v-align-bottom',
                ],
            ],
            'default' => 'top',
            'toggle' => false,
        ]
    );


    $widget->add_control(
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


    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();



}

function pe_text_animation($widget, $multiple = false)
{

    $settings = $widget->get_settings_for_display();

    $out = $settings['animate_out'] ? $settings['animate_out'] : 'false';

    if ($widget->get_name() === 'petextwrapper') {
        $inserted = $settings['additional'] === 'insert' ? 'true' : 'false';
    } else {
        $inserted = false;
    }

    $dataset = '{' .
        'duration=' . $settings['duration'] . '' .
        ';delay=' . $settings['delay'] . '' .
        ';stagger=' . $settings['stagger'] . '' .
        ';pin=' . $settings['pin'] . '' .
        ';pinTarget=' . $settings['pin_target'] . '' .
        ';scrub=' . $settings['scrub'] . '' .
        ';item_ref_start=' . $settings['item_ref_start'] . '' .
        ';window_ref_start=' . $settings['window_ref_start'] . '' .
        ';item_ref_end=' . $settings['item_ref_end'] . '' .
        ';window_ref_end=' . $settings['window_ref_end'] . '' .
        ';out=' . $out . '' .
        ';inserted=' . $inserted . '' .
        '}';


    $animation = $settings['select_animation'] !== 'none' ? $settings['select_animation'] : '';

    $widget->add_render_attribute(
        'animation_attributes',
        [
            'data-animate' => 'true',
            'data-animation' => [$animation],
            'data-settings' => [$dataset],
        ]
    );

    $animationAttributes = $settings['select_animation'] !== 'none' ? $widget->get_render_attribute_string('animation_attributes') : '';

    return $animationAttributes;

}

function pe_button_settings($widget, $link = false)
{


    $widget->add_control(
        'button_text',
        [
            'label' => esc_html__('Button Text', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Write your text here', 'pe-core'),
            'default' => esc_html('Button', 'pe-core')
        ]
    );


    if ($link) {
        $widget->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'textdomain'),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow', 'custom_attributes'],
                'default' => [
                    'url' => 'http://',
                    'is_external' => false,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => false,
            ]
        );
    }

    $widget->add_control(
        'button_size',
        [
            'label' => esc_html__('Size', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'pb--normal',
            'options' => [
                'pb--normal' => esc_html__('Normal', 'pe-core'),
                'pb--medium' => esc_html__('Medium', 'pe-core'),
                'pb--large' => esc_html__('Large', 'pe-core'),
            ],
        ]
    );

    $widget->add_responsive_control(
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

    $widget->add_control(
        'background',
        [
            'label' => esc_html__('Background', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--background',
            'default' => 'pb--background',
        ]
    );

    $widget->add_control(
        'bordered',
        [
            'label' => esc_html__('Bordered', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--bordered',
            'default' => 'false',
        ]
    );

    $widget->add_control(
        'marquee',
        [
            'label' => esc_html__('Marquee', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--marquee',
            'default' => 'false',
        ]
    );

    $widget->add_control(
        'marquee_direction',
        [
            'label' => esc_html__('Marquee Direction', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'left-to-right' => [
                    'title' => esc_html__('Left To Right', 'pe-core'),
                    'icon' => 'eicon-h-align-right',
                ],
                'right-to-left' => [
                    'title' => esc_html__('Right To Left', 'pe-core'),
                    'icon' => 'eicon-h-align-left',
                ],
            ],
            'default' => 'right-to-left',
            'toggle' => false,
            'label_block' => false,
            'condition' => ['marquee' => 'pb--marquee'],
        ]
    );



    $widget->add_control(
        'marquee_duration',
        [
            'label' => esc_html__('Duration', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 60,
            'step' => 1,
            'default' => 5,
            'condition' => ['marquee' => 'pb--marquee'],
            'selectors' => [
                '{{WRAPPER}} .pb--marquee__inner' => '--duration: {{VALUE}}s;',
            ],
        ]
    );

    $widget->add_control(
        'underlined',
        [
            'label' => esc_html__('Underlined', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--underlined',
            'default' => 'false',
            'condition' => ['marquee!' => 'pb--marquee'],
        ]
    );

    $widget->add_control(
        'show_icon',
        [
            'label' => esc_html__('Show Icon', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'pb--icon',
            'default' => 'pb--icon',
        ]
    );


    $widget->add_control(
        'icon',
        [
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'material-icons md-arrow_outward',
                'library' => 'material-design-icons',
            ],
            'condition' => ['show_icon' => 'pb--icon'],
        ]
    );

    $widget->add_control(
        'icon_position',
        [
            'label' => esc_html__('Icon Position', 'pe-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'icon__left' => [
                    'title' => esc_html__('Left', 'pe-core'),
                    'icon' => 'eicon-text-align-left',
                ],
                'icon__right' => [
                    'title' => esc_html__('Right', 'pe-core'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'icon__right',
            'toggle' => false,
            'condition' => ['show_icon' => 'pb--icon'],

        ]
    );


}

function pe_button_style_settings($widget, $name = 'Button')
{


    $widget->start_controls_section(
        'button_styles',
        [

            'label' => esc_html__($name . ' Styles', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );


    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'button_typography',
            'selector' => '{{WRAPPER}} .pe--button',
        ]
    );

    $widget->add_responsive_control(
        'border-radius',
        [
            'label' => esc_html__('Border Radius', 'textdomain'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'border-width',
        [
            'label' => esc_html__('Border Width', 'textdomain'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'condition' => ['bordered' => 'pb--bordered'],
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'underline_height',
        [
            'label' => esc_html__('Underline Height', 'pe-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 60,
            'step' => 1,
            'condition' => ['underlined' => 'pb--underlined'],
            'selectors' => [
                '{{WRAPPER}} .pe--button.pb--underlined .pe--button--wrapper a::after' => 'height: {{VALUE}}px;',
            ],
        ]
    );

    $widget->add_responsive_control(
        'padding',
        [
            'label' => esc_html__('Padding', 'textdomain'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );


    $widget->add_control(
        'color_options',
        [
            'label' => esc_html__('Colors', 'textdomain'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->start_controls_tabs(
        'button_c_options_tabs'
    );

    $widget->start_controls_tab(
        'main_tab',
        [
            'label' => esc_html__('Default', 'textdomain'),
        ]
    );

    $widget->add_control(
        'default_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-control-field-description">If you apply custom colors; this widget will no longer change on layout switching unless you set switched color options from the "Switched" tab above.</div>',


        ]
    );


    $widget->add_control(
        'button_main_color',
        [
            'label' => esc_html__('Main Color', 'pe-core'),
            'description' => esc_html__('Used for borders, icon/text color, hover background color etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => '--mainColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'button_main_background',
        [
            'label' => esc_html__('Main Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button a' => '--secondaryBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'advanced_colors',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => esc_html__('Advanced Colors', 'textdomain'),
            'label_off' => esc_html__('Default', 'textdomain'),
            'label_on' => esc_html__('Custom', 'textdomain'),
            'return_value' => 'adv--styled',
        ]
    );

    $widget->start_popover();

    $widget->add_control(
        'adv_text_color',
        [
            'label' => esc_html__('Text Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a span' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_icon_color',
        [
            'label' => esc_html__('Icon Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a span i' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_background_color',
        [
            'label' => esc_html__('Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a' => 'background-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_border_color',
        [
            'label' => esc_html__('Border Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a' => 'border-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_hover_text_color',
        [
            'label' => esc_html__('Text (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a:hover span' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_hover_icon_color',
        [
            'label' => esc_html__('Icon (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a:hover span i' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_hover_background_color',
        [
            'label' => esc_html__('Background (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled .pe--button--wrapper a::before' => 'background-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_hover_border_color',
        [
            'label' => esc_html__('Border (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .pe--button.adv--styled a:hover' => 'border-color: {{VALUE}}',
            ]
        ]
    );

    $widget->end_popover();


    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'secondary_tab',
        [
            'label' => esc_html__('Switched', 'textdomain'),

        ]
    );

    $widget->add_control(
        'switched_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-control-field-description">This settings will be used when the page layout switched from default.</div>',


        ]
    );

    $widget->add_control(
        'button_secondary_color',
        [
            'label' => esc_html__('Main Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button a' => '--mainColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'button_secondary_background',
        [
            'label' => esc_html__('Main Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button a' => '--secondaryBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'advanced_secondary_colors',
        [
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label' => esc_html__('Advanced Colors', 'textdomain'),
            'label_off' => esc_html__('Default', 'textdomain'),
            'label_on' => esc_html__('Custom', 'textdomain'),
            'return_value' => 'adv--styled',
        ]
    );

    $widget->start_popover();

    $widget->add_control(
        'adv_secondary_text_color',
        [
            'label' => esc_html__('Text Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a span' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_secondary_icon_color',
        [
            'label' => esc_html__('Icon Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a span i' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_secondary_background_color',
        [
            'label' => esc_html__('Background Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a' => 'background-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_secondary_border_color',
        [
            'label' => esc_html__('Border Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a:hover' => 'border-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_secondary_hover_text_color',
        [
            'label' => esc_html__('Text (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a:hover span' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_secondary_hover_icon_color',
        [
            'label' => esc_html__('Icon (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a:hover span i' => 'color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_secondary_hover_background_color',
        [
            'label' => esc_html__('Background (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled .pe--button--wrapper a::before' => 'background-color: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'adv_secondary_hover_border_color',
        [
            'label' => esc_html__('Border (Hover) Color', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}} .pe--button.adv--styled a:hover' => 'border-color: {{VALUE}}',
            ]
        ]
    );

    $widget->end_popover();

    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();



}

function pe_button_render($widget, $link = false)
{


    $settings = $widget->get_settings_for_display();

    $classes = [];

    array_push($classes, [$settings['background'], $settings['bordered'], $settings['underlined'], $settings['marquee'], $settings['show_icon'], $settings['icon_position'], $settings['button_size'], $settings['advanced_colors']]);
    $mainClasses = implode(' ', array_filter($classes[0]));

    ob_start();

    \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']);

    $icon = ob_get_clean();

    $buttonText = $settings['button_text'];

    $buttonHTML = ($settings['icon_position'] === 'icon__left' ? $icon : '') . $buttonText . ($settings['icon_position'] === 'icon__right' ? $icon : '');

    // Button Link
    if (!empty($settings['link']['url'])) {
        $widget->add_link_attributes('link', $settings['link']);
    }

    //Cursor
    ob_start();

    \Elementor\Icons_Manager::render_icon($settings['cursor_icon'], ['aria-hidden' => 'true']);

    $cursorIcon = ob_get_clean();

    $widget->add_render_attribute(
        'cursor_settings',
        [
            'data-cursor' => "true",
            'data-cursor-type' => $settings['cursor_type'],
            'data-cursor-text' => $settings['cursor_text'],
            'data-cursor-icon' => $cursorIcon,
        ]
    );

    $cursor = $settings['cursor_type'] !== 'none' ? $widget->get_render_attribute_string('cursor_settings') : '';
    //Cursor


    ?>

    <div class="pe--button <?php echo esc_attr($mainClasses) ?>">

        <div class="pe--button--wrapper">

            <?php if (!empty($settings['link']['url'])) { ?>

                <a <?php echo $widget->get_render_attribute_string('link') . $cursor; ?>>

                <?php } else {

                echo '<a href="#.">';

            } ?>

                <span class="pb__main"><?php echo $buttonHTML ?>

                    <?php if ($settings['underlined'] !== 'pb--underlined') {
                        if ($settings['background'] === 'pb--background' || $settings['bordered'] === 'pb--bordered') {
                            ?>


                            <span class="pb__hover"><?php echo $buttonHTML ?></span>

                        <?php }
                    } ?>

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

                <?php if (!empty($settings['link']['url'])) { ?>
                </a>
            <?php } else {
                    echo '</a>';
                } ?>


        </div>

    </div>


<?php }

function pe_cursor_settings($widget)
{

    $widget->start_controls_section(
        'cursor_interactions',
        [
            'label' => __('Cursor Interactions', 'pe-core'),
        ]
    );

    $widget->add_control(
        'cursor_type',
        [
            'label' => esc_html__('Interaction', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'default' => esc_html__('Default', 'pe-core'),
                'text' => esc_html__('Text', 'pe-core'),
                'icon' => esc_html__('Icon', 'pe-core'),
            ],

        ]
    );

    $widget->add_control(
        'cursor_icon',
        [
            'label' => esc_html__('Icon', 'pe-core'),
            'description' => esc_html__('Only Material Icons allowed, do not select Font Awesome icons.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-circle',
                'library' => 'fa-solid',
            ],
            'condition' => ['cursor_type' => 'icon'],
        ]
    );

    $widget->add_control(
        'cursor_text',
        [
            'label' => esc_html__('Text', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'condition' => ['cursor_type' => 'text'],
        ]
    );


    $widget->end_controls_section();


}

function pe_cursor($widget)
{

    $settings = $widget->get_settings_for_display();

    ob_start();

    \Elementor\Icons_Manager::render_icon($settings['cursor_icon'], ['aria-hidden' => 'true']);

    $cursorIcon = ob_get_clean();

    $widget->add_render_attribute(
        'cursor_settings',
        [
            'data-cursor' => "true",
            'data-cursor-type' => $settings['cursor_type'],
            'data-cursor-text' => $settings['cursor_text'],
            'data-cursor-icon' => $cursorIcon,
        ]
    );

    $cursor = $settings['cursor_type'] !== 'none' ? $widget->get_render_attribute_string('cursor_settings') : '';

    return $cursor;

}

function pe_color_options($widget)
{

    $widget->start_controls_section(
        'widget_colors',
        [

            'label' => esc_html__('Colors', 'pe-core'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->start_controls_tabs(
        'widget_colors_tabs'
    );

    $widget->start_controls_tab(
        'widget_default_colors_tab',
        [
            'label' => esc_html__('Default', 'textdomain'),
        ]
    );

    $widget->add_control(
        'widget_default_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-control-field-description">If you apply custom colors; this widget will no longer change colors on layout switching unless you set switched color options from the "Switched" tab above.</div>',
        ]
    );


    $widget->add_control(
        'widget_main_texts_color',
        [
            'label' => esc_html__('Main Color', 'pe-core'),
            'description' => esc_html__('Used for text/icon color, borders, hover background color etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--mainColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'widget_secondary_texts_color',
        [
            'label' => esc_html__('Secondary Color', 'pe-core'),
            'description' => esc_html__('Generally used for sub-texts but in some cases may be used as hover colors.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--secondaryColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'widget_main_background_color',
        [
            'label' => esc_html__('Main Background Color', 'pe-core'),
            'description' => esc_html__('Used as main background color when it necessary.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--mainBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'widget_secondary_background_color',
        [
            'label' => esc_html__('Secondary Background Color', 'pe-core'),
            'description' => esc_html__('Most of times this color will be used inner element backgrounds. Such as; inline buttons/switchers etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--secondaryBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'widget_switched_colors_tab',
        [
            'label' => esc_html__('Switched', 'textdomain'),

        ]
    );

    $widget->add_control(
        'widget_switched_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-control-field-description">This settings will be used when the page layout switched from default.</div>',


        ]
    );

    $widget->add_control(
        'widget_switched_main_texts_color',
        [
            'label' => esc_html__('Main Color', 'pe-core'),
            'description' => esc_html__('Used for text/icon color, borders, hover background color etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}}' => '--mainColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'widget_switched_secondary_texts_color',
        [
            'label' => esc_html__('Secondary Color', 'pe-core'),
            'description' => esc_html__('Generally used for sub-texts but in some cases may be used as hover colors.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}}' => '--secondaryColor: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'widget_switched_main_background_color',
        [
            'label' => esc_html__('Main Background Color', 'pe-core'),
            'description' => esc_html__('Used as main background color when it necessary.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}}' => '--mainBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->add_control(
        'widget_switched_secondary_background_color',
        [
            'label' => esc_html__('Secondary Background Color', 'pe-core'),
            'description' => esc_html__('Most of times this color will be used inner element backgrounds. Such as; inline buttons/switchers etc.', 'pe-core'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                'body.layout--switched {{WRAPPER}}' => '--secondaryBackground: {{VALUE}}',
            ]
        ]
    );

    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();

}

function pe_video_settings($widget, $conditionId = false, $conditionVal = false)
{

    $widget->add_control(
        'video_provider',
        [
            'label' => esc_html__('Video Provider', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'self',
            'options' => [
                'self' => esc_html__('Self', 'pe-core'),
                'vimeo' => esc_html__('Vimeo', 'pe-core'),
                'youtube' => esc_html__('Youtube', 'pe-core'),
            ],
            'condition' => [
                $conditionId => $conditionVal,

            ]
        ]
    );

    $widget->add_control(
        'self_video',
        [
            'label' => esc_html__('Choose Video', 'pe-core'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'media_types' => ['video'],
            'condition' => [
                'video_provider' => 'self',
                $conditionId => $conditionVal,

            ]
        ]
    );

    $widget->add_control(
        'youtube_id',
        [
            'label' => esc_html__('Video ID', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Enter video od here.', 'pe-core'),
            'condition' => [
                'video_provider' => ['youtube'],
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'vimeo_id',
        [
            'label' => esc_html__('Video ID', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => esc_html__('Enter video od here.', 'pe-core'),
            'condition' => [
                'video_provider' => ['vimeo'],
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'controls',
        [
            'label' => esc_html__('Controls', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'true',
            'condition' => [
                $conditionId => $conditionVal,
            ]
        ]
    );


    $widget->add_control(
        'select_controls',
        [
            'label' => esc_html__('Select Controls', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple' => true,
            'options' => [
                'play' => esc_html__('Play', 'pe-core'),
                'current-time' => esc_html__('Current Time', 'pe-core'),
                'duration' => esc_html__('Duration', 'pe-core'),
                'progress' => esc_html__('Progress Bar', 'pe-core'),
                'mute' => esc_html__('Mute', 'pe-core'),
                'volume' => esc_html__('Volume', 'pe-core'),
                'captions' => esc_html__('Captions', 'pe-core'),
                'settings' => esc_html__('Settings', 'pe-core'),
                'pip' => esc_html__('PIP', 'pe-core'),
                'airplay' => esc_html__('Airplay (Safari Only)', 'pe-core'),
                'fullscreen' => esc_html__('Fullscreen', 'pe-core'),
            ],
            'default' => ['play', 'current-time', 'duration', 'progress', 'mute', 'volume', 'fullscreen'],
            'condition' => [
                'controls' => ['true'],
                $conditionId => $conditionVal,
            ]
        ]
    );


    $widget->add_control(
        'autoplay',
        [
            'label' => esc_html__('Autoplay', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'word_notice',
        [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
           <span>When autoplay is enabled, many browsers require the video to be "muted" for it to autoplay properly.</div>',
            'condition' => [
                'autoplay' => 'true',
                $conditionId => $conditionVal,
            ],


        ]
    );

    $widget->add_control(
        'muted',
        [
            'label' => esc_html__('Muted', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'loop',
        [
            'label' => esc_html__('Loop', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'lightbox',
        [
            'label' => esc_html__('Play in Lightbox', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'pe-core'),
            'label_off' => esc_html__('No', 'pe-core'),
            'return_value' => 'true',
            'default' => 'false',
            'condition' => [
                'controls' => ['true'],
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'play_button',
        [
            'label' => esc_html__('Play Button', 'pe-core'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'icon',
            'options' => [
                'icon' => esc_html__('Icon', 'pe-core'),
                'text' => esc_html__('Text', 'pe-core'),
            ],
            'condition' => [
                'controls' => ['true'],
                $conditionId => $conditionVal,
            ]
        ]
    );

    $widget->add_control(
        'play_text',
        [
            'label' => esc_html__('Play Text', 'pe-core'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('PLAY', 'pe-core'),
            'condition' => [
                'play_button' => ['text'],
                'controls' => ['true'],
                $conditionId => $conditionVal,
            ],

        ]
    );

    $widget->add_control(
        'player_skin',
        [
            'label' => esc_html__( 'Player Skin', 'pe-core' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'global',
            'options' => [
                'global' => esc_html__( 'Use Global', 'pe-core' ),
                'skin--simple' => esc_html__( 'Simple', 'pe-core' ),
                'skin--rounded' => esc_html__( 'Rounded', 'pe-core' ),
                'skin--minimal' => esc_html__( 'Minimal', 'pe-core' ),
            ],
        ]
    );

}

function pe_video_render($widget , $repeater = false)
{

    if ($repeater) {
        $settings = $repeater;
    } else {
        $settings = $widget->get_settings_for_display();
    }
   

    $skin = $settings['player_skin'];
    $provider = $settings['video_provider'];
    $video_id = '';

    if ($provider === 'youtube') {

        $video_id = $settings['youtube_id'];
    }

    if ($provider === 'vimeo') {

        $video_id = $settings['vimeo_id'];
    }

    $controls = [];
    if ($settings['select_controls']) {
        foreach ($settings['select_controls'] as $control) {

            array_push($controls, $control);
        }
    }

    ?>

    <?php ob_start(); ?>
    <div class="pe-video pe-<?php echo $provider .' '. $skin  ?>" data-controls="<?php echo implode(',', $controls) ?>" data-autoplay="<?php echo $settings['autoplay'] ?>" data-muted="<?php echo $settings['muted'] ?>" data-loop="<?php echo $settings['loop'] ?>" data-lightbox="<?php echo $settings['lightbox'] ?>" >

        <?php if ($settings['lightbox'] === 'true') { ?>
            <div class="pe--lightbox--close x-icon">

                <div class="pl--close--icon">
                    <img src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../assets/img/close.svg'); ?>">
                </div>

            </div>
        <?php }

        if ($settings['controls'] === 'true') {

            if ($settings['play_button'] === 'icon') { ?>

                <div class="pe--large--play icons">

                    <div class="pe--play">

                        <svg xmlns="http://www.w3.org/2000/svg" height="100%" width="100%" viewBox="0 -960 960 960" width="24">
                            <path d="M320-200v-560l440 280-440 280Z" />
                        </svg>

                    </div>

                </div>

            <?php } else { ?>

                <div class="pe--large--play texts">
                    <div class="pe--play">
                        <?php echo esc_html($settings['play_text']); ?>
                    </div>
                </div>

            <?php }
        } ?>

        <?php if ($provider === 'self') { ?>

            <video class="p-video" playsinline loop autoplay>
                <source src="<?php echo esc_url($settings['self_video']['url']) ?>">
            </video>


        <?php } else { ?>

            <div class="p-video" data-plyr-provider="<?php echo $provider ?>" data-plyr-embed-id="<?php echo $video_id ?>"></div>

        <?php } ?>


    </div>
    <?php

$video = ob_get_clean();
return $video;

}