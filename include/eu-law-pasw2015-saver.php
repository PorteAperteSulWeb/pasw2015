<?php

    if(isset($_POST['Submit'])) { //Salvataggio Impostazioni
		update_option( 'pasw_eucookie_button', $_POST["pasw_eucookie_button_n"] );
		update_option( 'pasw_eucookie_info', $_POST["pasw_eucookie_info_n"] );
		update_option( 'pasw_eucookie_page', $_POST["pasw_eucookie_page_n"] );
		update_option( 'pasw_eucookie_msg', esc_html(stripslashes($_POST["pasw_eucookie_msg_n"])) );
		update_option( 'pasw_eucookie_box_msg', esc_html(stripslashes($_POST["pasw_eucookie_box_msg_n"])) );
		update_option( 'pasw_eucookie_expire', $_POST["pasw_eucookie_expire_n"] );

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

?>
