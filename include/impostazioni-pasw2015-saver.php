<?php

    $cryptKey = get_option('pasw_key');
    $qEncoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $_POST["pasw_ga_password_n"], MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );

    if(isset($_POST['Submit'])) { //Salvataggio Impostazioni

        // INFO SITO
        update_option( 'pasw_autore', $_POST["pasw_autore_n"] );
        update_option( 'pasw_recapito_scuola', $_POST["pasw_recapito_scuola_n"] );
        update_option( 'pasw_email_scuola', $_POST["pasw_email_scuola_n"] );
        update_option( 'pasw_pec_scuola', $_POST["pasw_pec_scuola_n"] );
        update_option( 'pasw_cfpiva_scuola', $_POST["pasw_cfpiva_scuola_n"] );
        update_option( 'pasw_indirizzo_scuola', $_POST["pasw_indirizzo_scuola_n"] );
        update_option( 'pasw_logo', $_POST["pasw_logo_n"] );
        update_option( 'pasw_favicon', $_POST["pasw_favicon_n"] );
        update_option( 'pasw_ga_id', $_POST["pasw_ga_id_n"] );
        update_option( 'pasw_ga_profile_id', $_POST["pasw_ga_profile_id_n"] );
        update_option( 'pasw_ga_user', $_POST["pasw_ga_user_n"] );
        update_option( 'pasw_submenu', $_POST["pasw_submenu_n"] );

		if (get_option('pasw_eulaw') == 1) {	
		update_option( 'pasw_eucookie_button', $_POST["pasw_eucookie_button_n"] );
		update_option( 'pasw_eucookie_info', $_POST["pasw_eucookie_info_n"] );
		update_option( 'pasw_eucookie_page', $_POST["pasw_eucookie_page_n"] );
		update_option( 'pasw_eucookie_msg', esc_html(stripslashes($_POST["pasw_eucookie_msg_n"])) );
		update_option( 'pasw_eucookie_box_msg', esc_html(stripslashes($_POST["pasw_eucookie_box_msg_n"])) );
		}

        if ($_POST["pasw_ga_password_n"] != '#OK#') {
            update_option( 'pasw_ga_password', $qEncoded );
        }
        update_option( 'pasw_loghi_footer', htmlentities(stripslashes($_POST["pasw_loghi_footer_n"])) );
        update_option( 'pasw_testo_footer', htmlentities(stripslashes($_POST["pasw_testo_footer_n"])) );

        $get_recapito_scuola = $_POST["pasw_recapito_scuola_n"];
        update_option( 'pasw_recapito_scuola', $get_recapito_scuola );

        if (isset($_POST['pasw_social_n'])){
                update_option('pasw_social', '1');
            } else {
                update_option('pasw_social', '0');
        }

        if (isset($_POST['pasw_fixedmenu_n'])){
                update_option('pasw_fixedmenu', '1');
            } else {
                update_option('pasw_fixedmenu', '0');
        }

        if (isset($_POST['pasw_secondo_menu_n'])){
                update_option('pasw_secondo_menu', '1');
            } else {
                update_option('pasw_secondo_menu', '0');
        }

        if (isset($_POST['pasw_menu_login_n'])){
                update_option('pasw_menu_login', '0');
            } else {
                update_option('pasw_menu_login', '1');
        }

        if (isset($_POST['pasw_fluid_layout_n'])){
                update_option('pasw_fluid_layout', '1');
            } else {
                update_option('pasw_fluid_layout', '0');
        }
        
        if (isset($_POST['pasw_ga_anonymous_n'])){
                update_option('pasw_ga_anonymous', '1');
            } else {
                update_option('pasw_ga_anonymous', '0');
        }

    }
?>
