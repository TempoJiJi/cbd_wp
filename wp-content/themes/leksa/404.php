<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Leksa
 */
$option = get_option('pe-redux');
get_header();



?>



    <main id="primary" class="site-main" <?php echo leksa_barba(false) ?>>

        <?php if ($option['404_page_template']) {

            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($option['404_page_template']);

        } else { ?>

            <div class="pe-section">

                <div class="pe-wrapper">

                    <div class="pe-col-12">

                        <section class="error-404 not-found">
                            <header class="page-header">
                                <h1 class="page-title">
                                    <?php esc_html_e('Oops! That page can&rsquo;t be found.', 'leksa'); ?>
                                </h1>
                            </header><!-- .page-header -->

                            <div class="page-content">
                                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'leksa'); ?>
                                </p>

                                <?php
                                get_search_form();
                                ?>


                            </div><!-- .page-content -->
                        </section><!-- .error-404 -->


                    </div>

                </div>

            </div>

        <?php } ?>

    </main><!-- #main -->

    <?php

    get_footer();