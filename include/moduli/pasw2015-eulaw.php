<?php 

if (get_option('pasw_eucookie_page') && get_option('pasw_eucookie_msg') && get_option('pasw_eucookie_button') && get_option('pasw_eucookie_info')){

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

/* =========== SHORTCODE ============ */
function cookie_policy($atts, $content = null)
{
	$cookie_name = 'pasw_law_cookie';
	if(!isset($_COOKIE[$cookie_name])) {
		$returner = '<div class="pasw2015cookies_block" style="width:auto;height:auto;">';
		$returner .= '<span>' . get_option('pasw_eucookie_box_msg') .'</span>';
		$returner .= '<!--' . $content . '-->';
		$returner .='</div><div class="clear"></div>';
		return $returner;
	}
	else
	{
		$returner = $content ;
		return $returner;
	}
}
add_shortcode('cookie_policy', 'cookie_policy');



/* ========= END SHORTCODE ========== */


}
