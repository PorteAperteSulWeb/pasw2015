<div id="rightsidebar" class="column">
<ul>
<?php
if ($children && get_option( 'pasw_submenu') == '4') { ?>
	<li class="widget widget_nav_menu">
		<h2 class="widgettitle">Sub-Page</h2>
	  	<ul id="subpage-sidebar" class="menu">
	 		<?php wp_list_pages('depth=1&title_li=&child_of='.$post->ID); ?>
		</ul>
	</li>
<?php }
if ( function_exists('generated_dynamic_sidebar')) {
    if ( function_exists('dynamic_sidebar') && generated_dynamic_sidebar() ) : endif;
} else {
    if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-2') ) : endif;
}
?>
</ul>
</div>
