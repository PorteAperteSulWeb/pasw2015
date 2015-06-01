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

extract(shortcode_atts(array(
    'tipo' => '',
    'showbox' => 'no',
    'privacy' => '',
   ), $atts));
	
	$html1= '<p style="text-align: right;">contenuto bloccato: ';
	
	switch ($tipo) {
		case "youtube":
			$privacy = 'http://www.google.it/intl/it/policies/privacy/';
			break;
		case "vimeo":
			$privacy = 'https://vimeo.com/privacy';
			break;
		case "facebook":
			$privacy = 'https://www.facebook.com/privacy/explanation';
			break;
		case "slideshare":
			$privacy ='https://www.linkedin.com/legal/privacy-policy';
			break;
	}
	
	if ($privacy != ''){
		$pageprivacy = ' - pagina <a href="'. $privacy .'" target="_blank" title="link esterno privacy '.$tipo.'">privacy</a> fornitore del servizio</p>';
		}
		else
		{
		$pageprivacy = '';
		}
		
	
	$cookie_name = 'pasw_law_cookie';
	if(!isset($_COOKIE[$cookie_name])) {
		if ($showbox == 'si'){
			$returner = '<div class="pasw2015cookies_block" style="width:auto;height:auto;">';
			$returner .= html_entity_decode(get_option('pasw_eucookie_box_msg'));
			if ($tipo != ''){
				$returner .= $html1 . $tipo . $pageprivacy;
				}
			$returner .= '<!--' . $content . '-->';
			$returner .='</div><div class="clear"></div>';
		}
		else{
			$returner .= '<!--' . $content . '-->';
		}
	    return $returner;
	}
	else
	{
	$returner = $content ;
	return $returner;
	}
}
add_shortcode('cookie', 'cookie_policy');



/* ========= END SHORTCODE ========== */

/* ========= Buttom Editor ========== */
function my_add_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'my_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'my_register_mce_button' );
	}
}
add_action('admin_head', 'my_add_mce_button');

// Declare script for new button
function my_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['my_mce_button'] = get_template_directory_uri() . '/js/buttomeditorcookie.js';
	return $plugin_array;
}

// Register new button in the editor
function my_register_mce_button( $buttons ) {
	array_push( $buttons, 'my_mce_button' );
	return $buttons;
}
/* ======= END Buttom Editor ======== */

}
