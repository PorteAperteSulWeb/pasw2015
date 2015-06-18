<?php

add_action('admin_enqueue_scripts', 'pasw2015_upload_eulaw_admin_scripts');

function pasw2015_upload_eulaw_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'pasw2015-eu-law') {
        wp_enqueue_media();
        wp_register_script('pasw2015-upload-admin-js', get_template_directory_uri() . '/js/uploader.js', array('jquery'));
        wp_enqueue_script('pasw2015-upload-admin-js');
    }
}

add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );

function wp_enqueue_color_picker( ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker-script-handle', get_template_directory_uri() . '/js/pasw2015_law_setting.js', array( 'wp-color-picker' ), false, true );
}


function pasw2015_cookie() { ?>
    <div class="wrap">
        <h2>Cookie Law Info</h2>
		<?php require ( get_template_directory() . '/include/eu-law/eu-law-pasw2015-saver.php' ); ?>
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
							<br>
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
							<br>
							<label for="eucookie_expire">Posizione Banner:</label><br>
							<select name="pasw_eucookie_position_banner_n" >
								<option value="0" <?php if (get_option( 'pasw_eucookie_position_banner') == '0') { echo 'selected="selected"'; }?>>Basso</option>
								<option value="1" <?php if (get_option( 'pasw_eucookie_position_banner') == '1') { echo 'selected="selected"'; }?>>Alto</option>
							</select>
						</div>
						
					</div>
					<br><hr>
					
					<h4>Setting Colori</h4>
					<div class="welcome-panel-column-container">
					<table style="	width: 100%;">
						<tr style="font-weight: bold;">							
							<td style="	width: 15%;">Area<td>
							<td></td>
							<td style="	width: 15%;">Colore Sfondo</td>
							<td style="	width: 15%;">Colore testo</td>
							<td>Trasparenza background</td>
						</tr>
						<tr>
							<td>Banner<td>
							<td></td>
							<td><input id="eucookie_bgcolor_banner" type="text" name="pasw_eucookie_bgcolor_banner_n" value="<?php echo get_option('pasw_eucookie_bgcolor_banner'); ?>" class="colorfield" data-default-color="#222222"/></td>
							<td><input id="eucookie_textcolor_banner" type="text" name="pasw_eucookie_textcolor_banner_n" value="<?php echo get_option('pasw_eucookie_textcolor_banner'); ?>" class="colorfield" data-default-color="#ffffff"/>	</td>
							<td><input id="eucookie_bgopacity_banner" type="text" name="pasw_eucookie_bgopacity_banner_n" value="<?php echo get_option('pasw_eucookie_bgopacity_banner'); ?>" size="2">
							valore compreso tra 0 e 1 ( 0 = trasparente; 1 = opaco) es. 0.9</td>
						</tr>
						<tr>
							<td>Area Blocco codice<td>
							<td></td>
							<td><input id="eucookie_bgcolor_blocco" type="text" name="pasw_eucookie_bgcolor_blocco_n" value="<?php echo get_option('pasw_eucookie_bgcolor_blocco'); ?>" class="colorfield" data-default-color="#222222"/></td>
							<td><input id="eucookie_textcolor_blocco" type="text" name="pasw_eucookie_textcolor_blocco_n" value="<?php echo get_option('pasw_eucookie_textcolor_blocco'); ?>" class="colorfield" data-default-color="#ffffff"/>	</td>
							<td><input id="eucookie_bgopacity_blocco" type="text" name="pasw_eucookie_bgopacity_blocco_n" value="<?php echo get_option('pasw_eucookie_bgopacity_blocco'); ?>" size="2">
							valore compreso tra 0 e 1 ( 0 = trasparente; 1 = opaco) es. 0.9</td>
						
						</tr>
						<tr>
							<td>Shortcode cookie-controll<td>
							<td>Si Cookie<br/>No Coocki</td>
							<td>
							<input id="eucookie_bgcolor_short_ca" type="text" name="pasw_eucookie_bgcolor_short_ca_n" value="<?php echo get_option('pasw_eucookie_bgcolor_short_ca'); ?>" class="colorfield" data-default-color="#FCA182"/><br>
							<input id="eucookie_bgcolor_short_cd" type="text" name="pasw_eucookie_bgcolor_short_cd_n" value="<?php echo get_option('pasw_eucookie_bgcolor_short_cd'); ?>" class="colorfield" data-default-color="#A1B8CB"/>
							</td>
							<td>
							<input id="eucookie_textcolor_short_ca" type="text" name="pasw_eucookie_textcolor_short_ca_n" value="<?php echo get_option('pasw_eucookie_textcolor_short_ca'); ?>" class="colorfield" data-default-color="#000000"/><br>
							<input id="eucookie_textcolor_short_cd" type="text" name="pasw_eucookie_textcolor_short_cd_n" value="<?php echo get_option('pasw_eucookie_textcolor_short_cd'); ?>" class="colorfield" data-default-color="#ffffff"/>
							</td>
							<td><!-- <input id="eucookie_bgopacity_shortcode" type="text" name="pasw_eucookie_bgopacity_shortcode_n" value="<?php echo get_option('pasw_eucookie_bgopacity_shortcode'); ?>" size="2">
							valore compreso tra 0 e 1 ( 0 = trasparente; 1 = opaco) es. 0.9 --></td>
						</tr>
					</table>					
						
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

