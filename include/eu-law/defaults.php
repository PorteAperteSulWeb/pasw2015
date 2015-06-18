<?php
        if (get_option('pasw_eucookie_button') == ''){ update_option('pasw_eucookie_button', 'Si, accetto'); }
        if (get_option('pasw_eucookie_info') == ''){ update_option('pasw_eucookie_info', 'No, maggiori informazioni'); }
        if (get_option('pasw_eucookie_msg') == ''){ update_option('pasw_eucookie_msg', 'I cookie ci aiutano a migliorare il sito. Utilizzando il sito, accetti l\'utilizzo dei cookie da parte nostra.'); }
        if (get_option('pasw_eucookie_box_msg') == ''){ update_option('pasw_eucookie_box_msg', 'Contenuto bloccato, accetta i cookie per visualizzare il contenuto'); }
        if (get_option('pasw_eucookie_position_banner') == ''){ update_option('pasw_eucookie_position_banner', '0'); }
		
		// Default colore
		
		if (get_option('pasw_eucookie_bgcolor_banner') == ''){ update_option('pasw_eucookie_bgcolor_banner', '#222222'); }
		if (get_option('pasw_eucookie_textcolor_banner') == ''){ update_option('pasw_eucookie_textcolor_banner', '#ffffff'); }
		if (get_option('pasw_eucookie_bgopacity_banner') == ''){ update_option('pasw_eucookie_bgopacity_banner', '0.9'); }
		
		if (get_option('pasw_eucookie_bgcolor_blocco') == ''){ update_option('pasw_eucookie_bgcolor_blocco', '#d8d8d8'); }
		if (get_option('pasw_eucookie_textcolor_blocco') == ''){ update_option('pasw_eucookie_textcolor_blocco', '#7f7f7f'); }
		if (get_option('pasw_eucookie_bgopacity_blocco') == ''){ update_option('pasw_eucookie_bgopacity_blocco', '0.5'); }
		
		if (get_option('pasw_eucookie_bgcolor_short_ca') == ''){ update_option('pasw_eucookie_bgcolor_short_ca', '#FCA182'); }
		if (get_option('pasw_eucookie_textcolor_short_ca') == ''){ update_option('pasw_eucookie_textcolor_short_ca', '#00004d'); }

		
		if (get_option('pasw_eucookie_bgcolor_short_cd') == ''){ update_option('pasw_eucookie_bgcolor_short_cd', '#A1B8CB'); }
		if (get_option('pasw_eucookie_textcolor_short_cd') == ''){ update_option('pasw_eucookie_textcolor_short_cd', '#ffffff'); }
	//	if (get_option('pasw_eucookie_bgopacity_shortcode') == ''){ update_option('pasw_eucookie_bgopacity_shortcode', '0.9'); }