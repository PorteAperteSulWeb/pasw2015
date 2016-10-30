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

	$bgbanner= convertHex(get_option('pasw_eucookie_bgcolor_banner'),get_option('pasw_eucookie_bgopacity_banner'));

	if (get_option('pasw_eucookie_cookieName') == ""){
	$cookieName = 'pasw_law_cookie';
	}
	else
	{
	$cookieName = get_option('pasw_eucookie_cookieName');
	}

    $scriptData = array(
        'message' 	=> get_option('pasw_eucookie_msg') ,
        'button'  	=> get_option('pasw_eucookie_button'),
        'more'    	=> get_option('pasw_eucookie_info'),
        'url'   	=> get_permalink(get_option('pasw_eucookie_page')),
		'fine' 		=> get_option('pasw_eucookie_expire'),
		'bottom_active' => get_option('pasw_eucookie_remove_bottom'),
		'position' 	=> get_option ('pasw_eucookie_position_banner'),
		'bgbanner' => $bgbanner,
		'textcolor' => get_option ('pasw_eucookie_textcolor_banner'),
		'acceptOnClick' => get_option ('pasw_eucookie_acceptOnClick'),
		'cookieName' => $cookieName,
		'positionrevocalr' => get_option ('pasw_eucookie_position_revocalr'),
		'positionrevocatb' => get_option ('pasw_eucookie_position_revocatb')
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


/* =========== Auto Block ============ */
add_filter( 'the_content', 'pasw_eulaw_autoblock', 11);
add_filter( 'widget_text','pasw_eulaw_autoblock_widget', 11, 3 );

function pasw_eulaw_autoblock($content) {
	global $post;
	$is_exclude_page = get_post_meta($post->ID, '_is_pasw2015_exclude_page', true);
    if ( !cookie_accepted() && get_option('pasw_eucookie_automatic') && (!$is_exclude_page)) {
		$content = preg_replace('#<script.*?\/script>#is', '', $content);
		$content = preg_replace('#<iframe.*?\/iframe>|<embed.*?>|<object.*?\/object>#is', generate_cookie_notice_lite('auto', '100%'), $content);
    }
    return $content;
}

function pasw_eulaw_autoblock_widget($content) {

	   if ( !cookie_accepted() && get_option('pasw_eucookie_automatic')) {
		$content = preg_replace('#<script.*?\/script>#is', '', $content);
        $content = preg_replace('#<iframe.*?\/iframe>|<embed.*?>|<object.*?\/object>#is', generate_cookie_notice_widget('auto', '100%'), $content);
    }

    return $content;
}


/* ======== End Auto Block ========= */

/* =========== Funzioni ============ */

function cookie_accepted() {

	if (get_option('pasw_eucookie_cookieName') == ""){
	$cookieName = 'pasw_law_cookie';
	}
	else
	{
	$cookieName = get_option('pasw_eucookie_cookieName');
	}

    if ( isset( $_COOKIE[$cookieName] ) ) {
        return true;
    } else {
        return false;
    }
}

function generate_cookie_notice_text($height, $width, $text, $textpriv= null) {
	if (get_option ('pasw_eucookie_bgopacity_blocco')!= 0){
		$bgbox = 'background:'.convertHex(get_option ('pasw_eucookie_bgcolor_blocco'),get_option ('pasw_eucookie_bgopacity_blocco'));
	}
	$textboxcolor = get_option('pasw_eucookie_textcolor_blocco');
    return '<div class="pasw2015cookies_block" style="'. $bgbox .';color:'.$textboxcolor.';width:'.$width.';height:'.$height.';"><span>'.$text.'</span>'.$textpriv.'</div>';
}

function generate_cookie_notice_privacy($privacy, $tipo) {
	if($privacy != '') {
		return '<p style="text-align: right;">Contenuto bloccato: '. $tipo .' - pagina <a href="'. $privacy .'" target="_blank" title="link esterno privacy '.$tipo.'">privacy</a> fornitore del servizio</p>';
		} else {
			return '<p style="text-align: right;">Contenuto bloccato: '. $tipo.'</p>';
		}
}

function generate_cookie_notice($height, $width, $privacy=null, $tipo=null ) {
    $textpriv = generate_cookie_notice_privacy($privacy, $tipo);
    $text = html_entity_decode(get_option('pasw_eucookie_box_msg'));
	return generate_cookie_notice_text($height, $width, $text, $textpriv);
}
function generate_cookie_notice_lite($height, $width) {
    $text = html_entity_decode(get_option('pasw_eucookie_box_msg'));
	return generate_cookie_notice_text($height, $width, $text);
}

function generate_cookie_notice_widget($height, $width) {
    $text = html_entity_decode(get_option('pasw_eucookie_box_widget'));
	return generate_cookie_notice_text($height, $width, $text);
}

function pulisci($content,$ricerca){
	$caratteri = strlen($ricerca)+6;
	$stringa = substr($content, strpos($content, $ricerca), $caratteri);
	$stringa = str_replace($ricerca, '', $stringa);
	$stringa = trim(str_replace('"', '', $stringa));
	return $stringa.'px';
}

function convertHex($hex,$opacity){
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
    $result = 'rgba('.$r.','.$g.','.$b.','.$opacity.')';
    return $result;
}

/* ========= Buttom Editor ========== */
function cookie_add_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'cookie_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'cookie_register_mce_button' );
	}
}
add_action('admin_head', 'cookie_add_mce_button');

// Declare script for new button
function cookie_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['my_mce_button'] = get_template_directory_uri() . '/js/buttomeditorcookie.js';
	return $plugin_array;
}

// Register new button in the editor
function cookie_register_mce_button( $buttons ) {
	array_push( $buttons, 'my_mce_button' );
	return $buttons;
}
/* ======= END Buttom Editor ======== */

/* =========== SHORTCODE ============ */
function cookie_policy($atts, $content)
{

extract(shortcode_atts(array(
    'tipo' => '',
    'showbox' => 'no',
    'privacy' => '',
	'size' => 'auto',
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


	if ( cookie_accepted() ) {
        return do_shortcode( $content );
    } else {
        if ($size!='auto') {$width = pulisci($content,'width='); } else {$width='auto';}
        if ($size!='auto') {$height = pulisci($content,'height=');} else {$height = '100%';}
		if ($showbox == 'si'){
			if ($tipo != ''){
				return generate_cookie_notice($height, $width, $privacy, $tipo);
			} else {
				return generate_cookie_notice_lite($height, $width);
			}
		}
	}

}
add_shortcode('cookie', 'cookie_policy');



function eu_cookie_control_shortcode( $atts ) {
    if ( cookie_accepted() ) {
        return '
            <div class="pasw2015cookies_control" style="color:'.get_option('pasw_eucookie_textcolor_short_ca').'; background-color:'.get_option('pasw_eucookie_bgcolor_short_ca').' ;">
				Cookies abilitati <button id="remove-cookie-short"  href="#">Revoca consenso Cookie</button>
            </div>';
    } else {
        return '
            <div class="pasw2015cookies_control" style="color:'.get_option('pasw_eucookie_textcolor_short_cd').'; background-color:'.get_option('pasw_eucookie_bgcolor_short_cd').' ;">
             Cookie disabilitati<br>Accetta i Cookie cliccando "Si, accetto" nel banner.
            </div>';
    }
}
add_shortcode( 'cookie-control', 'eu_cookie_control_shortcode' );

/* ========= END SHORTCODE ========== */

}
