<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeScControls extends Widget_Base
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
		return 'pesccontrols';
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
		return __('Slider/Carousel Controls', 'pe-core');
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
		return 'eicon-carousel pe-widget';
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


		// Tab Title Control
		$this->start_controls_section(
			'section_tab_title',
			[
				'label' => __('Slider/Carousel Controls', 'pe-core'),
			]
		);
		$this->add_control(
			'control_type',
			[
				'label' => __('Control Type', 'pe-core'),
				'label_block' => true,
				'default' => 'fraction',
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'fraction' => esc_html__('Fraction', 'pe-core'),
					'progressbar' => esc_html__('Progressbar', 'pe-core'),
					'navigation' => esc_html__('Navigation', 'pe-core'),
				],

			]
		);

		$this->add_control(
			'target_id',
			[
				'label' => esc_html__('Target Carousel/Slider ID', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'ai' => false,
				'description' => esc_html__('Must be exact match with the carousel/slider ID.', 'pe-core'),
			]
		);

		$this->add_control(
			'nav_type',
			[
				'label' => esc_html__('Navigation Type', 'pe-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'text' => esc_html__('Text', 'pe-core'),
					'icon' => esc_html__('Icon', 'pe-core')
				],
				'default' => 'icon',
				'condition' => [
					'control_type' => 'navigation'
				]
			]
		);

		$this->add_control(
			'prev_text',
			[
				'label' => esc_html__('Prev Text', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('PREV', 'pe-core'),
				'condition' => [
					'control_type' => 'navigation',
					'nav_type' => 'text'
				]
			]
		);

		$this->add_control(
			'next_text',
			[
				'label' => esc_html__('Next Text', 'pe-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('NEXT', 'pe-core'),
				'condition' => [
					'control_type' => 'navigation',
					'nav_type' => 'text'
				]
			]
		);

		$this->add_control(
			'prev_icon',
			[
				'label' => esc_html__('Prev Icon', 'pe-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => [
					'control_type' => 'navigation',
					'nav_type' => 'icon'
				]
			]
		);

		$this->add_control(
			'next_icon',
			[
				'label' => esc_html__('Next Icon', 'pe-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => [
					'control_type' => 'navigation',
					'nav_type' => 'icon'
				]
			]
		);

		$this->add_control(
			'seperator_icon',
			[
				'label' => esc_html__('Seperator Icon', 'pe-core'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'material-icons md-arrow_outward',
					'library' => 'material-design-icons',
				],
				'condition' => ['control_type' => 'fraction'],
			]
		);


		$this->add_responsive_control(
			'bar_width',
			[
				'label' => esc_html__('Bar Width', 'pe-core'),
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
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors' => [
					'{{WRAPPER}} .sc--progressbar' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['control_type' => 'progressbar'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => esc_html__('Typography', 'pe-core'),
				'selector' => '{{WRAPPER}} .sc--fraction',
			]
		);

		$this->add_control(
			'fraction_color',
			[
				'label' => esc_html__('Color', 'pe-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pe--sc--controls' => '--mainColor: {{VALUE}}',
				],
			]
		);


		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__('Alignment', 'pe-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__('Left', 'pe-core'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'pe-core'),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__('Right', 'pe-core'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'flex-start',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .pe--sc--controls' => 'justify-content: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();

		pe_color_options($this);

	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$option = get_option('pe-redux');

		ob_start();

		\Elementor\Icons_Manager::render_icon($settings['seperator_icon'], ['aria-hidden' => 'true']);

		$icon = ob_get_clean();

		?>



		<div class="pe--sc--controls" data-id='<?php echo esc_attr($settings['target_id']) ?>'>

			<?php if ($settings['control_type'] === 'fraction') { ?>
				<div class="sc--fraction">

					<span class="sc--current"></span>

					<?php echo $icon ?>

					<span class="sc--total"></span>

				</div>
			<?php } ?>

			<?php if ($settings['control_type'] === 'progressbar') { ?>

				<div class="sc--progressbar">

					<span class="sc--prog"></span>
					<span class="sc--full"></span>

				</div>

			<?php } ?>

			<?php if ($settings['control_type'] === 'navigation') { ?>

				<div class="sc--navigation">

					<span class="sc--prev">

						<?php if ($settings['nav_type'] === 'text') {

							echo $settings['prev_text'];

						} else if ($settings['nav_type'] === 'icon') { 
						 \Elementor\Icons_Manager::render_icon( $settings['prev_icon'], [ 'aria-hidden' => 'true' ] ); 
						}?>

					</span>

					<span class="sc--next">



						<?php if ($settings['nav_type'] === 'text') {

							echo $settings['next_text'];

						} else if ($settings['nav_type'] === 'icon') { 
							\Elementor\Icons_Manager::render_icon( $settings['next_icon'], [ 'aria-hidden' => 'true' ] ); 
						   }?>



					</span>

				</div>

			<?php } ?>

		</div>



		<?php
	}

}
