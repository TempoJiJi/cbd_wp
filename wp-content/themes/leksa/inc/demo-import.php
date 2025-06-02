<?php

function ocdi_import_files()
{
  return array(
    array(
      'import_file_name' => 'All Demo Content with Images',
      'import_file_url' => 'https://themes.pethemes.com/leksa/demos/all-with-images.xml',
      'import_customizer_file_url' => 'https://themes.pethemes.com/leksa/demos/l-customizer.dat',

      'import_redux' => array(
        array(
          'file_url' => 'https://themes.pethemes.com/leksa/demos/l-redux.json',
          'option_name' => 'pe-redux',
        ),
      ),

      'import_preview_image_url' => 'https://themes.pethemes.com/leksa/demos/all_w_imgs.png',
      'preview_url' => 'https://leksa.pethemes.com/',
    ),
    array(
      'import_file_name' => 'All Demo Content without Images',
      'import_file_url' => 'https://themes.pethemes.com/leksa/demos/all-no-images.xml',
      'import_customizer_file_url' => 'https://themes.pethemes.com/leksa/demos/l-customizer.dat',

      'import_redux' => array(
        array(
          'file_url' => 'https://themes.pethemes.com/leksa/demos/l-redux.json',
          'option_name' => 'pe-redux',
        ),
      ),

      'import_preview_image_url' => 'https://themes.pethemes.com/leksa/demos/all_no_imgs.png',
      'preview_url' => 'https://leksa.pethemes.com/',
    ),
    array(
      'import_file_name' => 'Templates Only',
      'import_file_url' => 'https://themes.pethemes.com/leksa/demos/templates-only.xml',
      'import_preview_image_url' => 'https://themes.pethemes.com/leksa/demos/templates_onn.png',
      'preview_url' => 'https://leksa.pethemes.com/',
    ),
    array(
      'import_file_name' => 'Projects Only',
      'import_file_url' => 'https://themes.pethemes.com/leksa/demos/projects-only.xml',
      'import_preview_image_url' => 'https://themes.pethemes.com/leksa/demos/projects_only.png',
      'preview_url' => 'https://leksa.pethemes.com/',
    ),
    array(
      'import_file_name' => 'Pages Only',
      'import_file_url' => 'https://themes.pethemes.com/leksa/demos/pages-only.xml',
      'import_preview_image_url' => 'https://themes.pethemes.com/leksa/demos/pages_only.png',
      'preview_url' => 'https://leksa.pethemes.com/',
    ),
    array(
      'import_file_name' => 'Products Only',
      'import_file_url' => 'https://themes.pethemes.com/leksa/demos/products-only.xml',
      'import_preview_image_url' => 'https://themes.pethemes.com/leksa/demos/products_only.png',
      'preview_url' => 'https://leksa.pethemes.com/',
    ),
    array(
      'import_file_name' => 'Posts Only',
      'import_file_url' => 'https://themes.pethemes.com/leksa/demos/posts-only.xml',
      'import_preview_image_url' => 'https://themes.pethemes.com/leksa/demos/posts_only.png',
      'preview_url' => 'https://leksa.pethemes.com/',
    ),
  );
}
add_filter('pt-ocdi/import_files', 'ocdi_import_files');

function ocdi_after_import_setup()
{
  // Assign menus to their locations.
  $main_menu = get_term_by('name', 'Main Menu - Hozirontal', 'nav_menu');

  set_theme_mod(
    'nav_menu_locations',
    array(
      'menu-1' => $main_menu->term_id, // replace 'main-menu' here with the menu location identifier from register_nav_menu() function
    )
  );

  // Assign front page and posts page (blog page).
  $front_page_id = get_page_by_title('Home');
  //    $blog_page_id  = get_page_by_title( 'Journal' );

  update_option('show_on_front', 'page');
  update_option('page_on_front', $front_page_id->ID);
  //    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action('pt-ocdi/after_import', 'ocdi_after_import_setup');


add_filter('pt-ocdi/disable_pt_branding', '__return_true');

function ocdi_plugin_intro_text($default_text)
{

  $isActivated = get_option('is_activated');

  if (!$isActivated) {

    $default_text .= '<div class="leksa-settings-disabled"></div>
<div class="nsd-warn"><h4>You need to activate the theme with your purchase code to gain access to one click demo importer.</h4></div>';

    return $default_text;
  }

}

add_filter('ocdi/plugin_intro_text', 'ocdi_plugin_intro_text');