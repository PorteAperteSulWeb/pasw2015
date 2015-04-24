<?php

    //Registra widget del tema Pasw2015 @ 14.09.2014

    add_action( 'widgets_init', 'pasw2015_load_widgets' );

    function pasw2015_load_widgets() {
        register_widget( 'pasw2015_posts' );

        if (!function_exists('is_plugin_active')) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        if ( is_plugin_active( 'amministrazione-trasparente/amministrazionetrasparente.php' ) ) {
            register_widget( 'pasw2015_at' );
        }

        if ( is_plugin_active( 'gestione-circolari/GestioneCircolari.php' ) || is_plugin_active( 'gestione-circolari-groups/GestioneCircolari.php' ) ) {
            register_widget( 'pasw2015_circolari' );
        }

        if ( is_plugin_active( 'albo-pretorio-on-line/AlboPretorio.php' ) ) {
            register_widget( 'pasw2015_albo' );
        }
 	if (get_option('pasw_taxdest') != 0) {
            register_widget( 'pasw2015_taxdest' );
        }

    }

    class pasw2015_posts extends WP_Widget {

        function pasw2015_posts() {
            parent::__construct( false, 'PASW @ Categorie' );
        }

        function widget( $args, $instance ) {

            extract( $args );
               // these are the widget options
            $title = apply_filters('widget_title', $instance['titolo']);
            $limit = $instance['limite'];
            $category = $instance['categoria'];
            $align = $instance['allineamento'];
            $excerpt = $instance['riassunto'];
            $thumbnail = $instance['imgevidenza'];
      		$showall = $instance['showall'];

			if ($showall) {
				$category_id = $category;
				$category_link = get_category_link($category_id);
				$category_name = get_cat_name($category_id);
							?>
				<!-- Print a link to this category
				<a href="<?php echo esc_url( $category_link ); ?>" title="Tutti gli articoli della categoria <?php echo $category_name; ?>">Mostra <?php echo $category_name; ?></a> 
				-->

				<?php
			$after_title = '<span class="showall_widget after_widget_title"><a href='. esc_url( $category_link ) .' title="Tutti gli articoli della categoria '. $category_name . '" >Mostra Tutto &rsaquo;</a></span>'.$after_title;
			}

            

            if ( $title ) {
                echo $before_widget . $before_title . $title . $after_title;
            }

            echo '<ul';
            if ($align != '' && $align != 0) { echo ' style="text-align:center;"'; }
            echo '>';

            global $post;
            $myposts = get_posts('numberposts=' . $limit . '&category='.$category);
            foreach($myposts as $post) :
                    setup_postdata($post);
                    global $more;
                    $more = 0;
            ?>
                <li><h3><span class="hdate"><?php the_time('j M y') ?></span> <a href="<?php the_permalink(); ?>">

                    <?php
                        if ( has_post_thumbnail() && $thumbnail ) {
                            the_post_thumbnail(array(50,50));
                        }
                        the_title(); ?></a></h3></li>
                          <?php
                          if ($excerpt != '' && $excerpt != 0) { echo '<li>'; the_excerpt(); echo '</li>';} //echo '<div class="clear"></div>';
            endforeach;

            echo '</ul>';

            //FINE WIDGET

            echo $after_widget;
        }

        function update( $new_instance, $old_instance ) {

            $instance = $old_instance;
            $instance['titolo'] = strip_tags($new_instance['titolo']);
              $instance['categoria'] = strip_tags($new_instance['categoria']);
              $instance['limite'] = strip_tags($new_instance['limite']);
              $instance['riassunto'] = strip_tags($new_instance['riassunto']);
              $instance['allineamento'] = strip_tags($new_instance['allineamento']);
              $instance['imgevidenza'] = strip_tags($new_instance['imgevidenza']);
              $instance['showall'] = strip_tags($new_instance['showall']);
              return $instance;

        }

        function form( $instance ) {

            $instance = wp_parse_args( (array) $instance, array( 'limite' => '0' ) ); ?>

            <p>
                <label for="<?php echo $this->get_field_id( 'titolo' ); ?>">Titolo:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'titolo' ); ?>" name="<?php echo $this->get_field_name( 'titolo' ); ?>" value="<?php echo $instance['titolo']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'limite' ); ?>">Numero post visualizzati:</label>
                <input type="number" min="1" max="10" class="widefat" id="<?php echo $this->get_field_id( 'limite' ); ?>" name="<?php echo $this->get_field_name( 'limite' ); ?>" value="<?php echo $instance['limite']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'categoria' ); ?>">Categoria:</label>
		<?php 
			$args = array( 
				'name' => $this->get_field_name("categoria"),
				'hierarchical' => 1, 
				'orderby' => 'name', 
				'selected' => $instance["categoria"] 
				);
				
			wp_dropdown_categories( $args ); 
		?>

            </p>

            <p>
                <input id="<?php echo $this->get_field_id('riassunto'); ?>" name="<?php echo $this->get_field_name('riassunto'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['riassunto'])); ?>/>
                <label for="<?php echo $this->get_field_id('riassunto'); ?>">Mostra anteprima testuale</label>
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('imgevidenza'); ?>" name="<?php echo $this->get_field_name('imgevidenza'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['imgevidenza'])); ?>/>
                <label for="<?php echo $this->get_field_id('imgevidenza'); ?>">Mostra immagine in evidenza</label>
            </p>
            
			<p>
                <input id="<?php echo $this->get_field_id('showall'); ?>" name="<?php echo $this->get_field_name('showall'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['showall'])); ?>/>
                <label for="<?php echo $this->get_field_id('showall'); ?>">Mostra link visualizza tutto</label>
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('allineamento'); ?>" name="<?php echo $this->get_field_name('allineamento'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['allineamento'])); ?>/>
                <label for="<?php echo $this->get_field_id('allineamento'); ?>">Allinea testo centralmente</label>
            </p>

<?php
        }
    }

    class pasw2015_at extends WP_Widget {

        function pasw2015_at() {
            parent::__construct( false, 'PASW @ AT #Milesi' );
        }

        function widget( $args, $instance ) {

            extract( $args );
               // these are the widget options
            $title = apply_filters('widget_title', $instance['titolo']);
            $limit = $instance['limite'];
            $align = $instance['allineamento'];
            $excerpt = $instance['riassunto'];

            if ( $title ) {
                echo $before_widget . $before_title . $title . $after_title;
            }

            echo '<ul';
            if ($align != '' && $align != 0) { echo ' style="text-align:center;"'; }
            echo '>';

            //WordPress loop for custom post type
            $my_query = new WP_Query('post_type=amm-trasparente&showposts=' . $limit);
            while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <li><h3><span class="hdate"><?php the_time('j M y') ?></span> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></li>
                        <?php
                          if ($excerpt != '' && $excerpt != 0) { echo '<li>'; the_excerpt(); echo '</li>';}
            endwhile;
            wp_reset_query();

            echo '</ul>';

            //FINE WIDGET

            echo $after_widget;
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['titolo'] = strip_tags($new_instance['titolo']);
              $instance['limite'] = strip_tags($new_instance['limite']);
              $instance['riassunto'] = strip_tags($new_instance['riassunto']);
              $instance['allineamento'] = strip_tags($new_instance['allineamento']);
              return $instance;
        }

        function form( $instance ) {

            $instance = wp_parse_args( (array) $instance, array( 'limite' => '0' ) ); ?>

            <p>
                <label for="<?php echo $this->get_field_id( 'titolo' ); ?>">Titolo:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'titolo' ); ?>" name="<?php echo $this->get_field_name( 'titolo' ); ?>" value="<?php echo $instance['titolo']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'limite' ); ?>">Numero post visualizzati:</label>
                <input type="number" min="1" max="10" class="widefat" id="<?php echo $this->get_field_id( 'limite' ); ?>" name="<?php echo $this->get_field_name( 'limite' ); ?>" value="<?php echo $instance['limite']; ?>" />
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('riassunto'); ?>" name="<?php echo $this->get_field_name('riassunto'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['riassunto'])); ?>/>
                <label for="<?php echo $this->get_field_id('riassunto'); ?>">Mostra anteprima testuale</label>
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('allineamento'); ?>" name="<?php echo $this->get_field_name('allineamento'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['allineamento'])); ?>/>
                <label for="<?php echo $this->get_field_id('allineamento'); ?>">Allinea centralmente</label>
            </p>

<?php
        }

    }

    class pasw2015_albo extends WP_Widget {

        function pasw2015_albo() {
            parent::__construct( false, 'PASW @ Albo Pretorio On line', array('description' => 'Widget che permette la visualizzazione degli ultimi atti pubblicati nell\'Albo Pretorio') );
        }
        public function form($instance)
        {
         $defaults = array(
             'titolo' => 'Ultimi Atti',
            'numero_atti' => 5,
            'pagina_albo' => NULL,
            'ordine_campo' => NULL,
            'ordinamento' => 'C'
            );
            $instance = wp_parse_args( (array) $instance, $defaults );?>
            <p>
                <label for="<?php echo $this->get_field_id( 'titolo' ); ?>">
                    Titolo widget:
                </label>
                <input type="text" id="<?php echo $this->get_field_id( 'titolo' ); ?>" name="<?php echo $this->get_field_name( 'titolo' ); ?>" value="<?php echo $instance['titolo']; ?>" size="30" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'numero_atti' ); ?>">
                    Numero Atti da visualizzare:
                </label>
                <input type="text" id="<?php echo $this->get_field_id( 'numero_atti' ); ?>" name="<?php echo $this->get_field_name( 'numero_atti' ); ?>" value="<?php echo $instance['numero_atti']; ?>" size="2"/>

            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'pagina_albo' ); ?>">
                   Pagina Albo:
                </label>
            <select id="<?php echo $this->get_field_id( 'pagina_albo' ); ?>" name="<?php echo $this->get_field_name( 'pagina_albo' ); ?>">
             <option value=""><?php echo esc_attr( __( 'Select page' ) ); ?></option>
             <?php
              $pages = get_pages();
              foreach ( $pages as $pagg ) {
                if (get_page_link( $pagg->ID ) == $instance['pagina_albo'] )
                    $Selezionato= 'selected="selected"';
                else
                    $Selezionato="";
                  $option = '<option '.$Selezionato.' value="' . get_page_link( $pagg->ID ) . '">';
                $option .= $pagg->post_title;
                $option .= '</option>';
                echo $option;
              }
             ?>
            </select>
            </p>
            <h3>Ordine Elenco</h3>
            <p>
                <label for="<?php echo $this->get_field_id( 'ordine_campo' ); ?>">
                   In base a:
                </label>
            <select id="<?php echo $this->get_field_id( 'ordine_campo' ); ?>" name="<?php echo $this->get_field_name( 'ordine_campo' ); ?>">
             <option value="Pubblicazione" <?php if ($instance['ordine_campo']=="Pubblicazione") echo 'selected="selected"'?> >Data Pubblicazione </option>
             <option value="Scadenza" <?php if ($instance['ordine_campo']=="Scadenza") echo 'selected="selected"'?> >Data Scadenza </option>
            </select>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'ordinamento' ); ?>">
                   Ordine:
                </label>
            <select id="<?php echo $this->get_field_id( 'ordinamento' ); ?>" name="<?php echo $this->get_field_name( 'ordinamento' ); ?>">
             <option value="C" <?php if ($instance['ordinamento']=="C") echo 'selected="selected"'?> >Crescente </option>
             <option value="D" <?php if ($instance['ordinamento']=="D") echo 'selected="selected"'?> >Decrescente </option>
            </select>
            </p>
           <?php
        }


    public function widget( $args, $instance )
        {
            global $wpdb;

            extract( $args );

            $titolo = apply_filters('widget_title', $instance['titolo'] );
             if ($titolo=='')
                $titolo="Albo Pretorio";
            echo $before_widget;
            echo $before_title .$titolo. $after_title;
            echo "<div>";

        if ($instance['ordine_campo']=="Pubblicazione")
            $Ordinamento="DataInizio";
        else
            $Ordinamento="DataFine";

        if ($instance['ordinamento']=="C")
            $Ordinamento.=" ASC";
        else
            $Ordinamento.=" DESC";
        $coloreAnnullati=get_option('opt_AP_ColoreAnnullati');
        $lista=ap_get_all_atti(1,0,0,'',0,0,$Ordinamento,0,$instance['numero_atti']);
        $HtmlW='<ul>';
        if ($lista){
            foreach($lista as $riga){
                if($riga->DataAnnullamento!='0000-00-00'){
                    $Annullato='style="background-color: '.$coloreAnnullati.';"';
                    $CeAnnullato=true;
                }else
                    $Annullato='';
                if (strpos($instance['pagina_albo'],"?")>0)
                    $sep="&amp;";
                else
                    $sep="?";
                $HtmlW.= '<li><h3><span class="hdate">'.date_i18n("j M y", strtotime($riga->DataInizio)).'</span> - <span class="hdate">'.date_i18n("j M y", strtotime($riga->DataFine)).'</span> <a href="'.$instance['pagina_albo'].$sep.'action=visatto&amp;id='.$riga->IdAtto.'"'.$Annullato.'>'.$riga->Oggetto .'</a></h3>
                    </li>';
            }
        } else {
                $HtmlW.= '<li>
                        Nessun Atto Codificato
                      </li>';
        }
        $HtmlW.= '</ul>';
        if ($CeAnnullato)
            $HtmlW.= '<p>Le righe evidenziate con questo sfondo <span style="background-color: '.$coloreAnnullati.';">&nbsp;&nbsp;&nbsp;</span> indicano Atti Annullati</p>';
    $HtmlW.= '</div>';
    ?>
                <div>
                  <?php echo $HtmlW; ?>
                </div>
    <?php
           echo $after_widget;
        }

        public function update( $new_instance, $old_instance )
        {
                $instance = $old_instance;

                $instance['titolo'] = strip_tags( $new_instance['titolo'] );
                $instance['numero_atti'] = strip_tags( $new_instance['numero_atti'] );
                $instance['pagina_albo'] = strip_tags( $new_instance['pagina_albo'] );
                $instance['ordine_campo'] = strip_tags( $new_instance['ordine_campo'] );
                $instance['ordinamento'] = strip_tags( $new_instance['ordinamento'] );

                return $instance;
        }
    }

    class pasw2015_circolari extends WP_Widget {

        function pasw2015_circolari() {
            parent::__construct( false, 'PASW @ Circolari #Scimone');
        }

        function widget( $args, $instance ) {

            extract( $args );
            // these are the widget options
            $title = apply_filters('widget_title', $instance['titolo']);
            $limit = $instance['limite'];
            $align = $instance['allineamento'];
            $excerpt = $instance['riassunto'];
	    	$pagina_circolari = $instance['pagina_circolari'];
	
			if (!empty($pagina_circolari)){
				$after_title = '<span class="showall_widget after_widget_title"><a href='. $pagina_circolari .' title="link interno pagina circolari" >Vai alla pagina &rsaquo;</a></span>'.$after_title;
			}
			
            if ( $title ) {
                echo $before_widget . $before_title . $title . $after_title;
            }

            echo '<ul';
            if ($align != '' && $align != 0) { echo ' style="text-align:center;"'; }
            echo '>';

            //WordPress loop for custom post type
            $numCe=1;
            $IdCircolari=get_option('Circolari_Categoria');
			$args = array( 'cat' => $IdCircolari,
		       'post_type' => array('post','circolari'),
			   'posts_per_page'  => -1,
			   'post_status' => 'publish');
			$my_query = new WP_Query($args);
			while ($my_query->have_posts() && $numCe<=$limit) : $my_query->the_post(); 
				$visibilita=get_post_meta($my_query->post->ID, "_visibilita");
			 	if(count($visibilita)==0)
			 		$visibilita="p";
			 	else 
			 		$visibilita=$visibilita[0];
			 	if (function_exists(Is_Circolare_per_User))
			 		$IsPerUser=((Is_Circolare_per_User($my_query->post->ID) and $visibilita=="d") or $visibilita=="p");
			 	if (function_exists(gcg_Is_Circolare_per_User))
			 		$IsPerUser=gcg_Is_Circolare_per_User($my_query->post->ID);

				if ($IsPerUser){
					$numCe++;			
			?>
				<li><h3><span class="hdate"><?php the_time('j M y') ?></span> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></li>
		        		<?php
		                  if ($excerpt != '' && $excerpt != 0) { echo '<li>'; the_excerpt(); echo '</li>'; }
		         }
			endwhile; 
			wp_reset_query();

            echo '</ul>';

            //FINE WIDGET

            echo $after_widget;
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['titolo'] = strip_tags($new_instance['titolo']);
              $instance['limite'] = strip_tags($new_instance['limite']);
              $instance['riassunto'] = strip_tags($new_instance['riassunto']);
              $instance['allineamento'] = strip_tags($new_instance['allineamento']);
              $instance['pagina_circolari'] = strip_tags($new_instance['pagina_circolari']);
              return $instance;
        }

        function form( $instance ) {
        	
        	$defaults = array(
				'titolo' => 'Ultime Circolari',
				'limite' => 5,
				'pagina_circolari' => NULL,
            );

            $instance = wp_parse_args( (array) $instance, $defaults ); ?>

            <p>
                <label for="<?php echo $this->get_field_id( 'titolo' ); ?>">Titolo:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'titolo' ); ?>" name="<?php echo $this->get_field_name( 'titolo' ); ?>" value="<?php echo $instance['titolo']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'limite' ); ?>">Numero post visualizzati:</label>
                <input type="number" min="1" max="10" class="widefat" id="<?php echo $this->get_field_id( 'limite' ); ?>" name="<?php echo $this->get_field_name( 'limite' ); ?>" value="<?php echo $instance['limite']; ?>" />
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('riassunto'); ?>" name="<?php echo $this->get_field_name('riassunto'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['riassunto'])); ?>/>
                <label for="<?php echo $this->get_field_id('riassunto'); ?>">Mostra anteprima testuale</label>
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('allineamento'); ?>" name="<?php echo $this->get_field_name('allineamento'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['allineamento'])); ?>/>
                <label for="<?php echo $this->get_field_id('allineamento'); ?>">Allinea centralmente</label>
            </p>
       		
       		<p>
            	<label for="<?php echo $this->get_field_id( 'pagina_circolari' ); ?>">
               		Pagina Circolari:
            	</label>
				<select id="<?php echo $this->get_field_id( 'pagina_circolari' ); ?>" name="<?php echo $this->get_field_name( 'pagina_circolari' ); ?>" style="width:270px;"> 
		 			<option value=""><?php echo esc_attr( __( 'Select page' ) ); ?></option> 
					<?php 
		  				$pages = get_pages(); 
		  				foreach ( $pages as $pagg ) {
		    				if (get_page_link( $pagg->ID ) == $instance['pagina_circolari'] ) 
								$Selezionato= 'selected="selected"';
							else
								$Selezionato="";
		  					$option = '<option '.$Selezionato.' value="' . get_page_link( $pagg->ID ) . '">';
							$option .= $pagg->post_title;
							$option .= '</option>';
							echo $option;
		  					}
					 ?>
				</select>
        	</p>     

<?php
        }
    }
	class pasw2015_taxdest extends WP_Widget {

        function pasw2015_taxdest() {
            parent::__construct( false, 'PASW @ TaxDestinatari' );
    	}

        function widget( $args, $instance ) {

        	extract( $args );
            // these are the widget options
           	$title = apply_filters('widget_title', $instance['titolo']);
        	$limit = $instance['limite'];
	        $taxdestinatari = $instance['destinatari'];
	        $align = $instance['allineamento'];
	        $excerpt = $instance['riassunto'];
	        $thumbnail = $instance['imgevidenza'];
      		$showall = $instance['showall'];

    		if ($showall) {
        		$taxonomy = 'paswdestinatari';
              	$term_id = $taxdestinatari;
              	$term = get_term( $term_id, $taxonomy );
              	$term_link = get_term_link( $term );
              	$link = esc_url( $term_link ).'&post_type=post';
            	$after_title = '<span class="showall_widget after_widget_title"><a href='. $link .' title="Tutti gli articoli di '. $term->name . '" >Mostra Tutto &rsaquo;</a></span>'.$after_title;
    		}            

            if ( $title ) {
                echo $before_widget . $before_title . $title . $after_title;
            }

            echo '<ul';
            if ($align != '' && $align != 0) { echo ' style="text-align:center;"'; }
            echo '>';
			global $post;

			$myquery = get_posts(array(
				'post_type' => 'post',
				'posts_per_page' => $limit,
				'tax_query' => array(
					array(
						'taxonomy' => 'paswdestinatari',
						'field' => 'term_id',
						'terms' => $taxdestinatari)
					))
			);

            foreach($myquery as $post) :
    			setup_postdata($post);
                global $more;
                $more = 0;
            	?>
                <li><h3><span class="hdate"><?php the_time('j M y') ?></span> <a href="<?php the_permalink(); ?>">
                <?php
			    if ( has_post_thumbnail() && $thumbnail ) {
                    the_post_thumbnail(array(50,50));
            	}
                the_title(); ?></a></h3></li>
                <?php
                if ($excerpt != '' && $excerpt != 0) { echo '<li>'; the_excerpt(); echo '</li>';} //echo '<div class="clear"></div>';
            endforeach;

            echo '</ul>';

            //FINE WIDGET

            echo $after_widget;
        }

        function update( $new_instance, $old_instance ) {

            $instance = $old_instance;
            $instance['titolo'] = strip_tags($new_instance['titolo']);
	        $instance['destinatari'] = strip_tags($new_instance['destinatari']);
    	    $instance['limite'] = strip_tags($new_instance['limite']);
            $instance['riassunto'] = strip_tags($new_instance['riassunto']);
            $instance['allineamento'] = strip_tags($new_instance['allineamento']);
            $instance['imgevidenza'] = strip_tags($new_instance['imgevidenza']);
            $instance['showall'] = strip_tags($new_instance['showall']);
            return $instance;
        }

        function form( $instance ) {

            $instance = wp_parse_args( (array) $instance, array( 'limite' => '0' ) ); ?>

            <p>
                <label for="<?php echo $this->get_field_id( 'titolo' ); ?>">Titolo:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'titolo' ); ?>" name="<?php echo $this->get_field_name( 'titolo' ); ?>" value="<?php echo $instance['titolo']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'limite' ); ?>">Numero post visualizzati:</label>
                <input type="number" min="1" max="10" class="widefat" id="<?php echo $this->get_field_id( 'limite' ); ?>" name="<?php echo $this->get_field_name( 'limite' ); ?>" value="<?php echo $instance['limite']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'destinatari' ); ?>">Destinatari:</label>
                <select id="<?php echo $this->get_field_id('destinatari'); ?>" name="<?php echo $this->get_field_name('destinatari'); ?>" class="widefat" style="width:100%;">
                    <?php foreach(get_terms('paswdestinatari','parent=0&hide_empty=0') as $term) { ?>
                        <option <?php selected( $instance['destinatari'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('riassunto'); ?>" name="<?php echo $this->get_field_name('riassunto'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['riassunto'])); ?>/>
                <label for="<?php echo $this->get_field_id('riassunto'); ?>">Mostra anteprima testuale</label>
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('imgevidenza'); ?>" name="<?php echo $this->get_field_name('imgevidenza'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['imgevidenza'])); ?>/>
                <label for="<?php echo $this->get_field_id('imgevidenza'); ?>">Mostra immagine in evidenza</label>
            </p>
            
			<p>
                <input id="<?php echo $this->get_field_id('showall'); ?>" name="<?php echo $this->get_field_name('showall'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['showall'])); ?>/>
                <label for="<?php echo $this->get_field_id('showall'); ?>">Mostra link visualizza tutto</label>
            </p>

            <p>
                <input id="<?php echo $this->get_field_id('allineamento'); ?>" name="<?php echo $this->get_field_name('allineamento'); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr($instance['allineamento'])); ?>/>
                <label for="<?php echo $this->get_field_id('allineamento'); ?>">Allinea testo centralmente</label>
            </p>

<?php
        }
    }    
?>
