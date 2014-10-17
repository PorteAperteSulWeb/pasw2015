<?php

add_action('admin_enqueue_scripts', 'pasw2015_upload_admin_scripts');

function pasw2015_upload_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'pasw2015-impostazioni') {
        wp_enqueue_media();
        wp_register_script('pasw2015-upload-admin-js', get_template_directory_uri() . '/js/uploader.js', array('jquery'));
        wp_enqueue_script('pasw2015-upload-admin-js');
    }
}

function pasw2015_impostazioni() { ?>
    <div class="wrap">

        <h2>Impostazioni</h2>

            <?php require ( get_template_directory() . '/include/impostazioni-pasw2015-saver.php' ); ?>

            <form method="post" name="options" target="_self">
            <?php wp_nonce_field('update-options') ?>

        <div id="welcome-panel" class="welcome-panel">
            <div class="welcome-panel-content">
                <h3>Generali</h3>
                <p class="about-description">Personalizza l'aspetto del sito</p>
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h4>Stile</h4>

                        <input id="fluid" type="checkbox" name="pasw_fluid_layout_n"
                        <?php $get_pasw_fluid_layout = get_option('pasw_fluid_layout');
                        if ($get_pasw_fluid_layout == '1') { echo ' checked="checked" '; } ?>><label for="fluid">layout allargato</label><br/>

                        <input id="social" type="checkbox" name="pasw_social_n"
                        <?php $get_pasw_social = get_option('pasw_social');
                        if ($get_pasw_social == '1') { echo ' checked="checked" '; }?>><label for="social">Abilita Pulsanti Sociali negli articoli</label>
                    <ul>
                        <li><a href="themes.php?page=custom-background" class="welcome-icon welcome-view-site">Cambia immagine o colore di sfondo</a></li>
                    </ul>

                    </div>
                    <div class="welcome-panel-column">
                        <h4>Visualizzazione Sottopagine</h4>
                        <select name="pasw_submenu_n" >
                            <option value="3" <?php if (get_option( 'pasw_submenu') == '3') { echo 'selected="selected"'; }?>>Disabilitato</option>
                            <option value="0" <?php if (get_option( 'pasw_submenu') == '0') { echo 'selected="selected"'; }?>>Verticale Sinistra</option>
                            <option value="1" <?php if (get_option( 'pasw_submenu') == '1') { echo 'selected="selected"'; }?>>Verticale Destra</option>
                            <option value="2" <?php if (get_option( 'pasw_submenu') == '2') { echo 'selected="selected"'; }?>>Orizzontale</option>
                        </select>
                    </div>
                    <div class="welcome-panel-column welcome-panel-last">
                        <h4>Homepage</h4>
                        <p>La prima pagina di Pasw2015 è composta da 3 fasce orizzontali.</p>
                        <ul>
                            <li><a href="<?php echo get_edit_post_link( get_option('page_on_front') ); ?>" class="welcome-icon welcome-view-site">Modifica 1a Fascia (testo homepage)</a></li>
                            <li><a href="widgets.php" class="welcome-icon welcome-view-site">Modifica 2a/3a Fascia (widget)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="welcome-panel" class="welcome-panel">
            <div class="welcome-panel-content">
                <h3>Google Analytics</h3>
                <p class="about-description">Personalizza Google Analytics</p>
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h4>Codice di Monitoraggio</h4>

                        <label for="ga-id">ID monitoraggio (es. UA-00000000-0):</label>
                        <input id="ga-id" type="text" name="pasw_ga_id_n" value="<?php echo get_option('pasw_ga_id'); ?>" class="regular-text">
                        <br/><small>(lascia vuoto per non inserire il codice)</small>

                    </div>
                    <div class="welcome-panel-column">
                        <h4>Pagina Statistiche</h4>

                        <label for="ga-profile-id">ID Profilo (es. 00000000):</label>
                        <input id="ga-profile-id" type="text" name="pasw_ga_profile_id_n" value="<?php echo get_option('pasw_ga_profile_id'); ?>" class="regular-text">
                        <label for="ga-user">Username:</label>
                        <input id="ga-user" type="text" name="pasw_ga_user_n" value="<?php echo get_option('pasw_ga_user'); ?>" class="regular-text">
                        <label for="ga-password">Password:</label>
                        <input id="ga-password" type="text" name="pasw_ga_password_n" value="<?php if (get_option('pasw_ga_password')) { echo '#OK#'; } ?>" class="regular-text">
                        <br/><small>(la password verrà criptata)</small>

                    </div>
                    <div class="welcome-panel-column welcome-panel-last">

                    </div>
                </div>
            </div>
        </div>

        <div id="welcome-panel" class="welcome-panel">
            <div class="welcome-panel-content">
                <h3>Header</h3>
                <p class="about-description">Personalizza la <strong>testata</strong> di <?php bloginfo('name'); ?>.</p>
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h4>Logo</h4>
                        <label for="upload_image">
                            <input id="pasw_logo_n" type="text" size="36" name="pasw_logo_n" value="<?php if (get_option('pasw_logo') != '') { echo get_option('pasw_logo'); } else { echo 'http://'; } ?>" />
                            <input id="pasw_logo_upload" class="button" type="button" value="Carica" />
                            <br />Inserisci un URL o carica un'immagine
                        </label>
                    </div>
                    <div class="welcome-panel-column">
                        <h4></h4>
                        <ul>
                            <li><a href="options-general.php" class="welcome-icon welcome-edit-page">Modifica il titolo o la descrizione del sito</a></li>
                            <li><a href="themes.php?page=custom-header" class="welcome-icon welcome-view-site">Cambia immagine o colore della testata</a></li>
                        </ul>
                    </div>
                    <div class="welcome-panel-column welcome-panel-last">

                        <input id="loglink" type="checkbox" name="pasw_menu_login_n"
                        <?php $get_pasw_menu_login = get_option('pasw_menu_login');
                        if ($get_pasw_menu_login == '0') { echo ' checked="checked" '; }?>><label for="loglink">Abilita link Login nel Menù</label>
                        <br/>
                        <input id="secondomenu" type="checkbox" name="pasw_secondo_menu_n"
                        <?php $get_pasw_secondo_menu = get_option('pasw_secondo_menu');
                        if ($get_pasw_secondo_menu == '1') { echo ' checked="checked" '; }?>><label for="secondomenu">Abilita Secondo Menù</label>
                    </div>
                </div>
            </div>
        </div>

        <div id="welcome-panel" class="welcome-panel">
            <div class="welcome-panel-content">
                <h3>Footer</h3>
                <p class="about-description">Personalizza il <strong>piede</strong> di <?php bloginfo('name'); ?>.</p>
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h4>Autore</h4>

                        <label for="author">webmaster:</label>
                        <input id="author" type="text" name="pasw_autore_n" value="<?php echo get_option('pasw_autore'); ?>" class="regular-text">


                    </div>
                    <div class="welcome-panel-column">
                        <h4>Info Scuola</h4>

                        <label for="address">indirizzo:</label>
                        <input id="address" type="text" name="pasw_indirizzo_scuola_n" value="<?php echo get_option('pasw_indirizzo_scuola'); ?>" class="regular-text">
                        <br/><small>(es. "Via Papa Giovanni XXIII, 1 - 24016")</small>

                        <br/><label for="phone">numero di telefono:</label>
                        <input id="phone" type="text" name="pasw_recapito_scuola_n" value="<?php echo get_option('pasw_recapito_scuola'); ?>" class="regular-text">
                        <br/><small>(es. "tel. 0345/ - fax 0345/")</small>

                        <label for="email">e-mail:</label>
                        <input id="email" type="text" name="pasw_email_scuola_n" value="<?php echo get_option('pasw_email_scuola'); ?>" class="regular-text">
                        <br/><small>(es. "codicemecc@pec.istruzione.it")</small>
                    </div>
                </div>
                <h4>Loghi Footer</h4>
                        <?php
                            $content = html_entity_decode(get_option('pasw_loghi_footer'));
                            $editor_settings =  array (
                                    'textarea_rows' => 8,
                                    'teeny'         => TRUE,
                                    'tinymce'       => TRUE,
                                    'quicktags'     => array ( 'buttons' => 'strong,em,link' )
                            );

                            wp_editor( $content, 'pasw_loghi_footer_n', $editor_settings );
                        ?>
                <h4>Testo Footer</h4>
                <p>Es: PEC: codicemecc@pec.istruzione.it - Cod.Mecc. codicemecc - Cod.Fisc. 12 345 678 901</p>
                        <?php
                            $content = html_entity_decode(get_option('pasw_testo_footer'));
                            $editor_settings =  array (
                                    'textarea_rows' => 2,
                                    'media_buttons' => FALSE,
                                    'teeny'         => TRUE,
                                    'tinymce'       => TRUE,
                                    'quicktags'     => array ( 'buttons' => 'strong,em,link' )
                            );

                            wp_editor( $content, 'pasw_testo_footer_n', $editor_settings );
                        ?>
            </div>
        </div>

        <p class="submit"><input type="submit" class="button-primary" name="Submit" value="Salva Impostazioni" /></p>
        </form>

    </div>

<?php }

?>
