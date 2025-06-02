<?php
namespace PeElementor;

use Elementor\Core\Base\Module as BaseModule;
use Elementor\Modules\Library\Documents;
use Elementor\Core\DocumentTypes\Post;
use Elementor\Core\Documents_Manager;


/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin
{

  /**
   * Instance
   *
   * @since 1.0.0
   * @access private
   * @static
   *
   * @var Plugin The single instance of the class.
   */
  private static $_instance = null;

  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @since 1.2.0
   * @access public
   *
   * @return Plugin An instance of the class.
   */
  public static function instance()
  {

    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  /**
   * widget_scripts
   *
   * Load required plugin core files.
   *
   * @since 1.2.0
   * @access public
   */
  public function pe_scripts()
  {

    wp_enqueue_script('pe-text-ans', plugins_url('/assets/js/pe-text-animations.js', __FILE__), ['jquery'], false, true);

    wp_enqueue_script('pe-general-ans', plugins_url('/assets/js/pe-general-animations.js', __FILE__), ['jquery'], false, true);

    wp_enqueue_script('pe-image-ans', plugins_url('/assets/js/pe-image-animations.js', __FILE__), ['jquery'], false, true);

    wp_enqueue_script('pe-video-player', plugins_url('/assets/js/pe-video-player.js', __FILE__), ['jquery'], false, true);

    wp_enqueue_script('pe-bulge-effect', plugins_url('/assets/js/pe-bulge-effect.js', __FILE__), ['jquery'], false, true);

    $api_key = get_option('google_maps_api_key', '');

    wp_enqueue_script('widget-scripts', plugins_url('/assets/js/widget-scripts.js', __FILE__), ['jquery', 'google-maps-api'], false, true);

    wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key, [], null, true);



  }

  public function pe_editor_styles()
  {

    wp_register_style('editor-style', plugins_url('assets/css/editor.css', __FILE__));


    wp_enqueue_style('editor-style');

  }

  public function pe_editor_scripts()
  {

    wp_register_script('editor-script', plugins_url('assets/js/editor.js', __FILE__));

    wp_enqueue_script('editor-script');

  }


  /**
   * widget_styles
   *
   * Load required plugin core files.
   *
   * @since 1.2.0
   * @access public+
   */
  public function pe_styles()
  {

    wp_register_style('widget-styles', plugins_url('assets/css/widget-styles.css', __FILE__));

    wp_enqueue_style('widget-styles');


  }

  public function admin_styles()
  {

    wp_register_style('pe-admin-styles', plugins_url('assets/css/admin.css', __FILE__));

    wp_enqueue_style('pe-admin-styles');


  }


  /**
   * Register Custom Widget Categories
   *
   * @return void
   */
  public function add_elementor_widget_categories($elements_manager)
  {

    $elements_manager->add_category(
      'pe-content',
      [
        'title' => esc_html__('Content Elements', 'alioth'),
        'icon' => 'eicon-plug',
      ]
    );

    $elements_manager->add_category(
      'pe-showcase',
      [
        'title' => esc_html__('Showcase Widgets', 'alioth-elementor'),
        'icon' => 'eicon-sitemap',
      ]
    );

    $elements_manager->add_category(
      'pe-dynamic',
      [
        'title' => esc_html__('Dynamic Elements', 'alioth-elementor'),
        'icon' => 'eicon-sitemap',
      ]
    );

  }

  /**
   * Include Widgets files
   *
   * Load widgets files
   *
   * @since 1.2.0
   * @access private
   */
  private function include_widgets_files()
  {

    require_once (__DIR__ . '/widgets/circle-text.php');


    require_once (__DIR__ . '/widgets/tabs.php');
    require_once (__DIR__ . '/widgets/table.php');

    require_once (__DIR__ . '/widgets/marquee.php');

    require_once (__DIR__ . '/widgets/icon.php');
    require_once (__DIR__ . '/widgets/text-wrapper.php');
    require_once (__DIR__ . '/widgets/video.php');
    require_once (__DIR__ . '/widgets/slider.php');
    require_once (__DIR__ . '/widgets/carousel.php');
    require_once (__DIR__ . '/widgets/sc-controls.php');
    require_once (__DIR__ . '/widgets/clients.php');
    require_once (__DIR__ . '/widgets/single-image.php');
    require_once (__DIR__ . '/widgets/accordion.php');
    require_once (__DIR__ . '/widgets/testimonials.php');
    require_once (__DIR__ . '/widgets/layout-switcher.php');
    require_once (__DIR__ . '/widgets/single-post.php');
    require_once (__DIR__ . '/widgets/single-project.php');
    require_once (__DIR__ . '/widgets/blog-posts.php');
    require_once (__DIR__ . '/widgets/button.php');
    require_once (__DIR__ . '/widgets/forms.php');
    require_once (__DIR__ . '/widgets/team-member.php');

    require_once (__DIR__ . '/widgets/portfolio.php');
    require_once (__DIR__ . '/widgets/project-media.php');
    require_once (__DIR__ . '/widgets/project-field.php');
    require_once (__DIR__ . '/widgets/post-field.php');
    require_once (__DIR__ . '/widgets/post-media.php');

    require_once (__DIR__ . '/widgets/site-logo.php');
    require_once (__DIR__ . '/widgets/site-navigation.php');
    require_once (__DIR__ . '/widgets/nav-menu.php');

    require_once (__DIR__ . '/widgets/infinity-cards.php');
    require_once (__DIR__ . '/widgets/showcase-rotate.php');
    require_once (__DIR__ . '/widgets/showcase-slideshow.php');
    require_once (__DIR__ . '/widgets/showcase-wall.php');
    require_once (__DIR__ . '/widgets/fullscreen-cards.php');
    require_once (__DIR__ . '/widgets/showcase-carousel.php');
    require_once (__DIR__ . '/widgets/showcase-table.php');
    require_once (__DIR__ . '/widgets/fullscreen-list.php');
    require_once (__DIR__ . '/widgets/google-maps.php');

    if (class_exists('woocommerce')) {
      require_once (__DIR__ . '/widgets/shopping-cart.php');
      require_once (__DIR__ . '/widgets/products-archive.php');
      require_once (__DIR__ . '/widgets/single-product.php');
    }


  }

  /**
   * Register Widgets
   *
   * Register new Elementor widgets.
   *
   * @since 1.2.0
   * @access public
   */
  public function register_widgets()
  {
    // Its is now safe to include Widgets files
    $this->include_widgets_files();

    //     Register Widgets



    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peCircleText());

    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peTabs());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peTable());

    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peMarquee());

    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peIcon());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peTextWrapper());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peVideo());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peSlider());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peCarousel());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peScControls());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peClients());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peSingleImage());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peAccordion());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peTestimonials());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peLayoutSwitcher());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peSinglePost());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peSingleProject());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peBlogPosts());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peButton());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peForms());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peTeamMember());

    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\pePortfolio());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peProjectMedia());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peProjectField());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\pePostField());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\pePostMedia());

    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peSiteLogo());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peSiteNavigation());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peNavMenu());

    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peInfiniteCards());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peShowcaseRotate());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peShowcaseSlideshow());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peShowcaseWall());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peFullscreenCards());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peShowcaseCarousel());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peShowcaseTable());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peFullscreenList());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peGoogleMaps());

    if (class_exists('woocommerce')) {

      \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peProductsArchive());
      \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peShoppingCart());
      \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\peSingleProduct());

    }


  }

  public function pe_register_document_type($documents_manager)
  {
    require_once (__DIR__ . '/inc/template-types/project-hero.php');
    require_once (__DIR__ . '/inc/template-types/header.php');
    require_once (__DIR__ . '/inc/template-types/footer.php');
    require_once (__DIR__ . '/inc/template-types/menu.php');
    require_once (__DIR__ . '/inc/template-types/post.php');

    \Elementor\Plugin::$instance->documents->register_document_type('project-hero', Documents\Project_Hero::get_class_full_name());

    \Elementor\Plugin::$instance->documents->register_document_type('pe-header', Documents\Pe_Header::get_class_full_name());

    \Elementor\Plugin::$instance->documents->register_document_type('pe-footer', Documents\Pe_Footer::get_class_full_name());

    \Elementor\Plugin::$instance->documents->register_document_type('pe-menu', Documents\Pe_Menu::get_class_full_name());

    \Elementor\Plugin::$instance->documents->register_document_type('pe-post', Documents\Pe_Post::get_class_full_name());

  }

  /**
   *  Plugin class constructor
   *
   * Register plugin action hooks and filters
   *
   * @since 1.2.0
   * @access public
   */
  public function __construct()
  {
    $isActivated = get_option('is_activated');

    if ($isActivated) {
      add_action('elementor/frontend/after_register_scripts', [$this, 'pe_scripts']);

      add_action('elementor/frontend/after_enqueue_styles', [$this, 'pe_styles']);

      add_action('elementor/editor/before_enqueue_styles', [$this, 'pe_editor_styles']);

      add_action('elementor/editor/after_enqueue_scripts', [$this, 'pe_editor_scripts']);

      add_action('elementor/widgets/register', [$this, 'register_widgets']);

      add_action('elementor/documents/register', [$this, 'pe_register_document_type']);

      add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
    }

  }

}

Plugin::instance();
