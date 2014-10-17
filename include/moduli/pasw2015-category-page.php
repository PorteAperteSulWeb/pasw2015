<?php
	add_action( 'add_meta_boxes', 'UsrLo_meta_box_add_PaginaCategoria' );
	function UsrLo_meta_box_add_PaginaCategoria()
	{
		add_meta_box( 'usrlo-meta-box-id', 'Elenco Categorie', 'UsrLo_meta_box_PaginaCategoria', 'page', 'side', 'default' );
	}
	function UsrLo_meta_box_PaginaCategoria( $post )
	{
		$values = get_post_custom( $post->ID );
		$selected = isset( $values['usrlo_pagina_categoria'] ) ? esc_attr( $values['usrlo_pagina_categoria'][0] ) : '';
		wp_nonce_field( 'usrlo_pagina_categoria_nonce', 'usrlo_pagina_categoria_meta_box_nonce' );
		?>
	    <?php
	    $selezionata = '';
		if ( get_post_meta($post->ID, 'usrlo_pagina_categoria', true) ) : $selezionata = get_post_meta($post->ID, 'usrlo_pagina_categoria', true); endif; ?>
		
		<p>
			<label for="usrlo_pagina_categoria"><strong>Categorie</strong></label><br />
	        <em>seleziona una delle seguenti categorie per mostrare il suo contenuto in questa pagina</em>
	        <?php
	        $args = array('id'=>'usrlo_pagina_categoria','name'=>'usrlo_pagina_categoria','hide_empty'=> 0, 'orderby'=> 'name','order'=> 'ASC','hierarchical'=>1,'show_option_none'=>'- Pagina senza Categoria', 'selected'=>$selezionata);
			wp_dropdown_categories( $args ); ?>
		</p>
		<?php	
	}
	add_action( 'save_post', 'UsrLo_meta_box_save_PaginaCategoria' );
	function UsrLo_meta_box_save_PaginaCategoria( $post_id )
	{
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if( !isset( $_POST['usrlo_pagina_categoria_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['usrlo_pagina_categoria_meta_box_nonce'], 'usrlo_pagina_categoria_nonce' ) ) return;
		if( !current_user_can( 'edit_post' ) ) return;
		if( isset( $_POST['usrlo_pagina_categoria'] ) )
			update_post_meta( $post_id, 'usrlo_pagina_categoria', esc_attr( $_POST['usrlo_pagina_categoria'] ) );
	}
?>