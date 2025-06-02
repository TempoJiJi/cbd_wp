<?php
/**
 * Enqueue scripts and styles.
 */
function leksa_scripts_styles() {
    
    wp_enqueue_style( 'plugins' , get_template_directory_uri() . '/css/plugins.css');
    
	wp_enqueue_style( 'style', get_stylesheet_uri(), array() );
    
	wp_style_add_data( 'style-rtl', 'rtl', 'replace' );
    
     wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'),'',true);
    
     wp_enqueue_script( 'gsap', get_template_directory_uri() . '/js/gsap.js', array('jquery'),'',true);
	
     wp_enqueue_script( 'barba', get_template_directory_uri() . '/js/barba.min.js', array('jquery'),'',true);
    
     wp_enqueue_script( 'plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'),'',true);
    
	 wp_enqueue_script('lenis', get_template_directory_uri() . '/js/lenis.min.js', array('jquery'), '', true);

	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'),'',true);

	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

add_action( 'wp_enqueue_scripts', 'leksa_scripts_styles');
add_filter( 'wp_enqueue_scripts', 'leksa_scripts_styles', 0 );


?>
