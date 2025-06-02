<?php
if (!class_exists("Redux")) {
    return;
}

$opt_name = "pe-redux";

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = [
    "display_name" => $theme->get("Name") . " Options",
    "display_version" => $theme->get("Version"),
    "menu_title" => esc_html__("Theme Options", "pe-core"),
    "customizer" => false,
    "dev_mode" => false,
    'output' => true,
    'output_variables' => true
];

Redux::setArgs($opt_name, $args);
// Redux::set_extensions($opt_name, __DIR__ . '/extensions');
// Redux::get_extensions($opt_name);

Redux::setSection($opt_name, [
    "title" => esc_html__("Site General", "pe-core"),
    "id" => "site_general",
    "icon" => "eicon-site-logo",
    "fields" => [
        [
            "id" => "page_transitions",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Page Transitions", "pe-core"),
            "subtitle" => __(
                "AJAX page transitions will be enabled for entire website.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],
        [
            "id" => "page_loader",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Page Loader", "pe-core"),
            "subtitle" => __(
                "Page loader will be shown at first load. Disabling it during website building may speed up things.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],

        [
            "id" => "smooth_scroll",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Smooth Scroll", "pe-core"),
            "subtitle" => __("GSAP smooth scroll will be enabled.", "pe-core"),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],

        [
            "id" => "mouse_cursor",
            "type" => "switch",
            "class" => "pr--25 pr--boxed label--block",
            "title" => __("Mouse Cursor", "pe-core"),
            "subtitle" => __(
                "An interactive mouse cursor will be follow the default mouse cursor.",
                "pe-core"
            ),
            "on" => __("On", "pe-core"),
            "off" => __("Off", "pe-core"),
            "default" => false,
        ],

        [
            "id" => "default--colors--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'default-colors-heading',
            'type' => 'raw',
            'title' => esc_html__('Default Site Colors', 'pe-core'),
        ],
        [
            "id" => "main_color",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Main Color", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used in primary texts.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainColor" => " :root , :root body.layout--switched .header--switched",
            ],
        ],
        [
            "id" => "secondary_color",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Secondary Color", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used in secondary texts.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryColor" => " :root , :root body.layout--switched .header--switched",
            ],
        ],
        [
            "id" => "main_background",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Main Background", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used as background color of the site.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainBackground" => " :root , :root body.layout--switched .header--switched",
            ],
        ],
        [
            "id" => "secondary_background",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__(
                "Secondary Background",
                "pe-core"
            ),
            "subtitle" => esc_html__(
                "Will be used on backgrounded elements background.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryBackground" => " :root , :root body.layout--switched .header--switched",
            ],
        ],

        [
            "id" => "switched--colors--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'switched-colors-heading',
            'type' => 'raw',
            'title' => esc_html__('Switched Site Colors', 'pe-core'),
        ],

        [
            "id" => "secondary_main_color",
            "type" => "color",
            "title" => esc_html__("Main Color", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used in primary texts.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainColor" => " .header--switched, .layout--colors, :root body.layout--switched",
            ],
        ],
        [
            "id" => "secondary_secondary_color",
            "type" => "color",
            "title" => esc_html__("Secondary Color", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used in secondary texts.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryColor" => " .header--switched, .layout--colors, :root body.layout--switched",
            ],
        ],
        [
            "id" => "secondary_main_background",
            "type" => "color",
            "title" => esc_html__("Main Background", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used as background color of the site.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--mainBackground" => " .header--switched, .layout--colors, :root body.layout--switched",
            ],
        ],
        [
            "id" => "secondary_secondary_background",
            "type" => "color",
            "title" => esc_html__(
                "Secondary Background",
                "pe-core"
            ),
            "subtitle" => esc_html__(
                "Will be used on backgrounded elements background.",
                "pe-core"
            ),
            "validate" => "color",
            "transparent" => false,
            "output" => [
                "--secondaryBackground" => " .header--switched, .layout--colors, :root body.layout--switched",
            ],
        ],

        [
            "id" => "site--branding--options",
            "type" => "section",
            "subsection" => true,
            "indent" => false,
        ],
        [
            'id' => 'site-branding-heading',
            'type' => 'raw',
            'title' => esc_html__('Site Branding', 'pe-core'),
        ],

        [
            "id" => "main_site_logo",
            "type" => "media",
            "url" => true,
            "class" => "pr--logo pr--fill--box",
            "preview_size" => "full",
            "title" => esc_html__("Main Site Logo", "pe-core"),
            "subtitle" => esc_html__("Upload your main logo here.", "pe-core"),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
        ],

        [
            "id" => "secondary_site_logo",
            "type" => "media",
            "url" => true,
            "class" => "pr--logo pr--fill--box",
            "preview_size" => "full",
            "title" => esc_html__("Secondary Site Logo", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used when site/header layout has switched.",
                "pe-core"
            ),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
        ],

        [
            "id" => "main_sticky_logo",
            "type" => "media",
            "url" => true,
            "preview_size" => "full",
            "class" => "pr--logo pr--fill--box",
            "title" => esc_html__("Main Sticky Logo", "pe-core"),
            "subtitle" => esc_html__(
                "Upload your main sticky logo here.",
                "pe-core"
            ),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
        ],

        [
            "id" => "secondary_sticky_logo",
            "type" => "media",
            "url" => true,
            "preview_size" => "full",
            "class" => "pr--logo pr--fill--box",
            "title" => esc_html__("Sticky Logo (Light)", "pe-core"),
            "subtitle" => esc_html__(
                "Will be used when site/header layout has switched.",
                "pe-core"
            ),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Header/Footer", "pe-core"),
    "icon" => "eicon-header",
    "id" => "header_footer_options",
    "fields" => [
        [
            "id" => "header-options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'header-opt-heading',
            'type' => 'raw',
            'title' => esc_html__('Header Settings', 'pe-core'),
        ],
        [
            "id" => "header_type",
            "type" => "button_set",
            "title" => __("Header Type", "pe-core"),
            "subtitle" => esc_html__("Select header type.", "pe-core"),
            "options" => [
                "default" => "Default",
                "template" => "Template",
            ],
            "default" => "default",
        ],
        [
            "id" => "header_layout",
            "type" => "button_set",
            "title" => __("Header Layout", "pe-core"),
            "subtitle" => esc_html__("Select header layout.", "pe-core"),
            "options" => [
                "default" => "Default",
                "switched" => "Switched",
            ],
            "default" => "default",
        ],
        [
            "id" => "select-header-template",
            "type" => "select",
            "select2" => false,
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Select Header Template", 'pe-core'),
            "subtitle" => esc_html__(
                "Select Elementor header template.",
                "pe-core"
            ),
            "required" => ["header_template", "not", "default"],
        ],
        [
            "id" => "header_behavior",
            "type" => "button_set",
            "title" => __("Header Behavior", "pe-core"),
            "options" => [
                "static" => "Static",
                "sticky" => "Sticky",
                "fixed" => "Fixed",
            ],
            "default" => "fixed",
        ],
        [
            "id" => "header_background",
            "type" => "color",
            "title" => esc_html__("Header Background Color", "pe-core"),
            "subtitle" => esc_html__(
                "Pick a background color for site header.",
                "pe-core"
            ),
            "output" => [
                "background-color" => ".site-header",
            ],
            "default" => "transparent",
            "validate" => "color",
        ],

        [
            "id" => "sticky_header_background",
            "type" => "color",
            "title" => esc_html__("Sticky Header Background Color", "pe-core"),
            "subtitle" => esc_html__(
                "Pick a background color for site header.",
                "pe-core"
            ),
            "default" => "#f1f1f1",
            "validate" => "color",
        ],

        [
            "id" => "footer--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'footer-opt-heading',
            'type' => 'raw',
            'title' => esc_html__('Footer Settings', 'pe-core'),
        ],

        [
            "id" => "footer_fixed",
            "type" => "switch",
            "title" => __("Fixed Footer", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
        ],
        [
            "id" => "footer_template",
            "type" => "button_set",
            "title" => __("Footer Type", "pe-core"),
            "subtitle" => esc_html__("Select header layout.", "pe-core"),
            "options" => [
                "default" => "Default",
                "template" => "Template",
            ],
            "default" => "default",
        ],
        [
            "id" => "select-footer-template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Select Footer Template", 'pe-core'),
            "subtitle" => esc_html__(
                "Select Elementor header template.",
                "pe-core"
            ),
            "required" => ["header_template", "not", "default"],
        ],

    ],
]);

Redux::setSection($opt_name, [
    "title" => __("Posts/Pages", "pe-core"),
    "id" => "posts-pages",
    "subsection" => false,
    "icon" => "eicon-single-page",
    "fields" => [
        [
            "id" => "portfolio--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'portfolio-heading',
            'type' => 'raw',
            'title' => esc_html__('Portfolio Settings', 'pe-core'),
        ],
        [
            "id" => "project_hero_template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Global Project Hero Template", 'pe-core'),
            "subtitle" => __("Settings can be changed from portfolio edit pages.", 'pe-core'),

        ],
        [
            "id" => "portfolio-slug",
            "type" => "text",
            "title" => __("Custom Portfolio Slug", "pe-core"),
            "subtitle" => __(
                'Leave it empty if you want to continue using "portfolio" slug. ',
                "pe-core"
            ),
            "description" => __(
                "If you can not view your portfolio posts after you changed this, please update your permalink settings once.",
                "pe-core"
            ),
        ],
        [
            "id" => "show_next_project",
            "type" => "switch",
            "title" => __("Next Project Section", "pe-core"),
            "on" => __("Show", "pe-core"),
            "off" => __("Hide", "pe-core"),
            "default" => true,
        ],
        [
            "id" => "next_project_template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Next Project Template", 'pe-core'),
            "required" => ["show_next_project", "=", "true"],

        ],
        [
            "id" => "post--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'post-settings',
            'type' => 'raw',
            'title' => esc_html__('Post Settings', 'pe-core'),
        ],
        [
            "id" => "single_post_template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("Single Post Template", 'pe-core'),
            "subtitle" => __("You can create/customize templates via 'Templates' section on side menu of the dashboard.", 'pe-core'),

        ],
        [
            'id' => '404-settings',
            'type' => 'raw',
            'title' => esc_html__('404 Page', 'pe-core'),
        ],
        [
            "id" => "404_page_template",
            "type" => "select",
            "data" => "posts",
            "args" => [
                "post_type" => ["elementor_library"],
                "posts_per_page" => -1,
            ],
            "title" => __("404 Page Template", 'pe-core'),
            "subtitle" => __("You can create/customize templates via 'Templates' section on side menu of the dashboard.", 'pe-core'),

        ],

    ],
]);

Redux::setSection(
    $opt_name,
    array(
        'title' => __('Shop', 'pe-core'),
        'id' => 'shop',
        'icon' => 'eicon-woocommerce',
    )
);

Redux::setSection(
    $opt_name,
    array(
        'title' => __('Shop Page', 'pe-core'),
        'id' => 'shop-page',
        'subsection' => true,
        'fields' => array(


            array(
                'id' => 'shop_sidebar',
                'type' => 'button_set',
                'title' => __('Sidebar', 'pe-core'),
                'subtitle' => __('Select sidebar position.', 'pe-core'),
                'options' => array(
                    'no-sidebar' => 'No Sidebar',
                    'left-sidebar' => 'Left Sidebar',
                    'right-sidebar' => 'Right Sidebar',
                ),
                'default' => 'no-sidebar',
            ),
            array(
                'id' => 'shop_page_title_show',
                'type' => 'switch',
                'title' => __('Shop Page Title', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display page header.', 'pe-core'),
            ),

            array(
                'id' => 'shop_page_title',
                'type' => 'text',
                'title' => __('Shop Page Title', 'pe-core'),
                'subtitle' => __('Enter shop page title', 'pe-core'),
                'default' => __('Shop', 'pe-core'),
                'required' => array(
                    'shop_page_title_show',
                    '=',
                    'true'
                ),
            ),

            array(
                'id' => 'products_count',
                'type' => 'switch',
                'title' => __('Products Count', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display page header.', 'pe-core'),
            ),


            array(
                'id' => 'shop_title_typography',
                'type' => 'typography',
                'title' => esc_html__('Title Typography', 'pe-core'),
                'google' => true,
                'font-backup' => true,
                'output' => array('.shop-page-header .page-title h1.big-title'),
                'units' => 'px',
                'subtitle' => esc_html__('Customize shop page title.', 'pe-core'),
                'default' => false,
                'required' => array(
                    'shop_page_title_show',
                    '=',
                    'true'
                ),
            ),

            array(
                'id' => 'is_filterable',
                'type' => 'switch',
                'title' => __('Filterable Products?', 'pe-core'),
                'on' => __('Yes', 'pe-core'),
                'off' => __('No', 'pe-core'),
                'default' => true,
            ),

            array(
                'id' => 'grid_switcher',
                'type' => 'switch',
                'title' => __('Grid Switcher', 'pe-core'),
                'on' => __('Yes', 'pe-core'),
                'off' => __('No', 'pe-core'),
                'default' => true,
            ),

            array(
                'id' => 'is_sale_highlight',
                'type' => 'switch',
                'title' => __('Highlight Sale Items', 'pe-core'),
                'on' => __('Yes', 'pe-core'),
                'off' => __('No', 'pe-core'),
                'default' => true,
                'subtitle' => __('If is set "yes" on sale products will be double sized.', 'pe-core'),
            ),

            array(
                'id' => 'empty_cart_button_text',
                'type' => 'text',
                'title' => __('Empty Cart Button Text', 'pe-core'),
                'default' => __('Return The Shop', 'pe-core'),
            ),
            array(
                'id' => 'empty_cart_button_url',
                'type' => 'text',
                'title' => __('Empty Cart Button URL', 'pe-core'),
                'subtitle' => __('Leave it empty if you want to redirect button to products page', 'pe-core'),
            ),


        )
    )
);



Redux::setSection(
    $opt_name,
    array(
        'title' => __('Single Product', 'pe-core'),
        'id' => 'single-product',
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'product_gallery_type',
                'type' => 'button_set',
                'title' => __('Product Gallery Type', 'pe-core'),
                'subtitle' => __('If you select "sticky" product meta will be pinned to product gallery.', 'pe-core'),
                'options' => array(
                    'gal-static' => 'Static',
                    'gal-sticky' => 'Sticky',
                ),
                'default' => 'static',
            ),
            array(
                'id' => 'image-sizes',
                'type' => 'select',
                'title' => esc_html__('Gallery Image Heights', 'pe-core'),
                'options' => array(
                    'img-default' => 'Theme Default',
                    'img-masonry' => 'Masonry',
                ),
                'default' => 'img-default',

            ),

            array(
                'id' => 'pgal-image-height',
                'type' => 'slider',
                'title' => esc_html__('Image Height (vh)', 'pe-core'),
                "default" => 50,
                "min" => 1,
                "step" => 1,
                "max" => 100,
                'display_value' => 'vh',
                'output_variables' => true,
                'required' => array(
                    'image-sizes',
                    'not',
                    'img-masonry'
                ), // An array of CSS selectors
            ),


            array(
                'id' => 'pgal-mobile-width',
                'type' => 'slider',
                'title' => esc_html__('Gallery Width (vw)', 'pe-core'),
                'subtitle' => __('For mobile screens', 'pe-core'),
                "default" => 50,
                "min" => 1,
                "step" => 1,
                "max" => 100,
                'display_value' => 'vh',
                'output_variables' => true,
                'required' => array(
                    'image-sizes',
                    'not',
                    'img-masonry'
                ), // An array of CSS selectors
            ),
            array(
                'id' => 'image-cols',
                'type' => 'select',
                'title' => esc_html__('Gallery Image Columns', 'pe-core'),
                'options' => array(
                    'gal-col-1' => '1 Column',
                    'gal-col-2' => '2 Columns',
                ),
                'default' => 'gal-col-2',
                'required' => array(
                    'image-sizes',
                    'not',
                    'img-masonry'
                ), // An array of CSS selectors

            ),
            array(
                'id' => 'show_related_products',
                'type' => 'switch',
                'title' => __('Related Products', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display related products.', 'pe-core'),
            ),



            array(
                'id' => 'related_products_title_show',
                'type' => 'switch',
                'title' => __('Related Products Title', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display related products title.', 'pe-core'),
            ),

            array(
                'id' => 'related_products_title',
                'type' => 'text',
                'title' => __('Related Products Title', 'pe-core'),
                'subtitle' => __('Enter related products title', 'pe-core'),
                'default' => __('Related Products', 'pe-core'),
            ),

            array(
                'id' => 'show_sku',
                'type' => 'switch',
                'title' => __('SKU', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product SKU.', 'pe-core'),
            ),

            array(
                'id' => 'show_product_category',
                'type' => 'switch',
                'title' => __('Category', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product category.', 'pe-core'),
            ),

            array(
                'id' => 'show_product_tags',
                'type' => 'switch',
                'title' => __('Tags', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product tags.', 'pe-core'),
            ),

            array(
                'id' => 'show_short_description',
                'type' => 'switch',
                'title' => __('Short Description', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product short description.', 'pe-core'),
            ),

            array(
                'id' => 'add_to_cart_qty',
                'type' => 'switch',
                'title' => __('Add to Cart Button Quantity', 'pe-core'),
                'on' => __('Show', 'pe-core'),
                'off' => __('Hide', 'pe-core'),
                'default' => true,
                'subtitle' => __('Switch "Hide" if you dont want to display product quantity option on add to cart button.', 'pe-core'),
            ),

        )
    )
);

Redux::setSection($opt_name, [
    "title" => esc_html__("Page Loader", "pe-core"),
    "id" => "pageLoader",
    "icon" => "eicon-spinner",
    "fields" => [
        [
            "id" => "loader--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'loader-heading',
            'type' => 'raw',
            'title' => esc_html__('Page Loader Settings', 'pe-core'),
        ],
        [
            'id' => 'only--home',
            'type' => 'switch',
            'title' => __('Only on Homepage', 'pe-core'),
            'on' => __('Yes', 'pe-core'),
            'off' => __('No', 'pe-core'),
            'default' => false,
            'subtitle' => esc_html__('Page loader will be running only on homepage.', 'pe-core'),
        ],
        [
            "id" => "loader_type",
            "type" => "button_set",
            "title" => __("Loader Type", "pe-core"),
            "options" => [
                "overlay" => "Overlay",
                "fade" => "Fade",
                "slide" => "Slide",
            ],
            "default" => "overlay",
        ],
        [
            "id" => "loader_direction",
            "type" => "button_set",
            "title" => __("Loader Direction", "pe-core"),
            "options" => [
                "up" => "Up",
                "down" => "Down",
                "left" => "Left",
                "right" => "Right",
            ],
            "default" => "up",
            'required' => ['loader_type', '!=', 'fade']
        ],
        [
            "id" => "loader_curved",
            "type" => "switch",
            "title" => __("Curved Overlay", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
            'required' => ['loader_type', '=', 'overlay']
        ],
        [
            'id' => 'loader_duration',
            'type' => 'slider',
            'title' => esc_html__('Loader Duration', 'pe-core'),
            'subtitle' => esc_html__('Minimum loader time by ms.', 'pe-core'),
            'display_value' => 'label',
            'min' => 1000,
            'max' => 10000,
            'default' => 3500,
            'step' => 100
        ],
        [
            'id' => 'loader_elements',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Loader Elements', 'pe-core'),
            'options' => [
                'caption' => esc_html__('Caption', 'pe-core'),
                'logo' => esc_html__('Logo', 'pe-core'),
                'counter' => esc_html__('Counter', 'pe-core')
            ],
            'default' => ['counter']
        ],
        [
            "id" => "loader_logo",
            "type" => "media",
            "url" => true,
            "class" => "pr--logo pr--fill--box",
            "preview_size" => "full",
            "title" => esc_html__("Loader Logo", "pe-core"),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
            'required' => ['loader_elements', '=', 'logo']
        ],
        [
            "id" => "loader_caption",
            "type" => "text",
            "title" => esc_html__("Loader Caption", "pe-core"),
            "default" => esc_html__("Loading, please wait..", "pe-core"),
            'required' => ['loader_elements', '=', 'caption']

        ],

        [
            "id" => "loader--styles",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'loader-styles-heading',
            'type' => 'raw',
            'title' => esc_html__('Loader Styles', 'pe-core'),
        ],

        [
            "id" => "loader_background",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Loader Background Color", "pe-core"),
            "validate" => "color",
            "transparent" => false,
        ],
        [
            "id" => "loader_colors",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Loader Texts Color", "pe-core"),
            "validate" => "color",
            "transparent" => false,
        ],
        [
            "id" => "counter_v_align",
            "type" => "button_set",
            "title" => __("Counter Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "bottom",
            'required' => ['loader_elements', '=', 'counter']
        ],
        [
            "id" => "counter_h_align",
            "type" => "button_set",
            "title" => __("Counter Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "right",
            'required' => ['loader_elements', '=', 'counter']
        ],
        [
            "id" => "counter_size",
            "type" => "typography",
            "class" => 'label--block',
            'font-family' => false,
            'font-style' => false,
            'font-weight' => false,
            'text-align' => false,
            'line-height' => false,
            'color' => false,
            'preview' => false,
            "title" => esc_html__("Counter Size", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [".page--loader--count"],
            "units" => "px",
            "default" => false,
            'required' => ['loader_elements', '=', 'counter'],

        ],
        [
            "id" => "caption_v_align",
            "type" => "button_set",
            "title" => __("Caption Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "middle",
            'required' => ['loader_elements', '=', 'caption']
        ],
        [
            "id" => "caption_h_align",
            "type" => "button_set",
            "title" => __("Caption Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => ['loader_elements', '=', 'caption']
        ],
        [
            "id" => "caption_size",
            "type" => "typography",
            "class" => 'label--block',
            'font-family' => false,
            'font-style' => false,
            'font-weight' => false,
            'text-align' => false,
            'line-height' => false,
            'color' => false,
            'preview' => false,
            "title" => esc_html__("Caption Size", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [".page--loader--count"],
            "units" => "px",
            "default" => false,
            'required' => ['loader_elements', '=', 'caption'],

        ],
        [
            "id" => "logo_v_align",
            "type" => "button_set",
            "title" => __("Logo Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "middle",
            'required' => ['loader_elements', '=', 'logo']
        ],
        [
            "id" => "logo_h_align",
            "type" => "button_set",
            "title" => __("Logo Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => ['loader_elements', '=', 'logo']
        ],
        [
            'id' => 'loader_logo_width',
            'type' => 'dimensions',
            'height' => false,
            'units' => array('em', 'px', '%'),
            'title' => esc_html__('Logo Width', 'pe-core'),
            'required' => ['loader_elements', '=', 'logo'],
        ],

    ],
]);

Redux::setSection($opt_name, [
    "title" => __("Page Transitions", "pe-core"),
    "id" => "page_transitions",
    "icon" => "eicon-page-transition",
    "fields" => [
        [
            "id" => "transitions--options",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'transitions-heading',
            'type' => 'raw',
            'title' => esc_html__('Page Transitions Settings', 'pe-core'),
        ],

        [
            "id" => "transition_type",
            "type" => "button_set",
            "title" => __("Transition Type", "pe-core"),
            "options" => [
                "overlay" => "Overlay",
                "fade" => "Fade",
                "slide" => "Slide",
            ],
            "default" => "overlay",
        ],
        [
            "id" => "transition_curved",
            "type" => "switch",
            "title" => __("Curved Overlay", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
            'required' => ['loader_type', '=', 'overlay']
        ],
        [
            'id' => 'transition_duration',
            'type' => 'slider',
            'title' => esc_html__('Transition Duration', 'pe-core'),
            'subtitle' => esc_html__('Minimum loader time by ms.', 'pe-core'),
            'display_value' => 'label',
            'min' => 1000,
            'max' => 10000,
            'default' => 3500,
            'step' => 100
        ],
        [
            'id' => 'transition_elements',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Transition Elements', 'pe-core'),
            'options' => [
                'caption' => esc_html__('Caption', 'pe-core'),
                'logo' => esc_html__('Logo', 'pe-core'),
            ],
            'default' => ['caption']
        ],
        [
            'id' => 'caption_type',
            'type' => 'select',
            'multi' => false,
            'title' => esc_html__('Caption Type', 'pe-core'),
            'options' => [
                'basic' => esc_html__('Basic', 'pe-core'),
                'marquee' => esc_html__('Marquee', 'pe-core'),
            ],
            'default' => 'basic',
            'required' => ['transition_elements', '=', 'caption']
        ],
        [
            "id" => "transition_logo",
            "type" => "media",
            "url" => true,
            "class" => "pr--logo pr--fill--box",
            "preview_size" => "full",
            "title" => esc_html__("Transition Logo", "pe-core"),
            "default" => [
                "url" =>
                    "https://s.wordpress.org/style/images/codeispoetry.png",
            ],
            'required' => ['transition_elements', '=', 'logo']
        ],
        [
            "id" => "transition_caption",
            "type" => "text",
            "title" => esc_html__("Transition Caption", "pe-core"),
            "default" => esc_html__("Loading, please wait..", "pe-core"),
            'required' => ['transition_elements', '=', 'caption']

        ],

        [
            "id" => "transitions--styles",
            "type" => "section",
            "subsection" => true,
            "indent" => true,
        ],
        [
            'id' => 'transitions-styles-heading',
            'type' => 'raw',
            'title' => esc_html__('Page Transitions Styles', 'pe-core'),
        ],

        [
            "id" => "transition_background",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Transition Background Color", "pe-core"),
            "validate" => "color",
            "transparent" => false,
        ],
        [
            "id" => "transition_colors",
            "type" => "color",
            "class" => "label--block",
            "title" => esc_html__("Transition Texts Color", "pe-core"),
            "validate" => "color",
            "transparent" => false,
        ],
        [
            "id" => "trans_caption_v_align",
            "type" => "button_set",
            "title" => __("Caption Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "middle",
            'required' => ['transition_elements', '=', 'caption']
        ],
        [
            "id" => "trans_caption_h_align",
            "type" => "button_set",
            "title" => __("Caption Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => ['transition_elements', '=', 'caption']
        ],
        [
            "id" => "trans_caption_size",
            "type" => "typography",
            "class" => 'label--block',
            'font-family' => false,
            'font-style' => false,
            'font-weight' => false,
            'text-align' => false,
            'line-height' => false,
            'color' => false,
            'preview' => false,
            "title" => esc_html__("Caption Size", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "units" => "px",
            "default" => false,
            'required' => ['transition_elements', '=', 'caption'],

        ],
        [
            "id" => "trans_logo_v_align",
            "type" => "button_set",
            "title" => __("Logo Vertical Align", "pe-core"),

            "options" => [
                "top" => "Top",
                "middle" => "Middle",
                "bottom" => "Bottom",
            ],
            "default" => "middle",
            'required' => ['transition_elements', '=', 'logo']
        ],
        [
            "id" => "trans_logo_h_align",
            "type" => "button_set",
            "title" => __("Logo Horizontal Align", "pe-core"),
            "options" => [
                "left" => "Left",
                "center" => "Center",
                "right" => "Right",
            ],
            "default" => "center",
            'required' => ['transition_elements', '=', 'logo']
        ],
        [
            'id' => 'trans_loader_logo_width',
            'type' => 'dimensions',
            'height' => false,
            'units' => array('em', 'px', '%'),
            'title' => esc_html__('Logo Width', 'pe-core'),
            'required' => ['transitions_elements', '=', 'logo'],
        ]
    ],
]);


Redux::setSection($opt_name, [
    "title" => esc_html__("Smooth Scroll", "pe-core"),
    "id" => "smoothScroll",
    "icon" => "eicon-scroll",
    "fields" => [
        [
            "id" => "smooth--scroll--settings",
            "type" => "section",
            "subsection" => true,
            "indent" => false,
        ],
        [
            'id' => 'smooth-scroll-heading',
            'type' => 'raw',
            'title' => esc_html__('Smooth Scroll', 'pe-core'),
        ],

        [
            "id" => "smooth_strength",
            "type" => "text",
            "title" => __("Smooth Strength", "pe-core"),
            "default" => "0.8",
        ],
        [
            "id" => "normalize_scroll",
            "type" => "switch",
            "title" => __("Normalize Scroll", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => true,
            "subtitle" => __(
                "It forces scrolling to be done on the JavaScript thread, ensuring it is synchronized and the address bar doesnt show/hide on mobile devices.",
                "pe-core"
            ),
        ],

        [
            "id" => "smooth_speed",
            "type" => "text",
            "title" => __("Speed", "pe-core"),
            "default" => "1",
        ],

        [
            "id" => "smooth_touch",
            "type" => "switch",
            "title" => __("Smooth Touch", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => false,
            "subtitle" => __("Smooth scroll on touch only devices.", "pe-core"),
        ],
        [
            "id" => "smooth_touch_strength",
            "type" => "text",
            "title" => __("Smooth Touch Strength", "pe-core"),
            "default" => "0.8",
            "required" => ["smooth_touch", "=", "true"],
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Mouse Cursor", "pe-core"),
    "id" => "mouseCursor",
    "icon" => "eicon-circle-o",
    "fields" => [
        [
            "id" => "mouse--cursor--settings",
            "type" => "section",
            "subsection" => true,
            "indent" => false,
        ],
        [
            'id' => 'mouse-cursor-heading',
            'type' => 'raw',
            'title' => esc_html__('Mouse Cursor', 'pe-core'),
        ],
        [
            "id" => "mouse_cursor_type",
            "type" => "button_set",
            "title" => __("Mouse Cursor", "pe-core"),
            "options" => [
                "none" => "None",
                "dot" => "Dot",
                "circle" => "Circle",
            ],
            "default" => "none",
        ],

        [
            "id" => "mouse_cursor_layout",
            "type" => "button_set",
            "title" => __("Mouse Cursor Layout", "pe-core"),
            "options" => [
                "dark" => "Dark",
                "light" => "Light",
            ],
            "default" => "dark",
        ],

        [
            "id" => "cursor_loading",
            "type" => "switch",
            "title" => __("Loading Animation", "pe-core"),
            "on" => __("Yes", "pe-core"),
            "off" => __("No", "pe-core"),
            "default" => true,
        ],

        [
            "id" => "cursor_color",
            "type" => "color",
            "color_alpha" => true,
            "title" => __("Cursor Color", "pe-core"),
            "output" => [
                "fill" => "div#mouseCursor.dot .main-circle",
                "stroke" => "div#mouseCursor.circle .main-circle",
                "important" => true,
            ],
        ],

        [
            "id" => "cursor_text_color",
            "type" => "color",
            "color_alpha" => true,
            "title" => __("Cursor Text Color", "pe-core"),
            "output" => [
                "color" => "mouse-cursor-text",
                "important" => true,
            ],
        ],

        [
            "id" => "cursor_icon_color",
            "type" => "color",
            "color_alpha" => true,
            "title" => __("Cursor Icon Color", "pe-core"),
            "output" => [
                "color" => "mouse-cursor-icon",
                "important" => true,
            ],
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Styling", "pe-core"),
    "id" => "colors",
    "icon" => "eicon-global-colors",
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("General Optıons", "pe-core"),
    "id" => "general-colors",
    "subsection" => true,
    "fields" => [
        [
            "id" => "custom_fonts",
            "type" => "custom_fonts",
            "title" => esc_html__("Custom Fonts", "pe-core"),
        ],
        [
            "id" => "body-background",
            "type" => "background",
            "title" => esc_html__("Body Background", "pe-core"),
            "subtitle" => esc_html__(
                "Body background with image, color, etc.",
                "pe-core"
            ),
            "output" => ["body", "important" => true],
        ],

        [
            "id" => "body_typo",
            "type" => "typography",
            "title" => __("Body Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["body"],
            "units" => "px",
        ],

        [
            "id" => "link_colors",
            "type" => "link_color",
            "title" => esc_html__("Links Colors", "pe-core"),
            "output" => ["#page a"],
        ],

        [
            "id" => "p_typo",
            "type" => "typography",
            "title" => __("Paragraph", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["#page h1"],
            "units" => "px",
        ],

        [
            "id" => "h1_typo",
            "type" => "typography",
            "title" => __("Heading 1", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["#page h1"],
            "units" => "px",
        ],

        [
            "id" => "h2_typo",
            "type" => "typography",
            "title" => __("Heading 2", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["#page h2"],
            "units" => "px",
        ],

        [
            "id" => "h3_typo",
            "type" => "typography",
            "title" => __("Heading 3", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["#page h3"],
            "units" => "px",
        ],

        [
            "id" => "h4_typo",
            "type" => "typography",
            "title" => __("Heading 4", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["#page h4"],
            "units" => "px",
        ],

        [
            "id" => "h5_typo",
            "type" => "typography",
            "title" => __("Heading 5", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["#page h5"],
            "units" => "px",
        ],

        [
            "id" => "h6_typo",
            "type" => "typography",
            "title" => __("Heading 6", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => ["#page h6"],
            "units" => "px",
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Header", "pe-core"),
    "id" => "header-colors",
    "subsection" => true,
    "fields" => [
        [
            "id" => "sticky_header_bg_color",
            "type" => "color",
            "title" => __("Sticky Header Background Color.", "pe-core"),
            "subtitle" => __("Set sticky header background color", "pe-core"),
        ],

        [
            "id" => "fs_menu_bg_color",
            "type" => "color",
            "title" => __("Fullscreen Menu Background Color.", "pe-core"),
            "subtitle" => __("Set fullscreen menu background color", "pe-core"),
            "output" => [
                "background-color" => ".fullscreen_menu::before",
                "important" => true,
            ],
        ],

        [
            "id" => "fs_menu_item_typo",
            "type" => "typography",
            "title" => __("Menu Item Typography", "pe-core"),
            "subtitle" => __("For fullscreen menu.", "pe-core"),
            "color" => false,
            "google" => true,
            "font-backup" => true,
            "output" => [
                ".site-navigation.fullscreen .menu.main-menu > li.menu-item",
            ],
            "units" => "px",
        ],

        [
            "id" => "fs_menu_item_color",
            "type" => "color",
            "title" => __("Menu item color.", "pe-core"),
            "subtitle" => __("For fullscreen menu", "pe-core"),
            "output" => [
                "color" =>
                    ".site-header .site-navigation.fullscreen .menu.main-menu > li.menu-item a::before",
                "background-color" => ".site-header.menu_dark .sub-togg-line",
                "important" => true,
            ],
        ],

        [
            "id" => "fs_menu_item_transparent_color",
            "type" => "color",
            "title" => __("Menu item transparent color.", "pe-core"),
            "subtitle" => __("For fullscreen menu", "pe-core"),
            "output" => [
                "color" =>
                    ".site-header .site-navigation.fullscreen .menu.main-menu > li.menu-item a",
                "important" => true,
            ],
        ],

        [
            "id" => "menu_toggle_color",
            "type" => "color",
            "title" => __("Menu toggle background color.", "pe-core"),
            "subtitle" => __("For fullscreen menu.", "pe-core"),
            "output" => [
                "background-color" => ".site-header .toggle-line",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_menu_item_typo",
            "type" => "typography",
            "title" => __("Menu Item Typography", "pe-core"),
            "subtitle" => __("For classic menu.", "pe-core"),
            "color" => false,
            "google" => true,
            "font-backup" => true,
            "output" => ["#primary-menu .menu-item"],
            "units" => "px",
        ],

        [
            "id" => "classic_menu_dark_item_color",
            "type" => "color",
            "title" => __("Menu item color.(Dark)", "pe-core"),
            "subtitle" => __("For classic menu (dark layout)", "pe-core"),
            "default" => "rgba(25, 27, 29, .6)",
            "output" => [
                "color" => ".site-navigation.classic .menu.main-menu > li > a",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_menu_dark_item_hover_color",
            "type" => "color",
            "title" => __("Menu item hover color(Dark).", "pe-core"),
            "subtitle" => __("For classic menu (dark layout)", "pe-core"),
            "default" => "#191b1d",
        ],
        [
            "id" => "classic_menu_dark_item_active_color",
            "type" => "color",
            "title" => __("Menu item active color(Dark).", "pe-core"),
            "subtitle" => __("For classic menu (dark layout)", "pe-core"),
            "default" => "#191b1d",
            "output" => [
                "color" =>
                    ".site-header .site-navigation.classic .menu.main-menu li.current-menu-item > a",
                "important" => true,
            ],
        ],
        [
            "id" => "classic_menu_light_item_color",
            "type" => "color",
            "title" => __("Menu item color.(Light)", "pe-core"),
            "subtitle" => __("For classic menu (light layout)", "pe-core"),
            "default" => "hsla(0,0%,100%,.2)",
            "output" => [
                "color" =>
                    ".site-header.light .site-navigation.classic .menu.main-menu > li > a",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_menu_light_item_hover_color",
            "type" => "color",
            "title" => __("Menu item hover color(Light).", "pe-core"),
            "subtitle" => __("For classic menu (light layout)", "pe-core"),
            "default" => "#ffffff",
        ],

        [
            "id" => "classic_menu_light_item_active_color",
            "type" => "color",
            "title" => __("Menu item active color(Light).", "pe-core"),
            "subtitle" => __("For classic menu (light layout)", "pe-core"),
            "default" => "#ffffff",
            "output" => [
                "color" =>
                    ".site-header.light .site-navigation.classic .menu.main-menu li.current-menu-item > a",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_menu_submenu_item_color",
            "type" => "color",
            "title" => __("Submenu Item Color.", "pe-core"),
            "subtitle" => __("For classic menu.", "pe-core"),
            "output" => [
                "color" => ".sub-menu a",
                "important" => true,
            ],
        ],

        [
            "id" => "classic_submenu_background_color",
            "type" => "color",
            "title" => __("Submenu background color.", "pe-core"),
            "subtitle" => __("For classic menu.", "pe-core"),
            "output" => [
                "background-color" => ".site-navigation.classic .sub-menu",
                "important" => true,
            ],
        ],

        [
            "id" => "git_button_typo",
            "type" => "typography",
            "title" => __("CTA Typography", "pe-core"),
            "subtitle" => __("For fullscreen menu.", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [
                ".site-header.menu_dark .git-button a",
                ".site-header.menu_light .git-button a",
            ],
            "units" => "px",
        ],

        [
            "id" => "social_links_typo",
            "type" => "typography",
            "title" => __("Social Links Typography", "pe-core"),
            "subtitle" => __("For fullscreen menu.", "pe-core"),
            "google" => true,
            "color" => false,
            "font-backup" => true,
            "output" => [
                ".site-header.menu_dark .social-list li a",
                ".site-header.menu_light .social-list li a",
            ],
            "units" => "px",
        ],
    ],
]);

Redux::setSection($opt_name, [
    "title" => esc_html__("Footer", "pe-core"),
    "id" => "footer-styles",
    "subsection" => true,
    "fields" => [
        [
            "id" => "footer-background",
            "type" => "background",
            "title" => esc_html__("Footer Background", "pe-core"),
            "subtitle" => esc_html__(
                "Footer background with image, color, etc.",
                "pe-core"
            ),
            "output" => [".site-footer", "important" => true],
        ],

        [
            "id" => "footer_menu_typo",
            "type" => "typography",
            "title" => __("Footer Menu Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [
                "#footer.dark .footer-menu ul li a",
                "#footer.light .footer-menu ul li a",
            ],
            "units" => "px",
        ],

        [
            "id" => "copyright_text_typo",
            "type" => "typography",
            "title" => __("Copyright Text Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [
                "#footer.dark .copyright-text",
                "#footer.light .copyright-text",
            ],
            "units" => "px",
        ],

        [
            "id" => "mail_button_typo",
            "type" => "typography",
            "title" => __("Mail Button Typography", "pe-core"),
            "google" => true,
            "font-backup" => true,
            "output" => [
                "#footer.dark .big-button a",
                "#footer.light .big-button a",
                ".big-button a::after",
            ],
            "units" => "px",
        ],
    ],
]);
Redux::setSection($opt_name, [
    "title" => esc_html__("Global Widget Styles", "pe-core"),
    "id" => "global-widget-styles",
    "subsection" => true,
    "icon" => "eicon-elementor-circle",
    "fields" => [
        [
            "id" => "global-opts-accordion",
            "type" => "accordion",
            "title" => "Accordion",
            "subtitle" => 'Global settings for "accordion" widget.',
            "position" => "start",
        ],

        [
            "id" => "accordion_list_type",
            "type" => "select",
            "title" => __("List Type", "pe-core"),
            "multi" => false,
            "options" => [
                "ac--ordered" => "Ordered",
                "ac--nested" => "Nested",
            ],
            "default" => "ac--nested",
        ],
        [
            'id' => "accordion_open_first",
            'type' => 'button_set',
            'title' => esc_html__('Active First', 'pe-core'),
            'subtitle' => esc_html__('First item will be active as default', 'pe-core'),
            'options' => [
                'active--firt' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => 'ac--ordered',
            'multi' => false
        ],
        [
            'id' => 'accordion_toggle_style',
            'type' => 'select',
            'multi' => false,
            'title' => esc_html__('Toggle Style', 'pe-core'),
            'options' => [
                'toggle--plus' => esc_html__('Plus', 'pe-core'),
                'toggle--dot' => esc_html__('Dot', 'pe-core'),
                'toggle--custom' => esc_html__('Custom', 'pe-core')
            ],
            'default' => 'toggle--plus'
        ],
        [
            'id' => 'accordion_open_icon',
            'type' => 'icon_select',
            'title' => esc_html__('Open Icon', 'pe-core'),
            "required" => ["accordion_toggle_style", "=", "toggle--custom"],
            'default' => 'fas fa-plus'
        ],
        [
            'id' => 'accordion_close_icon',
            'type' => 'icon_select',
            'title' => esc_html__('Close Icon', 'pe-core'),
            "required" => ["accordion_toggle_style", "=", "toggle--custom"],
            'default' => 'fas fa-plus'
        ],
        [
            'id' => 'accordion_toggle_bg',
            'type' => 'button_set',
            'title' => esc_html__('Toggle Background', 'pe-core'),
            'subtitle' => esc_html__('You can adjust colors from "Style" tab above.', 'pe-core'),
            'multi' => false,
            'options' => [
                'toggle--bg' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ]
        ],
        [
            'id' => 'accordion_underlined',
            'type' => 'button_set',
            'title' => esc_html__('Underlined?', 'pe-core'),
            'multi' => false,
            'options' => [
                'ac--underlined' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => ''
        ],
        [
            "id" => "global-opts-accordion-end",
            "type" => "accordion",
            "position" => "end",
        ],
        [
            "id" => "global-opts-blogposts",
            "type" => "accordion",
            "title" => "Blog Posts",
            "position" => "start",
        ],

        [
            "id" => "global-opts-blogposts-end",
            "type" => "accordion",
            "position" => "end",
        ],
        [
            'id' => 'global-opts-button',
            'type' => 'accordion',
            'title' => esc_html__('Button', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'button_size',
            'type' => 'select',
            'multi' => false,
            'options' => [
                'pb--normal' => esc_html__('Normal', 'pe-core'),
                'pb--medium' => esc_html__('Medium', 'pe-core'),
                'pb--large' => esc_html__('Large', 'pe-core')
            ],
            'default' => 'pb--normal'
        ],
        [
            'id' => 'button_alignment',
            'type' => 'button_set',
            'title' => esc_html__('Alignment', 'pe-core'),
            'options' => [
                'left' => esc_html__('Left', 'pe-core'),
                'center' => esc_html__('Center', 'pe-core'),
                'right' => esc_html__('Right', 'pe-core')
            ],
            'multi' => false,
            'default' => 'left'
        ],
        [
            'id' => 'button_background',
            'type' => 'button_set',
            'title' => esc_html__('Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--background' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => 'pb--background'
        ],
        [
            'id' => 'button_bordered',
            'type' => 'button_set',
            'title' => esc_html__('Bordered', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--bordered' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'button_marquee',
            'type' => 'button_set',
            'title' => esc_html__('Marquee', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--marquee' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'button_marquee_direction',
            'type' => 'button_set',
            'title' => esc_html__('Marquee Direction', 'pe-core'),
            'multi' => false,
            'options' => [
                'left-to-right' => esc_html__('Left To Right', 'pe-core'),
                'right-to-left' => esc_html__('Right To Left', 'pe-core')
            ],
            'default' => 'right-to-left',
            'required' => ['button_marquee', '=', 'pb--marquee']
        ],
        [
            'id' => 'button_underlined',
            'type' => 'button_set',
            'title' => esc_html__('Underlined', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--underlined' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => '',
            'required' => ['button_marquee', 'not', 'pb--marquee']
        ],
        [
            'id' => 'button_show_icon',
            'type' => 'button_set',
            'title' => esc_html__('Show Icon', 'pe-core'),
            'multi' => false,
            'options' => [
                'pb--icon' => esc_html__('Yes', 'pe-core'),
                '' => esc_html__('No', 'pe-core')
            ],
            'default' => 'pb--icon'
        ],
        [
            'id' => 'button_icon',
            'type' => 'icon_select',
            'title' => esc_html__('Icon', 'pe-core'),
            'required' => ['button_show_icon', '=', 'pb--icon'],
        ],
        [
            'id' => 'button_icon_position',
            'title' => esc_html__('Icon Position', 'pe-cor'),
            'type' => 'button_set',
            'options' => [
                'icon__left' => esc_html__('Left', 'pe-core'),
                'icon__right' => esc_html__('Right', 'pe-core'),
            ],
            'default' => 'icon__right',
            'required' => ['button_show_icon', '=', 'pb--icon']
        ],
        [
            'id' => 'button_border_radius',
            'type' => 'spacing',
            'title' => esc_html__('Border Radius', 'pe-core'),
            'units' => ['px', '%'],
            'units_extended' => true,
            'default' => [
                'border-top-left-radius' => '30px',
                'border-top-right-radius' => '30px',
                'border-bottom-right-radius' => '30px',
                'border-bottom-left-radius' => '30px',
                'units' => 'px'
            ]
        ],
        [
            'id' => 'button_border_width',
            'type' => 'spacing',
            'title' => esc_html__('Border Width', 'pe-core'),
            'units' => ['px'],
            'units_extended' => true,
            'default' => [
                'border-top-width' => '1px',
                'border-right-width' => '1px',
                'border-bottom-width' => '1px',
                'border-left-width' => '1px',
                'units' => 'px'
            ]
        ],
        [
            'id' => 'button_underline_height',
            'type' => 'slider',
            'title' => esc_html__('Underline Height', 'pe-core'),
            "default" => 1,
            "min" => 0.1,
            "step" => 0.1,
            "max" => 5,
            'display_value' => 'label'
        ],
        [
            'id' => 'button_padding',
            'type' => 'spacing',
            'title' => esc_html__('Padding', 'pe-core'),
            'units' => ['px', '%'],
            'units_extended' => true,
            'default' => [
                'padding-top' => '30px',
                'padding-right' => '30px',
                'padding-bottom' => '30px',
                'padding-left' => '30px',
                'units' => 'px'
            ]
        ],
        [
            'id' => 'global-opts-button-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-carousel',
            'type' => 'accordion',
            'position' => 'start',
            'title' => esc_html__('Carousel')
        ],
        [
            'id' => 'carousel_items_width',
            'type' => 'slider',
            'title' => esc_html__('Items Width', 'pe-core'),
            'display_value' => 'label',
            'min' => 0,
            'max' => 1000,
            'step' => 1
        ],
        [
            'id' => 'carousel_items_gap',
            'type' => 'slider',
            'title' => esc_html__('Space Between Items', 'pe-core'),
            'display_value' => 'label',
            'min' => 0,
            'max' => 1000,
            'step' => 1
        ],
        [
            'id' => 'carousel_items_pos',
            'type' => 'button_set',
            'title' => esc_html__('Items Position', 'pe-core'),
            'options' => [
                'start' => esc_html__('Top', 'pe-core'),
                'center' => esc_html__('Middle', 'pe-core'),
                'end' => esc_html__('Bottom', 'pe-core')
            ],
            'multi' => false,
            'default' => 'center'
        ],
        [
            'id' => 'carousel_equal_height',
            'type' => 'switch',
            'title' => esc_html__('Custom Height', 'pe-core'),
            'default' => false
        ],
        [
            'id' => 'carousel_item_height',
            'type' => 'slider',
            'title' => esc_html__('Item Height', 'pe-core'),
            'min' => 0,
            'max' => 1000,
            'step' => 1,
            'display_value' => 'label',
            'required' => ['carousel_equal_height', '=', 'true']
        ],
        [
            'id' => 'global-opts-carousel-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-circletext',
            'type' => 'accordion',
            'title' => esc_html__('Circle Text', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'circletext_center_icon',
            'type' => 'button_set',
            'title' => esc_html__('Center Icon', 'pe-core'),
            'options' => [
                'on' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circletext_center_icon_select',
            'type' => 'icon_select',
            'title' => esc_html__('Icon', 'pe-core'),
            'required' => ['circletext_center_icon', '=', 'on']
        ],
        [
            'id' => 'circletext_words_seperator',
            'type' => 'button_set',
            'title' => esc_html__('Words Seperator', 'pe-core'),
            'options' => [
                'on' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circletext_words_seperator_select',
            'type' => 'icon_select',
            'title' => esc_html__('Seperator', 'pe-core'),
            'required' => ['circletext_words_seperator', '=', 'on']
        ],
        [
            'id' => 'circletext_rotate_direction',
            'type' => 'button_set',
            'title' => esc_html__('Rotate Direction', 'pe-core'),
            'multi' => false,
            'options' => [
                'counter_clockwise' => esc_html__('Left', 'pe-core'),
                '' => esc_html__('Right', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circetext_height',
            'type' => 'slider',
            'title' => esc_html__('Height', 'pe-core'),
            'min' => 20,
            'max' => 1000,
            'step' => 1,
            'default' => 200,
            'display_value' => 'label'
        ],
        [
            'id' => 'circletext_blur_bg',
            'type' => 'button_set',
            'title' => esc_html__('Blur Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'blur-bg' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circletext_color_bg',
            'type' => 'button_set',
            'title' => esc_html__('Color Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-bg' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'circletext_alignment',
            'type' => 'button_set',
            'title' => esc_html__('Alignment', 'pe-core'),
            'multi' => false,
            'options' => [
                'left' => esc_html__('Left', 'pe-core'),
                'center' => esc_html__('Center', 'pe-core'),
                'right' => esc_html__('Right', 'pe-core'),
            ],
            'default' => 'left'
        ],
        [
            'id' => 'global-opts-circletext-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-clients',
            'type' => 'accordion',
            'title' => esc_html__('Clients', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'clients_type',
            'type' => 'select',
            'title' => esc_html__('Type', 'pe-core'),
            'multi' => false,
            'options' => [
                'pe--clients--grid' => esc_html__('Grid', 'pe-core'),
                'pe--clients-carousel' => esc_html__('Carousel', 'pe-core'),
            ],
            'default' => 'pe--clients--grid'
        ],
        [
            'id' => 'clients_columns',
            'type' => 'slider',
            'title' => esc_html__('Columns', 'pe-core'),
            'min' => 0,
            'max' => 12,
            'step' => 1,
            'default' => 3,
            'display_value' => 'label',
            'required' => ['clients_type', '=', 'pe--clients--grid']
        ],
        [
            'id' => 'clients_columns_spacing',
            'type' => 'slider',
            'title' => esc_html__('Columns Spacing', 'pe-core'),
            'min' => 0,
            'max' => 500,
            'step' => 1,
            'default' => 20,
            'display_value' => 'label',
            'required' => ['clients_type', '=', 'pe--clients--grid']
        ],
        [
            'id' => 'clients_background',
            'type' => 'button_set',
            'title' => esc_html__('Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-bg' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => ''
        ],
        [
            'id' => 'clients_hover',
            'type' => 'button_set',
            'title' => esc_html__('Hover', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-hover' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => '',
            'required' => ['clients_background', '=', 'has-bg']
        ],
        [
            'id' => 'clients_hover_switch',
            'type' => 'button_set',
            'title' => esc_html__('Switch logos at hover', 'pe-core'),
            'multi' => false,
            'options' => [
                'hover-switch-logos' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => '',
            'required' => ['clients_background', '=', 'has-bg']
        ],
        [
            'id' => 'clients_captions',
            'type' => 'button_set',
            'title' => esc_html__('Captions', 'pe-core'),
            'multi' => false,
            'options' => [
                'show-captions' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => 'show-captions',
        ],
        [
            'id' => 'global-opts-clients-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-icon',
            'type' => 'accordion',
            'title' => esc_html__('Icon', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'icon_size',
            'type' => 'slider',
            'title' => esc_html__('Size', 'pe-core'),
            'min' => 0,
            'max' => 1000,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label'
        ],
        [
            'id' => 'icon_alignment',
            'type' => 'button_set',
            'title' => esc_html__('Alignment', 'pe-core'),
            'multi' => 'false',
            'options' => [
                'left' => esc_html__('Left', 'pe-core'),
                'center' => esc_html__('Center', 'pe-core'),
                'right' => esc_html__('Right', 'pe-core')
            ],
            'default' => 'left'
        ],
        [
            'id' => 'icon_background',
            'type' => 'button_set',
            'title' => esc_html__('Background', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-bg' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ],
            'default' => 'has-bg'
        ],
        [
            'id' => 'icon_background_size',
            'type' => 'slider',
            'title' => esc_html__('Background Size', 'pe-core'),
            'min' => 0,
            'max' => 1000,
            'step' => 1,
            'default' => 100,
            'display_value' => 'label',
            'required' => ['icon_background', '=', 'has-bg']
        ],
        [
            'id' => 'icon_hover_effects',
            'type' => 'button_set',
            'title' => esc_html__('Hover Effects', 'pe-core'),
            'multi' => false,
            'options' => [
                'has-hover' => esc_html__('On', 'pe-core'),
                '' => esc_html__('Off', 'pe-core')
            ]
        ],
        [
            'id' => 'global-opts-icon-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-marquee',
            'type' => 'accordion',
            'title' => esc_html__('Marquee', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'marquee_text_type',
            'type' => 'select',
            'title' => esc_html__('Text Type', 'pe-core'),
            'options' => [
                'h1' => esc_html__('H1', 'pe-core'),
                'h2' => esc_html__('H2', 'pe-core'),
                'h3' => esc_html__('H3', 'pe-core'),
                'h4' => esc_html__('H4', 'pe-core'),
                'h5' => esc_html__('H5', 'pe-core'),
                'h6' => esc_html__('H6', 'pe-core'),
            ],
            'default' => 'h1'
        ],
        [
            'id' => 'marquee_heading_size',
            'type' => 'select',
            'title' => esc_html__('Heading Size', 'pe-core'),
            'multi' => false,
            'options' => [
                '' => esc_html__('Normal', 'pe-core'),
                'md-title' => esc_html__('Medium', 'pe-core'),
                'big-title' => esc_html__('Large', 'pe-core')
            ],
            'required' => ['marquee_text_type', '=', 'h1']
        ],
        [
            'id' => 'marquee_seperator_type',
            'type' => 'select',
            'title' => esc_html__('Seperator Type', 'pe-core'),
            'multi' => false,
            'options' => [
                'none' => esc_html__('None', 'pe-core'),
                'icon' => esc_html__('Icon', 'pe-core'),
                'image' => esc_html__('Image', 'pe-core')
            ]
        ],
        [
            'id' => 'marquee_seperator_size',
            'type' => 'slider',
            'title' => esc_html__('Seperator Size', 'pe-core'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label',
            'required' => ['marquee_seperator_type', '=', 'icon']
        ],
        [
            'id' => 'marquee_seperator_margin',
            'type' => 'slider',
            'title' => esc_html__('Seperator Margin', 'pe-core'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label',
            'required' => ['marquee_seperator_type', '=', 'icon']
        ],
        [
            'id' => 'marquee_image_size',
            'type' => 'slider',
            'title' => esc_html__('Image Size', 'pe-core'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label',
            'required' => ['marquee_seperator_type', '=', 'image']
        ],
        [
            'id' => 'marquee_image_margin',
            'type' => 'slider',
            'title' => esc_html__('Seperator Margin', 'pe-core'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 50,
            'display_value' => 'label',
            'required' => ['marquee_seperator_type', '=', 'image']
        ],
        [
            'id' => 'global-opts-marquee-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-singlepost',
            'type' => 'accordion',
            'title' => esc_html__('Single Post', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'singlepost_thumb',
            'type' => 'switch',
            'title' => esc_html__('Thumbnail', 'pe-core')
        ],
        [
            'id' => 'singlepost_date',
            'type' => 'switch',
            'title' => esc_html__('Date', 'pe-core')
        ],
        [
            'id' => 'singlepost_cats',
            'type' => 'switch',
            'title' => esc_html__('Category', 'pe-core')
        ],
        [
            'id' => 'singlepost_excerpt',
            'type' => 'switch',
            'title' => esc_html__('Excerpt', 'pe-core')
        ],
        [
            'id' => 'singlepost_button',
            'type' => 'switch',
            'title' => esc_html__('Button', 'pe-core')
        ],
        [
            'id' => 'global-opts-singlepost-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-singleproject',
            'type' => 'accordion',
            'title' => esc_html__('Single Project', 'pe-core'),
            'position' => 'start',
        ],
        [
            'id' => 'singleproject_cat',
            'type' => 'switch',
            'title' => esc_html__('Category', 'pe-core')
        ],
        [
            'id' => 'singleproject_title_pos',
            'type' => 'button_set',
            'title' => esc_html__('Title Pos', 'pe-core'),
            'options' => [
                'column-reverse' => esc_html__('Top', 'pe-core'),
                'column' => esc_html__('Bottom', 'pe-core')
            ],
            'default' => 'column'
        ],
        [
            'id' => 'singleproject_border_radius',
            'type' => 'spacing',
            'title' => esc_html__('Border Radius', 'pe-core'),
            'units' => ['px', '%'],
            'units_extended' => true,
            'default' => [
                'border-top-left-radius' => '30px',
                'border-top-right-radius' => '30px',
                'border-bottom-right-radius' => '30px',
                'border-bottom-left-radius' => '30px',
                'units' => 'px'
            ]
        ],
        [
            'id' => 'global-opts-singleproject-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-testimonials',
            'type' => 'accordion',
            'title' => esc_html__('Testimonials', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'testimonials_style',
            'type' => 'select',
            'title' => esc_html__('Style', 'pe-core'),
            'multi' => false,
            'options' => [
                'test--dynamic' => esc_html__('Dynamic', 'pe-core'),
                'test--carousel' => esc_html__('Carousel', 'pe-core')
            ],
            'default' => 'test--dynamic'
        ],
        [
            'id' => 'testimonials_text_alignment',
            'type' => 'button_set',
            'multi' => false,
            'title' => esc_html__('Text Alignment', 'pe-core'),
            'options' => [
                'column-reverse' => esc_html__('Top', 'pe-core'),
                'column' => esc_html__('Bottom', 'pe-core')
            ],
            'default' => 'column'
        ],
        [
            'id' => 'global-opts-testimonials-end',
            'type' => 'accordion',
            'position' => 'end'
        ],
        [
            'id' => 'global-opts-video',
            'type' => 'accordion',
            'title' => esc_html__('Video', 'pe-core'),
            'position' => 'start'
        ],
        [
            'id' => 'video_select_controls',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Select Controls', 'pe-core'),
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
        ],
        [
            'id' => 'video_autoplay',
            'title' => esc_html__('Autoplay', 'pe-core'),
            'type' => 'switch',
        ],
        [
            'id' => 'video_muted',
            'title' => esc_html__('Muted', 'pe-core'),
            'type' => 'switch',
        ],
        [
            'id' => 'video_loop',
            'title' => esc_html__('Loop', 'pe-core'),
            'type' => 'switch',
        ],
        [
            'id' => 'video_lightbox',
            'title' => esc_html__('Lightbox', 'pe-core'),
            'type' => 'switch',
        ],
        [
            'id' => 'global-opts-video-end',
            'type' => 'accordion',
            'position' => 'end'
        ]

    ],
]);
Redux::setSection($opt_name, [
    "title" => esc_html__("Custom CSS/JS", "pe-core"),
    "id" => "fullscreen-foasasddoter",
    "icon" => "eicon-custom-css",
    "fields" => [
        [
            "id" => "css_editor",
            "type" => "ace_editor",
            "title" => __("CSS", "pe-core"),
            "subtitle" => __("Write your custom CSS code here.", "pe-core"),
            "mode" => "css",
            "theme" => "monokai",
        ],
        [
            "id" => "js_editor",
            "type" => "ace_editor",
            "title" => __("JavaScript", "pe-core"),
            "subtitle" => __("Write your custom JS code here.", "pe-core"),
            "mode" => "javascript",
            "theme" => "chrome",
        ],
    ],
]);
