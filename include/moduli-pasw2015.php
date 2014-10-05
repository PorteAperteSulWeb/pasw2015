<?php

    function pasw2015_moduli() {

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
                    <p><span style="color:red;font-weight:bold;">Funzione dormiente - per il momento -</span></p>
                </div>
            </td>
        </tr>

    </table>

    <?php }
?>
