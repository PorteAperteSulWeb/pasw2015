<div class="lastmodified">
 Ultima modifica: <?php the_modified_date('j F Y'); ?>
</div>
<div id="path">
<?php
 if ( function_exists('bcn_display') ) {
  bcn_display();
 } else if ( function_exists('yoast_breadcrumb') ) {
  yoast_breadcrumb('<p id="breadcrumbs">','</p>');
 }
?>
</div>
