<?php
namespace PeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
  exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class PeNavMenu extends Widget_Base
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
    return 'penavmenu';
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
    return __('Nav Menu', 'pe-core');
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
    return 'eicon-nav-menu pe-widget';
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
    return ['pe-dynamic'];
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

    // Tab Title Control
    $this->start_controls_section(
      'section_tab_title',
      [
        'label' => __('Nav Menu', 'pe-core'),
      ]
    );

    $this->add_control(
      'menu_style',
      [
        'label' => esc_html__('Menu Style', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'menu--vertical',
        'options' => [
          'menu--vertical' => esc_html__('Vertical', 'pe-core'),
          'menu--horizontal' => esc_html__('Horizontal', 'pe-core'),
        ],
      ]
    );

    $this->add_control(
      'select_menu',
      [
        'label' => esc_html__('Select Menu', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => $menus,
      ]
    );

    $this->add_control(
      'indexed',
      [
        'label' => esc_html__('Items Index', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'pe-core'),
        'label_off' => esc_html__('No', 'pe-core'),
        'return_value' => " menu--indexed",
        'default' => false,
      ]
    );

    $this->add_control(
      'sub_behavior',
      [
        'label' => esc_html__('Sub-Menu Behavior', 'pe-core'),
        'description' => esc_html__('If you select "toggle and parent"; Menu items which are parenting a sub-menu will not be directed to the link inserted for it, It will open sub-menu when it clicked. ', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'st--only',
        'options' => [
          'st--all' => esc_html__('Toggle and Parent', 'pe-core'),
          'st--only' => esc_html__('Toggle Only', 'pe-core'),
        ],
      ]
    );

    $this->add_control(
      'nav_visibility',
      [
        'label' => esc_html__('Show Navigation:', 'pe-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'always--show',
        'options' => [
          'always--show' => esc_html__('Always', 'pe-core'),
          'show--sticky' => esc_html__('When heeader stkicked/fixed.', 'pe-core'),
          'show--on--top' => esc_html__('When header on top.', 'pe-core'),
        ],
      ]
    );

    $this->end_controls_section();

    // pe_text_animation_settings($this);

    $this->start_controls_section(
      'style',
      [
        'label' => esc_html__('Styling', 'pe-core'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'parents_typography',
        'label' => esc_html__('Parent Items Typography', 'pe-core'),
        'selector' => '{{WRAPPER}} ul.menu.main-menu > li',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'subs_typography',
        'label' => esc_html__('Sub-Menu Items Typography', 'pe-core'),
        'selector' => '{{WRAPPER}} ul.menu ul.sub-menu li',
      ]
    );



    $this->end_controls_section();

    pe_color_options($this);


  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $option = get_option('pe-redux');
    $menuClasses = 'menu main-menu ' . $settings['menu_style'] . ' ' . $settings['indexed'];

    $this->add_render_attribute(
      '_wrapper',
      [
        'class' => 'wd--' . $settings['nav_visibility']

      ]
    );


    $subToggle = '<span class="sub--toggle st--plus"><span class="toggle--line"></span><span class="toggle--line"></span></span>';

    echo '<nav id="site-navigation" class="main-navigation ' . $settings['sub_behavior'] . '" data-sub-toggle="' . esc_attr($subToggle) . '">';

    wp_nav_menu(
      array(
        'theme_location' => '',
        'menu' => $settings['select_menu'],
        'container' => false,
        'menu_class' => $menuClasses,
        // 'before' => '<span ' . pe_text_animation($this) . ' class="anim--holder">',
        // 'after' => '</span>',
      )
    );

    echo '</nav>';

  }

}
