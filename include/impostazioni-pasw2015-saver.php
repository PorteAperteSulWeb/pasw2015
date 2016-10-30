<?php

    $cryptKey = get_option('pasw_key');
    if (function_exists('mcrypt_encrypt') ) {
        if (!isset($_POST["pasw_ga_password_n"])) {
            $qEncoded = '';
        } else {
            $qEncoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $_POST["pasw_ga_password_n"], MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
        }
    }

    if(isset($_POST['Submit'])) { //Salvataggio Impostazioni

        // INFO SITO
        update_option( 'pasw_autore', $_POST["pasw_autore_n"] );
        update_option( 'pasw_autorelink', $_POST["pasw_autorelink_n"] );
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
	update_option( 'pasw_scrolltop', $_POST["pasw_scrolltop_n"] );

		// SOCIAL ENTE

		update_option( 'pasw_pagefb', $_POST["pasw_pagefb_n"] );
		update_option( 'pasw_proftwitter', $_POST["pasw_proftwitter_n"] );
		update_option( 'pasw_profinstagram', $_POST["pasw_profinstagram_n"] );
		update_option( 'pasw_canaleyoutube', $_POST["pasw_canaleyoutube_n"] );
		update_option( 'pasw_profgoogle', $_POST["pasw_profgoogle_n"] );
		update_option( 'pasw_proflinkedin', $_POST["pasw_proflinkedin_n"] );
		update_option( 'pasw_pisocial', $_POST["pasw_pisocial_n"] );
		update_option( 'pasw_dimsocial', $_POST["pasw_dimsocial_n"] );

		if (isset($_POST['pasw_hidesocial_n'])){
                update_option('pasw_hidesocial', '1');
            } else {
                update_option('pasw_hidesocial', '0');
        }

		// fine SOCIAL ENTE


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

		if (isset($_POST['pasw_search_show_n'])){
                update_option('pasw_search_show', '0');
            } else {
                update_option('pasw_search_show', '1');
        }

        if (isset($_POST['pasw_fluid_layout_n'])){
                update_option('pasw_fluid_layout', '1');
            } else {
                update_option('pasw_fluid_layout', '0');
        }

		if (isset($_POST['pasw_responsive_layout_n'])){
                update_option('pasw_responsive_layout', '1');
            } else {
                update_option('pasw_responsive_layout', '0');
        }

        if (isset($_POST['pasw_ga_anonymous_n'])){
                update_option('pasw_ga_anonymous', '1');
            } else {
                update_option('pasw_ga_anonymous', '0');
        }

    }
?>
