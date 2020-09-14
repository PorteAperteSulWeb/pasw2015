</div>
<div class="clear"></div>

    <?php if (get_option('pasw_loghi_footer')!= '') { ?>

    <div class="imglinks">
        <?php echo html_entity_decode(get_option('pasw_loghi_footer')); ?>
        <div class="clear"></div>
    </div>

    <?php } else { echo '<br/><br/><br/>'; } ?>

</div>

<footer id="footer">

    <div id="footer-interno" <?php if (get_option('pasw_fluid_layout') == '0') { echo 'style="max-width: 1150px;"'; } ?>>
        <div class="footer-column">
            <img style="float:left;padding:10px;max-height:140px;" src="<?php echo get_option('pasw_logo'); ?>" alt=""/>
            <span style="float:left;padding-top: 12px;max-width: 70%;">
                <?php bloginfo('name'); ?>
                <br/>
                <small>

<?php
    $site_url = get_site_url();
if (get_option('pasw_indirizzo_scuola') != '') {
        echo stripslashes(get_option('pasw_indirizzo_scuola')) . '<br/>';
    }
    if (get_option('pasw_recapito_scuola') != '') {
        echo stripslashes(get_option('pasw_recapito_scuola')) . '<br/>';
    }
    if (get_option('pasw_email_scuola') != '') {
        echo stripslashes(get_option('pasw_email_scuola')) . '<br/>';
    }
    if (get_option('pasw_pec_scuola') != '') {
        echo stripslashes(get_option('pasw_pec_scuola')) . '<br/>';
    }
    if (get_option('pasw_cfpiva_scuola') != '') {
        echo stripslashes(get_option('pasw_cfpiva_scuola')) . '<br/>';
    }
        ?>
                    <?php echo html_entity_decode(get_option('pasw_testo_footer')); ?><br/>
                </small>
            </span>
        </div>

        <div class="footer-column" style="width:15%;">
        <?php

         $menu_name = 'menu-3'; // Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)

            if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
                $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

                $menu_items = wp_get_nav_menu_items($menu->term_id);

                $i = 0;
                echo '<ul style="list-style-type: square;font-size: 0.8em;margin-top: 30px;">';
                foreach ( (array) $menu_items as $key => $menu_item ) {

                    echo  '<li><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
                }
                echo '</ul>';
            }

        ?>
        </div>

        <div id="footer-credits">
			
			<?php 
			if (get_option('pasw_pisocial') === '3'){get_template_part('template/tlp-social');}?>
            Credits
        <p>Sito realizzato 
            <?php
                if (get_option('pasw_Autore')) {
                    if (get_option('pasw_autorelink')) {
                        echo 'da <a href="' . get_option('pasw_autorelink') . '" title="'.get_option('pasw_Autore').'" >' . get_option('pasw_Autore') . '</a><br>';
                    } else {
                        echo 'da ' . get_option('pasw_Autore') . '<br>';
                    }
                }
            ?>
            su modello della comunit&agrave; di pratica<br/>
<?php
    // #######################
    // Abbiamo lavorato molto su questo nuovo tema. Per favore, non rimuovere i credits.
    // #######################
?>

            <a title="Porte Aperte sul Web" href="http://www.porteapertesulweb.it/"> <img src="<?php echo get_template_directory_uri() . '/images/logopab.png'; ?>" width="180" alt="logo porte aperte sul web"/></a>

        <br/><small> Versione 2015.<?php echo get_option('pasw2015_version') . version_child(); ?><br/>
        Proudly powered by <a href="https://wordpress.org" title="Piattaforma CMS WordPress">WordPress</a> &bull;
        <a href="https://validator.w3.org/check/referer" title="HTML5 valido"><abbr title="HyperText Markup Language">HTML5</abbr></a> &bull;
        <a href="https://jigsaw.w3.org/css-validator/check/referer" title="CSS valido"><abbr title="Cascading Style Sheets">CSS</abbr></a>
        </small>
            </p>
        </div>
    </div>
</footer>
<?php if (get_option( 'pasw_scrolltop') != '0') { 
	switch (get_option( 'pasw_scrolltop')) {
    case 1:
        $temp = "right";
        break;
    case 2:
		$temp = "left";
        break;
	}
?>
	<a href="#content" class="back-to-top" title="Vai su" style="<?php echo $temp ?>: 2.0% !important;"><i class="fa fa-arrow-circle-o-up fa-2x"><span class="screen-reader-text">Link vai su</span></i></a>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>
