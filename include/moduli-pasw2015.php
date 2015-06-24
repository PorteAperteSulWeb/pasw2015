<?php

    function pasw2015_moduli() {

        if (isset($_GET['switchcolumn']) || wp_verify_nonce($_GET['switchcolumn'], 'switchcolumn')) {
            if (get_option('pasw_mcolumn') == 0) {
                update_option('pasw_mcolumn', '1');
            } else {
                update_option('pasw_mcolumn', '0');
            }
        }

        if (isset($_GET['switchcat']) || wp_verify_nonce($_GET['switchcat'], 'switchcat')) {
            if (get_option('pasw_catpage') == 0) {
                update_option('pasw_catpage', '1');
            } else {
                update_option('pasw_catpage', '0');
            }
        }

        if (isset($_GET['switchtax']) || wp_verify_nonce($_GET['switchtax'], 'switchtax')) {
            if (get_option('pasw_taxdest') == 0) {
                update_option('pasw_taxdest', '1');
            } else {
                update_option('pasw_taxdest', '0');
            }
        }

        if (isset($_GET['switchsidebar']) || wp_verify_nonce($_GET['switchsidebar'], 'switchsidebar')) {
            if (get_option('pasw_msidebar') == 0) {
                update_option('pasw_msidebar', '1');
            } else {
                update_option('pasw_msidebar', '0');
            }
        }

		if (isset($_GET['switcheulaw']) || wp_verify_nonce($_GET['switcheulaw'], 'switcheulaw')) {
			if ( is_plugin_active( 'eu-cookie-law/eu-cookie-law.php' ) ) {
				$checkattiva = '<br>Il modulo non può essere attivato<br>è attivo EU Cookie Law';
			}else{
				if (get_option('pasw_eulaw') == 0) {
					update_option('pasw_eulaw', '1');
					require get_template_directory() . '/include/eu-law/defaults.php';
				} else {
					update_option('pasw_eulaw', '0');
				}
			} 
        }

        ?>

    <h2>Funzioni aggiuntive integrate</h2>
    <p>
        In questa pagina puoi gestire le funzioni speciali presenti in Pasw2015.
        </p>
    <table class="wp-list-table widefat plugins">
<thead>
    <tr>
        <th scope="col" id="cb" class="manage-column column-cb check-column" style="">

        </th>
        <th scope="col" id="name" class="manage-column column-name" style="">Plugin</th>
        <th scope="col" id="description" class="manage-column column-description" style="">Descrizione</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th scope="col" class="manage-column column-cb check-column" style=""><th scope="col" class="manage-column column-name" style="">Plugin</th><th scope="col" class="manage-column column-description" style="">Descrizione</th>    </tr>
    </tfoot>
    <tbody id="the-list">
        <tr class="<?php if (get_option('pasw_mcolumn') == 0) { echo 'in'; } ?>active"><th scope="row" class="check-column"></th>
            <td class="plugin-title"><strong>Shortcode per Colonne</strong><div class="row-actions visible">
                <span class="activate">
                    <a href="<?php print wp_nonce_url(admin_url('admin.php?page=pasw2015-moduli'), 'switchcolumn', 'switchcolumn');?>" class="edit">
                        <?php if (get_option('pasw_mcolumn') == 0) { echo 'Attiva'; } else { echo 'Disattiva'; } ?>
                    </a>
                </span>
            </td>
            <td class="column-description desc">
                <div class="plugin-description">
                    <p>Questa funzione offre la possibilità di creare colonne di diversa larghezza tramite shortcode nei contenuti</p>
                </div>
            </td>
        </tr>

        <tr class="<?php if (get_option('pasw_catpage') == 0) { echo 'in'; } ?>active"><th scope="row" class="check-column"></th>
            <td class="plugin-title"><strong>Categorie nelle Pagine</strong><div class="row-actions visible">
                <span class="activate">
                    <a href="<?php print wp_nonce_url(admin_url('admin.php?page=pasw2015-moduli'), 'switchcat', 'switchcat');?>" class="edit">
                        <?php if (get_option('pasw_catpage') == 0) { echo 'Attiva'; } else { echo 'Disattiva'; } ?>
                    </a>
                </span>
            </td>
            <td class="column-description desc">
                <div class="plugin-description">
                    <p>Questa funzione offre la possibilità di mostrare, in una pagina, la lista degli ultimi 5 articoli prelevati da una categoria di WordPress.
                    <br/>Una volta attivato, comparirà un nuovo riquadro nel back-end per la modifica delle pagine.
                    <br/><span style="color:red;">Sconsigliamo di abilitare questa funzione su nuove installazioni in quanto il CMS offre nativamente alternative migliori nella maggior parte dei casi</span></p>
                </div>
            </td>
        </tr>

        <tr class="<?php if (get_option('pasw_msidebar') == 0) { echo 'in'; } ?>active"><th scope="row" class="check-column"></th>
            <td class="plugin-title"><strong>Sidebars Generator</strong><div class="row-actions visible">
                <span class="activate">
                    <a href="<?php print wp_nonce_url(admin_url('admin.php?page=pasw2015-moduli'), 'switchsidebar', 'switchsidebar');?>" class="edit">
                        <?php if (get_option('pasw_msidebar') == 0) { echo 'Attiva'; } else { echo 'Disattiva'; } ?>
                    </a>
                     &bull;
                    <a class="add-new-h2" href="https://github.com/PorteAperteSulWeb/pasw2015/wiki/Sidebar-generator" target="_blank">Documentazione</a>
                </span>
            </td>
            <td class="column-description desc">
                <div class="plugin-description">
                    <p>Crea e gestisci più barre laterali e associale alle pagine.</p>
                </div>
            </td>
        </tr>

        <tr class="<?php if (get_option('pasw_taxdest') == 0) { echo 'in'; } ?>active"><th scope="row" class="check-column"></th>
            <td class="plugin-title"><strong>Tassonomia destinatari</strong><div class="row-actions visible">
                <span class="activate">
                    <a href="<?php print wp_nonce_url(admin_url('admin.php?page=pasw2015-moduli'), 'switchtax', 'switchtax');?>" class="edit">
                        <?php if (get_option('pasw_taxdest') == 0) { echo 'Attiva'; } else { echo 'Disattiva'; } ?>
                    </a>
                </span>
            </td>
            <td class="column-description desc">
                <div class="plugin-description">
                    <p>Abilita un nuovo sistema di catalogazione delle informazioni basato su destinatari (alunni, genitori, ATA, docenti). Attualmente in <strong>beta</strong>. Documentazione in fase di sviluppo</p>
                </div>
            </td>
        </tr>
	
		<tr class="<?php if (get_option('pasw_eulaw') == 0) { echo 'in'; } ?>active"><th scope="row" class="check-column"></th>
            <td class="plugin-title"><strong>EU Cookie Law </strong><div class="row-actions visible">
                <span class="activate">
                    <a href="<?php print wp_nonce_url(admin_url('admin.php?page=pasw2015-moduli'), 'switcheulaw', 'switcheulaw');?>" class="edit">
                        <?php if (get_option('pasw_eulaw') == 0) { echo 'Attiva'; echo $checkattiva;} else { echo 'Disattiva'; } ?>
                    </a>
                </span>
            </td>
            <td class="column-description desc">
                <div class="plugin-description">
                    <p>Il modulo è una soluzione leggera, facile da configurare ed utilizzare che consente al sito di rispettare la legge europea sui cookie,  informando gli utenti  che il sito utilizza cookie. Il modulo permette di bloccare gli script e i relativi cookie prima dell'accettazione rispettando in questo modo la normativa italiana. <br> <strong>Attenzione</strong> il modulo funziona solo con il tema Pasw2015, se si utilizza plugin per la visualizzazione del sito nei cellulari il modulo non genera alcun effetto in tale modalit&agrave, in questo caso si consiglia l'uso del plugin EU Cookie Law di Marco Milesi.</p>
                </div>
            </td>
        </tr>

    </table>

    <?php }
?>
