<?php

// Register Custom Taxonomy
//function pasw_destinatari_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Utenti', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Utente', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Utenti', 'text_domain' ),
        'all_items'                  => __( 'All Items', 'text_domain' ),
        'parent_item'                => __( 'Parent Item', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
        'new_item_name'              => __( 'New Item Name', 'text_domain' ),
        'add_new_item'               => __( 'Add New Item', 'text_domain' ),
        'edit_item'                  => __( 'Edit Item', 'text_domain' ),
        'update_item'                => __( 'Update Item', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'search_items'               => __( 'Search Items', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'paswdestinatari', array( 'post', 'page' ), $args );
    pasw_generate_dest_terms();

//}

// Hook into the 'init' action
//add_action( 'init', 'pasw_destinatari_taxonomy', 0 );


function pasw_generate_dest_terms() {

    $destinatari = array('Docenti', 'Alunni', 'Genitori', 'Personale ATA');

    for ($i=0; $i<4; $i++) {
         if (!term_exists( $destinatari[$i], 'paswdestinatari')) {
            wp_insert_term( $destinatari[$i], 'paswdestinatari');
        }
    }

}

add_action( 'admin_init', 'pasw_generate_dest_terms');


/* =========== SHORTCODE ============ */

function paswdestinatari_func($atts)
{
extract(shortcode_atts(array(
    'tipo' => '',
    'utente' => '',
    'numero' => '5',
    'anno' => 'all',
    'link' => 'si',
    'ordine' => 'date', //vuoto: post -> data // pagine -> alfabetico
	'riassunto' => 'no'
   ), $atts));

    if ($utente == '') {
            return '<p style="color:red;">Errore Shortcode: parametro <strong>utente</strong> non specificato<p>';
    }

    $tipo_cpt = get_post_type_object( $tipo );
    if (is_object($tipo_cpt)) {
        $tipo_cpt = $tipo_cpt->labels->name;
        if ($ordine == '') {
            $ordine = 'name';
        }
    } else {
        $tipo_cpt = "Contenuti";
        //Sarà necessario fare una query per ogni CPT
        $tipo = 'post,page';
    }

    $utente_cpt = strtolower(get_term_by( 'slug', $utente, 'paswdestinatari' )->name);

    $returner = '';
    $returner .= '<div class="shortcode-destinatari">';
    $returner .= '<h3>' . $tipo_cpt . ' di interesse per ' . $utente_cpt;

    $returner .= '</h3>';

	if ($tipo == 'page') {
		$genere .= 'e';
	} else {
		$genere .= 'i';
	}
	
	
    $returner .= '<small>Visualizzazione di ' . $numero . ' ' . strtolower($tipo_cpt) . ' ordinat' . $genere . ' per ' . $ordine;
	
    if ($anno != '') { $returner .= ' inserit' . $genere . ' nel ' . $anno; }

    $returner .= '  &bull;  <a href="' . add_query_arg( 'post_type', $tipo , get_term_link( $utente, 'paswdestinatari' ) );
    $returner .='">Tutti i contenuti per ' . $utente_cpt . ' &raquo;</a>';
    $returner .= '</small>';

    if (strtolower($ordine) == 'data') { $ordine = 'date'; }

    $arrayposttypes = explode(',', $tipo);

    foreach ($arrayposttypes as $ciao) {

       
		if (count($arrayposttypes) > 1) {
            $returner .= '<p><h4>' .  get_post_type_object( $ciao )->labels->name . '</h4></p>';
        }

        if (strtolower(get_post_type_object( $ciao )->labels->singular_name) == "pagina") {
            $numero_n = -1;
            $ordine_n = 'name';
            $order = 'ASC';
        } else {
            $numero_n = $numero;
            $ordine_n = $ordine;
            $order = 'DESC';
        }

        query_posts( array(
            'post_type' => $ciao,
            'orderby' => $ordine_n,
            'order' => $order,
            'year' => $anno,
            'posts_per_page' => $numero_n,
            'paswdestinatari' => $utente )
        );

        if ($ciao == "page") {
			$returner .= '<p>';
		}
		
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            global $post;

            if (strtolower(get_post_type_object( $ciao )->labels->singular_name) == "articolo") {
			
				$returner .= '<div class="post-box-archive">';
				$returner .= '<span class="hdate">' . get_the_time('j F y') . '</span>';

				$returner .= '<a href="' . get_the_permalink() . '">';
				$id= get_the_id();
				if ( has_post_thumbnail($id) ) {
					$returner .= get_the_post_thumbnail($id, array(100,100));
				}
				$returner .= '</a>';

				$returner .= '<h4 class="piccino"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
				if ( $riassunto =='si' ) {
					$returner .= '<div class="piccino">';
					$returner .= '<p>' . get_the_excerpt() . '</p>';
					$returner .= '</div>';
				}
				$returner .= '</div>';
				
            } else if (strtolower(get_post_type_object( $ciao )->labels->singular_name) == "pagina") {
                 $returner .= '<a href="' .  get_the_permalink() . '">' . get_the_title() . '</a> &bull; ';
            }


            endwhile; else:
            $returner .= 'Spiacenti, nessun contenuto per questa categoria.';
        endif;

        if ($ciao == "page") {
			$returner .= '</p>';
		}
		
		
        wp_reset_query();
    }


    $returner .= '</div><div class="clear"></div>';
    return $returner;
}
add_shortcode('destinatari', 'paswdestinatari_func');

?>
