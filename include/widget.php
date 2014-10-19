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
            //register_widget( 'pasw2015_albo' );
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
                <select id="<?php echo $this->get_field_id('categoria'); ?>" name="<?php echo $this->get_field_name('categoria'); ?>" class="widefat" style="width:100%;">
                    <?php foreach(get_terms('category','hide_empty=0') as $term) { ?>
                        <option <?php selected( $instance['categoria'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
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
            parent::__construct( false, 'PASW @ Albo #Scimone' );
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

            if ( $title ) {
                echo $before_widget . $before_title . $title . $after_title;
            }

            echo '<ul';
            if ($align != '' && $align != 0) { echo ' style="text-align:center;"'; }
            echo '>';

            //WordPress loop for custom post type
            $my_query = new WP_Query('post_type=circolari&showposts=' . $limit);
            while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <li><h3><span class="hdate"><?php the_time('j M y') ?></span> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></li>
                        <?php
                          if ($excerpt != '' && $excerpt != 0) { echo '<li>'; the_excerpt(); echo '</li>'; }
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

?>
