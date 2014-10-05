<div id="rightsidebar" class="column">
<ul>
<?php
if ( function_exists('generated_dynamic_sidebar')) {
    if ( function_exists('dynamic_sidebar') && generated_dynamic_sidebar() ) : endif;
} else {
    if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-2') ) : endif;
}
?>
</ul>
</div>
