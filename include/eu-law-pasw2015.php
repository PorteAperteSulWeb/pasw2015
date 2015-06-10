<?php

add_action('admin_enqueue_scripts', 'pasw2015_upload_eulaw_admin_scripts');

function pasw2015_upload_eulaw_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'pasw2015-eu-law') {
        wp_enqueue_media();
        wp_register_script('pasw2015-upload-admin-js', get_template_directory_uri() . '/js/uploader.js', array('jquery'));
        wp_enqueue_script('pasw2015-upload-admin-js');
    }
}

function pasw2015_cookie() { ?>
    <div class="wrap">
        <h2>Cookie Law Info</h2>
		<?php require ( get_template_directory() . '/include/eu-law-pasw2015-saver.php' ); ?>
        <form method="post" name="options" target="_self">
			<?php wp_nonce_field('update-options') ?>

			<?php if (get_option('pasw_eulaw') == 1) {?> 
			<div id="welcome-panel" class="welcome-panel">
				<div class="welcome-panel-content">
					<h3>Cookie Law Info</h3>
					<p class="about-description">direttiva europea Cookie Law recepita nel 2012 in Italia.</p>
					<br>
					<div class="welcome-panel-column-container">
						
						<div class="welcome-panel-column" >
						
						<input id="eucookie_automatic" type="checkbox" name="pasw_eucookie_automatic_n"
                        <?php $get_pasw_eucookie_automatic = get_option('pasw_eucookie_automatic');
                        if ($get_pasw_eucookie_automatic == '1') { echo ' checked="checked" '; }?>>
						<label for="eucookie_automatic">Abilita blocco automatico</label>
						<p>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; blocca iframe, embed, object, script</p>
						
						<input id="eucookie_remove_bottom" type="checkbox" name="pasw_eucookie_remove_bottom_n"
                        <?php $get_pasw_eucookie_remove_bottom = get_option('pasw_eucookie_remove_bottom');
                        if ($get_pasw_eucookie_remove_bottom == '1') { echo ' checked="checked" '; }?>>
						<label for="eucookie_remove_bottom">Abilita pulsante revoca cookie</label>
						<br>
						<br>
							<label for="eucookie_expire">Numero giorni cookie attivo:</label>
							<input id="eucookie_expire" type="text" name="pasw_eucookie_expire_n" value="<?php echo get_option('pasw_eucookie_expire'); ?>" size="5">
							<br><small>se vuoto il cookie risulta essere di sessione</small>
						
						
						</div>
						
						<div class="welcome-panel-column" >
							<label for="eucookie_button">Testo pulsante accetta cookie:</label>
							<input id="eucookie_button" type="text" name="pasw_eucookie_button_n" value="<?php if (get_option('pasw_eucookie_button') != '') {echo stripslashes(get_option('pasw_eucookie_button'));} else {echo 'Accetta';} ?>" class="regular-text">
							<br/><label for="eucookie_info">Testo link altre informazioni:</label>
							<input id="eucookie_info" type="text" name="pasw_eucookie_info_n" value="<?php if (get_option('pasw_eucookie_info') !='') {echo stripslashes(get_option('pasw_eucookie_info'));} else {echo 'Informazioni';} ?>" class="regular-text">
						</div>
						
						<div class="welcome-panel-column" >
							<label for="eucookie_page"><?php _e('Page per EU LAW Cookies') ?></label>
						
							<?php $args = array(
								'depth'                 => 0,
								'child_of'              => 0,
								'selected'              => get_option('pasw_eucookie_page'),
								'echo'                  => 1,
								'name'                  => 'pasw_eucookie_page_n',
								'id'                    => null, 
								'show_option_none'      => null, 
								'show_option_no_change' => null, 
								'option_none_value'     => null, 
							); ?>

							<?php wp_dropdown_pages($args); ?>
						</div>
						
					</div>
					<br><hr>
					<h4>Testi utilizzati nei vari banner</h4>
					<div class="welcome-panel-column-container">
						<div class="welcome-panel-column">
							<label for="eucookie_msg">Messaggio Banner:</label>
						</div>	
						<div class="welcome-panel-column" style="width: 60% !important;">
							<?php
								$content = html_entity_decode(get_option('pasw_eucookie_msg'));
								if ($content == '')
								{
								$content ='I cookie ci aiutano a migliorare il sito. Utilizzando il sito, accetti l\'utilizzo dei cookie da parte nostra.';
								}
								$editor_settings =  array (
										'textarea_rows' => 2,
										'media_buttons' => FALSE,
										'teeny'         => TRUE,
										'tinymce'       => TRUE
								);
								wp_editor( $content, 'pasw_eucookie_msg_n', $editor_settings );
							?>
						</div>	
					</div>
					<div class="welcome-panel-column-container">
						<div class="welcome-panel-column">
							<label for="eucookie_msg_box">Messaggio Contenuto Bloccato ( articoli - pagine ) :</label>
						</div>
						<div class="welcome-panel-column" style="width: 60% !important;">			
							<?php
								$content_eu_box = html_entity_decode(get_option('pasw_eucookie_box_msg'));
								if ($content_eu_box == '')
								{
								$content_eu_box ='<p style="text-align: center;">Il D.lgs. 196/2003 e a seguito delle modalità semplificate per l’informativa e l’acquisizione del consenso per l’uso dei cookie pubblicata sulla Gazzetta Ufficiale n.126 del 3 giugno 2014 e relativo registro dei provvedimenti n.229 dell’8 maggio 2014, prevede l\'accettazione dei cookies da parte degli utenti, il contenuto qui oscurato genera cookies terze parti, pertanto senza l\'accettazione degli stessi non pu&ograve essere visualizzato.</p>
									<p style="text-align: center;">Abilitare i cookie cliccando su - Si  accetto - in basso a destra per sbloccarlo</p>';
								}
								$editor_settings =  array (
									'textarea_rows' => 2,
									'media_buttons' => FALSE,
									'teeny'         => TRUE,
									'tinymce'       => TRUE
								);
								wp_editor( $content_eu_box, 'pasw_eucookie_box_msg_n', $editor_settings );
							?>
						</div>
					</div>
					<div class="welcome-panel-column-container">
						<div class="welcome-panel-column">	
							<label for="eucookie_msg_widget">Messaggio Contenuto Bloccato ( widget ) :</label>
						</div>
						<div class="welcome-panel-column" style="width: 60% !important;">
							<?php
								$content_eu_widget = html_entity_decode(get_option('pasw_eucookie_box_widget'));
								if ($content_eu_widget == '')
								{
								$content_eu_widget ='<p style="text-align: center;">Abilitare i cookie cliccando su - Si  accetto - in basso a destra per sbloccarlo</p>';
								}
								$editor_settings =  array (
											'textarea_rows' => 2,
											'media_buttons' => FALSE,
											'teeny'         => TRUE,
											'tinymce'       => TRUE
										);
								wp_editor( $content_eu_widget, 'pasw_eucookie_box_widget_n', $editor_settings );
							?>
						</div>
					</div>		
													
							<br/>
							<br/>
							
				</div>
			</div>	
			<?php } ?>
			<p class="submit"><input type="submit" class="button-primary" name="Submit" value="Salva Impostazioni" /></p>
        </form>
	</div>	
<?php }

