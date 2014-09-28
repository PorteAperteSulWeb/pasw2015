<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="centrecontent" class="column">
	<h2>404</h2>
	<p>Spiacenti: la pagina non esiste</p>
	<?php if ( function_exists('related_posts_404') ) { ?>
	<p>
	Prova con
	<ul>
	<?php related_posts_404(5, 10, '<li>', '</li>', '', '', false, true); ?>
	</ul></p><?php } ?>	
</div>
<?php include(TEMPLATEPATH . '/rightsidebar.php'); ?>
<?php get_footer(); ?>
