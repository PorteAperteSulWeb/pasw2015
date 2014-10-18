<div id="path">
<?php
    if (!is_home() && !is_front_page()) {
        if ( function_exists('bcn_display') ) {
            bcn_display();
        } else if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb('<p id="breadcrumbs">','</p>');
        }
    }
?>
</div>
