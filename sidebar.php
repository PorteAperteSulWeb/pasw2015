<div id="leftsidebar" class="column">
  <ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-1') ) :?>
<?php endif; ?>
  </ul>
</div>
<?php if (get_option('pasw_secondo_menu')) {
	echo '<div class="secondo-menu">';

	if(function_exists('wp_nav_menu')) {
		wp_nav_menu( array( 'menu' => '', 'container' => '', 'menu_class' => '', 'theme_location' => 'menu-4' ) );
	}
	echo '</div>';
} ?>
