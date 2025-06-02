<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Leksa
 */

if (class_exists("Redux")) {
    $option = get_option('pe-redux');
    $footerFixed = $option['footer_fixed'] ? 'footer--fixed' : '';

} else {
    $footerFixed = '';

}

?>

<?php if (leksa_footer_template()) { ?>

    <footer id="colophon" class="site-footer <?php echo esc_attr($footerFixed) ?> footer--overlay">

        <?php echo leksa_footer_template() ?>


    </footer><!-- #colophon -->
<?php } else { ?>

    <footer id="colophon" class="site-footer pe-section">

        <div class="pe-wrapper">

            <div class="site-info">

                <a href="<?php echo esc_url(__('https://pethemes.com/', 'leksa')); ?>">
                    <?php
                    /* translators: %s: CMS name, i.e. WordPress. */
                    printf(esc_html__('Proudly powered by %s', 'leksa'), 'PeThemes');
                    ?>
                </a>

                <span class="sep"> | </span>

                <?php
                /* translators: 1: Theme name, 2: Theme author. */
                printf(esc_html__('Theme: %1$s by %2$s.', 'leksa'), 'leksa', '<a href="http://pethemes.com/">Pe Themes</a>');
                ?>
            </div><!-- .site-info -->

        </div>
    </footer><!-- #colophon -->

<?php } ?>

</div><!-- #page -->

<?php wp_footer();
  ?>

</body>

</html>