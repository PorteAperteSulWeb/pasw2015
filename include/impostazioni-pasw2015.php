<?php

add_action('admin_enqueue_scripts', 'pasw2015_upload_admin_scripts');

function pasw2015_upload_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'pasw2015-impostazioni') {
        wp_enqueue_media();
        wp_register_script('pasw2015-upload-admin-js', get_template_directory_uri() . '/js/uploader.js', array('jquery'));
        wp_enqueue_script('pasw2015-upload-admin-js');
    }
}
function my_myme_types($mime_types){
    $mime_types['p12'] = 'application/x-pkcs12'; //Adding svg extension
    return $mime_types;
}

add_filter('upload_mimes', 'my_myme_types', 1, 1);
function pasw2015_impostazioni() { ?>
    <div class="wrap">

        <h2><b>P</b>orte <b>A</b>perte <b>s</b>ul <b>W</b>eb &bull; Impostazioni</h2>

            <?php require ( get_template_directory() . '/include/impostazioni-pasw2015-saver.php' ); ?>

            <form method="post" name="options" target="_self">
            <?php wp_nonce_field('update-options') ?>

        <div id="welcome-panel" class="welcome-panel">
            <div class="welcome-panel-content">
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h4>Stile</h4>

                        <input id="fluid" type="checkbox" name="pasw_fluid_layout_n"
                        <?php $get_pasw_fluid_layout = get_option('pasw_fluid_layout');
                        if ($get_pasw_fluid_layout == '1') { echo ' checked="checked" '; } ?>><label for="fluid">layout allargato</label><br/>

                        <input id="social" type="checkbox" name="pasw_social_n"
                        <?php $get_pasw_social = get_option('pasw_social');
                        if ($get_pasw_social == '1') { echo ' checked="checked" '; }?>><label for="social">Abilita Pulsanti Sociali negli articoli</label>

                        <h4>Modalità Sottopagine</h4>
                        <select name="pasw_submenu_n" >
                            <option value="3" <?php if (get_option( 'pasw_submenu') == '3') { echo 'selected="selected"'; }?>>Disabilitato</option>
                            <option value="0" <?php if (get_option( 'pasw_submenu') == '0') { echo 'selected="selected"'; }?>>Verticale Sinistra</option>
                            <option value="1" <?php if (get_option( 'pasw_submenu') == '1') { echo 'selected="selected"'; }?>>Verticale Destra</option>
                            <option value="2" <?php if (get_option( 'pasw_submenu') == '2') { echo 'selected="selected"'; }?>>Orizzontale</option>
                            <option value="4" <?php if (get_option( 'pasw_submenu') == '4') { echo 'selected="selected"'; }?>>On Sidebar</option>
                        </select>
                        
                        <h4>Logo</h4>
                        <label for="upload_image">
                            <input id="pasw_logo_n" type="text" size="36" name="pasw_logo_n" value="<?php if (get_option('pasw_logo') != '') { echo get_option('pasw_logo'); } else { echo 'http://'; } ?>" />
                            <input id="pasw_logo_upload" class="button" type="button" value="Carica" />
                        </label>
                        
                        <h4>Menù Principale</h4>

                        <input id="loglink" type="checkbox" name="pasw_menu_login_n"
                        <?php $get_pasw_menu_login = get_option('pasw_menu_login');
                        if ($get_pasw_menu_login == '0') { echo ' checked="checked" '; }?>><label for="loglink">Abilita link Login nel Menù</label>
                        <br/>
                        <input id="secondomenu" type="checkbox" name="pasw_secondo_menu_n"
                        <?php $get_pasw_secondo_menu = get_option('pasw_secondo_menu');
                        if ($get_pasw_secondo_menu == '1') { echo ' checked="checked" '; }?>><label for="secondomenu">Abilita Secondo Menù</label>

                        <br/>
                        <input id="fixedmenu" type="checkbox" name="pasw_fixedmenu_n"
                        <?php $get_pasw_fixedmenu = get_option('pasw_fixedmenu');
                        if ($get_pasw_fixedmenu == '1') { echo ' checked="checked" '; }?>><label for="fixedmenu">Fixed menu</label>

                    </div>
                    <div class="welcome-panel-column">
                        <h4>Informazioni Autore</h4>

                        <label for="author">Autore del sito:</label>
                        <input id="author" type="text" name="pasw_autore_n" value="<?php echo get_option('pasw_autore'); ?>" size="40" placeholder="Mario Rossi">
                        <br>
                        <label for="author">URL Autore del sito:</label>
                        <input id="authorlink" type="text" name="pasw_autorelink_n" value="<?php echo get_option('pasw_autorelink'); ?>" size="40" placeholder="http://">
                        
                        <h4>Informazioni Ente</h4>

                        <label for="address">indirizzo:</label>
                        <input id="address" type="text" name="pasw_indirizzo_scuola_n" value="<?php echo stripslashes(get_option('pasw_indirizzo_scuola')); ?>" size="40" placeholder="Via Papa Giovanni XXIII, 1">

                        <br/><label for="phone">numero di telefono:</label>
                        <input id="phone" type="text" name="pasw_recapito_scuola_n" value="<?php echo stripslashes(get_option('pasw_recapito_scuola')); ?>" size="40" placeholder="tel. 0345/ - fax 0345/">

                        <br/><label for="email">e-mail:</label><br />
                        <input id="email" type="text" name="pasw_email_scuola_n" value="<?php echo stripslashes(get_option('pasw_email_scuola')); ?>" size="40" placeholder="codicemecc@istruzione.it">
						
			<br/><label for="pec">pec:</label><br />
                        <input id="email" type="text" name="pasw_pec_scuola_n" value="<?php echo stripslashes(get_option('pasw_pec_scuola')); ?>" size="40" placeholder="codicemecc@pec.istruzione.it">
                        
            		<br/><label for="cfpiva">C.Fisc / P.Iva:</label>
                        <input id="email" type="text" name="pasw_cfpiva_scuola_n" value="<?php echo stripslashes(get_option('pasw_cfpiva_scuola')); ?>" size="40" placeholder="c.f. xxxxxxxxxxx">
                    </div>
                    <div class="welcome-panel-column welcome-panel-last">
                        <h4>Homepage</h4>
                        <p>La prima pagina di Pasw2015 è composta da 3 fasce orizzontali.</p>
                        <ul>
                            <li><a href="<?php echo get_edit_post_link( get_option('page_on_front') ); ?>" class="welcome-icon welcome-view-site">Modifica 1a Fascia (testo homepage)</a></li>
                            <li><a href="widgets.php" class="welcome-icon welcome-view-site">Modifica 2a/3a Fascia (widget)</a></li>
                        </ul>
                        
                        <h4>Varie</h4>
                        <ul>
                            <li><a href="options-general.php" class="welcome-icon welcome-edit-page">Modifica il titolo o la descrizione del sito</a></li>
                            <li><a href="themes.php?page=custom-header" class="welcome-icon welcome-view-site">Cambia immagine o colore della testata</a></li>
                            <li><a href="customize.php" class="welcome-icon welcome-view-site">Cambia icona del sito da <b>Identità del Sito</b></a></li>
                            <li><a href="themes.php?page=custom-background" class="welcome-icon welcome-view-site">Cambia immagine o colore di sfondo</a></li>
                        </ul>
                    </div>
                <div class="clear"></div>
                <h4>Loghi Footer</h4>
                        <?php
                            $content = html_entity_decode(get_option('pasw_loghi_footer'));
                            $editor_settings =  array (
                                    'textarea_rows' => 8,
                                    'teeny'         => TRUE,
                                    'tinymce'       => TRUE
                            );

                            wp_editor( $content, 'pasw_loghi_footer_n', $editor_settings );
                        ?>
                <h4>Testo Footer</h4>
                        <?php
                            $content = html_entity_decode(get_option('pasw_testo_footer'));
                            $editor_settings =  array (
                                    'textarea_rows' => 2,
                                    'media_buttons' => FALSE,
                                    'teeny'         => TRUE,
                                    'tinymce'       => TRUE
                            );

                            wp_editor( $content, 'pasw_testo_footer_n', $editor_settings );
                        ?>
            </div>
        </div>
            <br><hr><br>
            <div class="welcome-panel-content">
                <h4>Google Analytics</h4>

                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h4>Codice di Monitoraggio</h4>

                        <label for="ga-id">ID monitoraggio:</label>
                        <input id="ga-id" type="text" name="pasw_ga_id_n" value="<?php echo get_option('pasw_ga_id'); ?>" class="regular-text" placeholder="UA-00000000-0">
                        
                        <br>
                        <input id="ga-anonymous" type="checkbox" name="pasw_ga_anonymous_n"
                        <?php $get_pasw_ga_anonymous = get_option('pasw_ga_anonymous');
                        if ($get_pasw_ga_anonymous == '1') { echo ' checked="checked" '; }?>><label for="ga-anonymous">Anonimizza gli indirizzi IP</label>

                    </div>
                    <div class="welcome-panel-column">
                        <h4>Pagina Statistiche</h4>

                        <label for="ga-profile-id">ID Profilo (es. 00000000):</label>
                        <input id="ga-profile-id" type="text" name="pasw_ga_profile_id_n" value="<?php echo get_option('pasw_ga_profile_id'); ?>" class="regular-text">
                        
                        <label for="ga-user">Username:</label>
                        <input id="ga-user-n" type="text" name="pasw_ga_user_n" value="<?php echo get_option('pasw_ga_user'); ?>" class="regular-text" placeholder="xxx@developer.gserviceaccount.com"><small>(lascia vuoto se vuoi utilizzare il sistema di autenticazione PASW)</small>
                        
                        <br>
                        <?php if ( get_option( 'pasw_ga_password' ) ) { ?>
                        <label for="ga-password">Password:</label>
                        <input id="ga-password-n" type="text" name="pasw_ga_password_n" value="<?php if (get_option('pasw_ga_password')) { echo '#OK#'; } ?>" class="regular-text">
                        <br/><small style="background-color:yellow;">Elimina la Password per passare al nuovo sistema di autenticazione. Fallo al più presto, per nuove funzioni e maggior sicurezza.</small>
                        <?php } else { ?>
                        <label for="upload_image">
                            Inserisci un certificato P12
                            <input id="pasw-p12-n" type="text" size="36" name="pasw_p12_n" value="<?php if (get_option('pasw_p12') != '') { echo get_option('pasw_p12'); } else { echo 'http://'; } ?>" />
                            <input id="pasw_p12_upload" class="button" type="button" value="Carica" />
                            <br><br>
                        </label>
                        
                        <?php } ?>

                    </div>
                    <div class="welcome-panel-column welcome-panel-last">
                        <center> <br><br>
                        <small><a class="add-new-h2" href="https://github.com/PorteAperteSulWeb/pasw2015/wiki/Configurare-Google-Analytics" target="_blank">Guida alla Configurazione</a></small>
                        </center>
                    </div>
                </div>
            </div>
        </div>

    </div>
        <p class="submit"><input type="submit" class="button-primary" name="Submit" value="Salva Impostazioni" /></p>
        </form>

<?php }

?>
