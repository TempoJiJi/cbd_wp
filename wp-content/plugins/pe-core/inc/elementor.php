<?php

function container_colors($element, $section_id, $args)
{

	if (('section' === $element->get_name() || 'container' === $element->get_name()) && 'section_background' === $section_id) {



		$element->start_controls_section(
			'custom_section',
			[
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'label' => esc_html__('Container Colors', 'pe-core'),
			]
		);

		$element->add_control(
			'switch_on_enter',
			[
				'label' => esc_html__('Switch Layout on Enter', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'switch_on_enter',
				'prefix_class' => '',
				'default' => false,
			]
		);

		$element->start_controls_tabs(
			'element_tabs'
		);

		$element->start_controls_tab(
			'colors_default',
			[
				'label' => esc_html__('Default', 'pe-core'),
			]
		);

		$element->add_control(
			'main_color',
			[
				'label' => esc_html__('Main Texts Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--mainColor: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'secondary_color',
			[
				'label' => esc_html__('Secondary Texts Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--secondaryColor: {{VALUE}}',
				],
			]
		);

		$element->end_controls_tab();

		$element->start_controls_tab(
			'colors_switched',
			[
				'label' => esc_html__('Switched', 'pe-core'),
			]
		);

		$element->add_control(
			'switched_main_color',
			[
				'label' => esc_html__('Main Texts Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'body.layout--switched {{WRAPPER}}' => '--mainColor: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'switched_secondary_color',
			[
				'label' => esc_html__('Secondary Texts Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'body.layout--switched {{WRAPPER}}' => '--secondaryColor: {{VALUE}}',
				],
			]
		);

		$element->end_controls_tab();

		$element->end_controls_tabs();

		$element->end_controls_section();




	}

}
add_action('elementor/element/before_section_start', 'container_colors', 10, 4);



function convert_containers($element, $section_id, $args)
{

	if (('container' === $element->get_name()) && 'section_layout_additional_options' === $section_id) {

		$element->start_controls_section(
			'convert_section',
			[
				'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
				'label' => esc_html__('Convert Container', 'pe-core'),
			]
		);

		$element->add_control(
			'convert_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-info">	
	           <span>When converting containers; create inner containers and their contents first and than select convert type, selecting convert type before building content may hard to navigate between items in the editor.</span></div>',
				'condition' => ['convert_container!' => 'convert--none'],
			]
		);


		$element->add_control(
			'convert_container',
			[
				'label' => 'Convert Container',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'convert--none' => 'None',
					'convert--layered' => 'Layered',
					'convert--carousel' => 'Carousel',
					'convert--tabs' => 'Tabs',
					'convert--accordion' => 'Accordion',
				],
				'default' => 'convert--none',
				'render_type' => 'template',
				'prefix_class' => '',
			]
		);

		$element->add_control(
			'container_carousel_id',
			[
				'label' => esc_html__('Carousel ID', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('An id will required if the carousel controls from other widgets will be used.', 'pe-core'),
				'ai' => false,
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--carousel'],
			]
		);


		$element->add_control(
			'container_carousel_behavior',
			[
				'label' => esc_html__('Carousel Behavior', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'cr--drag',
				'options' => [
					'cr--drag' => esc_html__('Drag', 'pe-core'),
					'cr--scroll' => esc_html__('Scroll', 'pe-core'),
				],
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--carousel'],
			]
		);

		$element->add_control(
			'container_carousel_trigger',
			[
				'label' => esc_html__('Carousel Trigger', 'pe-core'),
				'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('Normally the carousel pin itself but in some cases, a custom trigger may required.', 'pe-core'),
				'ai' => false,
				'prefix_class' => '',
				'condition' => ['container_carousel_behavior' => 'cr--scroll'],
			]
		);

		$element->add_control(
			'scroll_speed',
			[
				'label' => esc_html__('Scroll Speed', 'pe-core'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'step' => 100,
				'default' => 1000,
				'prefix_class' => 'layered_speed_',
				'condition' => ['convert_container' => 'convert--layered'],
			]
		);

		$element->add_control(
			'only_desktop',
			[
				'label' => esc_html__('Only Desktop', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'only__desktop',
				'prefix_class' => '',
				'render_type' => 'template',
				'condition' => [
					'convert_container' => 'convert--layered'
				]
			]
		);

		$element->add_control(
			'pin_target',
			[
				'label' => esc_html__('Pin Target', 'pe-core'),
				'placeholder' => esc_html__('Eg. #worksContainer', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__('Normally the container pin itself but in some cases, a custom trigger may required.', 'pe-core'),
				'ai' => false,
				'prefix_class' => 'layered_target_',
				'condition' => ['convert_container' => 'convert--layered'],
			]
		);

		$element->add_control(
			'cursor_drag',
			[
				'label' => esc_html__('Cursor Drag Interaction', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'cursor_drag',
				'prefix_class' => '',
				'default' => false,
				'condition' => ['convert_container' => 'convert--carousel'],
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'container_tab_title',
			[
				'label' => esc_html__('Title', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Title', 'pe-core'),
				'label_block' => true,
			]
		);

		$element->add_control(
			'container_tab_titles',
			[
				'label' => esc_html__('Tab Titles', 'pe-core'),
				'description' => esc_html__('Please enter titles in accordance with the order of the containers, ensuring that the number of titles matches the number of containers within the tabs.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'container_tab_title' => esc_html__('Title #1', 'pe-core'),
					],
					[
						'container_tab_title' => esc_html__('Title #2', 'pe-core'),
					],
				],
				'title_field' => '{{{ container_tab_title }}}',
				'condition' => ['convert_container' => 'convert--tabs'],
			]
		);

		$element->add_control(
			'tab_titles_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-control-field-description">Please enter titles in accordance with the order of the containers, ensuring that the number of titles matches the number of containers within the tabs</div>',
				'condition' => ['convert_container' => 'convert--tabs'],
			]
		);

		$element->add_responsive_control(
			'title_alignment',
			[
				'label' => esc_html__('Titles Alignment', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__('Left', 'pe-core'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'pe-core'),
						'icon' => 'eicon-text-align-center'
					],
					'end' => [
						'title' => esc_html__('Right', 'pe-core'),
						'icon' => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => esc_html__('Justify', 'pe-core'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'start',
				'condition' => ['convert_container' => 'convert--tabs'],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .container--tab--titles--wrap' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_title_typography',
				'label' => esc_html__('Title Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .container--tab--title',
				'condition' => ['convert_container' => 'convert--tabs'],
			]
		);


		$element->add_responsive_control(
			'tab_titles_gap',
			[
				'label' => esc_html__('Titles Gap', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'condition' => [
					'background_type' => ['color']
				],
				'selectors' => [
					'{{WRAPPER}} .container--tab--titles--wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['convert_container' => 'convert--tabs'],
			]
		);


		$element->add_control(
			'show_seperator',
			[
				'label' => esc_html__('Show Seperator', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'show--seperator',
				'default' => 'false',
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--tabs'],

			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_seperator_typography',
				'label' => esc_html__('Seperator Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .tabs--seperator',
				'condition' => [
					'show_seperator' => 'show--seperator',
					'convert_container' => 'convert--tabs'
				]
			]
		);


		$element->add_control(
			'accordion_type',
			[
				'label' => esc_html__('Accordion Type', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ac--nested',
				'options' => [
					'ac--ordered' => esc_html__('Ordered', 'pe-core'),
					'ac--nested' => esc_html__('Nested', 'pe-core'),
				],
				'prefix_class' => 'container--',
				'label_block' => false,
				'condition' => ['convert_container' => 'convert--accordion'],
			]
		);

		$element->add_control(
			'open_first',
			[
				'label' => esc_html__('Active First', 'pe-core'),
				'description' => esc_html__('First item will be active as default.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'active--first',
				'default' => 'false',
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--accordion'],

			]
		);

		$element->add_control(
			'toggle_style',
			[
				'label' => esc_html__('Toggle Style', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'toggle--plus',
				'options' => [
					'toggle--plus' => esc_html__('Plus', 'pe-core'),
					'toggle--dot' => esc_html__('Dot', 'pe-core'),
					// 'toggle--custom' => esc_html__('Custom', 'pe-core'),
				],
				'label_block' => false,
				'prefix_class' => 'ac--',
				'condition' => ['convert_container' => 'convert--accordion'],
			]
		);

		// $element->add_control(
		// 	'accordion_open_icon',
		// 	[
		// 		'label' => esc_html__('Open Icon', 'pe-core'),
		// 		'type' => \Elementor\Controls_Manager::ICONS,
		// 		'skin' => 'inline',
		// 		'separator' => 'before',
		// 		'label_block' => false,
		// 		'default' => [
		// 			'value' => 'fas fa-plus',
		// 			'library' => 'fa-solid',
		// 		],
		// 		'condition' => [
		// 			'toggle_style' => 'toggle--custom',
		// 			'convert_container' => 'convert--accordion'
		// 		]
		// 	]
		// );

		// $element->add_control(
		// 	'accordion_close_icon',
		// 	[
		// 		'label' => esc_html__('Close Icon', 'pe-core'),
		// 		'type' => \Elementor\Controls_Manager::ICONS,
		// 		'skin' => 'inline',
		// 		'separator' => 'before',
		// 		'label_block' => false,
		// 		'default' => [
		// 			'value' => 'fas fa-plus',
		// 			'library' => 'fa-solid',
		// 		],
		// 		'condition' => [
		// 			'toggle_style' => 'toggle--custom',
		// 			'convert_container' => 'convert--accordion'
		// 		]
		// 	]
		// );

		$element->add_control(
			'underlined',
			[
				'label' => esc_html__('Underlined?', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'ac--underlined',
				'default' => 'false',
				'prefix_class' => '',
				'condition' => ['convert_container' => 'convert--accordion'],
			]
		);

		$element->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__('Title Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .container--accordion--title',
				'condition' => ['convert_container' => 'convert--accordion'],
			]
		);
		$element->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'order_typography',
				'label' => esc_html__('Order Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} span.ac-order',
				'condition' => [
					'accordion_type' => 'ac--ordered',
					'convert_container' => 'convert--accordion'
				]
			]
		);

		$element->end_controls_section();

	}

}
add_action('elementor/element/before_section_start', 'convert_containers', 10, 4);

function container_animations($element, $section_id, $args)
{
	if (('section' === $element->get_name() || 'container' === $element->get_name()) && 'section_layout_additional_options' === $section_id) {
		pe_general_animation_settings($element, \Elementor\Controls_Manager::TAB_LAYOUT, true);
	}

}
add_action('elementor/element/before_section_start', 'container_animations', 10, 3);


function container_notice($element, $section_id, $args)
{

	if (('container' === $element->get_name()) && 'section_layout_container' === $section_id) {

		$element->add_control(
			'converted_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="elementor-panel-notice elementor-panel-alert elementor-panel-alert-danger">	
				   <span>This container has been converted. You can view converting preferences via <u>"Convert Container"</u> section below.</span></div>',
				'condition' => ['convert_container!' => 'convert--none'],

			]

		);



	}

	if (('container' === $element->get_name()) && 'section_layout_additional_options' === $section_id) {

		$element->add_control(
			'container_title',
			[
				'label' => esc_html__('Container Title', 'pe-core'),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter container title here.', 'pe-core'),
				'description' => esc_html__('If this container is a sub-element of a container that has been converted to an accordion or tab, a title must be entered.', 'pe-core'),
				'ai' => false

			]
		);



	}
}
add_action('elementor/element/after_section_start', 'container_notice', 10, 4);


function container_background_settings($element, $section_id, $args)
{

	if ('container' === $element->get_name() && 'section_background' === $section_id) {

		$element->add_control(
			'pe_background_sec',
			[
				'label' => esc_html__('Theme Backgrounds', 'pe-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$element->add_control(
			'background_type',
			[
				'label' => 'Background Type',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'color' => 'Color',
					'video' => 'Video',
					'image' => 'Image',
				],
				'default' => 'none',
				'prefix_class' => 'bg--',
			]
		);


		$element->add_control(
			'video_provider',
			[
				'label' => 'Video Provider',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'self' => 'Self',
					'vimeo' => 'Vimeo',
					'youtube' => 'Youtube',
				],
				'default' => 'self',
				'prefix_class' => '',
				'condition' => [
					'background_type' => ['video']
				]
			]
		);

		$element->add_control(
			'sec_video',
			[
				'label' => esc_html__('Choose Video', 'pe-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['mp4'],

				'condition' => [
					'video_provider' => ['self'],
					'background_type' => ['video']
				]
			]
		);

		$element->add_control(
			'youtube_id',
			[
				'label' => esc_html__('Video ID', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Youtube video ID', 'pe-core'),
				'condition' => [
					'video_provider' => ['youtube'],
					'background_type' => ['video']

				]

			]
		);

		$element->add_control(
			'vimeo_id',
			[
				'label' => esc_html__('Video ID', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Vimeo video ID', 'pe-core'),
				'condition' => [
					'video_provider' => ['vimeo'],
					'background_type' => ['video']
				]

			]
		);

		$element->start_controls_tabs(
			'bg_color_Tabs'
		);

		$element->start_controls_tab(
			'bg_default',
			[
				'label' => esc_html__('Default', 'pe-core'),
				'condition' => [
					'background_type' => ['color']
				]
			]
		);

		$element->add_control(
			'main_background',
			[
				'label' => esc_html__('Main Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--mainBackground: {{VALUE}} !important',
				],
				'condition' => [
					'background_type' => ['color']
				]

			]
		);

		$element->add_control(
			'secondary_background',
			[
				'label' => esc_html__('Secondary Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => '--secondaryBackground: {{VALUE}}',
				],
				'condition' => [
					'background_type' => ['color']
				]

			]
		);


		$element->end_controls_tab();

		$element->start_controls_tab(
			'bg_switched',
			[
				'label' => esc_html__('Switched', 'pe-core'),
				'condition' => [
					'background_type' => ['color']
				]
			]
		);

		$element->add_control(
			'switched_main_background',
			[
				'label' => esc_html__('Main Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'body.layout--switched {{WRAPPER}}' => '--mainBackground: {{VALUE}}',
					'body.layout--switched .reverse__' . $element->get_id() => '--mainBackground: {{VALUE}}',
				],
				'condition' => [
					'background_type' => ['color']
				]

			]
		);

		$element->add_control(
			'switched_secondary_background',
			[
				'label' => esc_html__('Secondary Background', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'body.layout--switched {{WRAPPER}}' => '--secondaryBackground: {{VALUE}}',
				],
				'condition' => [
					'background_type' => ['color']
				]

			]
		);


		$element->end_controls_tab();

		$element->end_controls_tabs();


		$element->add_control(
			'curved_bg',
			[
				'label' => esc_html__('Curved Background', 'pe-core'),
				'description' => esc_html__('For "classic" background type only.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'true',
				'default' => 'false',
				'render_type' => 'template',
				'prefix_class' => 'curved_',
				'condition' => [
					'background_type' => ['color']
				]

			]
		);

		$element->add_responsive_control(
			'curves',
			[
				'label' => esc_html__('Curves', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'pe-core'),
						'icon' => 'eicon-v-align-top',
					],
					'both' => [
						'title' => esc_html__('Both', 'pe-core'),
						'icon' => 'eicon-justify-space-between-v'
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'pe-core'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'both',
				'condition' => [
					'curved_bg' => ['true']
				]
			]
		);

		$element->add_responsive_control(
			'curve',
			[
				'label' => esc_html__('Curve Size', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 75,
				],
				'condition' => [
					'background_type' => ['color']
				],
				'selectors' => [
					'{{WRAPPER}} .bg--reverse-layer' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_control(
			'background_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => "<div class='elementor-panel-notice elementor-panel-alert elementor-panel-alert-info'>	
	           <span>If you use Elementor's default background settings for a background adjustment, you won't be able to use some theme features for this container. For example, curved backgrounds, color changes in layout switch, etc</span></div>",
				'condition' => [
					'background_background' => ['classic', 'gradient', 'video', 'slideshow'],
				],

			]
		);

		$element->add_control(
			'elementor_bg_notice',
			[
				'label' => esc_html__('Elementor Backgrounds', 'pe-core'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);



	}

	if ('container' === $element->get_name() && 'section_border' === $section_id) {

		$element->add_control(
			'animate_radius',
			[
				'label' => esc_html__('Animate Radius', 'pe-core'),
				'description' => esc_html__('For "classic" background type only.', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'animate--radius',
				'default' => 'no',
				'prefix_class' => '',
				'render_type' => 'template',

			]
		);


	}

	if ('container' === $element->get_name() && 'section_border' === $section_id) {

		$element->add_control(
			'integared_width',
			[
				'label' => esc_html__('Intergrate Width', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'pe-core'),
				'label_off' => esc_html__('No', 'pe-core'),
				'return_value' => 'yes',
				'default' => 'no',
				'render_type' => 'template',

			]
		);


	}

}
add_action('elementor/element/after_section_start', 'container_background_settings', 10, 3);

function container_attributes($element)
{

	if ($element->get_settings('integared_width') === 'yes') {

		$element->add_render_attribute(
			'_wrapper',
			[
				'class' => 'integared--width',

			]
		);

	}
	if ($element->get_settings('convert_container') === 'convert--carousel') {

		$element->add_render_attribute(
			'_wrapper',
			[
				'class' => $element->get_settings('convert_container') . ' ' . $element->get_settings('container_carousel_behavior') . ' carousel_id_' . $element->get_settings('container_carousel_id') . ' carousel_trigger_' . $element->get_settings('container_carousel_trigger'),
				'data-carousel-id' => $element->get_settings('container_carousel_id') ? $element->get_settings('container_carousel_id') : 'cr--' . $element->get_id(),
				'data-trigger' => $element->get_settings('container_carousel_trigger')

			]
		);

	}

	if ($element->get_settings('select_animation') !== 'none') {

		// Animations 
		$out = $element->get_settings('animate_out') ? $element->get_settings('animate_out') : 'false';

		$dataset = '{' .
			'duration=' . $element->get_settings('duration') . '' .
			';delay=' . $element->get_settings('delay') . '' .
			';stagger=' . $element->get_settings('stagger') . '' .
			';pin=' . $element->get_settings('pin') . '' .
			';pinTarget=' . $element->get_settings('pinned_target') . '' .
			';scrub=' . $element->get_settings('scrub') . '' .
			';item_ref_start=' . $element->get_settings('item_ref_start') . '' .
			';window_ref_start=' . $element->get_settings('window_ref_start') . '' .
			';item_ref_end=' . $element->get_settings('item_ref_end') . '' .
			';window_ref_end=' . $element->get_settings('window_ref_end') . '' .
			';out=' . $out . '' .
			'}';

		$checkMarkers = '';

		if (\Elementor\Plugin::$instance->editor->is_edit_mode() && $element->get_settings('show_markers')) {
			$checkMarkers = ' markers-on';
		}


		$animation = $element->get_settings('select_animation') !== 'none' ? $element->get_settings('select_animation') : '';

		//Scroll Button Attributes
		$element->add_render_attribute(
			'_wrapper',
			[
				'data-anim-general' => 'true',
				'data-animation' => $animation,
				'data-settings' => $dataset,
			]
		);

	}

	if ($element->get_settings('container_title')) {

		//Scroll Button Attributes
		$element->add_render_attribute(
			'_wrapper',
			[
				'data-title' => $element->get_settings('container_title'),
			]
		);

	}

	// if ($element->get_settings('convert_container') === 'convert--accordion') {


	// 	$element->add_render_attribute(
	// 		'_wrapper',
	// 		[
	// 			'data-accordion-length' => count($element->get_children()),
	// 		]
	// 	);

	// }



}
add_action('elementor/frontend/container/before_render', 'container_attributes');


function container_backgrounds($element)
{

	if ($element->get_settings('background_type') === 'video') {

		$id = $element->get_id();
		$provider = $element->get_settings('video_provider');

		if ($provider === 'vimeo') {

			$video_id = $element->get_settings('vimeo_id');

		} else if ($provider === 'youtube') {

			$video_id = $element->get_settings('youtube_id');
		} else {

			$video_id = false;
		}
		?>
		<div class="container--bg bg--for--<?php echo $id ?>">

			<div class="pe-video n-<?php echo $provider; ?> no-interactions" data-controls="false" data-autoplay=true
				data-muted=true data-loop=true>

				<?php if ($provider !== 'self') { ?>

					<div class="pe-video-wrap" data-plyr-provider="<?php echo $provider; ?>"
						data-plyr-embed-id="<?php echo $video_id ?>"></div>

				<?php } else { ?>

					<video autoplay muted playsinline loop class="pe-video-wrap">
						<source src="<?php echo $element->get_settings('sec_video')['url']; ?>">
					</video>

				<?php } ?>
			</div>

		</div>

		<?php

	}

	if ($element->get_settings('curved_bg') === 'true' && $element->get_settings('background_type') === 'color' && $element->get_settings('curves') !== 'bottom') {

		$curve = $element->get_settings('curve');

		if (isset($curve)) {
			$size = $element->get_settings('curve')['size'] . $element->get_settings('curve')['unit'];

			echo '<div class="reverse--hold rh--top reverse__' . $element->get_id() . '"><span style="width:' . $size . ';height:' . $size . '" class="bg--reverse-layer rl-top rl-left"></span>';
			echo '<span  style="width:' . $size . ';height:' . $size . '"class="bg--reverse-layer rl-top rl-right"></span></div>';
		}

	}

	if ($element->get_settings('convert_container') === 'convert--tabs') { ?>

		<div class="container--tab--titles--wrap container--tab--titles__<?php echo $element->get_id(); ?>">
			<?php foreach ($element->get_settings('container_tab_titles') as $key => $title) {
				$key++;
				$seperator = '<span class="tabs--seperator">/</span>';
				$active = $key == 1 ? 'active' : '';

				echo '<div class="container--tab--title ' . $active . '" data-index="' . $key . '">' . $title['container_tab_title'] . '</div>' . $seperator;
			} ?>

		</div>
		<?php

	}

	if ($element->get_settings('container_title')) { ?>

		<div class="container--accordion--title" data-id="<?php echo $element->get_id(); ?>">

			<span class="ac-order">1</span>

			<?php echo $element->get_settings('container_title') ?>

			<!-- <span class="accordion-toggle toggle--custom"> -->

			<!-- toggle custom  -->
			<!-- <span class="ac--togle ac-toggle-open"></span> -->

			<!-- <span class="ac--togle ac-toggle-close"></span> -->
			<!-- toggle custom  -->
			<!-- </span> -->

			<span class="accordion-toggle toggle--plus">

				<!-- toggle plus  -->
				<span></span>
				<span></span>
				<!-- toggle plus  -->
			</span>

			<span class="accordion-toggle toggle--dot">

				<!-- toggle dot  -->
				<span></span>
				<!-- toggle dot  -->

			</span>

		</div>

		<?php
	}

}
add_action('elementor/frontend/container/before_render', 'container_backgrounds');

function reverse_backgrounds($element)
{

	if ($element->get_settings('curved_bg') === 'true' && $element->get_settings('background_type') === 'color' && $element->get_settings('curves') !== 'top') {
		$curve = $element->get_settings('curve');

		if (isset($curve)) {
			$size = $element->get_settings('curve')['size'] . $element->get_settings('curve')['unit'];

			echo '<div class="reverse--hold rh--bottom reverse__' . $element->get_id() . '"><span style="width:' . $size . ';height:' . $size . '" class="bg--reverse-layer rl-bottom rl-left"></span>';
			echo '<span style="width:' . $size . ';height:' . $size . '" class="bg--reverse-layer rl-bottom rl-right"></span></div>';
		}

	}

}
add_action('elementor/frontend/container/after_render', 'reverse_backgrounds');

function container_render($template, $element)
{

	ob_start(); ?>

	<# if ( 'true'===settings.curved_bg && 'color'===settings.background_type && 'bottom' !==settings.curves ) { #>
		<div class="reverse--hold">
			<span class="bg--reverse-layer rl-top rl-left"></span>
			<span class="bg--reverse-layer rl-top rl-right"></span>
		</div>
		<# } #>

			<# if ( 'video'===settings.background_type ) { let provider=settings.video_provider; if (provider==='vimeo' ) {
				var video_id=settings.vimeo_id; } else if (provider==='youtube' ) { var video_id=settings.youtube_id; } else
				{ var video_id=false; } #>

				<div class="container--bg">

					<div class="pe-video n-{{provider}} no-interactions" data-controls="false" data-autoplay=true
						data-muted=true data-loop=true>

						<# if ( 'self' !==provider ) { #>

							<div class="pe-video-wrap" data-plyr-provider="{{provider}}" data-plyr-embed-id="{{video_id}}">
							</div>

							<# } else { #>

								<video autoplay muted playsinline loop class="pe-video-wrap">
									<source src="{{settings.sec_video.url}}">
								</video>

								<# } #>
					</div>

				</div>
				<# } #>

					<?php

					$acc = ob_get_clean();

					ob_start(); ?>

					<# if ( 'true'===settings.curved_bg && 'color'===settings.background_type && 'top' !==settings.curves )
						{ #>

						<div class="reverse--hold">
							<span class="bg--reverse-layer rl-bottom rl-left"></span>
							<span class="bg--reverse-layer rl-bottom rl-right"></span>
						</div>
						<# } #>

							<?php $dcc = ob_get_clean();

							ob_start(); ?>
							<# if ( 'none' !==settings.select_animation ) { let anim=settings.select_animation,
								duration=settings.duration, delay=settings.delay, stagger=settings.stagger,
								pin=settings.pin, pinTarget=settings.pinned_target, scrub=settings.scrub,
								item_ref_start=settings.item_ref_start, window_ref_start=settings.window_ref_start,
								item_ref_end=settings.item_ref_end, window_ref_end=settings.window_ref_end,
								out=settings.animate_out; #>
								<div hidden class="container--anim--hold" data-anim-general=true data-animation="{{anim}}"
									data-settings="{duration={{duration}};delay={{delay}};stagger={{stagger}};pin={{pin}};pinTarget={{pinTarget}};scrub={{scrub}};item_ref_start={{item_ref_start}};window_ref_start={{window_ref_start}};item_ref_end={{item_ref_end}};window_ref_end={{window_ref_end}};out={{out}}}">
								</div>
								<# } #>

									<?php $anim = ob_get_clean();

									ob_start(); ?>

									<# if ( 'convert--tabs'===settings.convert_container) { #>
										<div class="container--tab--titles--wrap">
											<# _.each( settings.container_tab_titles, function( item, index ) { index++; let
												active=index==1 ? 'active' : '' ; #>

												<div class="container--tab--title {{active}}" data-index="{{index}}">{{
													item.container_tab_title }}</div>
												<span class="tabs--seperator">/</span>

												<# } ); #>
										</div>
										<# } #>

											<?php $tabbed = ob_get_clean();


											ob_start(); ?>

											<# if ( settings.container_title) { let title=settings.container_title; #>
												<div class="container--accordion--title" data-id="">

													<span class="ac-order">1</span>

													{{title}}

													<span class="accordion-toggle toggle--plus">
														<span></span>
														<span></span>
													</span>

													<span class="accordion-toggle toggle--dot">
														<span></span>
													</span>

												</div>
												<# } #>

													<?php $accordion = ob_get_clean();


													return $acc . $anim . $tabbed . $accordion . $template . $dcc;
}


add_action("elementor/container/print_template", "container_render", 10, 2);