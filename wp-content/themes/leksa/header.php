<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Leksa
 */

if (class_exists("Redux")) {
    $option = get_option('pe-redux');


} else {

}

?>
<!doctype html>
<html class="first--load ajax--first" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo leksa_barba(true) ?>>
    <?php wp_body_open(); ?>
    <span hidden class="layout--colors"></span>



        <div id="page" class="site">


            <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'leksa'); ?></a>

            <?php

            leksa_mouse_cursor();
            leksa_page_transitions();

            if (class_exists("Redux") && $option['only--home']) {
                is_front_page() ? leksa_page_loader() : '';
            } else {
                leksa_page_loader();
            }

            if (leksa_header_template()) { ?>

                <header id="masthead"
                    class="site-header header--template pe-items-center <?php echo leksa_header_classes() ?>">

                    <?php echo leksa_header_template() ?>

                </header><!-- #masthead -->

            <?php } else { ?>

                <div class="pe-section header--default">

                    <header id="masthead" class="site-header pe-wrapper pe-items-center <?php leksa_header_classes() ?>">
                        <div class="pe-col-6">

                            <div class="site-branding">
                                <?php the_custom_logo(); ?>

                                <h5 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                        rel="home"><?php bloginfo('name'); ?></a></h5>

                                <?php

                                $leksa_description = get_bloginfo('description', 'display');
                                if ($leksa_description || is_customize_preview()):
                                    ?>
                                    <p class="site-description">
                                        <?php echo esc_html($leksa_description); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    </p>
                                <?php endif; ?>
                            </div><!-- .site-branding -->

                        </div>

                        <div class="pe-col-6 pe-items-right">

                            <nav id="site-navigation" class="main-navigation">
                                <button class="menu-toggle" aria-controls="primary-menu"
                                    aria-expanded="false"><?php esc_html_e('Primary Menu', 'leksa'); ?></button>
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'menu-1',
                                        'menu_id' => 'primary-menu',
                                    )
                                );
                                ?>
                            </nav><!-- #site-navigation -->

                        </div>

                    </header><!-- #masthead -->

                </div>

            <?php } ?>