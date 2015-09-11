<?php
   
add_action( 'admin_menu','post_tpl_admin_menu' );
function post_tpl_admin_menu(){
   add_submenu_page('pasw2015', 'Post Templates Pasw', 'Modelli articoli', 'manage_options', 'pasw-post-templates', 'post_tpl_admin_page' );
  }

function post_tpl_get_template( $template ) {
	global $post;
	$custom_field = get_post_meta( $post->ID, '_wp_post_template', true );

	if( !$custom_field )
		return $template;

	$custom_field = str_replace( '..', '', $custom_field );

	if( file_exists( get_stylesheet_directory() . "/{$custom_field}" ) )
		$template = get_stylesheet_directory() . "/{$custom_field}";
	elseif( file_exists( get_template_directory() . "/{$custom_field}" ) )
		$template = get_template_directory() . "/{$custom_field}";
	return $template;
}

add_filter( 'single_template', 'post_tpl_get_template' );

function post_tpl_get_templates() { 
  $templates = wp_get_theme()->get_files( 'php', 1, true );
  $post_templates = array();
	foreach ( (array) $templates as $file => $full_path ) {
		if ( ! preg_match( '|' . str_replace("_", " ", "Modello_di_pubblicazione:") . '(.*)$|mi', file_get_contents( $full_path ), $header ) )
			continue;
		$post_templates[ $file ] = _cleanup_header_comment( $header[1] );
	}
	return $post_templates;
}
 
function post_tpl_dropdown() {
	global $post;
	$post_templates = post_tpl_get_templates();
	foreach ( (array) $post_templates as $template_file => $template_name ) {
		$selected = ( $template_file == get_post_meta( $post->ID, '_wp_post_template', true ) ) ? ' selected="selected"' : '';
		$opt = '<option value="' . esc_attr( $template_file ) . '"' . $selected . '>' . esc_html( $template_name ) . '</option>';
		echo $opt;
	}
} 
 
function post_tpl_meta_box_callback( $post ) {
  wp_nonce_field( 'post_tpl_meta_box', 'post_tpl_meta_box_nonce' );
	
	echo '<label for="_wp_post_template"><em>Selezionare il modello di pubblicazione da utilizzare:</em></label><br /><br />';
	echo '<select name="_wp_post_template" class="dropdown" style="width: 100%;">';
	echo '<option value="">Standard</option>';
	post_tpl_dropdown();
  echo '</select><br /><br />';
} 
  
add_action( 'add_meta_boxes', 'post_tpl_add_metabox' );  

function post_tpl_add_metabox($postType) {
  if(get_option('pasw_post_tpl_type') == ''){ 
		$postType_title = 'post';
		$postType_arr[] = $postType_title;
	}else{
		$postType_title = get_option('pasw_post_tpl_type');
		$postType_arr = explode(',',$postType_title);
	}
	if(in_array($postType, $postType_arr)){
		add_meta_box( 'post_tpl_id',
              'Modello pubblicazione',
              'post_tpl_meta_box_callback',
              $postType, 
              'side', 
              'high' );
	}
}

add_action( 'save_post', 'post_tpl_save', 1, 2 );
function post_tpl_save( $post_id, $post ) {

  if ( ! isset( $_POST['post_tpl_meta_box_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['post_tpl_meta_box_nonce'], 'post_tpl_meta_box' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

  if ( isset( $_POST['post_type'] ) && 'post' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

  $tpl_post['_wp_post_template'] = $_POST['_wp_post_template'];
  
  foreach ( $tpl_post as $key => $value ) { 
    if( 'revision' == $post->post_type ) 
      return;
  
    $value = implode( ',', (array) $value );
    
    if( get_post_meta( $post->ID, $key, false ) ) 
      update_post_meta( $post->ID, $key, $value ); 
    else 
      add_post_meta( $post->ID, $key, $value ); 
    if( ! $value ) 
      delete_post_meta( $post->ID, $key ); 
  }
}
 
// add_filter( 'the_content', 'post_tpl_set_fields', 9 );
function post_tpl_set_fields( $content ){ 
  if (!is_single()) {
		return $content;
	}
  global $post;
  $template = get_post_meta( $post->ID, '_wp_post_template', true);
  if (!stripos($template, 'custom')) {
    return $content;
  }
  
  $post_title = $post->post_title;
  $post_header = html_entity_decode(get_option('pasw_post_tpl_header'));
  $post_sign = html_entity_decode(get_option('pasw_post_tpl_sign'));
  $result = '';
  if($post_header){
    $result .= $post_header . '<hr>';
  }
  $content = preg_replace('#Oggetto:#is', '<strong>Oggetto&nbsp;</strong>: '.$post_title , $content);
  $result .= '<div class="content">'. $content;
  if($post_sign) {
    $result .= '<div class="sign">' . $post_sign . '</div>';
  } 
  $result .= '</div>';
  return $result;
} 

// Pagina delle opzioni in ambiente administrator
function post_tpl_admin_page(){
  $args = array(
			'public'   => true,
			'_builtin' => false
		);
	$post_types = get_post_types($args);
	array_push($post_types, 'post');
	    
  $msg = '';
  
  if ( count($_POST) > 0) {
    
    if (!empty($_POST['post_type_name'])) {
    
			$impVal = implode(',', $_POST['post_type_name']);
			delete_option ('pasw_post_tpl_type');
			add_option ('pasw_post_tpl_type', $impVal);
			
      update_option('pasw_post_tpl_header', htmlentities(stripslashes($_POST["pasw_post_tpl_header_n"])));
      
      echo 'Debug: ' . htmlentities(stripslashes($_POST['pasw_post_tpl_sign_n']));
      update_option('pasw_post_tpl_sign', htmlentities(stripslashes($_POST['pasw_post_tpl_sign_n'])));
      
      $msg = '<div id="message" class="updated below-h2"><p>Impostazioni salvate correttamente.</p></div>';
    }
    else {			
      delete_option ( 'pasw_post_tpl_type');
			add_option ( 'pasw_post_tpl_type', 'post' );
			$msg = '<div id="message" class="error"><p>Bisogna selezionare almeno un tipo di pubblicazione!</p></div>';
		}
    
  } 
?>
<style>
.type_chkbox {
    margin-top: 10px;
}
</style>
<h2>Impostazioni per i modelli di pubblicazione</h2>  

<?php echo $msg; ?>

<form method="post" enctype="multipart/form-data" style="min-width: 700px; margin: 5px 100px 2px 0px; padding: 1px 12px;" target="_self">  

<fieldset style="border: 1px solid #AAAAAA; margin-top: 20px; padding: 15px">
<legend><strong >Tipologie di pubblicazione</strong></legend>

<div>
<?php foreach($post_types as $type){ 
		$counter++;
		$obj = get_post_type_object( $type );
		$post_types_name = $obj->labels->singular_name; 
		
		if(get_option('pasw_post_tpl_type') != ''){
			$postType_title = get_option('pasw_post_tpl_type');
			$postType_chkd = explode(',',$postType_title);
			$chd = '';
			if(in_array($type, $postType_chkd)){
				 $chd = 'checked="checked"';
			}
		}
		
?>
<div class="type_chkbox"><input type="checkbox" name="post_type_name[]" value="<?php echo $type; ?>" id="<?php echo $type; ?>" <?php echo $chd; ?> class="chkBox" /><label for="<?php echo $type; ?>"><?php echo $post_types_name; ?></label> </div>

<?php } ?>
</div>

</fieldset>	
<p><input class="button-primary" name="Submit" type="submit" value="Salva Impostazioni"></p>

<fieldset style="border: 1px solid #AAAAAA; margin-top: 20px; padding: 15px">
<legend><strong >Impostazione campi parametrizzati</strong></legend>

<h4>Intestazione degli avvisi</h4>
<?php
  $content = html_entity_decode(get_option('pasw_post_tpl_header'));
  $editor_settings =  array (
          'textarea_rows' => 8,
          'teeny'         => TRUE,
          'tinymce'       => TRUE
          );

  wp_editor( $content, 'pasw_post_tpl_header_n', $editor_settings );
?>

<h4>Firma degli avvisi</h4>
<?php
  $content = html_entity_decode(get_option('pasw_post_tpl_sign'));
  $editor_settings =  array (
          'textarea_rows' => 4,
          'teeny'         => TRUE,
          'tinymce'       => TRUE
          );

  wp_editor( $content, 'pasw_post_tpl_sign_n', $editor_settings );
?>

</fieldset>
<p><input class="button-primary" name="Submit" type="submit" value="Salva Impostazioni"></p>
</form>

<?php  
  }
  
?>