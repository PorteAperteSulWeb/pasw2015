<?php

    if(isset($_POST['Submit'])) { //Salvataggio Impostazioni
		update_option( 'pasw_eucookie_button', $_POST["pasw_eucookie_button_n"] );
		update_option( 'pasw_eucookie_info', $_POST["pasw_eucookie_info_n"] );
		update_option( 'pasw_eucookie_page', $_POST["pasw_eucookie_page_n"] );
		update_option( 'pasw_eucookie_msg', esc_html(stripslashes($_POST["pasw_eucookie_msg_n"])) );
		update_option( 'pasw_eucookie_box_msg', esc_html(stripslashes($_POST["pasw_eucookie_box_msg_n"])) );
		update_option( 'pasw_eucookie_box_widget', esc_html(stripslashes($_POST["pasw_eucookie_box_widget_n"])) );
		update_option( 'pasw_eucookie_expire', $_POST["pasw_eucookie_expire_n"] );
		update_option( 'pasw_eucookie_position_banner', $_POST["pasw_eucookie_position_banner_n"] );
		
		// Salvataggio colori
		update_option( 'pasw_eucookie_bgcolor_banner', $_POST["pasw_eucookie_bgcolor_banner_n"] );
		update_option( 'pasw_eucookie_textcolor_banner', $_POST["pasw_eucookie_textcolor_banner_n"] );
		update_option( 'pasw_eucookie_bgopacity_banner', $_POST["pasw_eucookie_bgopacity_banner_n"] );
		
		update_option( 'pasw_eucookie_bgcolor_blocco', $_POST["pasw_eucookie_bgcolor_blocco_n"] );
		update_option( 'pasw_eucookie_textcolor_blocco', $_POST["pasw_eucookie_textcolor_blocco_n"] );
		update_option( 'pasw_eucookie_bgopacity_blocco', $_POST["pasw_eucookie_bgopacity_blocco_n"] );
		
		update_option( 'pasw_eucookie_bgcolor_short_ca', $_POST["pasw_eucookie_bgcolor_short_ca_n"] );
		update_option( 'pasw_eucookie_textcolor_short_ca', $_POST["pasw_eucookie_textcolor_short_ca_n"] );
		update_option( 'pasw_eucookie_bgcolor_short_cd', $_POST["pasw_eucookie_bgcolor_short_cd_n"] );
		update_option( 'pasw_eucookie_textcolor_short_cd', $_POST["pasw_eucookie_textcolor_short_cd_n"] );
	
	//	update_option( 'pasw_eucookie_bgopacity_shortcode', $_POST["pasw_eucookie_bgopacity_shortcode_n"] );
		
		// fine salvataggio colori

		if (isset($_POST['pasw_eucookie_automatic_n'])){
                update_option('pasw_eucookie_automatic', '1');
            } else {
                update_option('pasw_eucookie_automatic', '0');
        }
		
		if (isset($_POST['pasw_eucookie_remove_bottom_n'])){
                update_option('pasw_eucookie_remove_bottom', '1');
            } else {
                update_option('pasw_eucookie_remove_bottom', '0');
        }
	}
