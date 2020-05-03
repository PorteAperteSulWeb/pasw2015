<?php
/*
Plugin Name: Sidebar Generator
Plugin URI: http://www.getson.info
Description: This plugin generates as many sidebars as you need. Then allows you to place them on any page you wish. Version 1.1 now supports themes with multiple sidebars.
Version: 1.1.0
Author: Kyle Getson
Author URI: http://www.kylegetson.com
Copyright (C) 2009 Kyle Robert Getson
*/

/*
Copyright (C) 2009 Kyle Robert Getson, kylegetson.com and getson.info

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


/*
* Modifiche effettuate
* Cambiato il nome della classe con pasw_sidebar_generator,
* in modo da prevenire conflitti con il plugin originale.
* Aggiunta Sidebar(sidebar-2) come predefinita.
*/

class pasw_sidebar_generator {

    function __construct(){
        add_action('init',array('pasw_sidebar_generator','init'));
        add_action('admin_menu',array('pasw_sidebar_generator','admin_menu'));
        add_action('admin_print_scripts', array('pasw_sidebar_generator','admin_print_scripts'));
        add_action('wp_ajax_add_sidebar', array('pasw_sidebar_generator','add_sidebar') );
        add_action('wp_ajax_remove_sidebar', array('pasw_sidebar_generator','remove_sidebar') );

        //edit posts/pages
        add_action('edit_form_advanced', array('pasw_sidebar_generator', 'edit_form'));
        add_action('edit_page_form', array('pasw_sidebar_generator', 'edit_form'));

        //save posts/pages
        add_action('edit_post', array('pasw_sidebar_generator', 'save_form'));
        add_action('publish_post', array('pasw_sidebar_generator', 'save_form'));
        add_action('save_post', array('pasw_sidebar_generator', 'save_form'));
        add_action('edit_page_form', array('pasw_sidebar_generator', 'save_form'));

    }

    static function init(){
        //go through each sidebar and register it
        $sidebars = pasw_sidebar_generator::get_sidebars();


        if(is_array($sidebars)){
            foreach($sidebars as $sidebar){
                $sidebar_class = pasw_sidebar_generator::name_to_class($sidebar);
                register_sidebar(array(
                    'name'=>$sidebar,
                    'description' => 'Sidebar destra Personalizzata.'
                ));
            }
        }
    }

    static function admin_print_scripts(){
        wp_print_scripts( array( 'sack' ));
        ?>
            <script>
                function add_sidebar( sidebar_name )
                {

                    var mysack = new sack("<?php echo site_url(); ?>/wp-admin/admin-ajax.php" );

                      mysack.execute = 1;
                      mysack.method = 'POST';
                      mysack.setVar( "action", "add_sidebar" );
                      mysack.setVar( "sidebar_name", sidebar_name );
                      mysack.encVar( "cookie", document.cookie, false );
                      mysack.onError = function() { alert('Ajax error. Impossibile aggiungere la Sidebar' )};
                      mysack.runAJAX();
                    return true;
                }

                function remove_sidebar( sidebar_name,num )
                {

                    var mysack = new sack("<?php echo site_url(); ?>/wp-admin/admin-ajax.php" );

                      mysack.execute = 1;
                      mysack.method = 'POST';
                      mysack.setVar( "action", "remove_sidebar" );
                      mysack.setVar( "sidebar_name", sidebar_name );
                      mysack.setVar( "row_number", num );
                      mysack.encVar( "cookie", document.cookie, false );
                      mysack.onError = function() { alert('Ajax error. Impossibile aggiungere la Sidebar' )};
                      mysack.runAJAX();
                    //alert('hi!:::'+sidebar_name);
                    return true;
                }
            </script>
        <?php
    }

    static function add_sidebar(){
        $sidebars = pasw_sidebar_generator::get_sidebars();
        $name = str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']);
        $id = pasw_sidebar_generator::name_to_class($name);
        if(isset($sidebars[$id])){
            die("alert('La Sidebar esiste già! Usa un nome differente.')");
        }

        $sidebars[$id] = $name;
        pasw_sidebar_generator::update_sidebars($sidebars);

        $js = "
            var tbl = document.getElementById('sbg_table');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);

            // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode('$name');
            cellLeft.appendChild(textNode);

            //middle cell
            var cellLeft = row.insertCell(1);
            var textNode = document.createTextNode('$id');
            cellLeft.appendChild(textNode);

            //var cellLeft = row.insertCell(2);
            //var textNode = document.createTextNode('[<a href=\'javascript:void(0);\' onclick=\'return remove_sidebar_link($name);\'>Remove</a>]');
            //cellLeft.appendChild(textNode)

            var cellLeft = row.insertCell(2);
            removeLink = document.createElement('a');
              linkText = document.createTextNode('remove');
            removeLink.setAttribute('onclick', 'remove_sidebar_link(\'$name\')');
            removeLink.setAttribute('href', 'javacript:void(0)');

              removeLink.appendChild(linkText);
              cellLeft.appendChild(removeLink);


        ";


        die( "$js");
    }

    static function remove_sidebar(){
        $sidebars = pasw_sidebar_generator::get_sidebars();
        $name = str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']);
        $id = pasw_sidebar_generator::name_to_class($name);
        if(!isset($sidebars[$id])){
            die("alert('La Sidebar non esiste.')");
        }
        $row_number = $_POST['row_number'];
        unset($sidebars[$id]);
        pasw_sidebar_generator::update_sidebars($sidebars);
        $js = "
            var tbl = document.getElementById('sbg_table');
            tbl.deleteRow($row_number)

        ";
        die($js);
    }

    static function admin_menu(){
        add_submenu_page('pasw2015', 'Sidebar Pasw', 'Sidebar', 'manage_options', 'pasw-sidebar-generator', 'pasw_sidebar_generator::admin_page' );
    }

    static function admin_page(){
        ?>
        <script type='text/javascript'>
            function remove_sidebar_link(name,num){
                answer = confirm("Sei sicuro di voler rimuovere " + name + "?\nQuesta operazione rimuoverà ogni widgets assegnato a questa sidebar.");
                if(answer){
                    //alert('AJAX REMOVE');
                    remove_sidebar(name,num);
                }else{
                    return false;
                }
            }
            function add_sidebar_link(){
                var sidebar_name = prompt("Nome Sidebar:","");
                //alert(sidebar_name);
                add_sidebar(sidebar_name);
            }
        </script>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"></div><h2>Barre Laterali <small>PASW</small>
             <a class="add-new-h2" href="https://github.com/PorteAperteSulWeb/pasw2015/wiki/Sidebar-generator" target="_blank">Documentazione</a></h2>
            <br />
            <table class="widefat page" id="sbg_table" style="width:600px;">
                <tr>
                    <th>Nome Sidebar</th>
                    <th>Classe CSS</th>
                    <th>Rimuovi</th>
                </tr>
                <?php
                $sidebars = pasw_sidebar_generator::get_sidebars();
                //$sidebars = array('bob','john','mike','asdf');
                if(is_array($sidebars) && !empty($sidebars)){
                    $cnt=0;
                    foreach($sidebars as $sidebar){
                        $alt = ($cnt%2 == 0 ? 'alternate' : '');
                ?>
                <tr class="<?php echo $alt?>">
                    <td><?php echo $sidebar; ?></td>
                    <td><?php echo pasw_sidebar_generator::name_to_class($sidebar); ?></td>
                    <td><a href="javascript:void(0);" onclick="return remove_sidebar_link('<?php echo $sidebar; ?>',<?php echo $cnt+1; ?>);" title="Rimuovi questa sidebar">rimuovi</a></td>
                </tr>
                <?php
                        $cnt++;
                    }
                }else{
                    ?>
                    <tr>
                        <td colspan="3">Nessuna Sidebars definita</td>
                    </tr>
                    <?php
                }
                ?>
            </table><br /><br />
            <div class="add_sidebar">
                <a href="javascript:void(0);" onclick="return add_sidebar_link()" title="Aggiungi una sidebar" class="button-primary">+ Aggiungi Nuova Sidebar</a>

            </div>

        </div>
        <?php
    }

    /**
     * for saving the pages/post
    */
    static function save_form($post_id){
        if(isset($_POST['sbg_edit']))
        $is_saving = $_POST['sbg_edit'];
        if(!empty($is_saving)){
            delete_post_meta($post_id, 'sbg_selected_sidebar');
            delete_post_meta($post_id, 'sbg_selected_sidebar_replacement');
            add_post_meta($post_id, 'sbg_selected_sidebar', $_POST['sidebar_generator']);
            add_post_meta($post_id, 'sbg_selected_sidebar_replacement', $_POST['sidebar_generator_replacement']);
        }
    }

    static function edit_form(){
        global $post;
        $post_id = $post;
        if (is_object($post_id)) {
            $post_id = $post_id->ID;
        }
        $selected_sidebar = get_post_meta($post_id, 'sbg_selected_sidebar', true);
        if(!is_array($selected_sidebar)){
            $tmp = $selected_sidebar;
            $selected_sidebar = array();
            $selected_sidebar[0] = $tmp;
        }
        $selected_sidebar_replacement = get_post_meta($post_id, 'sbg_selected_sidebar_replacement', true);
        if(!is_array($selected_sidebar_replacement)){
            $tmp = $selected_sidebar_replacement;
            $selected_sidebar_replacement = array();
            $selected_sidebar_replacement[0] = $tmp;
        }
        ?>

    <div id='sbg-sortables' class='meta-box-sortables'>
        <div id="sbg_box" class="postbox " >
            <div class="handlediv" title="Clicca per commutare"><br /></div><h3 class='hndle'><span>Pasw Sidebar</span></h3>
            <div class="inside">
                <div class="sbg_container">
                    <input name="sbg_edit" type="hidden" value="sbg_edit" />

                    <p>Seleziona la Sidebar che vuoi assegnare a questa pagina. <strong>Nota:</strong> Bisogna prima creare una sidebar da Aspetto > Pasw Sidebars.
                    </p>
                    <ul>
                    <?php
                    global $wp_registered_sidebars;
                    //var_dump($wp_registered_sidebars);
                        for($i=0;$i<1;$i++){ ?>
                            <li>
                            <select name="sidebar_generator[<?php echo $i?>]" style="display: none;">
                                <option value="0"<?php if($selected_sidebar[$i] == ''){ echo " selected";} ?>>WP Default Sidebar</option>
                            <?php
                            $sidebars = $wp_registered_sidebars;// sidebar_generator::get_sidebars();
                            if(is_array($sidebars) && !empty($sidebars)){
                                foreach($sidebars as $sidebar){
                                    if($selected_sidebar[$i] == $sidebar['name']){
                                        echo "<option value='{$sidebar['name']}' selected>{$sidebar['name']}</option>\n";
                                    }else{
                                        echo "<option value='{$sidebar['name']}'>{$sidebar['name']}</option>\n";
                                    }
                                }
                            }
                            ?>
                            </select>
                            <select name="sidebar_generator_replacement[<?php echo $i?>]">
                                <option value="0"<?php if($selected_sidebar_replacement[$i] == ''){ echo " selected";} ?>>Barra laterale (DX)</option>
                            <?php

                            $sidebar_replacements = $wp_registered_sidebars;//sidebar_generator::get_sidebars();
                            if(is_array($sidebar_replacements) && !empty($sidebar_replacements)){
                                foreach($sidebar_replacements as $sidebar){
                                    if($selected_sidebar_replacement[$i] == $sidebar['name']){
                                        echo "<option value='{$sidebar['name']}' selected>{$sidebar['name']}</option>\n";
                                    }else{
                                        echo "<option value='{$sidebar['name']}'>{$sidebar['name']}</option>\n";
                                    }
                                }
                            }
                            ?>
                            </select>

                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

        <?php
    }

    /**
     * called by the action get_sidebar. this is what places this into the theme
    */
    static function get_sidebar($name="0"){
        if(!is_singular()){
            if($name != "0"){
                dynamic_sidebar($name);
            }else{
                dynamic_sidebar('sidebar-2');
            }
            return;//dont do anything
        }
        global $wp_query;
        $post = $wp_query->get_queried_object();
        $selected_sidebar = get_post_meta($post->ID, 'sbg_selected_sidebar', true);
        $selected_sidebar_replacement = get_post_meta($post->ID, 'sbg_selected_sidebar_replacement', true);
        $did_sidebar = false;
        //this page uses a generated sidebar
        if($selected_sidebar != '' && $selected_sidebar != "0"){
            echo "";
            if(is_array($selected_sidebar) && !empty($selected_sidebar)){
                for($i=0;$i<sizeof($selected_sidebar);$i++){

                    if($name == "0" && $selected_sidebar[$i] == "0" &&  $selected_sidebar_replacement[$i] == "0"){
                        //echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
                        dynamic_sidebar('sidebar-2');//default behavior
                        $did_sidebar = true;
                        break;
                    }elseif($name == "0" && $selected_sidebar[$i] == "0"){
                        //we are replacing the default sidebar with something
                        //echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
                        dynamic_sidebar($selected_sidebar_replacement[$i]);//default behavior
                        $did_sidebar = true;
                        break;
                    }elseif($selected_sidebar[$i] == $name){
                        //we are replacing this $name
                        //echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
                        $did_sidebar = true;
                        dynamic_sidebar($selected_sidebar_replacement[$i]);//default behavior
                        break;
                    }
                    //echo "<!-- called=$name selected={$selected_sidebar[$i]} replacement={$selected_sidebar_replacement[$i]} -->\n";
                }
            }
            if($did_sidebar == true){
                echo "";
                return;
            }
            //go through without finding any replacements, lets just send them what they asked for
            if($name != "0"){
                dynamic_sidebar($name);
            }else{
                dynamic_sidebar('sidebar-2');
            }
            echo "";
            return;
        }else{
            if($name != "0"){
                dynamic_sidebar($name);
            }else{
                dynamic_sidebar('sidebar-2');
            }
        }
    }

    /**
     * replaces array of sidebar names
    */
    static function update_sidebars($sidebar_array){
        $sidebars = update_option('sbg_sidebars',$sidebar_array);
    }

    /**
     * gets the generated sidebars
    */
    static function get_sidebars(){
        $sidebars = get_option('sbg_sidebars');
        return $sidebars;
    }

    static function name_to_class($name){
        $class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
        return $class;
    }

}
$sbg = new pasw_sidebar_generator;

function generated_dynamic_sidebar($name='0'){
    pasw_sidebar_generator::get_sidebar($name);
    return true;
}
?>
