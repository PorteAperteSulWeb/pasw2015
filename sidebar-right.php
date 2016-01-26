<div id="rightsidebar" class="column">
<?php if (get_option('pasw_pisocial') === '2'){get_template_part('template/tlp-social');} ?>
<ul>
<?php
global $children;
if ($children && get_option( 'pasw_submenu') == '4') { ?>
	<li class="widget widget_nav_menu">
		<h2 class="widgettitle"><?php echo $post->post_title; ?></h2>
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
