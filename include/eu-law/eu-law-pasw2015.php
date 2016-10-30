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

//  START BOX EXCLUDE PAGE

function pasw2015_exclude_page_add_meta_box() {

	$screens = array( 'post', 'page' );

	foreach ( $screens as $screen ) {
		add_meta_box(
				'exclude_page_id',
				'Disable Autobloc Eu Cookie law',
				'exclude_page_meta_box_callback',
				$screen,
				'side',
				'high'
			);
	}
}

if (get_option('pasw_eulaw') == 1) {
add_action( 'add_meta_boxes', 'pasw2015_exclude_page_add_meta_box' );
}


// Disegna il box nella schermata
function exclude_page_meta_box_callback( $post ) {
	wp_nonce_field( 'pasw2015_exclude_page_meta_box', 'pasw2015_exclude_page_meta_box_nonce' );

	$value='';
	if (get_post_meta($post->ID, '_is_pasw2015_exclude_page', true)){
    $value = 'checked';
	}

  echo '<p font-size: 0.90em;><em>Questo parametro disabilita la funzione ';
  echo 'di autobloc script del modulo EU Law per questa pagina / articolo.</em>';
  echo '<div style="margin: 15px 0 10px 0;">';
  echo '<label for="pasw2015_exclude_page_field"><input type="checkbox" name="pasw2015_exclude_page_field" value="1" ' . $value . '>';
  echo '&nbsp;Disabilita Autobloc EU Law Coockie</label></div></p>';
}

// Salva i dati del checkbox quando viene salvata la pagina
function pasw2015_exclude_page_save_meta_box_data( $post_id ) {

	if ( ! isset( $_POST['pasw2015_exclude_page_meta_box_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['pasw2015_exclude_page_meta_box_nonce'], 'pasw2015_exclude_page_meta_box' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
		} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	$value = isset($_POST['pasw2015_exclude_page_field']) && $_POST['pasw2015_exclude_page_field'];

	update_post_meta( $post_id, '_is_pasw2015_exclude_page', $value );
}

if (get_option('pasw_eulaw') == 1) {
  add_action( 'save_post', 'pasw2015_exclude_page_save_meta_box_data' );
}

//  END BOX EXCLUDE PAGE

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

						<input id="eucookie_acceptOnClick" type="checkbox" name="pasw_eucookie_acceptOnClick_n"
                        <?php $get_pasw_eucookie_acceptOnClick = get_option('pasw_eucookie_acceptOnClick');
                        if ($get_pasw_eucookie_acceptOnClick == '1') { echo ' checked="checked" '; }?>>
						<label for="eucookie_acceptOnClick">Abilita accetta cookie su click</label>
						<br>

						<input id="eucookie_remove_bottom" type="checkbox" name="pasw_eucookie_remove_bottom_n"
                        <?php $get_pasw_eucookie_remove_bottom = get_option('pasw_eucookie_remove_bottom');
                        if ($get_pasw_eucookie_remove_bottom == '1') { echo ' checked="checked" '; }?>>
						<label for="eucookie_remove_bottom">Abilita pulsante revoca cookie</label>
						<select name="pasw_eucookie_position_revocalr_n" >
								<option value="0" <?php if (get_option( 'pasw_eucookie_position_revocalr') == '0') { echo 'selected="selected"'; }?>>Sx</option>
								<option value="1" <?php if (get_option( 'pasw_eucookie_position_revocalr') == '1') { echo 'selected="selected"'; }?>>Dx</option>
						</select>
						<select name="pasw_eucookie_position_revocatb_n" >
								<option value="0" <?php if (get_option( 'pasw_eucookie_position_revocatb') == '0') { echo 'selected="selected"'; }?>>Basso</option>
								<option value="1" <?php if (get_option( 'pasw_eucookie_position_revocatb') == '1') { echo 'selected="selected"'; }?>>Alto</option>
						</select>
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
							<br>
							<label for="eucookie_cookieName">Nome da assegnare al cookie:</label><br>
							<input id="eucookie_cookieName" type="text" name="pasw_eucookie_cookieName_n" value="<?php echo get_option('pasw_eucookie_cookieName'); ?>" size="20">
							<br><small>se vuoto il cookie assumerà nome <strong>pasw_law_cookie</strong></small><br>
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
							<td><input id="eucookie_bgcolor_blocco" type="text" name="pasw_eucookie_bgcolor_blocco_n" value="<?php echo get_option('pasw_eucookie_bgcolor_blocco'); ?>" class="colorfield" data-default-color="#d8d8d8"/></td>
							<td><input id="eucookie_textcolor_blocco" type="text" name="pasw_eucookie_textcolor_blocco_n" value="<?php echo get_option('pasw_eucookie_textcolor_blocco'); ?>" class="colorfield" data-default-color="#7f7f7f"/>	</td>
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
							<input id="eucookie_textcolor_short_ca" type="text" name="pasw_eucookie_textcolor_short_ca_n" value="<?php echo get_option('pasw_eucookie_textcolor_short_ca'); ?>" class="colorfield" data-default-color="#00004d"/><br>
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

