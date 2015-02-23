<?php 

function pasw2015_eu_law_script() {

   wp_enqueue_script(
        'jquery-cookie',
		get_template_directory_uri() . '/js/jquery.cookie.min.js',
        array( 'jquery' ),
        '',
        true
    );

    $scriptData = array(
        'message' => get_option('pasw_eucookie_msg') ,
        'button'  => get_option('pasw_eucookie_button'),
        'more'    => get_option('pasw_eucookie_info'),
        'url'    => get_permalink(get_option('pasw_eucookie_page')),
        );


	wp_enqueue_script(
		'pasw2015_law',
		get_template_directory_uri() . '/js/pasw2015_law.js',
		array('jquery','jquery-cookie'),
		'',
		true
	);

 wp_localize_script('pasw2015_law','pasw2015_law_text',$scriptData);


	
}

add_action('wp_enqueue_scripts', 'pasw2015_eu_law_script'); 
